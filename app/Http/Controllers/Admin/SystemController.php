<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\EditorImage;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZipArchive;

class SystemController extends Controller
{
    public function index()
    {
        return view('admin.system.index');
    }

    public function information()
    {
        return view('admin.system.information');
    }

    public function cache()
    {
        Artisan::call('optimize:clear');
        FileHandler::delete('storage/logs/laravel.log', 'direct');

        toastr()->success(d_trans('Cache Cleared Successfully'));
        return back();
    }

    public function maintenance()
    {
        return view('admin.system.maintenance');
    }

    public function maintenanceUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maintenance.title' => ['required_if:maintenance.status,on', 'nullable', 'string', 'max:150'],
            'maintenance.body' => ['required_if:maintenance.status,on', 'nullable', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $maintenance = $requestData['maintenance'];

        $maintenance['status'] = ($request->has('maintenance.status')) ? 1 : 0;

        $update = Setting::updateSettings('maintenance', $maintenance);
        if (!$update) {
            toastr()->error(d_trans('Updated Error'));
            return back();
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function addons()
    {
        $addons = Addon::orderbyDesc('id')->get();
        return view('admin.system.addons', [
            'addons' => $addons,
        ]);
    }

    public function addonsUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_code' => ['required', 'string'],
            'addon_files' => ['required', 'mimes:zip'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!class_exists('ZipArchive')) {
            toastr()->error(d_trans('ZipArchive extension is not enabled'));
            return back();
        }

        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $request->purchase_code)) {
            if (!preg_match("/^([d-u0-9]{10})-(([d-u0-9]{5})-){3}([d-u0-9]{10})$/i", $request->purchase_code)) {
                toastr()->error(d_trans('Invalid purchase code'));
                return back();
            }
        }

