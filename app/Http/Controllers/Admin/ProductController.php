<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
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
                    ->orWhere('brand_name', 'like', $searchTerm)
                    ->orWhere('overall_grade', 'like', $searchTerm);
            });
        }

        if (request()->filled('category')) {
            $products->where('category_id', request('category'));
        }

        if (request()->filled('sub_category')) {
            $products->where('sub_category_id', request('sub_category'));
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

        return view('admin.products.create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
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
            return back()->withInput();
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

        if ($request->hasFile('image')) {
            $data['image'] = FileHandler::upload($request->file('image'), [
                'path' => 'images/products',
            ]);
        }

        $product = Product::create($data);

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.products.show', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subCategory', 'labTestingResult', 'ingredientConcerns']);
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();

        return view('admin.products.show', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'grades' => $this->availableGrades(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        $subCategories = SubCategory::select('id', 'name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories,
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
            return back()->withInput();
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

        if ($request->hasFile('image')) {
            $data['image'] = FileHandler::upload($request->file('image'), [
                'path' => 'images/products',
                'old_file' => $product->image,
            ]);
        }

        $product->update($data);

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.products.index');
    }

    private function validationRules(?int $productId = null): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'brand_name' => ['required', 'string', 'max:191'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
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
}
