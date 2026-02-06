<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $input = $request->except(['_token', '_method']);

        // 1. Save all text inputs first
        foreach ($input as $key => $value) {
            if (!$request->hasFile($key)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'group' => 'school']
                );
            }
        }

        // 2. Handle File Uploads (Logos)
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('settings', 'public');

            // Delete old file
            $oldSetting = Setting::where('key', $key)->first();
            if ($oldSetting && $oldSetting->type === 'image' && $oldSetting->value) {
                Storage::disk('public')->delete($oldSetting->value);
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $path, 'type' => 'image', 'group' => 'school']
            );
        }

        return redirect()->back()->with('success', 'Pengaturan sekolah berhasil diperbarui.');
    }
}
