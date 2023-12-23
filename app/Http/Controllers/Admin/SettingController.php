<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [];
        foreach (Setting::all() as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'print_layout' => 'required|string',
        ]);
        Setting::updateOrCreate([
            'name' => 'print_layout'
        ], [
            'value' => $data['print_layout'],
        ]);
        return $this->backToForm('Setting updated successfully!');
    }
}
