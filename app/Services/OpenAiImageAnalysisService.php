<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class OpenAiImageAnalysisService
{
    public function analyzeProductImage(UploadedFile $image): array
    {
        $base64Image = base64_encode(file_get_contents($image->getRealPath()));
        $mimeType = $image->getMimeType();

        $response = Http::withToken(config('settings.openai.api_key'))
            ->timeout(60)
            ->post('https://api.openai.com/v1/responses', [
                'model' => config('settings.openai.model'),

                'input' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => $this->getPrompt(),
                            ],
                            [
                                'type' => 'input_image',
                                'image_url' => "data:{$mimeType};base64,{$base64Image}",
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new Exception(
                $response->json('error.message') ?? 'OpenAI image analysis failed.'
            );
        }

        $resultText = $response->json('output.0.content.0.text');

        if (!$resultText) {
            throw new Exception('OpenAI returned empty response.');
        }

        return $this->parseJsonResponse($resultText);
    }

    private function getPrompt(): string
    {
        return <<<PROMPT
Analyze this image and determine if it shows an authentic physical product.

Return only valid JSON.

JSON structure must be exactly:

{
  "is_product": false,
  "product_name": "",
  "category": "",
  "subcategory": "",
  "brand": "",
  "color": "",
  "material": "",
  "description": "",
  "confidence": 0
}

Rules:
- is_product must be true ONLY if the image shows a real physical product (e.g. food packaging, cosmetics, electronics, clothing, household items, medicines, beverages). Set is_product to false for screenshots, social media posts, news articles, memes, documents, text-only images, people, animals, or any non-product content. If is_product is false, return empty strings and 0 for all other fields.
- product_name should be the most likely product name.
- category should be broad, for example Electronics, Fashion, Grocery, Cosmetics, Furniture, Home, Sports.
- subcategory should be specific, for example Mobile Phone, Shirt, Shampoo, Chair, Shoes.
- brand should be detected only if clearly visible.
- color should be the main visible color.
- material should be guessed only if visible.
- confidence should be from 0 to 100.
- If unsure, give the best guess with lower confidence.
- Do not include markdown.
- Do not include explanation.
- Return JSON only.
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
            throw new Exception('Invalid JSON returned by OpenAI.');
        }

        if (isset($data['is_product']) && $data['is_product'] === false) {
            throw new Exception('not_a_product');
        }

        return [
            'product_name' => $data['product_name'] ?? null,
            'category' => $data['category'] ?? null,
            'subcategory' => $data['subcategory'] ?? null,
            'brand' => $data['brand'] ?? null,
            'color' => $data['color'] ?? null,
            'material' => $data['material'] ?? null,
            'description' => $data['description'] ?? null,
            'confidence' => $data['confidence'] ?? 0,
        ];
    }
}