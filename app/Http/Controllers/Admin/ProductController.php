<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\IngredientLibrary;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->with(['category', 'subCategory']);
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();

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
        $counters['lab_verified'] = $filteredProducts->where('lab_verified', true)->count();

        $products = $products->orderbyDesc('id')->paginate(50);
        $products->appends(request()->only(['search', 'category', 'sub_category', 'status', 'featured']));

        return view('admin.products.index', [
            'counters' => $counters,
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
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
            'subcategories' => $subCategories,
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
        $data['view_count'] = $data['view_count'] ?? 0;

        if (empty($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        $uploadedImages = $this->uploadProductImages($request);

        if (!empty($uploadedImages)) {
            $data['image'] = $uploadedImages[0];
        }

        $product = Product::create($data);

        // brands , categories, subcategories
        $brands = Brand::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();

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
        $subcategories = SubCategory::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'subcategories' => $subcategories,
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
            
            $categories = Category::select('id', 'name')->get();
            $subcategories = SubCategory::select('id', 'name')->get();
            $brands = Brand::select('id', 'name')->get();
            $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();

            return view('admin.products.edit', [
                'product' => $product,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'brands' => $brands,
                'ingredientLibraries' => $ingredientLibraries,
                'grades' => $this->availableGrades(),
            ])->withInput();
        }

        $data = $validator->validated();
        $data['organic_certified'] = $request->boolean('organic_certified');
        $data['lab_verified'] = $request->boolean('lab_verified');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['view_count'] = $data['view_count'] ?? $product->view_count;

        if (empty($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        $uploadedImages = $this->uploadProductImages($request);

        if (!empty($uploadedImages) && empty($product->image)) {
            $data['image'] = $uploadedImages[0];
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

    public function labTestsUpdate(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'mineral_uv_filter' => ['nullable', 'string', 'max:255'],
            'lab_name' => ['nullable', 'string', 'max:255'],
            'ingredient_grade' => ['nullable', 'string', 'in:' . implode(',', $this->availableGrades())],
            'defects_grade' => ['nullable', 'string', 'in:' . implode(',', $this->availableGrades())],
            'overall_grade' => ['nullable', 'string', 'in:' . implode(',', $this->availableGrades())],
            'tested_at' => ['nullable', 'date'],
            'footnote_ref' => ['nullable', 'string', 'max:255'],
            'footnote_text' => ['nullable', 'string'],
            'test_summary' => ['nullable', 'string'],
            'concerning_uv_filter' => ['nullable', 'boolean'],
            'has_fragrance' => ['nullable', 'boolean'],
            'plastic_compounds' => ['nullable', 'boolean'],
            'further_concerns' => ['nullable', 'boolean'],
            'further_concerns_detail' => ['nullable', 'string', 'max:500'],
            'further_defects' => ['nullable', 'boolean'],
            'further_defects_detail' => ['nullable', 'string', 'max:500'],

            'concerns' => ['nullable', 'array'],
            'concerns.*.ingredient_library_id' => ['nullable', 'integer', 'exists:ingredients_library,id'],
            'concerns.*.ingredient_name' => ['required_with:concerns.*.severity', 'string', 'max:255'],
            'concerns.*.inci_name' => ['nullable', 'string', 'max:255'],
            'concerns.*.severity' => ['required_with:concerns.*.ingredient_name', 'string', 'in:avoid,concern,caution'],
            'concerns.*.concentration' => ['nullable', 'numeric', 'min:0'],
            'concerns.*.description' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            
            $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();
            
            return back()->withInput()->with([
                'ingredientLibraries' => $ingredientLibraries,
                'grades' => $this->availableGrades(),
            ]);
        }

        $data = $validator->validated();

        // Prepare Lab Testing Data
        $labData = [
            'mineral_uv_filter' => $data['mineral_uv_filter'] ?? null,
            'lab_name' => $data['lab_name'] ?? null,
            'ingredient_grade' => $data['ingredient_grade'] ?? null,
            'defects_grade' => $data['defects_grade'] ?? null,
            'overall_grade' => $data['overall_grade'] ?? null,
            'tested_at' => $data['tested_at'] ?? null,
            'footnote_ref' => $data['footnote_ref'] ?? null,
            'footnote_text' => $data['footnote_text'] ?? null,
            'test_summary' => $data['test_summary'] ?? null,
            'concerning_uv_filter' => $request->boolean('concerning_uv_filter'),
            'has_fragrance' => $request->boolean('has_fragrance'),
            'plastic_compounds' => $request->boolean('plastic_compounds'),
            'further_concerns' => $request->boolean('further_concerns'),
            'further_concerns_detail' => $data['further_concerns_detail'] ?? null,
            'further_defects' => $request->boolean('further_defects'),
            'further_defects_detail' => $data['further_defects_detail'] ?? null,
        ];

        // === IMPROVED CONCERNS PROCESSING ===
        $concernsData = collect($data['concerns'] ?? [])
            ->map(function ($concern) {
                return [
                    'ingredient_library_id' => !empty($concern['ingredient_library_id']) ? (int) $concern['ingredient_library_id'] : null,
                    'ingredient_name' => trim($concern['ingredient_name'] ?? ''),
                    'inci_name' => trim($concern['inci_name'] ?? '') ?: null,
                    'severity' => $concern['severity'] ?? null,
                    'concentration' => $concern['concentration'] ?? null,
                    'description' => trim($concern['description'] ?? '') ?: null,
                ];
            })
            ->filter(function ($concern) {
                // Keep only rows that have at least name + severity
                return !empty($concern['ingredient_name']) && !empty($concern['severity']);
            })
            ->values()
            ->all();

        DB::transaction(function () use ($product, $labData, $concernsData) {
            // Update or create lab test record
            $product->labTestingResult()->updateOrCreate(
                ['product_id' => $product->id],
                $labData
            );

            // Delete old concerns and insert new ones
            $product->ingredientConcerns()->delete();

            if (!empty($concernsData)) {
                $product->ingredientConcerns()->createMany($concernsData);
            }

            // Optional: sync overall grade
            if (!empty($labData['overall_grade'])) {
                $product->update(['overall_grade' => $labData['overall_grade']]);
            }
        });

        toastr()->success(d_trans('Lab tests updated successfully'));
        return back();
    }


    public function labTests(Product $product)
    {
        $product->load(['category', 'subCategory', 'images', 'labTestingResult', 'ingredientConcerns']);
        $ingredientLibraries = IngredientLibrary::select('id', 'name')->orderBy('name')->get();
        return view('admin.products.lab-tests', [
            'product' => $product,
            'ingredientLibraries' => $ingredientLibraries,
            'grades' => $this->availableGrades(),
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
