<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $purchases = DB::table('purchases')->leftJoin('supplier', 'supplier.supplier_id', 'purchases.supplier_id')
        ->Leftjoin('product', 'product.product_id', 'purchases.product_id')
        ->select(
            'purchase_id', 'supplier_name', 'product_name', 'purchases.quantity', 'cost'
        )->get();
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchases.index', [
            'purchases'=>$purchases,
            'suppliers'=>$suppliers,
            'products'=>$products
        ]);
    }

    public function create(Request $request){

         $request->validate([
            'supplier'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'cost'=>'required',
        ]);


        $id = $request->id;
        $supplier = $request->supplier;
        $product = $request->product;
        $quantity = $request->quantity;
        $cost = $request->cost;


        if (isset($id)){
            Purchase::where('purchase_id',$id)->update([
                'supplier_id'=>$supplier,
                'product_id'=>$product,
                'quantity'=>$quantity,
                'cost'=>$cost,
            ]);
            return redirect('purchases/')->with('message', "Purchase has updated successfully");
        }

       
        

        
        $purchase = new Purchase();

        $purchase->supplier_id = $supplier;
        $purchase->product_id = $product;
        $purchase->quantity = $quantity;
        $purchase->cost = $cost;
        
        $purchase->save();
        return redirect('purchases/')->with('message', "Purchase  has saved successfully");
    }

    public function deletePurchase($id){
        $purchase = Purchase::where('purchase_id',$id)->firstOrFail();
        $purchase->delete();
        return redirect('purchases/')->with('message',
                        "The purchase has deleted perminantly");
    }

    public function editPurchase($id){
        $purchase = Purchase::where('purchase_id',$id)->firstOrFail();
        return $purchase;
    }
}
