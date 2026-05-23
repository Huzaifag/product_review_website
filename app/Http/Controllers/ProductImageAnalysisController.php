<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use App\Services\GeminiImageAnalysisService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ProductImageAnalysisController extends Controller
{
    public function analyze(Request $request, GeminiImageAnalysisService $geminiService)
    {
        $validator = Validator::make($request->all(), [
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            $imageFile = $request->file('image');
            $categoryNames = Category::query()->pluck('name')->all();
            $subCategoryNames = SubCategory::query()->pluck('name')->all();
            $locale = app()->getLocale();
            $languageName = $locale;

            if (function_exists('languages')) {
                $language = languages($locale);

                if ($language) {
                    $languageName = $language->trans->name ?? $language->name ?? $locale;
                }
            }

            $analysis = $geminiService->analyzeProductImage(
                $imageFile,
                $categoryNames,
                $subCategoryNames,
                $languageName
            );

            $fileName = Str::uuid().'.'.$imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('uploads'), $fileName);
            $imageUrl = asset('uploads/'.$fileName);
            $categoryName = trim((string) ($analysis['matched_category'] ?? $analysis['category'] ?? ''));
            $subCategoryName = trim((string) ($analysis['matched_subcategory'] ?? $analysis['subcategory'] ?? ''));
            $brandName = trim((string) ($analysis['brand'] ?? ''));
            $productName = trim((string) ($analysis['product_name'] ?? ''));
            $productNameTranslated = trim((string) ($analysis['product_name_translated'] ?? ''));

            $category = $categoryName !== ''
                ? Category::query()
                    ->whereRaw('LOWER(name) LIKE ?', ['%'.Str::lower($categoryName).'%'])
                    ->first()
                : null;

            $subCategory = $subCategoryName !== ''
                ? SubCategory::query()
                    ->when($category, function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    })
                    ->where(function ($query) use ($subCategoryName) {
                        $firstWord = trim(strtok($subCategoryName, ' '));

                        $query->where('name', 'like', '%'.$subCategoryName.'%');

                        if ($firstWord !== '' && $firstWord !== $subCategoryName) {
                            $query->orWhere('name', 'like', '%'.$firstWord.'%');
                        }
                    })
                    ->first()
                : null;

            $brand = $brandName !== ''
                ? Brand::query()
                    ->active()
                    ->where('name', 'like', '%'.$brandName.'%')
                    ->first()
                : null;

            $exactProduct = null;

            // Build list of names to try: translated name first, then original
            $namesToTry = array_values(array_unique(array_filter(
                [$productNameTranslated, $productName],
                fn($n) => $n !== ''
            )));

            $stripPunct = fn(string $s): string =>
                preg_replace('/\s+/', ' ', trim(strtolower(preg_replace('/[^a-z0-9\s]+/i', '', $s))));

            $tokenize = fn(string $s): array =>
                array_values(array_unique(array_filter(
                    preg_split('/\s+/', $stripPunct($s)),
                    fn($w) => strlen($w) >= 3
                )));

            $jaccard = function (array $a, array $b): float {
                $intersection = count(array_intersect($a, $b));
                $union        = count(array_unique(array_merge($a, $b)));
                return $union > 0 ? $intersection / $union : 0.0;
            };

            foreach ($namesToTry as $nameAttempt) {
                // Stage 1: exact case-insensitive DB match
                $exactProduct = Product::query()
                    ->with(['category', 'subCategory', 'brand'])
                    ->active()
                    ->when($brand,       fn($q) => $q->where('brand_id',        $brand->id))
                    ->when($category,    fn($q) => $q->where('category_id',     $category->id))
                    ->when($subCategory, fn($q) => $q->where('sub_category_id', $subCategory->id))
                    ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($nameAttempt))])
                    ->first();

                if ($exactProduct) break;

                // Fetch candidates once for stages 2 & 3
                $candidates = Product::query()
                    ->active()
                    ->when($brand,       fn($q) => $q->where('brand_id',        $brand->id))
                    ->when($category,    fn($q) => $q->where('category_id',     $category->id))
                    ->when($subCategory, fn($q) => $q->where('sub_category_id', $subCategory->id))
                    ->get(['id', 'name']);

                // Stage 2: normalized exact match (punctuation stripped, whitespace collapsed)
                $normalizedAttempt = $stripPunct($nameAttempt);
                foreach ($candidates as $candidate) {
                    if ($stripPunct($candidate->name) === $normalizedAttempt) {
                        $exactProduct = Product::query()
                            ->with(['category', 'subCategory', 'brand'])
                            ->find($candidate->id);
                        break;
                    }
                }

                if ($exactProduct) break;

                // Stage 3: word-overlap similarity — Jaccard >= 0.5 on meaningful words (3+ chars)
                $attemptTokens = $tokenize($nameAttempt);
                $bestScore     = 0.0;
                $bestId        = null;

                foreach ($candidates as $candidate) {
                    $score = $jaccard($attemptTokens, $tokenize($candidate->name));
                    if ($score > $bestScore) {
                        $bestScore = $score;
                        $bestId    = $candidate->id;
                    }
                }

                if ($bestScore >= 0.5 && $bestId) {
                    $exactProduct = Product::query()
                        ->with(['category', 'subCategory', 'brand'])
                        ->find($bestId);
                }

                if ($exactProduct) break;
            }

            $matchedProducts = collect();
            $categoryProducts = collect();
            $brandProducts = collect();

            if ($subCategory) {
                $matchedProducts = Product::query()
                    ->with(['category', 'subCategory'])
                    ->active()
                    ->where('sub_category_id', $subCategory->id)
                    ->when($exactProduct, function ($query) use ($exactProduct) {
                        $query->where('id', '!=', $exactProduct->id);
                    })
                    ->limit(12)
                    ->get();
            }

            if ($category) {
                $excludeIds = $matchedProducts->pluck('id')->all();

                $categoryProducts = Product::query()
                    ->with(['category', 'subCategory'])
                    ->active()
                    ->where('category_id', $category->id)
                    ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                        $query->whereNotIn('id', $excludeIds);
                    })
                    ->limit(12)
                    ->get();
            }

            if ($brand) {
                $excludeIds = $matchedProducts->pluck('id')
                    ->merge($categoryProducts->pluck('id'))
                    ->all();

                $brandProducts = Product::query()
                    ->with(['category', 'subCategory', 'brand'])
                    ->active()
                    ->where('brand_id', $brand->id)
                    ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                        $query->whereNotIn('id', $excludeIds);
                    })
                    ->limit(12)
                    ->get();
            }

            return view('themes.basic.image-analysis', [
                'analysis' => $analysis,
                'categoryMatch' => $category,
                'subCategoryMatch' => $subCategory,
                'brandMatch' => $brand,
                'exactProduct' => $exactProduct,
                'matchedProducts' => $matchedProducts,
                'categoryProducts' => $categoryProducts,
                'brandProducts' => $brandProducts,
                'imageUrl' => $imageUrl,
            ]);
        } catch (Exception $e) {
            $raw = strtolower($e->getMessage());

            if ($raw === 'not_a_product') {
                $friendly = 'Please upload a clear image of a real physical product. Supported items include makeup, cosmetics, hair conditioner, lip balm, and similar products.).';
            } elseif (str_contains($raw, '429') || str_contains($raw, 'quota') || str_contains($raw, 'rate limit') || str_contains($raw, 'resource_exhausted')) {
                $friendly = 'The system could not read this image. Please try a clearer photo.';
            } elseif (str_contains($raw, 'api key') || str_contains($raw, 'api_key') || str_contains($raw, 'invalid key') || str_contains($raw, 'permission')) {
                $friendly = 'Image analysis is not configured correctly. Please contact support.';
            } elseif (str_contains($raw, 'timeout') || str_contains($raw, 'timed out') || str_contains($raw, 'connection')) {
                $friendly = 'The request timed out. Please check your connection and try again.';
            } elseif (str_contains($raw, 'empty response') || str_contains($raw, 'could not parse')) {
                $friendly = 'The AI could not read this image. Please try a clearer photo.';
            } else {
                $friendly = 'Something went wrong while analyzing your image. Please try again.';
            }

            return redirect()->back()->withErrors([
                'image' => $friendly,
            ])->withInput();
        }
    }


}
