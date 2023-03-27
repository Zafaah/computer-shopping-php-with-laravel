<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function generateId(){
    $records = User::orderby('user_id', 'desc')->get();

   

    if(count($records)==0){
        return 'U001';
    }

    $last_id = $records[0]->user_id;

    $num = intval(substr($last_id, 1, strlen($last_id))) + 1;
    $new_id = '';
    if ($new_id < 10){
        $new_id = 'U00'.$num;
    }else{
        $new_id = 'U0'.$num;
    }
    return $new_id;
}

class UserController extends Controller
{   
    public function index()
    {
        $user = User::all();
        $employees = Employee::all();
   
        return view('users.index', [
            'users'=>$user,
            'employees'=>$employees,
        ]);
    }

    public function create(Request $request){
        
        $request->validate([
        'password'=>'required|min:3',
        'employee_id'=>'required',
        'status'=>'required',
        ]);

        $id = $request->id;
        $username = $request->username;
        $password = $request->password;
        $employee_id = $request->employee_id;
        $status = $request->status;

        if (isset($id)){
            User::where('user_id',$id)->update([
                'username'=>$username,
                'password'=>$password,
                'employee_id'=>$employee_id,
                'status'=>$status
            ]);
            return redirect('users/')->with('message', "User with id '$id' has updated successfully");
        }

        $request->validate([
            'username'=>'required|unique:users',
        ]);

        $new_id = generateId();
        $user = new User();

        $user->user_id = $new_id;
        $user->username = $username;
        $user->password = $password;
        $user->employee_id = $employee_id;
        $user->status = $status;
        
        $user->save();
        return redirect('users/')->with('message', "'$user->username' has saved successfully");
    }

    public function deleteUser($id){
        $user = User::where('user_id',$id)->firstOrFail();
        $user->delete();
        return redirect('users/')->with('message',
                        "The user with id '$user->user_id' has deleted perminantly");
    }

    public function editUser($id){
        $user = User::where('user_id',$id)->firstOrFail();
        return $user;
    }

    public function display(){
        return view('users.login');
    }

    public function login(Request  $request){

        // Validate the user request
        $user = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        // check if the usr exists
        $loggedUser = User::where('username',$user['username'])->first();
        if (!$loggedUser){
            return back()->withErrors([
                'username'=>'Invalid username',
            ])->onlyInput('username', 'password');
        }

        // check if the user is active or not
        if ($loggedUser->status!='active'){
            return back()->withErrors([
                'username'=>'This user is locked, please contact to the adminstrator.',
            ])->onlyInput('username', 'password');
        }

        // check if the user is authenticate
        if (auth()->attempt($user)){
            // Select the information of the logged employee
            $employee = DB::table('users')->join('employee', 'users.employee_id', 'employee.employee_id')
                        ->select('username', 'employee_name', 'title')
                        ->where('username', auth()->user()->username)
                        ->first();

            $menus = DB::table('user_rolls')->join('menus', 'menus.menu_id', 'user_rolls.menu_id')
                        ->select('menus.menu_id', 'menu_name', 'link', 'icon')
                        ->where('user_id', auth()->user()->user_id)
                        ->get();
        
            session(['employee'=>$employee, 'menus'=>$menus]);
            
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'password'=>'Invalid Credatial'
        ])->onlyInput('username','password');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
