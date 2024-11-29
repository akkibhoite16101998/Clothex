<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //

    public function store(Request $request){

        //return $request;  
        $rule = [
            'product_name'=> 'required',
            'sku_id'=> 'required',
            'price' => 'required|numeric| min:100',
            'product_type' => 'required|in:male,female',

        ];

        if($request->product_image !=""){

            $rule['product_image'] =  'image';

        }

        $validator = Validator::make($request->all(),$rule);
        
        #dd($validator->errors()->all());

        if($validator->fails())
        {
            return redirect()->route('account.add_product')->withInput()->withErrors($validator);
        }

        #echo "inn";die();

        $product = new Product();
        
        $product->name = $request->product_name;
        $product->sku_id = $request->sku_id;
        $product->price = $request->price;
        $product->type = $request->product_type;

        if($request->product_image !='')
        {
            $image = $request->product_image;
            $ext = $image->getClientOriginalExtension();
            $image_name = time().'.'.$ext; //unique Image Name
            # save image products directory
            $image->move(public_path('upload/products'),$image_name);
            $product->image = $image_name;
        }

        $product->save(); 

        #echo $product->id; die();

        return redirect()->route('account.productlist')->with('success','Product Sucessfully Added.');


    }

    public function productlist(){
        
        $product_list = DB::table('products')->paginate(4);
        #echo "<pre>";print_r($product_list);die();
        return view('account.productlist',['data'=>$product_list]);
    }

    
}
