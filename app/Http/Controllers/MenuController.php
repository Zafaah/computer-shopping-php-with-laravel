<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', ['menus'=>$menus]);
    }

    public function create(Request $request){
        
        $request->validate([
        'name'=>'required',
        'link'=>'required'
        ]);


        $id = $request->id;
        $name = $request->name;
        $link = $request->link;
        $icon = $request->icon;

        if (isset($id)){
            Menu::where('menu_id',$id)->update([
                'menu_name'=>$name,
                'link'=>$link,
                'icon'=>$icon
            ]);
            return redirect('menus/')->with('message', "menu with id '$name' has updated successfully");
        }

        $request->validate([
        'name'=>'required:unique:menus',
        'link'=>'required:unique:menus'
        ]);

        

        $menu = new Menu();

        $menu->menu_name = $name;
        $menu->link = $link;
        $menu->icon = $icon;
        
        $menu->save();
        return redirect('menus/')->with('message', "'$menu->menu_name' has saved successfully");
    }

    public function deleteMenu($id){
        $menu = Menu::where('menu_id',$id)->firstOrFail();
        $menu->delete();
        return redirect('menus/')->with('message',
                        "The menu with id '$menu->menu_name' has deleted perminantly");
    }

    public function editMenu($id){
        $menu = Menu::where('menu_id',$id)->firstOrFail();
        return $menu;
    }
}
