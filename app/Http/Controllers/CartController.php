<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $product = Product::find($request->product_id);

        $cart = Cart::where('user_id',Auth::id())->where('product_id',$request->product_id)->first();

        if ( $cart ) {

            $cart->update([

                'quantity'=> $cart->quantity + $request->num_product,
            ]);


        } else {
            Cart::create([
            'user_id'=> $request->user_id,
            'product_id'=> $request->product_id,
            'quantity'=> $request->num_product,
            'price'=> $product->sale_price ? $product->sale_price : $product->price
        ]);
        }
        return redirect()->back()->with('msg','added');


    }

    public function carts()
    {
        return view('site.carts');
    }
    public function checkout()
    {
        $amount = Auth::user()->cart()->sum(DB::raw('quantity * price'));


            $url = "https://eu-test.oppwa.com/v1/checkouts";
            $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                        "&amount=$amount" .
                        "&currency=USD" .
                        "&paymentType=DB";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $responseData = json_decode( $responseData , true );
            $id = $responseData['id'];

        return view('site.checkout',compact('id'));
    }
    public function payment(Request $request)
    {
        // dd($request->all());
        $resourcePath = $request->resourcePath;

            $url = "https://eu-test.oppwa.com$resourcePath";
            $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
             $responseData = json_decode($responseData ,true);
            // dd($responseData);

            $code = $responseData['result']['code'];

            if($code == '000.100.110'){
                $id = $responseData['id'];
                $amount = $responseData['amount'];

                DB::beginTransaction();
                try{

                            // create new order
                        $order = Order::create([
                            'total' => $amount,
                            'user_id' => Auth::id()
                        ]);

                        foreach(Auth::user()->cart as $cart){
                            //add cart item to order items
                            OrderItem::create([
                                'price'=>$cart->price  ,
                                'quantity'=>$cart->quantity  ,
                                'product_id'=>$cart->product_id  ,
                                'user_id'=>$cart->user_id  ,
                                'order_id'=> $order->id
                            ]);

                            //decrease the item quantity
                            // $cart->product()->update(['quantity'=>$cart->product->quantity - $cart->quantity]);
                            $cart->product->decrement('quantity' , $cart->quantity);

                            //remove cart items
                            $cart->delete();
                        }


                        //create payment record
                        Payment::create([
                            'total' => $amount ,
                            'user_id' => Auth::id() ,
                            'transaction_id' =>$id
                        ]);
                        DB::commit(); // ?????? ???? ???????? ???? ?????????? ???? ???????? ????????????
                }catch(Exception $e){
                    DB::rollBack();
                    throw new Exception($e->getMessage());
                }


                return redirect()->route('site.payment_success');
            }else{
                return redirect()->route('site.product_fail');

            }
        return view('site.payment');
    }
}
