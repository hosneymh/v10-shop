<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $slider=Product::orderbydesc('id')->limit(3)->get();
        $categories = Category::orderbydesc('id')->get();
        $all_product = Product::orderbydesc('id')->limit(9)->offset(3)->get();
        return view('site.index',compact('slider','categories','all_product'));
    }
    public function shop()
    {
        $categories = Category::orderbydesc('id')->get();
        $all_product = Product::orderbydesc('id')->paginate(4);


        return view('site.product',compact('categories','all_product'));

    }
    public function product_detail($id)
    {
        $product = Product::find($id);
        $all_product = Product::orderbydesc('id')->paginate(8);
        return view('site.product_datail',compact('product','all_product'));

    }
    public function about()
    {
        return view('site.about');
    }
    public function contact()
    {
        return view('site.contact');
    }
    public function review(Request $request , $id)
    {

        $request->validate([
            'rating' => 'required',
            'review' => 'required'
        ]);
        dd($request->all() );

        Review::create([
            'star'=> $request->rating ,
            'content'=> $request->review ,
            'product_id'=> $id ,
            'user_id'=> Auth::id()
        ]);
        return redirect()->back();
    }
}
