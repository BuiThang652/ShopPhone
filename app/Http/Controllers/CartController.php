<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CartController extends Controller
{
    //
    public function show() {
        $user = Auth::user();
        $user_id = $user->id;
        
        $orders = DB::table('orders')
                ->where('user_id', $user_id)
                ->first();

        $order_items = [];
        
        $total_quantity = 0;
        $total_amount = 0;
        
        if ($orders) {
            $order_items = DB::table('order_items')
                ->where('order_id', $orders->id)
                ->get();

        
        foreach ($order_items as $item) {                        
            $total_quantity += $item->quantity;                    
            $total_amount += $item->price;
            }
        }       
        
        $products = DB::table('products')
        ->get();

        $top_products = DB::table('products')->orderBy('id', 'desc')->take(5)->get();
                
        return view('frontend.orders', [
            'order_items'=>$order_items,
            'total_quantity'=>$total_quantity, 
            'total_amount'=>$total_amount, 
            'products'=>$products,
            'top_products'=>$top_products
        ]);
    }

    public function delete($id) {


        try {
            DB::beginTransaction();

            $user = Auth::user();

            $user_id = $user->id;
    
            $order_id = DB::table('orders')->where('user_id', $user_id)->first()->id;
        
            $delete = DB::table('order_items')
                ->where('order_id',$order_id)
                ->where('product_id', $id)
                ->get();
    
            foreach($delete as $d) {
                DB::table('order_items')
                    ->where('id', $d->id)
                    ->delete();
            }
            
            DB::commit();

            return redirect()->route('frontend.orders');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function add($id) {
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
    }

    public function remove($id) {


        try {
            DB::beginTransaction();

            $user_id = Auth::user()->id;
    
            $orders = DB::table('orders')->where('user_id',$user_id);
    
            $order = $orders->first();
    
            $order_id = $order ? $order->id : null;
    
            $product_id = $id;
    
            $check_order_item = DB::table('order_items')->where('order_id',$order_id)->where('product_id',$product_id)->first();
    
            $quantity = $check_order_item ? $check_order_item->quantity - 1 : 0; // Kiểm tra xem order_item có tồn tại hay không
    
            $price = DB::table('products')->where('id',$product_id)->value('price'); // Sử dụng value() để lấy giá trị trực tiếp
    
            $total_amount = 0;
            

            // dd($check_order_item);


            if ($check_order_item->quantity == 1) {
                $order_id = DB::table('orders')->where('user_id', $user_id)->first()->id;


                $delete = DB::table('order_items')
                ->where('order_id',$order_id)
                ->where('product_id', $product_id)
                ->get();
    
                foreach($delete as $d) {
                    DB::table('order_items')
                        ->where('id', $d->id)
                        ->delete();
                }
            } else {
                DB::table('order_items')
                ->where('order_id',$order_id)
                ->where('product_id',$product_id)
                ->update([
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
        }
    }

    public function order(Request $request) {

        return "Bảo trì";
    }
    
}