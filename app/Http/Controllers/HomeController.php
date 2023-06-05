<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    //
    public function show() {
        $top_products = DB::table('products')->orderBy('id', 'desc')->take(6)->get();

        $top_seller = DB::table('products')->orderBy('sold_count', 'desc')->take(3)->get();
        $top_new = DB::table('products')->orderBy('id', 'desc')->take(3)->get();
        $top_view = DB::table('products')->orderBy('view_count', 'desc')->take(3)->get();

        // dd($top_seller);

        return view('frontend.index', ['top_products'=>$top_products, 'top_seller'=> $top_seller, 'top_new'=>$top_new, 'top_view'=>$top_view]);
    }

    public function order($id) {
        try {
            DB::beginTransaction();
    
            if (Auth::check()) {
                $user_id = Auth::user()->id;
    
                $orders = DB::table('orders')->where('user_id',$user_id);
        
                $order = $orders->first();
                    
                $order_id = $order ? $order->id : null;
        
                $product_id = $id;

                
                $check_order_item = DB::table('order_items')->where('order_id',$order_id)->where('product_id',$product_id)->first();
                
                $quantity = $check_order_item ? $check_order_item->quantity + 1 : 1;
                
                $price = DB::table('products')->where('id',$product_id)->value('price');
                
                $total_amount = 0;
                
                // dd($check_order_item);
                if($order) {
                    
                } else {
                    $order_id = DB::table('orders')
                    ->insertGetId([
                        'user_id' => $user_id,
                    ]);
                }
        
                if ($check_order_item) {
                    DB::table('order_items')
                    ->where('order_id', $order_id)
                    ->where('product_id', $product_id)
                    ->update([
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'price' => $price * $quantity
                    ]);
                } else {
                    DB::table('order_items')
                    ->insert([
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'price' => $price * $quantity
                    ]);
                }
                

                $order_items = DB::table('order_items')->where('order_id',$order_id)->get();
            
                foreach ($order_items as $item) {
                    $total_amount += $item->price;
                }
            }else {
                return redirect()->route('login');
            }
            
            DB::commit();
    
            return redirect()->route('frontend.orders');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        }
    
        // return 1;

    }
    
}