<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrintSetting;
use Illuminate\Support\Facades\Auth;

class PrintSettingController extends Controller
{
    public function index()
    {
        // Because of BelongsToStore, we only get the settings for the current store
        $setting = PrintSetting::first();
        return view('settings.print', compact('setting'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
            'address' => 'nullable|string',
            'heading' => 'nullable|string|max:255',
            'footer' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $setting = PrintSetting::first();
        
        if (!$setting) {
            $setting = new PrintSetting();
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $setting->logo = '/storage/' . $path;
        }

        $setting->name = $data['name'] ?? null;
        $setting->desc = $data['desc'] ?? null;
        $setting->address = $data['address'] ?? null;
        $setting->heading = $data['heading'] ?? 'INVOICE';
        $setting->footer = $data['footer'] ?? null;
        
        $setting->save();

        return redirect()->back()->with(['success' => 'Invoice print settings updated successfully.', 'invoice_success' => true]);
    }
}
