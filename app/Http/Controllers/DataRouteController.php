<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class DataRouteController extends Controller
{
    #User List View
    public function userlist()  {
        $user = User::all();
        return view('pages.userList', ['users'=> $user] );
    }

    #Document upload View
    public function upload()  {
        $categories = Category::all();
        return view('pages.upload', ['categories'=> $categories] );
    }

    #Document upload View
    public function docList()  {
        $documents = Document::paginate(10);
        return view('pages.manage' , ['documents' => $documents ]);
    }

    #Category Jquery Fetch
    public function catJquery()
    {
        $categories = Category::all();

        // Return categories as JSON response
        return response()->json($categories);
    }
}
