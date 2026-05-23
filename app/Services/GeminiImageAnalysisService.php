<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;
use Log;

class GeminiImageAnalysisService
{
    public function analyzeProductImage(
        UploadedFile $image,
        array $categoryNames = [],
        array $subCategoryNames = [],
        string $languageName = ''
    ): array {
        $base64Image = base64_encode(file_get_contents($image->getRealPath()));
        $mimeType = $image->getMimeType();

        $model = config('settings.gemini.model');
        $apiKey = config('settings.gemini.api_key');

        $response = Http::timeout(60)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            [
                                'text' => $this->getPrompt($categoryNames, $subCategoryNames, $languageName),
                            ],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $base64Image,
                                ],
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    // Force the model to emit raw JSON (no markdown fences)
                    'responseMimeType' => 'application/json',
                ],
            ]);

        Log::info('Gemini API response', ['response' => $response->body()]);

        if ($response->failed()) {
            throw new Exception(
                $response->json('error.message') ?? 'Gemini image analysis failed.'
            );
        }

        $resultText = $response->json('candidates.0.content.parts.0.text');

        if (!$resultText) {
            throw new Exception('Gemini returned empty response.');
        }

        return $this->parseJsonResponse($resultText);
    }

    private function getPrompt(array $categoryNames, array $subCategoryNames, string $languageName): string
    {
        $categoryList = $this->formatList($categoryNames);
        $subCategoryList = $this->formatList($subCategoryNames);

        $languageLine = $languageName !== ''
            ? "All human-readable text in your response must be written in {$languageName}."
            : 'All human-readable text must match the current site language.';

        return <<<PROMPT
You are a product image analysis assistant.

Analyze the image and identify the actual product being sold, not the outer packaging design.

Return only valid JSON.
Do not include markdown.
Do not include explanation.

The JSON structure must be exactly:

{
  "is_product": false,
  "product_name": "",
  "product_name_translated": "",
  "category": "",
  "subcategory": "",
  "matched_category": "",
  "matched_subcategory": "",
  "brand": "",
  "product_size": "",
  "price": "",
  "color": "",
  "material": "",
  "description": "",
  "confidence": 0
}

Important product identification rule:
- Focus on the actual product itself, not the outer packet, box, wrapper, bottle, jar, tube, label, or packaging.
- Packaging should only be used to read information such as product name, brand, size, price, ingredients, flavor, variant, or product type.
- Do not describe the packaging design unless the packaging itself is the product being sold.
- For example:
  - If the image shows a shampoo bottle, the product is shampoo, not a plastic bottle.
  - If the image shows a lip balm tube, the product is lip balm, not a tube.
  - If the image shows a cereal box, the product is cereal, not a cardboard box.
  - If the image shows a chips packet, the product is chips/snack, not a packet.
  - If the image shows a perfume bottle, the product is perfume, not a glass bottle.
  - If the image shows a medicine strip/box, the product is medicine, not the box or strip.

Product validation rules:
- Set "is_product" to true only when the image clearly shows a real physical product or its retail packaging.
- A valid product can include cosmetics, makeup, skincare, shampoo, conditioner, lip balm, food, beverages, electronics, clothing, shoes, furniture, medicines, household items, or similar sellable goods.
- Set "is_product" to false for screenshots, website pages, social media posts, ads, documents, memes, text-only images, people, animals, landscapes, buildings, or non-product content.
- If "is_product" is false, all string fields must be empty strings and "confidence" must be 0.

Field rules:
- "product_name" must be the actual product name exactly as it appears on the packaging label (keep the original language of the label).
  Example: "Dove Intensive Repair Shampoo", not "white bottle".
- "product_name_translated" must be the same product name translated into {$languageName}. If the product name is already in {$languageName}, copy it exactly. This field is used for database matching so translate accurately and naturally.
- "category" should be the broad product category, for example Cosmetics, Grocery, Electronics, Fashion, Medicine, Home.
- "subcategory" should describe the actual product type, for example Shampoo, Hair Conditioner, Lip Balm, Face Cream, Chips, Juice, Perfume, Medicine.
- "matched_category" must be the closest value from the provided category list only. If none fit, return empty string.
- "matched_subcategory" must be the closest value from the provided subcategory list only. If none fit, return empty string.
- "brand" should be returned only if clearly visible or strongly identifiable.
- "product_size" should be the product quantity or size from the label, for example 200 ml, 50 g, 1 L, 30 tablets.
- "price" should be returned only if clearly visible.
- "color" should describe the actual product color when visible. If the actual product is not visible, describe the expected/common product color only if obvious from the label, otherwise return empty string.
- "material" should describe the actual product material only when relevant and visible, for example cotton for a shirt, leather for shoes, metal for a pan. For liquids, creams, food, cosmetics, medicines, or packaged goods, return empty string.
- "description" must describe the actual product being sold, not the packaging.
  Good: "A hair conditioner for dry or damaged hair."
  Bad: "A white plastic bottle with a green label."
- "confidence" must be an integer from 0 to 100.
- If unsure, give the best product-level guess with lower confidence.
- Do not guess brand, size, or price unless visible.
- Do not describe packaging color, label design, box shape, bottle shape, wrapper design, or container material in description.

Language rule:
{$languageLine}

Category list:
{$categoryList}

Subcategory list:
{$subCategoryList}
PROMPT;
    }

    private function parseJsonResponse(string $text): array
    {
        $text = trim($text);

        // Remove markdown code block if AI accidentally returns it
        $text = Str::replace(['```json', '```'], '', $text);
        $text = trim($text);

        $data = json_decode($text, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON returned by Gemini.');
        }

        if (isset($data['is_product']) && $data['is_product'] === false) {
            throw new Exception('not_a_product');
        }

        return [
            'product_name' => $data['product_name'] ?? null,
            'product_name_translated' => $data['product_name_translated'] ?? null,
            'category' => $data['category'] ?? null,
            'subcategory' => $data['subcategory'] ?? null,
            'matched_category' => $data['matched_category'] ?? null,
            'matched_subcategory' => $data['matched_subcategory'] ?? null,
            'brand' => $data['brand'] ?? null,
            'product_size' => $data['product_size'] ?? null,
            'price' => $data['price'] ?? null,
            'color' => $data['color'] ?? null,
            'material' => $data['material'] ?? null,
            'description' => $data['description'] ?? null,
            'confidence' => $data['confidence'] ?? 0,
        ];
    }

    private function formatList(array $items): string
    {
        $items = array_values(array_filter(array_map('trim', $items)));

        if (empty($items)) {
            return '-';
        }

        return '- ' . implode("\n- ", $items);
    }
}