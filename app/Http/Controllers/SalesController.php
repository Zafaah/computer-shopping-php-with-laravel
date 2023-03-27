<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $sales = DB::table('sales')->leftJoin('customer', 'sales.customer_id', 'customer.customer_id')
        ->Leftjoin('product', 'product.product_id', 'sales.product_id')
        ->select(
            'sale_id', 'customer_name', 'product_name', 'sales.quantity', 'price', 'discount', 'total_amount'
        )->get();
        $customers = Customer::all();
        $products = Product::all();

        return view('sales.index', [
            'sales'=>$sales,
            'customers'=>$customers,
            'products'=>$products
        ]);
    }

    public function create(Request $request){

        $request->validate([
            'customer'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'discount'=>'required',
        ]);

        $id = $request->id;
        $customer = $request->customer;
        $product = $request->product;
        $quantity = $request->quantity;
        $discount = $request->discount;


        $item = Product::where('product_id', $product)->first();


        if ($item->quantity < $quantity){
            return back()->withErrors([
                'quantity'=>"You have $item->quantity items in the stock"
            ])->onlyInput('customer', 'product', 'quantity', 'discount');
        };


        $price = $item->unit_price;
        $total_amount = ($price * $quantity) - ($price * $quantity * $discount / 100);

        if (isset($id)){
            Sales::where('sale_id',$id)->update([
                'customer_id'=>$customer,
                'product_id'=>$product,
                'quantity'=>$quantity,
                'price'=>$price,
                'discount'=>$discount,
                'total_amount'=>$total_amount,
            ]);
            return redirect('sales/')->with('message', "Sale has updated successfully");
        }
        
        $sale = new Sales();
        $sale->customer_id = $customer;
        $sale->product_id = $product;
        $sale->quantity = $quantity;
        $sale->price = $price;
        $sale->discount = $discount;
        $sale->total_amount = $total_amount;
        $sale->user_id = auth()->user()->user_id;
        
        $sale->save();
        return redirect('sales/')->with('message', "New sale  has saved successfully");
    }

    public function deleteSale($id){
        $sale = Sales::where('sale_id',$id)->firstOrFail();
        $sale->delete();
        return redirect('sales/')->with('message',
                        "The sale reocrd has deleted perminantly");
    }

    public function editSale($id){
        $purchase = Sales::where('sale_id',$id)->firstOrFail();
        return $purchase;
    }
}
