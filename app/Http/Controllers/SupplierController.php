<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

function generateId(){
    $records = Supplier::orderby('supplier_id', 'desc')->get();
    if(count($records)==0){
        return 'S001';
    }

    $last_id = $records[0]->supplier_id;

    $num = intval(substr($last_id, 1, strlen($last_id))) + 1;
    $new_id = '';
    if ($new_id < 10){
        $new_id = 'S00'.$num;
    }else{
        $new_id = 'S0'.$num;
    }
    return $new_id;
}

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', ['suppliers'=>$suppliers]);
    }

    public function create(Request $request){

         $request->validate([
        'name'=>'required',
        'address'=>'required',
        'contact'=>'required|unique:supplier',
        ]);

        $id = $request->id;
        $name = $request->name;
        $address = $request->address;
        $contact = $request->contact;


        if (isset($id)){
            Supplier::where('supplier_id',$id)->update([
                'supplier_name'=>$name,
                'address'=>$address,
                'contact'=>$contact
            ]);
            return redirect('suppliers/')->with('message', "Supplier with id '$id' has updated successfully");
        }

        $new_id = generateId();
        $supplier = new Supplier();

        $supplier->supplier_id = $new_id;
        $supplier->supplier_name = $name;
        $supplier->address = $address;
        $supplier->contact = $contact;
        
        $supplier->save();
        return redirect('suppliers/')->with('message', "'$supplier->supplier_name' has saved successfully");
    }

    public function deleteSupplier($id){
        $supplier = Supplier::where('supplier_id',$id)->firstOrFail();
        $supplier->delete();
        return redirect('suppliers/')->with('message',
                        "The supplier with id '$supplier->supplier_id' has deleted perminantly");
    }

    public function editsupplier($id){
        $supplier = Supplier::where('supplier_id',$id)->firstOrFail();
        return $supplier;
        // redirect('suppliers/')->with('form', $supplier)
    }
}
