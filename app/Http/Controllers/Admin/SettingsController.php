<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'delivery_inside_dhaka' => Setting::get('delivery_inside_dhaka', '60'),
            'delivery_outside_dhaka' => Setting::get('delivery_outside_dhaka', '120'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'delivery_inside_dhaka' => 'required|numeric|min:0',
            'delivery_outside_dhaka' => 'required|numeric|min:0',
        ]);

        Setting::set('delivery_inside_dhaka', $request->delivery_inside_dhaka);
        Setting::set('delivery_outside_dhaka', $request->delivery_outside_dhaka);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Delivery charges updated successfully.');
    }

    public function logo()
    {
        $settings = [
            'site_logo' => Setting::get('site_logo'),
            'site_favicon' => Setting::get('site_favicon'),
        ];

        return view('admin.settings.logo', compact('settings'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg|max:1024',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('logos', 'public');
            Setting::set('site_logo', $path);
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $path = $request->file('site_favicon')->store('favicons', 'public');
            Setting::set('site_favicon', $path);
        }

        // Handle logo removal
        if ($request->has('remove_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
                Setting::set('site_logo', null);
            }
        }

        // Handle favicon removal
        if ($request->has('remove_favicon')) {
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
                Setting::set('site_favicon', null);
            }
        }

        return redirect()->route('admin.settings.logo')
            ->with('success', 'Logo & favicon updated successfully.');
    }
}
