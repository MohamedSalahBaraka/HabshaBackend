<?php

namespace App\Http\Controllers\AdminArea;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\ModelSort;
use App\Traits\Upload;

class SettingController extends Controller
{
    use ModelSort, Upload;
    private $Keys = ['primaryColor', 'sitename', 'secondaryColor', 'whatsapp', 'twitter', 'facebook', 'instagram', 'youtube', 'telegram',];
    public function SectionStore(Request $request)
    {
        foreach ($this->Keys as $key) {
            $Section = Setting::firstOrCreate(['key' => $key], ['value' => $request->input($key)]);
            $Section->value = $request->input($key);
            $Section->save();
        }
        $path = $this->photoUploader($request);
        if (!is_null($path)) {

            $Section = Setting::firstOrCreate(['key' => 'logo'], ['value' => $path]);
            $Section->value = $path;
            $Section->save();
        }
        return back()->with('success', 'Saved successfully');
    }
    function get()
    {
        $vars = array();
        $settings = Setting::all();
        foreach ($settings as $setting) {
            $vars[$setting->key] = $setting->value;
        }
        return view('AdminArea.Setting.setting', $vars);
    }
}