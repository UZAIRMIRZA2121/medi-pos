<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() { return view('categories.index'); }
    public function apiIndex() { return response()->json(Category::all()); }
    public function store(Request $request) {
        $data = $request->validate(["name" => "required|string", "description" => "nullable|string", "color_tag" => "nullable|string"]);
        $category = Category::create($data);
        return response()->json($category);
    }
    public function show(Category $category) { return response()->json($category); }
    public function update(Request $request, Category $category) {
        $data = $request->validate(["name" => "required|string", "description" => "nullable|string", "color_tag" => "nullable|string"]);
        $category->update($data);
        return response()->json($category);
    }
    public function destroy(Category $category) {
        $category->delete();
        return response()->json(["message" => "Deleted"]);
    }
}