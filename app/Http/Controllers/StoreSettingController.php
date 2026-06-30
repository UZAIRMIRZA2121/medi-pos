<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\BusinessSetting::firstOrCreate(
            ['user_id' => auth()->id()],
            ['tax' => 0, 'discount' => 0]
        );
        $printSetting = \App\Models\PrintSetting::first();
        return view('settings.store', compact('settings', 'printSetting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax' => 'required|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $settings = \App\Models\BusinessSetting::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'tax' => $request->tax, 
                'discount' => $request->discount,
                'auto_print' => $request->has('auto_print')
            ]
        );

        return redirect()->back()->with('success', 'Store settings updated successfully.');
    }
}
