<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminCategoryController extends Controller
{
    //
    public function show() {
        $categories = DB::table('categories')->get();

        return view('admin.category.show', ['categories'=>$categories]);
    }

    public function create() {
        return view('admin.category.create');
    }
    
    public function store(Request $request) {
        try {
            DB::beginTransaction();

            DB::table('categories')->insert([
                'name' => $request->name
            ]);

            DB::commit();

            return redirect()->route('admin.category.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }    
    }   

    public function edit($id) {
        
        $categories = DB::table('categories')->where('id', '=', $id)->first();

        return view('admin.category.edit', ['categories'=>$categories]);
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();
            
            DB::table('categories')->where('id', $id)->update([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('admin.category.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }    
    }

    public function delete($id) {
        
        try {
            DB::beginTransaction();

            $productIds = DB::table('products')->where('category_id', $id)->pluck('id');

            DB::table('order_items')->whereIn('product_id', $productIds)->delete();

            DB::table('products')->where('category_id', $id)->delete();
            
            DB::table('categories')->where('id', '=', $id)->delete();

            DB::commit();

            return redirect()->route('admin.category.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }    
    }
}