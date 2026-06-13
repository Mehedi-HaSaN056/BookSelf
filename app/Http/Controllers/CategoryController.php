<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:100|unique:categories','color'=>'nullable|string|max:7','icon'=>'nullable|string|max:10','description'=>'nullable|string']);
        Category::create(['name'=>$request->name,'slug'=>Str::slug($request->name),'color'=>$request->color??'#3B82F6','icon'=>$request->icon??'📚','description'=>$request->description]);
        return back()->with('success','Category added!');
    }
    public function update(Request $request, Category $category) {
        $request->validate(['name'=>'required|string|max:100|unique:categories,name,'.$category->id,'color'=>'nullable|string|max:7','icon'=>'nullable|string|max:10','description'=>'nullable|string']);
        $category->update(['name'=>$request->name,'slug'=>Str::slug($request->name),'color'=>$request->color??'#3B82F6','icon'=>$request->icon??'📚','description'=>$request->description]);
        return back()->with('success','Category updated!');
    }
    public function destroy(Category $category) {
        if($category->books()->count() > 0) return back()->with('error','Category has books! Remove books first.');
        $category->delete();
        return back()->with('success','Category deleted!');
    }
}
