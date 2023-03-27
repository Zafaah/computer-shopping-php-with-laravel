<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', ['departments'=>$departments]);
    }

    public function create(Request $request){

        $request->validate([
        'name'=>'required',
        'location'=>'required'
        ]);

        $id = $request->id;
        $name = $request->name;
        $location = $request->location;

        if (isset($id)){
            Department::where('department_id',$id)->update([
                'department_name'=>$name,
                'location'=>$location,
            ]);
            return redirect('departments/')->with('message', "The department has updated successfully");
        }

        

        $department = new Department();

        $department->department_name = $name;
        $department->location = $name;
        
        $department->save();
        return redirect('departments/')->with('message', 
                        "The department with name '$department->department_name' has saved successfully");
    }

    public function deleteDepartment($id){
        $department = Department::where('department_id',$id)->firstOrFail();
        $department->delete();
        return redirect('departments/')->with('message',
                        "The department with name '$department->department_name' has deleted perminantly");
    }

    public function editDepartment($id){
        $department = Department::where('department_id',$id)->firstOrFail();
        return $department;
    }
}