        try {
            $addonZipFile = FileHandler::upload($request->file('addon_files'), [
                'disk' => 'temp',
            ]);

            $addonUploadPath = storage_path("app/temp/{$addonZipFile}");

            $tempFolder = md5(Str::random(10) . time());
            $addonTempPath = storage_path("app/temp/{$tempFolder}");

            if (File::exists($addonTempPath)) {
                FileHandler::deleteDirectory($addonTempPath);
            }

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        try {
            $zip = new ZipArchive;
            $res = $zip->open($addonUploadPath, ZipArchive::CREATE);
            if ($res != true) {
                throw new Exception(d_trans('Could not open the addon zip file'));
            }

            $res = $zip->extractTo($addonTempPath);
            if ($res == true) {
                FileHandler::delete($addonUploadPath, 'direct');
            }

            $zip->close();

            $configFile = "{$addonTempPath}/config.json";

            if (!File::exists($configFile)) {
                throw new Exception(d_trans('Addon Config is missing'));
            }

            $config = json_decode(File::get($configFile), true);

            if ($config['type'] != "addon") {
                throw new Exception(d_trans('Invalid addon files'));
            }

            $scriptAlias = $config['script']['alias'];
            $scriptVersion = $config['script']['version'];

            if (strtolower(config('system.item.alias')) != strtolower($scriptAlias)) {
                throw new Exception(d_trans('Invalid action request'));
            }

            if (config('system.item.version') < $scriptVersion) {
                throw new Exception(d_trans("The :addon_name addon require :script_name version :script_version or above", [
                    'addon_name' => $config['name'],
                    'script_name' => $scriptAlias,
                    'script_version' => $scriptVersion,
                ]));
            }

            $addonDestinationPath = base_path($config['path']);
            if (File::exists($addonDestinationPath)) {
                FileHandler::deleteDirectory($addonDestinationPath);
            }

            File::move($addonTempPath, $addonDestinationPath);

            $this->installAddonFiles($addonDestinationPath);

            $addon = Addon::updateOrCreate(['alias' => $config['alias']], [
                'name' => $config['name'],
                'version' => $config['version'],
                'thumbnail' => $config['thumbnail'],
                'path' => $config['path'],
                'action' => $config['action'],
                'status' => $config['status'],
            ]);

            if ($addon) {
                FileHandler::deleteDirectory($addonTempPath);
                toastr()->success(d_trans('The addon has been installed successfully'));
                return back();
            }

        } catch (Exception $e) {
            FileHandler::delete($addonUploadPath, 'direct');
            FileHandler::deleteDirectory($addonTempPath);
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function addonsUpdate(Request $request, Addon $addon)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error]);
            }
            return back();
        }

        if (!$addon->hasNoStatus()) {
            $addon->status = $request->status ? Addon::STATUS_ACTIVE : Addon::STATUS_DISABLED;
            $addon->update();
        }

        return response()->json(['success' => true]);
    }

    public function adminPanelStyle()
    {
        $customCssFile = public_path(config('system.admin.custom_css'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }

        $customCssFile = File::get($customCssFile);

        return view('admin.system.admin', [
            'customCssFile' => $customCssFile,
        ]);
    }

    public function adminPanelStyleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin.colors.*' => ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except(['_token', 'custom_css']);

        foreach ($requestData as $key => $value) {
            $update = Setting::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(d_trans('Updated Error'));
                return back();
            }
        }

        $this->updateAdminColors($requestData['admin']['colors']);
        $this->updateAdminCustomCss($request->custom_css);

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function editorImages()
    {
        $editorImages = EditorImage::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $editorImages->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('path', 'like', $searchTerm);
            });
        }

        $editorImages = $editorImages->orderbyDesc('id')->paginate(20);
        $editorImages->appends(request()->only(['search']));

        return view('admin.system.editor-images', [
            'editorImages' => $editorImages,
        ]);
    }

    public function editorImagesDestroy(EditorImage $editorImage)
    {
        try {
            $editorImage->deleteImage();

            toastr()->success(d_trans('Deleted Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function cronjob()
    {
        return view('admin.system.cronjob');
    }

    public function cronjobKeyGenerate()
    {
        Setting::updateSettings('cronjob', ['key' => hash_encode(time())]);
        toastr()->success(d_trans('Cron Job key generated successfully'));
        return back();
    }

    public function cronjobKeyRemove()
    {
        if (config('settings.cronjob.key')) {
            Setting::updateSettings('cronjob', ['key' => '']);
            toastr()->success(d_trans('Cron Job key removed successfully'));
        }
        return back();
    }

    public function installAddonFiles($addonPath)
    {
        $configFile = "{$addonPath}/config.json";
        $config = json_decode(File::get($configFile), true);
        $generalFiles = $config['general_files'];

        if (!empty($generalFiles)) {
            if (!empty($generalFiles['remove'])) {
                $removeDirectories = $generalFiles['remove']['directories'];
                if (!empty($removeDirectories)) {
                    foreach ($removeDirectories as $deleteDirectory) {
                        FileHandler::deleteDirectory(base_path($deleteDirectory));
                    }
                }
                $removeFiles = $generalFiles['remove']['files'];
                if (!empty($removeFiles)) {
                    foreach ($removeFiles as $removeFile) {
                        FileHandler::delete($removeFile, 'direct');
                    }
                }
            }
            if (!empty($generalFiles['create'])) {
                $createDirectories = $generalFiles['create']['directories'];
                if (!empty($createDirectories)) {
                    foreach ($createDirectories as $createDirectory) {
                        FileHandler::makeDirectory(base_path($createDirectory));
                    }
                }
            }
            if (!empty($generalFiles['copy'])) {
                $copyDirectories = $generalFiles['copy']['directories'];
                if (!empty($copyDirectories)) {
                    foreach ($copyDirectories as $copyDirectory) {
                        File::copyDirectory(base_path($copyDirectory['root']), base_path($copyDirectory['destination']));
                    }
                }
                $copyFiles = $generalFiles['copy']['files'];
                if (!empty($copyFiles)) {
                    foreach ($copyFiles as $copyFile) {
                        File::copy(base_path($copyFile['root']), base_path($copyFile['destination']));
                    }
                }
            }
        }

        if (!empty($config['database'])) {
            $databaseFiles = $config['database']['files'];
            if (!empty($databaseFiles)) {
                foreach ($databaseFiles as $databaseFile) {
                    if (File::exists(base_path($databaseFile))) {
                        $unprepared = DB::unprepared(File::get(base_path($databaseFile)));
                        if (!$unprepared) {
                            throw new Exception(d_trans("Cannot unprepared the database file"));
                        }
                    }
                }
            }
        }
    }

    public function updateAdminColors($colors)
    {
        $output = ':root {' . PHP_EOL;
        foreach ($colors as $key => $value) {
            $output .= '  --' . $key . ': ' . hexToRgb($value) . ';' . PHP_EOL;
        }
        $output .= '}' . PHP_EOL;

        $colorsFile = public_path(config('system.admin.colors'));
        if (!File::exists($colorsFile)) {
            File::put($colorsFile, '');
        }

        File::put($colorsFile, $output);
    }

    private function updateAdminCustomCss($content)
    {
        $customCssFile = public_path(config('system.admin.custom_css'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }

        File::put($customCssFile, $content);
    }
}
