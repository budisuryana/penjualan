<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\BranchType;
use App\Models\HistoryUser;
use DB,Validator,Input,Redirect,Session,Response,Carbon\Carbon,Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;

class BranchController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        $data['title'] = 'Manage Cabang';
        $data['data']  = Branch::with('branchType')->orderBy('name', 'asc')->get();
        
        return view('branch.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Cabang';
        $data['type']  = BranchType::drop_options();
        return view('branch.create', $data);
    }

    public function store(Request $request)
    {
        $rules     = array(
                            'name'         => 'required|unique:branch,name',
                            'address'      => 'required'
                          );

        $this->validate($request, $rules);
        $data = Branch::create($request->all());
        $type = BranchType::find($request->type);

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Created Branch "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('branch')->with('successMessage', 'Berhasil Menambah Cabang');
        
    }

    public function edit($id)
    {
        $data['data'] = Branch::find($id);
        $data['type']  = BranchType::drop_options();
        return view('branch.edit', $data)->withTitle('Edit Cabang');
    }

    public function update(Request $request, $id)
    {
        $rules     = array(
                            'name'         => 'required|unique:branch,name,'.$id,'id',
                            'address'      => 'required'
                          );

        $this->validate($request, $rules);
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());
        $type = BranchType::find($request->type);

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Mengupdate Cabang "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('branch')->with('successMessage', 'Berhasil Mengupdate Cabang');

    }

    public function destroy()
    {
        
        $post = Input::get('chkDel');
        DB::beginTransaction();
        try
        {
            Branch::where('id', $id)->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, gagal menghapus data!');
            
        }

        DB::commit();
        return redirect('customer')->with('successMessage', 'Berhasil Menghapus Data');
    }

    /**************Branch Type******************/
    public function indexBranchType()
    {
        $data['title'] = 'Manage Branch Type';
        $data['data']  = DB::table('branch_type')->get();
        return view('branch.indexBranchType', $data);
    }

    public function createBranchType()
    {
        $data['title'] = 'Create Branch Type';
        return view('branch.createBranchType', $data);
    }


    public function storeBranchType(Request $request)
    {
        
        $this->validate($request, [
               'typecode' => 'required|max:10|unique:branch_type,typecode', 
               'name' => 'required|min:3|unique:branch_type,name'
            ]);

        DB::table('branch_type')->insert($request->except('_token'));
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Branch Type "' . $request->input('name') . '" was created',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);

        Session::flash('successMessage', 'Branch Type Created');
        return Redirect('branchtype');
        
    }

    public function editBranchType($id)
    {
        $data['data']  = DB::table('branch_type')->where('typecode', $id)->first();
        $data['title'] = 'Edit Branch Type';
        return view('branch.editBranchType', $data);
    }

    public function updateBranchType(Request $request, $id)
    {
        $this->validate($request, [
               'typecode' => 'required|max:10|unique:branch_type,typecode,'.$id.',typecode', 
               'name' => 'required|min:3|unique:branch_type,name,'.$id.',typecode'
            ]);

        $branch = DB::table('branch_type')->where('typecode', $id)->update($request->except('_token'));
        //$branch->update($request->all());
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Branch Type "' . $request->input('name') . '" was updated',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);

        Session::flash('successMessage', 'Branch Type Updated');
        return Redirect('branchtype');

    }

    public function destroyBranchType($id)
    {
        
        DB::beginTransaction();
        try
        {
            $name   = Branch::getNameBranchType($id);
            $strSQL = DB::table('branch_type')->where('typecode', $id)->delete();
            HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Branch Type "'.$name.'" was deleted',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);
        }

        catch(\Illuminate\Database\QueryException $e){
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, this data has linked to other table! Please try again with other data.');
            
        }

        DB::commit();
        Session::flash('successMessage', 'Branch Deleted');
        return Redirect('branchtype');
    }

    

    
}
