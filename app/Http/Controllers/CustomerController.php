<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

function generateId(){
    $records = Customer::orderby('customer_id', 'desc')->get();
    if(count($records)==0){
        return 'C001';
    }

    $last_id = $records[0]->customer_id;

    $num = intval(substr($last_id, 1, strlen($last_id))) + 1;
    $new_id = '';
    if ($new_id < 10){
        $new_id = 'C00'.$num;
    }else{
        $new_id = 'C0'.$num;
    }
    return $new_id;
}

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $customers = Customer::all();
   
        return view('customers.index', ['customers'=>$customers]);
    }

    public function create(Request $request){
        
        $request->validate([
        'name'=>'required',
        'gender'=>'required',
        'address'=>'required'
        ]);


        $id = $request->id;
        $name = $request->name;
        $gender = $request->gender;
        $address = $request->address;
        $tell = $request->tell;

        if (isset($id)){
            Customer::where('customer_id',$id)->update([
                'customer_name'=>$name,
                'address'=>$address,
                'tell'=>$tell,
                'gender'=>$gender
            ]);
            return redirect('customers/')->with('message', "Customer with id '$id' has updated successfully");
        }

        $request->validate([
            'tell'=>'required|unique:customer',
        ]);

        $new_id = generateId();
        $customer = new Customer();

        $customer->customer_id = $new_id;
        $customer->customer_name = $name;
        $customer->address = $address;
        $customer->tell = $tell;
        $customer->gender = $gender;
        
        $customer->save();
        return redirect('customers/')->with('message', "'$customer->customer_name' has saved successfully");
    }

    public function deleteCustomer($id){
        $customer = Customer::where('customer_id',$id)->firstOrFail();
        $customer->delete();
        return redirect('customers/')->with('message',
                        "The Customer with id '$customer->customer_id' has deleted perminantly");
    }

    public function editCustomer($id){
        $customer = Customer::where('customer_id',$id)->firstOrFail();
        return $customer;
    }
}
