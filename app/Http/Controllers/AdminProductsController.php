<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AdminProductsController extends Controller
{
    public function show() {
        $categories = DB::table('categories')->get();
        $products = DB::table('products')->get();

        return view('admin.products.show', ['categories'=>$categories, 'products'=>$products]);
    }

    public function create() {
        $categories = DB::table('categories')->get();
        $products = DB::table('products')->get();
        
        return view('admin.products.create',['categories'=>$categories, 'products'=>$products]);
    }
    
    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $fileName = NULL;
            $permissions = $request->permissions;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $ext = $file->getClientOriginalExtension();
                // $fileName = $file->getClientOriginalName();
                $fileName = time().'-'.'product.'.$ext;
                // dd($fileName);
        
                // Lưu file vào thư mục
                $file->move(public_path('ustora/img'), $fileName);


                // dd($fileName);
            }
            

            
            foreach ($permissions as $key => $value) {
                $categoryId = DB::table('categories')->where('name', $value)->first()->id;
                
                DB::table('products')->insert([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'thumbnail'=>$fileName,
                    'category_id' => $categoryId,
                    'sold_count'=>0,
                    'view_count'=>0
                ]);
            }



            DB::commit();

            return redirect()->route('admin.product.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }    
    }   

    public function edit($id) {
                
        $categories = DB::table('categories')->get();
        $products = DB::table('products')->where('id', $id)->first();
        $category_id = $products->category_id;

        return view('admin.products.edit', ['categories'=>$categories, 'products'=>$products, 'category_id'=>$category_id]);
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();

            $name_cate = $request->permissions;
            
            $categoryId = DB::table('categories')->where('name', $name_cate[0])->first()->id;
            
            $thumbnail = DB::table('products')->where('id', $id)->first();
            $path_delete = 'ustora/img/'.$thumbnail->thumbnail;

            if (File::exists($path_delete)) {
                // Xóa file
                File::delete($path_delete);
            }
            
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $ext = $file->getClientOriginalExtension();
                // $fileName = $file->getClientOriginalName();
                $fileName = time().'-'.'product.'.$ext;
                // dd($fileName);
                
                // Lưu file vào thư mục
                $file->move(public_path('ustora/img'), $fileName);
                
                // dd($file);
            }
            
            DB::table('products')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'thumbnail'=>$fileName,
                'category_id' => $categoryId
            ]);
            

            
            DB::commit();

            return redirect()->route('admin.product.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            
            $products = DB::table('products')->where('id', $id)->delete();
            
            DB::commit();

            return redirect()->route('admin.product.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
}