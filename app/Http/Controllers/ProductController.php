<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function generateId(){
    $records = Product::orderby('product_id', 'desc')->get();
    if(count($records)==0){
        return 'P001';
    }

    $last_id = $records[0]->product_id;

    $num = intval(substr($last_id, 1, strlen($last_id))) + 1;
    $new_id = '';
    if ($new_id < 10){
        $new_id = 'P00'.$num;
    }else{
        $new_id = 'P0'.$num;
    }
    return $new_id;
}

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $products = DB::table('product')->leftJoin('supplier', 'supplier.supplier_id', 'product.supplier_id')
        ->select(
            'product_id', 'product_name', 'product.supplier_id', 'supplier_name','quantity','status', 'unit_price'
        )->get();
        $suppliers = Supplier::all();
        return view('products.index', [
            'products'=>$products,
            'suppliers'=>$suppliers
        ]);
    }

    public function create(Request $request){

        $request->validate([
            'name'=>'required',
            'supplier'=>'required',
            'unit_price'=>'required',
        ]);

        $id = $request->id;
        $name = $request->name;
        $supplier = $request->supplier;
        $unit_price = $request->unit_price;


        if (isset($id)){
            Product::where('product_id',$id)->update([
                'product_name'=>$name,
                'supplier_id'=>$supplier,
                'unit_price'=>$unit_price,
            ]);
            return redirect('products/')->with('message', "Product with id '$id' has updated successfully");
        }

        
        $new_id = generateId();
        $product = new Product();

        $product->product_id = $new_id;
        $product->product_name = $name;
        $product->supplier_id = $supplier;
        $product->unit_price = $unit_price;
        
        $product->save();
        return redirect('products/')->with('message', "Product with name '$product->product_name' has saved successfully");
    }

    public function deleteProduct($id){
        $product = Product::where('product_id',$id)->firstOrFail();
        $product->delete();
        return redirect('products/')->with('message',
                        "The product with id '$product->product_id' has deleted perminantly");
    }

    public function editProduct($id){
        $product = Product::where('product_id',$id)->firstOrFail();
        return $product;
    }
}
