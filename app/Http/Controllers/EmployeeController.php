<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Illuminate\Http\Request;

function generateId(){
    $records = Employee::orderby('employee_id', 'desc')->get();
    if(count($records)==0){
        return 'E001';
    }

    $last_id = $records[0]->employee_id;

    $num = intval(substr($last_id, 1, strlen($last_id))) + 1;
    $new_id = '';
    if ($new_id < 10){
        $new_id = 'E00'.$num;
    }else{
        $new_id = 'E0'.$num;
    }
    return $new_id;
}

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $employees = DB::table('employee')->LeftJoin('department', 'department.department_id','employee.department_id')
        ->select(
            'employee_id',
            'employee_name',
            'title',
            'gender',
            'tell',
            'address',
            'employee.department_id',
            'department_name',
            'salary',
            'status'
            )->get();
        $departments = Department::all();
        return view('employees.index', [
            'employees'=>$employees,
            'departments'=>$departments
        ]);
    }

    public function create(Request $request){

        $request->validate([
        'name'=>'required|min:3',
        'address'=>'required',
        'gender'=>'required',
        'title'=>'required',
        'department'=>'required',
        'salary'=>'required',
        'status'=>'required'
        ]);

        $id = $request->id;
        $name = $request->name;
        $title = $request->title;
        $gender = $request->gender;
        $address = $request->address;
        $tell = $request->tell;
        $department_id = $request->department;
        $salary = $request->salary;
        $status = $request->status;


        if (isset($id)){
            Employee::where('employee_id',$id)->update([
                'employee_name'=>$name,
                'address'=>$address,
                'tell'=>$tell,
                'gender'=>$gender,
                'title'=>$title,
                'department_id'=>$department_id,
                'salary'=>$salary,
                'status'=>$status,
            ]);
            return redirect('employees/')->with('message', "employee with id '$id' has updated successfully");
        }

        $request->validate([
            'tell'=>'required|unique:employee',
        ]);

        $employee = new Employee();

        $new_id = generateId();

        $employee->employee_id = $new_id;
        $employee->employee_name = $name;
        $employee->address = $address;
        $employee->tell = $tell;
        $employee->gender = $gender;
        $employee->title = $title;
        $employee->department_id = $department_id;
        $employee->salary = $salary;
        $employee->status = $status;
        $employee->save();

        return redirect('employees/')->with('message', "'$employee->employee_name' has saved successfully");
    }

    public function deleteEmployee($id){
        $employee = Employee::where('employee_id',$id)->firstOrFail();
        $employee->delete();
        return redirect('employees/')->with('message',
                        "The employee with id '$employee->employee_id' has deleted perminantly");
    }

    public function editEmployee($id){
        $employee = Employee::where('employee_id',$id)->firstOrFail();
        return $employee;
    }
}
