<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Category;



class CategoryController extends Controller

{



    public function index(Request $request){

        $categories=Category::get();

        return view('Ajaxtest.categories',compact('categories'));

    }



    public function destroy(Request $request,$id){

        $category=Category::find($id);

        $category->delete();

        return back()->with('success','Category deleted successfully');

    }




    public function deleteMultiple(Request $request){

        $ids = $request->ids;

        Category::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status'=>true,'message'=>"Category deleted successfully."]);

    }

    //Actulizo mediante put
    public function update(Request $request,$id){

        $category=Category::find($id);


        return back()->with('success','Category Update successfully');

    }

}

