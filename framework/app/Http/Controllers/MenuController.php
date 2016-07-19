<?php

namespace App\Http\Controllers;
use App\Models\AppMenu;
use App\Models\HistoryUser;
use Illuminate\Http\Request;
use DB,Validator,Input,Redirect,Session,Response,Datatables,Carbon\Carbon,Sentinel;
use App\Http\Requests;

class MenuController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }

    public function index()
    {
    	$data['data'] = AppMenu::with('childs')
		    			->orderBy('menu_id', 'asc')
                        ->where('ismenu', 'Y')
                        ->where('is_active', 'Y')
		    			->get();

    	return view('menus.index', $data)->withTitle('Manage Menu');
    }

    public function create()
    {
    	$data['parent'] = AppMenu::drop_options();
    	return view('menus.create', $data)->withTitle('Create Menu');
    }

    public function edit($id)
    {
    	$data['data']  = AppMenu::find($id);
    	$data['parent'] = AppMenu::drop_options();
        return view('menus.edit', $data)->withTitle('Edit Menu');
    }

    public function destroy($id)
    {
        return Redirect::back()->with('infoMessage', "Oops, sorry in this demo you cant delete menu.");
        /*$menu = AppMenu::find($id);
        $menu->delete();
        return Redirect('menu')->with('successMessage', 'Menu Deleted');*/
    }

    public function store(Request $request)
    {
    	return Redirect::back()->with('infoMessage', "Oops, sorry in this demo you cant create menu.");
        /*$userID = Sentinel::getUser()->id;
    	$role   = DB::table('role_users')->where('user_id', $userID)->value('role_id');
    	
    	$this->validate($request, [
               'description' => 'required|unique:appmenu,description',
               'ismenu'      => 'required'
            ]);

        DB::beginTransaction();
        try
        {
        	$insert = AppMenu::insertGetId([
        				'description' => $request->description,
	    				'menu_url' => $request->menu_url ? $request->menu_url:null,
	    				'menu_alias' => $request->menu_alias ? $request->menu_alias:null,
	    				'ismenu' => $request->ismenu,
	    				'parent' => $request->parent ? $request->parent:null,
	    				'menu_icon' => $request->menu_icon,
	    				'menu_order' => $request->menu_order
        		]);

	        DB::table('appmenu_role')->insert([
	        	'appmenu_id' => $insert,
	        	'role_id'    => $role
	        	]);

	        HistoryUser::create([
	                   'entry_time'  => Carbon::now()->toDateTimeString(),
	                   'user_id'     => Sentinel::getUser()->id,
	                   'description' => 'Menu "' . $request->input('description') . '" was created',
	                   'created_at'  => Carbon::now()->toDateTimeString(),
	                   'updated_at'  => Carbon::now()->toDateTimeString()
	                   ]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return Redirect::back()->with('infoMessage', "Route not defined. ");
        }
        
        DB::commit();
        Session::flash('successMessage', 'Menu Created');
        return Redirect('menu');*/
    }

    public function update(Request $request, $id)
    {
    	return Redirect::back()->with('infoMessage', "Oops, sorry in this demo you cant update menu.");
        /*$this->validate($request, [
               'description' => 'required|unique:appmenu,description,'.$id.',menu_id',
               'ismenu'      => 'required'
            ]);

        
        $menus = AppMenu::findOrFail($id);
        $menus->update([
                'description' => $request->description,
                'menu_url' => $request->menu_url ? $request->menu_url:null,
                'menu_alias' => $request->menu_alias ? $request->menu_alias:null,
                'ismenu' => $request->ismenu,
                'parent' => $request->parent ? $request->parent:null,
                'menu_icon' => $request->menu_icon,
                'menu_order' => $request->menu_order
            ]);

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Menu "' . $request->input('description') . '" was updated',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);

        Session::flash('successMessage', 'Menu Updated');
        return Redirect('menu');*/
    }
}
