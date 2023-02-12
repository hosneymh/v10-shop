<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'messege' => 'Process Done',
            'status' => 1,
            'data' => Product::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'content_en' => 'required',
            'content_ar' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
        ]);

        // Uploads files
        $img_name = rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads'), $img_name);

        // Store to Database
        $product = Product::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'image' => $img_name,
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);
        return [
            'messege' => 'Process Done',
            'status' => 1,
            'data' => $product
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product){
            return [
                'messege' => 'Process Done',
                'status' => 1,
                'data' => $product
            ];
        }else{

            return [
                'messege' => 'Process Faild',
                'status' => 0,
                'data' => []
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        if ($request->hasFile('image')){
        // Uploads files
        $img_name = rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads'), $img_name);
        $data['image'] = $img_name;
        }

        
        // Store to Database
        $product->update($data);
        return [
            'messege' => 'Process Done',
            'status' => 1,
            'data' => $product
        ];


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorfail($id);
        File::delete(public_path('uploads/'.$product->image));
        $product->delete();

        return [
            'messege' => 'Process Done',
            'status' => 1,
            'data' => []
        ];
    }
}
