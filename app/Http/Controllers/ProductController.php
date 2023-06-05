<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductController extends Controller
{
    //
    public function show() {
        $products = DB::table('products')->paginate(12);
        
        return view('frontend.products', ['products' => $products]);
    }

    public function order($id) {
        try {
            DB::beginTransaction();
            // dd();
            if (Auth::check()) {

                $user_id = Auth::user()->id;
        
                $orders = DB::table('orders')->where('user_id',$user_id);
        
                $order = $orders->first();
                    
                $order_id = $order ? $order->id : null;
        
                $product_id = $id;
    
                // dd($order);
        
                $check_order_item = DB::table('order_items')->where('order_id',$order_id)->where('product_id',$product_id)->first();
        
                $quantity = $check_order_item ? $check_order_item->quantity + 1 : 1;
                
                $price = DB::table('products')->where('id',$product_id)->value('price');
        
                $total_amount = 0;
    
                if($order) {
                    
                } else {
                    $order_id = DB::table('orders')
                    ->insertGetId([
                        'user_id' => $user_id,
                    ]);
                }
        
                if($check_order_item) {
                    DB::table('order_items')
                    ->where('order_id',$order_id)->where('product_id',$product_id)->update([
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'quantity'=> $quantity,
                        'price' => $price*$quantity
                    ]);
                } else{
                    DB::table('order_items')
                    ->insert([
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'quantity'=> $quantity,
                        'price' => $price*$quantity
                    ]);
                }
    
                $order_items = DB::table('order_items')->where('order_id',$order_id)->get();
            
                foreach ($order_items as $item) {
                    $total_amount += $item->price;
                }
            } else {
                return redirect()->route('login');
            }
    
            
            DB::commit();
    
            return redirect()->route('frontend.products');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        }
    
        // Cart::add('293ad', 'Product 1', 1, 9.99);

        // return Cart::content();

    }
    
}