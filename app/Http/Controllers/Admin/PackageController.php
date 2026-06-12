<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order', 'asc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePackage($request);
        $data['slug'] = Str::slug($data['name']);
        
        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function update(Request $request, Package $package)
    {
        $data = $this->validatePackage($request, $package->id);
        $data['slug'] = Str::slug($data['name']);

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

    private function validatePackage(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_type' => 'required|in:monthly,yearly,one_time',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'trial_days' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer',
            'is_cloud' => 'boolean',
            'is_offline' => 'boolean',
            'lifetime_license' => 'boolean',
            'hosting_included' => 'boolean',
            'support_included' => 'boolean',
            'free_updates' => 'boolean',
        ]);
    }
}
