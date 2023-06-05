<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CategoryController extends Controller
{
    public function show() {
        $products = DB::table('products')->get();
        $categories = DB::table('categories')->get();

        // dd($products);

        return view('frontend.category', ['products'=>$products, 'categories'=>$categories]);
    }

    public function order($id) {
        try {
            DB::beginTransaction();
    
            if (Auth::check()) {
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
            }else {
                return redirect()->route('login');
            }
            
            DB::commit();
    
            return redirect()->route('frontend.category');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        }
    
    }
}