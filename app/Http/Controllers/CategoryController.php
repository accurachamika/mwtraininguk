<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCat(Request $request): RedirectResponse
    {
        $request->validate([
            'cat_name' => 'required|unique:category,name|string ',
        ] , [
            'cat_name.required' => 'The category name is required.',
            'cat_name.string' => 'The category name must be a valid string.',
            'cat_name.unique' => 'The category name has already been taken.', 
        ]);

        $category = Category::create([
            'name' => $request->cat_name
        ]);



        if ($category) {
            return redirect()->route('category')->with('success', 'Category created successfully!');
        } else {
            return redirect()->route('category')->with('error', 'Failed to create Category!');
        }
    }


    public function deleteCat($id): RedirectResponse
    {

        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return redirect()->route('category')->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->route('category')->with('error', 'Category not found!');
        }
    }

    public function truncate(): RedirectResponse
    {
        // Truncate the category table
        Category::truncate();

        // Redirect to the category page with a success message
        return redirect()->route('category')->with('success', 'All categories have been deleted!');
    }

}
