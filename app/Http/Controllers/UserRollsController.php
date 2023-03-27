<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\UserRolls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRollsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $rolls = DB::table('user_rolls')->join('users', 'users.user_id', 'user_rolls.user_id')
                ->join('menus', 'menus.menu_id', 'user_rolls.menu_id')
                ->select('id', 'users.user_id', 'username', 'menus.menu_id', 'menu_name', 'link')->get();
        $users = User::all();
        $menus = Menu::all();


        return view('rolls.index', [
            'rolls'=>$rolls,
            'users'=>$users,
            'menus'=>$menus
        ]);
    }

    public function create(Request $request){
        
        $request->validate([
        'user'=>'required',
        'menus'=>'required'
        ]);

        $user = $request->user;
        $menus = $request->menus;
        
        UserRolls::where('user_id',$user)->delete();
        
        foreach ($menus as $menu){
            $roll = new UserRolls();

            $roll->user_id = $user;
            $roll->menu_id = $menu;

            $roll->save();
        }

        return redirect('rolls/')->with('message', "User roll has saved successfully");
    }

    public function deleteRoll($id){
        $menu = UserRolls::where('id',$id)->firstOrFail();
        $menu->delete();
        return redirect('rolls/')->with('message',
                        "The Menu has deleted perminantly");
    }

    public function editRoll($id){
        $rolls = UserRolls::where('user_id',$id)->get();
        $menus = [];
        foreach($rolls as $roll){
            array_push($menus, $roll->menu_id);
        }

        $user_rolls = ['user'=>$id, 'menus'=>$menus];
        return $user_rolls;
    }
}
