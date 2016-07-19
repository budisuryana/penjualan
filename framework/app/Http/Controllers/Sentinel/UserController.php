<?php

namespace App\Http\Controllers\Sentinel;
use DB,Carbon\Carbon,Sentinel,Input,Redirect;
use App\Models\User;
use App\Models\HistoryUser;
use App\Models\Role;
use App\Models\AppMenu;
use App\Models\SettingSystem;
use Validator, Image;
use App\Events\UserRegistrationEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }

    public function index() {
    	$data['user'] = User::join('role_users', 'users.id', '=', 'role_users.user_id')
                        ->leftJoin('roles', 'role_users.role_id', '=', 'roles.id')
                        ->select('users.*', 'roles.name as role')
                        ->get();
                        
        $data['roles'] = Role::all();
    	return view('admin.users.index', $data)->withTitle('List Users');
    }

    public function create()
    {
        $data['title'] = 'Add User';
        $data['role']  = Role::drop_options();
        return view('admin.users.create', $data);
    }

    public function historyIndex()
    {
        $system = SettingSystem::all();
        $data['data'] = HistoryUser::with('user', 'user.role')->paginate($system[0]['page_per_rows']); //return $data['data'];
        return view('admin.users.history', $data)->withTitle('History Users');
    }

    public function edit($id)
    {
        $data['segment'] = \Request::segment(2);
        $data['title']   = 'Edit User';
        $data['data']    = User::join('role_users', 'users.id', '=', 'role_users.user_id')
                            ->join('roles', 'role_users.role_id', '=', 'roles.id')
                            ->select('users.*', 'role_users.role_id', 'roles.name')
                            ->where('users.id', $id)
                            ->first();

        $data['role'] = Role::drop_options();
        return view('admin.users.edit', $data);
    }

    public function getAllHistory(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $data = HistoryUser::join('users', 'history_user.user_id', '=', 'users.id')
                             ->select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                               'history_user.entry_time', DB::raw('concat(users.first_name," ",users.last_name) as fullname'), 
                               'history_user.description'])
                             ->orderBy('history_user.id', 'desc');
                                    
        if ($keyword = $request->get('search')['value']) {
            Datatables::of($data)->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return Datatables::of($data)
            ->editColumn('entry_time', function ($data) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $data->entry_time)->diffForHumans();
            })

            ->make(true);
    }

    public function roleIndex() {
    	$data['appMenus'] = AppMenu::mainMenu()->get();
    	return view('admin.groups', $data)->withTitle('Add Group Menu');
    }

    public function createRole()
    {
        $data['appMenu'] = AppMenu::with( array(
                'childs' => function($qChild) {
                        $qChild->Ismenu();
                        $qChild->with( array(
                            'childs' => function($qChild2) {
                                $qChild2->Ismenu();
                                $qChild2->with( array(
                                    'childs' => function($qChild3) {
                                        $qChild3->Ismenu();
                                    }) 
                                );
                            }) 
                        );
                    }) 
                )
                ->Ismenu()
                ->select('*', DB::raw("null as checked"))
                ->whereNull('parent')
                ->orderBy(DB::raw('menu_order=99'), 'desc')
                ->orderBy('menu_order', 'desc')
                ->get();

        return view('admin.users.createRole', $data)
                ->with('title', 'Add Role')
                ->withGrpid(null);
                
    }

    public function storeRole(Request $request)
    {
        $this->validate($request, Role::$rules);
        $roleData  = Input::only('name');
        $roleMenus = Input::get('menu_id');

        $role      = Role::create($roleData);

        $role->appMenu()->sync($roleMenus);


        return Redirect::route('user.list')
            ->with('successMessage', "Role $role->name created");
    }

    public function store(Request $request)
    {
        $this->validate($request, User::$rules);
        $credential  = Input::except('role_id','password_confirmation');
        $user        = Sentinel::register($credential, true);
        $role        = Sentinel::findRoleById(Input::get('role_id'));
        $role->users()->attach($user);
        
        //event(new UserRegistrationEvent(Input::all()));
        return Redirect::route('user.list')->with('successMessage', "Username $user->username created");
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'username'          => 'required|min:5|unique:users,username,'.$id.',id',
                'email'             => 'required|email|unique:users,email,'.$id.',id',
                'first_name'        => 'required',
                'last_name'         => 'required',
                'role_id'           => 'required'
               ]);

        $roleid = DB::table('role_users')->where('user_id', $id)->value('role_id');

        try {
            
            if($roleid == 1)
            {
                return Redirect::back()->with('infoMessage', 'Maaf anda tidak bisa mengupdate Role Admin di Demo ini.');
            }

            $user = User::findOrFail($id);
            $user->update($request->except('password', 'password_confirmation', 'role_id', '_token'));
            DB::table('role_users')->where('user_id', $id)->delete();
            $role = Sentinel::findRoleById(Input::get('role_id'));
            $role->users()->attach($user);

        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors('Something went wrong, please try again')->withInput();
        }
        
        return Redirect('users/list')->with('successMessage', "Username $user->username updated");

    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);

        $menus = AppMenu::with( array(
                'childs' => function($qChild) {
                        $qChild->Ismenu();
                        $qChild->with( array(
                            'childs' => function($qChild2) {
                                $qChild2->Ismenu();
                                $qChild2->with( array(
                                    'childs' => function($qChild3) {
                                        $qChild3->Ismenu();
                                    }) 
                                );
                            }) 
                        );
                    }) 
                )
                ->Ismenu()
                ->select('*', DB::raw("null as checked"))
                ->whereNull('parent')
                ->orderBy(DB::raw('menu_order=99'), 'desc')
                ->orderBy('menu_order', 'desc')
                ->get();

        $access = AppMenu::whereIsmenu('N')
                ->select('*', DB::raw("null as checked"))
                ->whereNull('parent')
                ->where(function($qWh) {
                    $qWh->whereNotNull('menu_alias');
                    $qWh->orWhereNotNull('menu_url');
                })
                ->orderBy('description')
                ->get();

        foreach ($menus as $menu => $value) {
            $menuCheck = DB::table('appmenu_role')
                            ->where('appmenu_id','=',$value->menu_id)
                            ->where('role_id','=',$id)
                            ->count();
            $menuCheck>0 ? $value->checked = 'checked' : null ;

            foreach ($value->childs as $level2 => $value2) {
                $menuCheck2 = DB::table('appmenu_role')
                                ->where('appmenu_id','=',$value2->menu_id)
                                ->where('role_id','=',$id)
                                ->count();
                $menuCheck2>0 ? $value2->checked = 'checked' : null ;

                foreach ($value2->childs as $level3 => $value3) {
                    $menuCheck3 = DB::table('appmenu_role')
                                    ->where('appmenu_id','=',$value3->menu_id)
                                    ->where('role_id','=',$id)
                                    ->count();
                    $menuCheck3>0 ? $value3->checked = 'checked' : null ;

                    foreach ($value3->childs as $level4 => $value4) {
                        $menuCheck4 = DB::table('appmenu_role')
                                        ->where('appmenu_id','=',$value4->menu_id)
                                        ->where('role_id','=',$id)
                                        ->count();
                        $menuCheck4>0 ? $value4->checked = 'checked' : null ;
                    }
                }
            }
        }

        foreach ($access as $akses => $valAks) {
            $menuCheck = DB::table('appmenu_role')
                            ->where('appmenu_id','=',$valAks->menu_id)
                            ->where('role_id','=',$id)
                            ->count();
            $rolename  = Role::find($id);
            $menuCheck>0 ? $valAks->checked = 'checked' : null ;
        }
        
        return view('admin.users.editRole', compact('role', 'id'))
                ->with('appMenu', $menus)
                ->with('pageAccess', $access)
                ->with('rolename', $rolename->name)
                ->with('title', 'Edit Role');
    }

    public function updateRole($id)
    {
        $rules = [
            'name'    => 'required|min:5|unique:roles,name,'.$id,
            'slug'    => 'required',
            'menu_id' => 'required'
        ];

        $role = Role::findOrFail($id);

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (!$role->update(Input::except(array('menu_id','akses_id')))) {
            return Redirect::back()->with('errorMessage', 'Something went wrong, please try again')->withInput();
        }


        $roleMenus = Input::get('menu_id');
        $accessMenus = Input::get('akses_id');

        try {
            DB::table('appmenu_role')->join('appmenu','appmenu.menu_id','=','appmenu_role.appmenu_id')
                ->whereIsmenu('Y')
                ->whereRoleId($id)
                ->delete();
            DB::table('appmenu_role')->join('appmenu','appmenu.menu_id','=','appmenu_role.appmenu_id')
                ->whereIsmenu('N')
                ->whereRoleId($id)
                ->delete();

            $role->appMenu()->attach($roleMenus);
            $role->appMenu()->attach($accessMenus);
        } catch (\Exception $e) {
            return Redirect::back()->with('errorMessage', 'Something went wrong, please try again')->withInput();
        }

        
        return Redirect::route('role.edit', array('id'=>$id))
                ->with('successMessage', "Role $role->name updated.");
    }

    public function changePassword()
    {
        return view('admin.users.resetpassword')->withTitle('Reset Password');
    }

    public function updatePassword(Request $request) {
        
        return Redirect::to('/')->with('infoMessage', 'Maaf di mode Demo, anda tidak bisa mengganti password');
        //return 'Maaf di mode Demo, anda tidak bisa mengganti password';
        /*$rules = [
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $hasher       = Sentinel::getHasher(); 
        $oldPassword  = $request->old_password;
        $password     = $request->password;
        $passwordConf = $request->password_confirmation;

        $user = Sentinel::getUser();

        if (!$hasher->check($oldPassword, $user->password)) {
            
            return Redirect::back()->with('errorMessage', 'Check input is correct.')->withInput();
        }

        Sentinel::update($user, array('password' => $password));

        return Redirect::to('/');*/
    }

    public function myprofile()
    {
        $data['data'] = Sentinel::getUser();
        $data['roles'] = Role::pluck('name', 'id');
        return view('admin.users.myprofile', $data)->withTitle('Profile Account');
    }

    public function postprofile(Request $request)
    {
        $id = Sentinel::getUser()->id;
        $roleid = DB::table('role_users')->where('user_id', $id)->value('role_id');

        $this->validate($request, [
                'username'          => 'required|min:5|unique:users,username,'.$id.',id',
                'email'             => 'required|email|unique:users,email,'.$id.',id',
                'first_name'        => 'required',
                'last_name'         => 'required',
                'role_id'           => 'required'
               ]);

        try {
            
            if($roleid == 1)
            {
                return Redirect::back()->with('infoMessage', 'Maaf anda tidak bisa mengganti Profile Admin di Demo ini.');
            }

            $user = User::findOrFail($id);
            $user->update($request->except('role_id', '_token'));
            DB::table('role_users')->where('user_id', $id)->delete();
            $role = Sentinel::findRoleById(Input::get('role_id'));
            $role->users()->attach($user);

        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors('Something went wrong, please try again')->withInput();
        }
        
        return Redirect::back()->with('successMessage', 'Berhasil mengupdate Profie');
    }

    public function postavatar(Request $request)
    {
        $id = Sentinel::getUser()->id;

        if (Input::hasFile('avatar')) 
        {
            $upload = Input::file('avatar');

            $extension = $upload->getClientOriginalExtension();

            $filename = $upload->getClientOriginalName();
            $destinationPath = 'assets/img/avatar/';

            $upload->move($destinationPath, $filename);

            $user = User::findOrFail($id); 
            $user->avatar = $filename;
            $user->save();
        }

        return Redirect::back()->with('successMessage', 'Berhasil mengganti Avatar');
    }
}
