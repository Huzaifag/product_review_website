<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\IngredientLibrary;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTest;
use App\Models\SubCategory;
use App\Models\TestAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use App\Services\TranslationService;
use App\Models\Translate;

class ProductController extends Controller
{
    //call constructor for TranslationService
    public function __construct(protected TranslationService $translationService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->with(['category', 'subCategory']);
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $products->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('slug', 'like', $searchTerm)
                    ->orWhere('overall_grade', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $products->where('category_id', request('category'));
        }

        if (request()->filled('sub_category')) {
            $products->where('sub_category_id', request('sub_category'));
        }

        //brand filter
        if (request()->filled('brand')) {
            $products->where('brand_id', request('brand'));
        }

        if (request()->filled('status')) {
            $products->where('is_active', request('status'));
        }

        if (request()->filled('featured')) {
            $products->where('is_featured', request('featured'));
        }

        $filteredProducts = $products->get();
        $counters['active'] = $filteredProducts->where('is_active', true)->count();
        $counters['inactive'] = $filteredProducts->where('is_active', false)->count();
        $counters['featured'] = $filteredProducts->where('is_featured', true)->count();
        $counters['lab_verified'] = ProductTest::whereIn('product_id', $filteredProducts->pluck('id'))->where('status', 'active')->count();
        $counters['oko_verified'] = $filteredProducts->where('oko_verified', true)->count();

        $products = $products->orderbyDesc('id')->paginate(50);
        $products->appends(request()->only(['search', 'category', 'sub_category', 'brand', 'status', 'featured']));

        return view('admin.products.index', [
            'counters' => $counters,
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
            'ingredientLibraries' => $ingredientLibraries,
            'grades' => $this->availableGrades(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }

            $categories = Category::select('id', 'name')->get();
            $subCategories = SubCategory::select('id', 'name')->get();
            $brands = Brand::select('id', 'name')->get();
            $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

            return view('admin.products.create', [
                'categories' => $categories,
                'subCategories' => $subCategories,
                'brands' => $brands,
                'ingredientLibraries' => $ingredientLibraries,
                'grades' => $this->availableGrades(),
            ])->withInput();
        }

        $data = $validator->validated();
        $data['organic_certified'] = $request->boolean('organic_certified');
        $data['lab_verified'] = $request->boolean('lab_verified');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['oko_verified'] = $request->boolean('oko_verified');
        $data['view_count'] = $data['view_count'] ?? 0;

        if (empty($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        $uploadedImages = $this->uploadProductImages($request);

        if (!empty($uploadedImages)) {
            $data['image'] = $uploadedImages[0];
        }

        // Generate slug from name if not provided
        if (empty($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $toTranslate = array_filter([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        $allTranslations = $this->translationService->detectAndTranslateMany($toTranslate);

        if (!empty($allTranslations['name']['en'])) {
            $data['name'] = $allTranslations['name']['en'];
        }
        if (!empty($allTranslations['description']['en'])) {
            $data['description'] = $allTranslations['description']['en'];
        }

        $product = Product::create($data);

        $this->storeTranslations($allTranslations);

        $this->storeProductImages($product, $uploadedImages);

        toastr()->success(d_trans('Created Successfully'));

        return redirect()->route('admin.products.show', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subCategory', 'labTestingResult', 'ingredientConcerns', 'images']);
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

        return view('admin.products.show', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
            'ingredientLibraries' => $ingredientLibraries,
            'grades' => $this->availableGrades(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['images']);
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
            'ingredientLibraries' => $ingredientLibraries,
            'grades' => $this->availableGrades(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), $this->validationRules($product->id));

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }

            return redirect()->back()
                ->withInput()
                ->with([
                    'categories' => Category::select('id', 'name')->get(),
                    'subCategories' => SubCategory::select('id', 'name')->get(),
                    'brands' => Brand::select('id', 'name')->get(),
                    'ingredientLibraries' => IngredientLibrary::select('id', 'name')->orderBy('name')->get(),
                    'grades' => $this->availableGrades(),
                ]);
        }

        $data = $validator->validated();

        // Booleans
        foreach (['organic_certified', 'lab_verified', 'is_featured', 'is_active', 'oko_verified'] as $bool) {
            $data[$bool] = $request->boolean($bool);
        }

        $data['view_count'] = $data['view_count'] ?? $product->view_count;

        // Empty slug → drop it (keep existing)
        if (empty($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        // Image: use uploaded, fallback to existing (skip placeholder)
        $uploadedImages = $this->uploadProductImages($request);
        $data['image'] = $uploadedImages[0]
            ?? (str_contains($product->image, 'placeholder') ? null : $product->image)
            ?? $product->image;

        // Generate slug from name if not provided
        if (empty($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        $this->storeProductImages($product, $uploadedImages);

        toastr()->success(d_trans('Updated Successfully'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            FileHandler::delete($image->path);
        }

        FileHandler::delete($product->image);

        $product->delete();

        toastr()->success(d_trans('Deleted Successfully'));

        return redirect()->route('admin.products.index');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:products,id'],
        ]);

        $products = Product::with('images')->whereIn('id', $request->ids)->get();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                FileHandler::delete($image->path);
            }
            FileHandler::delete($product->image);
            $product->delete();
        }

        toastr()->success(d_trans('Deleted Successfully'));

        return redirect()->route('admin.products.index');
    }

    public function labTestsUpdate(Request $request, Product $product)
    {
        $request->validate([
            'product_test_name' => ['required', 'string', 'max:255'],
            'product_test_status' => ['required', 'string', 'in:active,inactive'],
            'test_attribute' => ['required', 'array'],
            [
                'data.required' => 'Lab test data cannot be empty.',
            ]
        ]);

        // Clean and build attribute data
        $attributeData = [];
        $rawAttributes = $request->input('test_attribute', []);
        foreach ($rawAttributes as $attributeId => $value) {
            $value = is_string($value) ? trim($value) : $value;
            if ($value !== null && $value !== '') {
                $attributeData[$attributeId] = $value;
            }
        }

        $matchData = ['product_id' => $product->id];
        $fillData = [
            'product_id' => $product->id,
            'category_id' => $product->category_id,
            'sub_category_id' => $product->sub_category_id,
            'name' => $request->product_test_name,
            'data' => !empty($attributeData) ? $attributeData : null,
            'status' => $request->product_test_status,
        ];

        // dd([
        //     'request' => $request->all(),
        //     'product' => $product->toArray(),
        //     'fillData' => $fillData,
        //     'matchData' => $matchData,
        // ]);

        ProductTest::updateOrCreate($matchData, $fillData);

        toastr()->success(d_trans('Product test updated successfully'));

        return back();
    }

    public function labTests(Product $product)
    {
        $testAttributes = TestAttribute::active()->orderBy('name')->get();

        // 1. Own test → load with real values
        $productTest = ProductTest::where('product_id', $product->id)->latest()->first();



        // 2. No own test → use same category/subcategory as structure template (null values)
        if (!$productTest) {
            $templateTest = ProductTest::where('category_id', $product->category_id)
                ->where('sub_category_id', $product->sub_category_id)
                ->whereNotNull('data')
                ->latest()
                ->first();

            if ($templateTest) {
                $productTest = $templateTest->replicate();
                $productTest->exists = false;
                $productTest->product_id = $product->id;
                $productTest->data = array_fill_keys(
                    array_map('strval', array_keys($templateTest->data)),
                    null
                );
            }
        }

        return view('admin.products.lab-tests', [
            'product' => $product,
            'testAttributes' => $testAttributes,
            'productTest' => $productTest,
        ]);
    }

    private function validationRules(?int $productId = null): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'product_size' => ['nullable', 'string', 'max:255'],
            'organic_certifier' => ['nullable', 'string', 'max:255'],
            'overall_grade' => ['nullable', 'string', 'in:' . implode(',', $this->availableGrades())],
            'ingredients_inci' => ['nullable', 'string'],
            'test_date' => ['nullable', 'date'],
            'test_year' => ['nullable', 'string', 'size:4'],
            'test_edition' => ['nullable', 'string', 'max:255'],
            'magazine_page' => ['nullable', 'integer', 'min:1'],
            'view_count' => ['nullable', 'integer', 'min:0'],
            'oko_verified' => ['nullable', 'boolean'],
            'hazard_score' => ['nullable', 'integer', 'min:0', 'max:10'],
        ];
    }

    private function availableGrades(): array
    {
        return [
            'very_good',
            'good',
            'satisfactory',
            'adequate',
            'poor',
            'failing',
        ];
    }

    private function uploadProductImages(Request $request): array
    {
        $uploadedFiles = [];

        if ($request->hasFile('image')) {
            $uploadedFiles[] = $request->file('image');
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file) {
                    $uploadedFiles[] = $file;
                }
            }
        }

        if (empty($uploadedFiles)) {
            return [];
        }

        $uploadedImages = [];

        foreach ($uploadedFiles as $file) {
            $uploadedImages[] = FileHandler::upload($file, [
                'path' => 'images/products',
            ]);
        }

        return $uploadedImages;
    }

    private function storeTranslations(array $allTranslations): void
    {
        $rows = [];

        foreach ($allTranslations as $translations) {
            $enKey = $translations['en'] ?? null;
            if (!$enKey) continue;

            foreach ($translations as $lang => $value) {
                if ($lang === 'en' || $value === null) continue;
                $rows[] = ['key' => $enKey, 'lang' => $lang, 'value' => $value, 'type' => Translate::TYPE_DYNAMIC];
            }
        }

        if (!empty($rows)) {
            Translate::upsert($rows, ['key', 'lang'], ['value', 'type']);
        }
    }

    private function storeProductImages(Product $product, array $uploadedImages): void
    {
        foreach ($uploadedImages as $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
            ]);
        }
    }
}
