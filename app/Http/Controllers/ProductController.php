<?php

namespace App\Http\Controllers;

use URL;
use File;
use Illuminate\Http\Request;
use \App\Models\ProductModel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productList = ProductModel::paginate(5);
        if(isset($_GET['search'])){
            $productList = ProductModel::where('title','LIKE','%'.$_GET['search'].'%')->paginate(5);
        }
        if(isset($_GET['status'])){
                $productList = ProductModel::where('status',$_GET['status'])->paginate(5);
        }

        $data['productList'] = $productList;
        $data['pending'] = count(ProductModel::where('status','pending')->get());
        $data['approve'] = count(ProductModel::where('status','approve')->get());
        $data['reject'] = count(ProductModel::where('status','reject')->get());
        $data['all'] = count(ProductModel::get());
        return view('product',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->fileToUpload !== null && $request->title !== null && $request->price !== null && $request->quantity !== null && $request->description !== null){
            $file = $request->fileToUpload;
            $extension = $request->fileToUpload->extension();
            $file_name = time().'_product.'.$extension;
            $file->move(public_path('uploads'),$file_name);
            $request->merge(['image' => $file_name]);

            //Add database

            ProductModel::insert([
                'title' => $request->title,
                'price' => $request->price,
                'image' => $request->image,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'created_at' => Now(),
                'updated_at' => Now()
            ]);
            return redirect(route("product.index"))->with('success', 'Đã thêm sản phẩm');
        }
        else{
            return redirect(route("product.index"))->with('noti', 'Bạn đã nhập thiếu thông tin');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productList = ProductModel::get();
        $productDetail = ProductModel::find($id);
        $data['productList'] = $productList;
        $data['handle'] = 'loadFormEdit';
        $data['productDetail'] = $productDetail;
        return view('product',compact('data'));
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
        $deleteImage= asset('/uploads/'.$request->imageCurrent);
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
        // dd($request->all());
        if ($request->title !== null || $request->price !== null || $request->quantity !== null || $request->description !== null) {
            if ($request->fileToUpload !== null) {
                $file = $request->fileToUpload;
                $extension = $request->fileToUpload->extension();
                $file_name = time().'_product.'.$extension;
                $file->move(public_path('uploads'), $file_name);
                $request->merge(['image' => $file_name]);
            }
            else {
                $request->merge(['image' => $request->imageCurrent]);
            }
            ProductModel::where('id', $id)->update([
            'title' => $request->title,
            'price' => $request->price,
            'image' => $request->image,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status,
            'updated_at' => Now()
        ]);
            return redirect(route("product.index"))->with('success', 'Cập nhật thông tin khách hàng thành công');
        }
        else{
            dd('4');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleteImage="uploads/".ProductModel::find($id)['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
        ProductModel::where('id',$id)->delete();

        return redirect(route("product.index"))->with('success', 'Xóa sản phẩm thành công');
    }
    // public function pending(){
    //     $productList = ProductModel::where('status','pending')->paginate(5);
    //     $data['productList'] = $productList;
    //     return view('product',compact('data'));
    // }
    // public function approve(){
    //     $productList = ProductModel::where('status','approve')->paginate(5);
    //     $data['productList'] = $productList;
    //     return view('product',compact('data'));
    // }
    // public function reject(){
    //     $productList = ProductModel::where('status','reject')->paginate(5);
    //     $data['productList'] = $productList;
    //     return view('product',compact('data'));
    // }
}
