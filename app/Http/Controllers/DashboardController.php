<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employees = Employee::count();
        $products = Product::count();
        $customers = Customer::count();
        $suppliers = Supplier::count();
        $users = User::count();

        $info = [
            'Employees'=>$employees,
            'Products'=>$products,
            'Customers'=>$customers,
            'Suppliers'=>$suppliers,
            'Users'=>$users,
        ];
        
        return view('index', [
            'info'=>$info
        ]);
    }
}
