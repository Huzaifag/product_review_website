<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MailTemplate;
use App\Models\Translate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $languages->where('name', 'like', $searchTerm)
                ->OrWhere('code', 'like', $searchTerm);
        }

        $languages = $languages->get();

        return view('admin.settings.languages.index', ['languages' => $languages]);
    }

    public function sortable(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || is_null($ids) || !is_array($ids)) {
            return response()->json(['error' => d_trans('Failed to sort the table')]);
        }

        foreach ($ids as $sortOrder => $id) {
            $language = Language::find($id);
            $language->sort_id = ($sortOrder + 1);
            $language->update();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.settings.languages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'name' => ['required', 'string', 'block_patterns', 'max:150'],
            'code' => ['required', 'string', 'unique:languages', 'in:' . implode(',', array_keys(Language::getAvailableLanguages()))],
            'direction' => ['required', 'string', 'in:' . implode(',', array_keys(Language::getAvailableDirections()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $logo = FileHandler::upload($request->file('logo'), [
                'name' => $request->code,
                'path' => 'images/languages/',
            ]);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $language = new Language();
        $language->name = $request->name;
        $language->logo = $logo;
        $language->code = $request->code;
        $language->direction = $request->direction;
        $language->save();

        $this->createLanguageTranslates($language);
        $this->createLanguageMailTemplates($language);

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.settings.languages.translates', $language->id);
    }

    public function edit(Language $language)
    {
        return view('admin.settings.languages.edit', ['language' => $language]);
    }

    public function update(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'name' => ['required', 'string', 'block_patterns', 'max:150'],
            'direction' => ['required', 'string', 'in:' . implode(',', array_keys(Language::getAvailableDirections()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            if ($request->hasFile('logo')) {
                $logo = FileHandler::upload($request->file('logo'), [
                    'name' => $language->code,
                    'path' => 'images/languages/',
                    'old_file' => $language->logo,
                ]);
            } else {
                $logo = $language->logo;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $language->name = $request->name;
        $language->logo = $logo;
        $language->direction = $request->direction;
        $language->update();

        if ($language->isDefault()) {
            setEnv('APP_LOCALE', $language->code);
            setEnv('APP_FALLBACK_LOCALE', $language->code);
            setEnv('APP_FAKER_LOCALE', $language->code . '_' . strtoupper($language->code));
            setEnv('APP_DIRECTION', $language->direction);

            if (getLocale() == $language->code) {
                App::setLocale($language->code);
                Cookie::queue('locale', $language->code, 1440 * 30);
                Cookie::queue('direction', $language->direction, 1440 * 30);
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function translates(Language $language, $type = null)
    {
        $type = $type ?? Translate::TYPE_DYNAMIC;

        $translates = $language->translates()->where('type', $type);

        if (request()->filled('search')) {
            if (request()->filled('search')) {
                $searchTerm = '%' . request('search') . '%';
                $translates->where(function ($query) use ($searchTerm) {
                    $query->where('key', 'like', $searchTerm)
                        ->orWhere('value', 'like', $searchTerm);
                });
            }
        }

        $translates = $translates->orderbyDesc('id')->paginate(50);
        $translates->appends(request()->only(['search']));

        return view('admin.settings.languages.translates', [
            'type' => $type,
            'language' => $language,
            'translates' => $translates,
        ]);
    }

    public function translatesStore(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required', 'string', 'block_patterns'],
            'value' => ['nullable', 'string', 'block_patterns'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $keyExists = Translate::manual()->where('key', $request->key)
            ->where('lang', $language->code)
            ->exists();
        if ($keyExists) {
            toastr()->error(d_trans('The key is already exists'));
            return back();
        }

        $translate = new Translate();
        $translate->key = $request->key;
        $translate->value = $request->value;
        $translate->lang = $language->code;
        $translate->type = Translate::TYPE_MANUAL;
        $translate->save();

        toastr()->success(d_trans('Added Successfully'));
        return back();
    }

    public function translatesUpdate(Request $request, Language $language)
    {
        foreach ($request->translates as $id => $value) {
            $translate = $language->translates()->where('id', $id)->first();
            if ($translate) {
                $translate->value = $value;
                $translate->save();
            }
        }

        toastr()->success(d_trans('Updated Successfully'));
        toastr()->info(d_trans('Clear the cache to apply the changes'));
        return back();
    }

    public function translatesDestroy(Language $language, Translate $translate)
    {
        if ($translate->isManual() && $translate->language->id == $language->id) {
            $translate->delete();
            toastr()->success(d_trans('Deleted Successfully'));
        }

        return back();
    }

    public function makeDefault(Request $request, Language $language)
    {
        setEnv('APP_LOCALE', $language->code);
        setEnv('APP_FALLBACK_LOCALE', $language->code);
        setEnv('APP_FAKER_LOCALE', $language->code . '_' . strtoupper($language->code));
        setEnv('APP_DIRECTION', $language->direction);

        toastr()->success(d_trans('The default language has been changed successfully'));
        return back();
    }

    public function destroy(Language $language)
    {
        if ($language->isDefault()) {
            toastr()->error(d_trans('The default language cannot be deleted'));
            return back();
        }

        if ($language->code == getLocale()) {
            toastr()->error(d_trans('You cannot delete your current language'));
            return back();
        }

        FileHandler::delete($language->logo);
        $language->delete();

        toastr()->success(d_trans('Deleted Successfully'));
        return back();
    }

    private function createLanguageTranslates($language)
    {
        $translates = Language::with('translates')->default()->first()->translates;
        foreach ($translates as $translate) {
            $trans = new Translate();
            $trans->lang = $language->code;
            $trans->key = $translate->key;
            $trans->value = $translate->key;
            $trans->save();
        }
    }

    public function createLanguageMailTemplates($language)
    {
        $mailTemplates = MailTemplate::all();
        foreach ($mailTemplates as $mailTemplate) {
            $template = new MailTemplate();
            $template->name = $mailTemplate->name;
            $template->alias = $mailTemplate->alias;
            $template->group = $mailTemplate->group;
            $template->subject = $mailTemplate->subject;
            $template->body = $mailTemplate->body;
            $template->shortcodes = $mailTemplate->shortcodes;
            $template->status = $mailTemplate->status;
            $template->lang = $language->code;
            $template->save();
        }
    }
}
