<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SingleProductController extends Controller
{
    //
    public function show($id) {
        $product = DB::table('products')->where('id', $id)->first();

        $category = DB::table('categories')->where('id', $product->category_id)->first()->name;

        $products = DB::table('products')->where('category_id', $product->category_id)->get();

        $top_products = DB::table('products')->orderBy('id', 'desc')->take(5)->get();

        return view('frontend.single-product', ['product'=> $product,'top_products'=>$top_products, 'products'=>$products, 'category'=>$category]);
    }

    public function order($id) {
        try {
            DB::beginTransaction();
    
            $user_id = Auth::user()->id;
    
            $orders = DB::table('orders')->where('user_id',$user_id);
    
            $order = $orders->first(); // Lấy đối tượng đơn hàng đầu tiên
    
            $order_id = $order ? $order->id : null; // Kiểm tra xem đơn hàng có tồn tại hay không
    
            $product_id = $id;

            // dd($order);
    
            $check_order_item = DB::table('order_items')->where('order_id',$order_id)->where('product_id',$product_id)->first();
    
            $quantity = $check_order_item ? $check_order_item->quantity + 1 : 1; // Kiểm tra xem order_item có tồn tại hay không
    
            $price = DB::table('products')->where('id',$product_id)->value('price'); // Sử dụng value() để lấy giá trị trực tiếp
    
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
            
            DB::commit();
    
            return redirect()->route('frontend.orders');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        }
    
        // Cart::add('293ad', 'Product 1', 1, 9.99);

        // return Cart::content();

    }

    public function cart(Request $request, $id) {
        try {
            DB::beginTransaction();
    
            $ip_quantity = $request->quantity;
        
            $user_id = Auth::user()->id;
        
            $orders = DB::table('orders')->where('user_id',$user_id);
    
            $order = $orders->first();
    
            $order_id = $order ? $order->id : null;
            
            $product_id = $id;
            
            $check_order_item = DB::table('order_items')->where('order_id',$order_id)->where('product_id',$product_id)->first();
            
            $quantity = $check_order_item ? $check_order_item->quantity + $ip_quantity : $ip_quantity; 
    
            $price = DB::table('products')->where('id',$product_id)->value('price');
    
            // dd();
            if($order) {
                
            } else {
                $order_id = DB::table('orders')
                ->insertGetId([
                    'user_id' => $user_id,
                ]);
            }
    
    
            if($check_order_item) {
                DB::table('order_items')
                ->where('order_id',$order_id)
                ->where('product_id',$product_id)
                ->update([
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
    
            
            DB::commit();
    
            return redirect()->route('frontend.orders');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        } 
    }
}