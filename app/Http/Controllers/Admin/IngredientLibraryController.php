<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\IngredientLibrary;
use App\Models\Translate;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientLibraryController extends Controller
{
    // Fields whose text is translated and stored in the translates table.
    private const TRANSLATABLE = ['name', 'description', 'concern_description', 'health_effects'];

    public function __construct(protected TranslationService $translationService)
    {
    }

    public function index()
    {
        $counters = [
            'total'     => IngredientLibrary::count(),
            'published' => IngredientLibrary::where('is_published', true)->count(),
            'draft'     => IngredientLibrary::where('is_published', false)->count(),
            'avoid'     => IngredientLibrary::where('severity', 'avoid')->count(),
            'concern'   => IngredientLibrary::where('severity', 'concern')->count(),
        ];

        $query = IngredientLibrary::orderBy('name');

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('inci_name', 'like', $searchTerm)
                    ->orWhere('cas_number', 'like', $searchTerm)
                    ->orWhere('concern_description', 'like', $searchTerm)
                    ->orWhere('health_effects', 'like', $searchTerm)
                    ->orWhere('regulatory_status', 'like', $searchTerm);
            });
        }

        if (request()->filled('severity')) {
            $query->where('severity', request('severity'));
        }

        if (request()->filled('status')) {
            $query->where('is_published', request('status') === '1');
        }

        $ingredients = $query->paginate(20)->appends(request()->only(['search', 'severity', 'status']));

        return view('admin.ingredients-library.index', compact('ingredients', 'counters'));
    }

    public function create()
    {
        $grades = ['good', 'average', 'poor'];
        return view('admin.ingredients-library.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $this->prepareData($request);

        if ($request->hasFile('image_url')) {
            $data['image_url'] = FileHandler::upload($request->file('image_url'), [
                'path' => 'images/ingredients',
            ]);
        }

        $allTranslations = [];
        $toTranslate = $this->buildTranslatables($data);
        if (!empty($toTranslate)) {
            $allTranslations = $this->translationService->detectAndTranslateMany($toTranslate);
            $this->applyEnglish($data, $allTranslations);
        }

        IngredientLibrary::create($data);

        $this->storeTranslations($allTranslations);

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.ingredients-library.index');
    }

    public function show(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        return view('admin.ingredients-library.show', compact('ingredient'));
    }

    public function edit(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        $grades = ['good', 'average', 'poor'];
        return view('admin.ingredients-library.edit', compact('ingredient', 'grades'));
    }

    public function update(Request $request, string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);

        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $this->prepareData($request);

        if ($request->hasFile('image_url')) {
            FileHandler::delete($ingredient->image_url);
            $data['image_url'] = FileHandler::upload($request->file('image_url'), [
                'path' => 'images/ingredients',
            ]);
        } else {
            // Keep the existing image — don't overwrite with null
            unset($data['image_url']);
        }

        $allTranslations = [];
        $toTranslate = $this->buildTranslatables($data);
        if (!empty($toTranslate)) {
            $allTranslations = $this->translationService->detectAndTranslateMany($toTranslate);
            $this->applyEnglish($data, $allTranslations);
        }

        $ingredient->update($data);

        $this->storeTranslations($allTranslations);

        toastr()->success(d_trans('Updated Successfully'));
        return redirect()->route('admin.ingredients-library.index');
    }

    public function destroy(string $id)
    {
        $ingredient = IngredientLibrary::findOrFail($id);
        $ingredient->delete();
        toastr()->success(d_trans('Deleted Successfully'));
        return redirect()->route('admin.ingredients-library.index');
    }

    // -------------------------------------------------------
    // Translation — same pattern as ProductController
    // Key = English text value; only nl/de rows stored in translates.
    // -------------------------------------------------------

    /**
     * Flatten all translatable text from $data into a scalar key => text map
     * ready for detectAndTranslateMany().
     */
    private function buildTranslatables(array $data): array
    {
        // Simple top-level text fields
        $texts = array_filter(
            array_intersect_key($data, array_flip(self::TRANSLATABLE))
        );

        // functions — array of strings
        foreach ($data['functions'] ?? [] as $i => $func) {
            if (!empty($func)) {
                $texts["function_{$i}"] = $func;
            }
        }

        // concerns — array of {category, concern_text, reference_org}
        foreach ($data['concerns'] ?? [] as $i => $concern) {
            if (!empty($concern['category'])) {
                $texts["concern_{$i}_cat"] = $concern['category'];
            }
            if (!empty($concern['concern_text'])) {
                $texts["concern_{$i}_text"] = $concern['concern_text'];
            }
        }

        // concern_flags — {FlagName: Level} — translate the level values
        foreach ($data['concern_flags'] ?? [] as $flagKey => $flagVal) {
            if (!empty($flagVal)) {
                $texts["flag_{$flagKey}"] = (string) $flagVal;
            }
        }

        return $texts;
    }

    /**
     * Write the English translation back into $data so the DB columns
     * always store normalised English text.
     */
    private function applyEnglish(array &$data, array $allTranslations): void
    {
        // Simple top-level fields
        foreach (self::TRANSLATABLE as $field) {
            if (!empty($allTranslations[$field]['en'])) {
                $data[$field] = $allTranslations[$field]['en'];
            }
        }

        // functions
        foreach ($data['functions'] ?? [] as $i => $func) {
            if (!empty($allTranslations["function_{$i}"]['en'])) {
                $data['functions'][$i] = $allTranslations["function_{$i}"]['en'];
            }
        }

        // concerns
        foreach ($data['concerns'] ?? [] as $i => $concern) {
            if (!empty($allTranslations["concern_{$i}_cat"]['en'])) {
                $data['concerns'][$i]['category'] = $allTranslations["concern_{$i}_cat"]['en'];
            }
            if (!empty($allTranslations["concern_{$i}_text"]['en'])) {
                $data['concerns'][$i]['concern_text'] = $allTranslations["concern_{$i}_text"]['en'];
            }
        }

        // concern_flags
        foreach (array_keys($data['concern_flags'] ?? []) as $flagKey) {
            if (!empty($allTranslations["flag_{$flagKey}"]['en'])) {
                $data['concern_flags'][$flagKey] = $allTranslations["flag_{$flagKey}"]['en'];
            }
        }
    }

    private function storeTranslations(array $allTranslations): void
    {
        $rows = [];

        foreach ($allTranslations as $translations) {
            $enKey = $translations['en'] ?? null;
            if (!$enKey) continue;

            foreach ($translations as $lang => $value) {
                if ($lang === 'en' || $value === null) continue;
                $rows[] = [
                    'key'   => $enKey,
                    'lang'  => $lang,
                    'value' => $value,
                    'type'  => Translate::TYPE_DYNAMIC,
                ];
            }
        }

        if (!empty($rows)) {
            Translate::upsert($rows, ['key', 'lang'], ['value', 'type']);
        }
    }

    // -------------------------------------------------------
    // Shared validation rules
    // -------------------------------------------------------

    private function rules(?string $ignoreId = null): array
    {
        return [
            'name'                     => 'required|string|max:255|unique:ingredients_library,name' . ($ignoreId ? ",{$ignoreId}" : ''),
            'inci_name'                => 'nullable|string|max:255',
            'severity'                 => 'nullable|in:none,avoid,concern,caution',
            'concern_description'      => 'nullable|string',
            'description'              => 'nullable|string',
            'health_effects'           => 'nullable|string',
            'regulatory_status'        => 'nullable|string|max:255',
            'cas_number'               => 'nullable|string|max:255',
            'is_published'             => 'nullable|boolean',
            'oko_verified'             => 'nullable|boolean',
            'hazard_score'             => 'nullable|integer|min:0|max:10',
            'concerns'                 => 'nullable|array',
            'concerns.*.category'      => 'nullable|string|max:255',
            'concerns.*.concern_text'  => 'nullable|string',
            'concerns.*.reference_org' => 'nullable|string|max:255',
            'functions'                => 'nullable|array',
            'functions.*'              => 'nullable|string|max:255',
            'synonyms'                 => 'nullable|array',
            'synonyms.*'               => 'nullable|string|max:255',
            'concern_flags'            => 'nullable|array',
            'image_url'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'source'                   => 'nullable|string',
            'inhalation_risk_flag'     => 'nullable|boolean',
        ];
    }

    // -------------------------------------------------------
    // Request → model data
    // -------------------------------------------------------

    private function prepareData(Request $request): array
    {
        $data = $request->except(['_token', '_method', 'concern_flag_keys', 'concern_flag_values', 'image_url']);

        $data['is_published']         = $request->boolean('is_published');
        $data['oko_verified']         = $request->boolean('oko_verified');
        $data['inhalation_risk_flag'] = $request->boolean('inhalation_risk_flag');

        // Parse newline-delimited tag inputs into arrays
        foreach (['functions', 'synonyms'] as $field) {
            if ($request->filled($field) && is_string($request->input($field))) {
                $data[$field] = array_values(array_filter(array_map('trim', explode("\n", $request->input($field)))));
            }
        }

        // Remove empty concern rows
        if (isset($data['concerns'])) {
            $data['concerns'] = array_values(array_filter($data['concerns'], fn($c) => !empty($c['concern_text'])));
        }

        // Build concern_flags from submitted key/value pairs
        $keys   = $request->input('concern_flag_keys', []);
        $values = $request->input('concern_flag_values', []);
        $flags  = [];
        foreach ($keys as $i => $key) {
            if (!empty($key)) {
                $flags[$key] = $values[$i] ?? '';
            }
        }
        $data['concern_flags'] = $flags ?: null;

        return $data;
    }
}
