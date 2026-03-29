<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            ->with('success', 'Settings updated successfully.');
    }
}
