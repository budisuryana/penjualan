<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\HistoryUser;
use URL,DB,Validator,Input,Redirect,Session,Carbon\Carbon,Sentinel,Response,Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        return view('supplier.index')->withTitle('Manage Supplier');
    }

    public function data()
    {
        $suppliers = Supplier::select(['id', 'name', 'address', 'phone', 'email']);

        return Datatables::of($suppliers)
            ->addColumn('action', function ($supplier) {
                return '
                        <a href="'. URL::route('supplier.edit', $supplier->id) .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                        <a href="'. URL::route('supplier.delete', $supplier->id) .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash" onClick="return onDelete();"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function create()
    {
        $data['title'] = 'Create Supplier';
        return view('supplier.create', $data);
    }

    public function store(Request $request)
    {
        $rules     = array(
                            'name'         => 'required|alpha|unique:supplier,name|min:3',
                            'address'      => 'required|alpha_num|max:50',
                            'phone'        => 'numeric',
                            'email'        => 'required|email|unique:supplier,email'
                          );

        $this->validate($request, $rules);
        $supplier = Supplier::create($request->all());

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Created Supplier "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('supplier')->with('successMessage', 'Berhasil Menambah Supplier');
        
    }

    
    public function edit($id)
    {
        $data['data'] = Supplier::find($id);
        return view('supplier.edit', $data)->withTitle('Edit Supplier');
    }

    public function update(Request $request, $id)
    {
        $rules = array(
                       'name'    => 'required|alpha|unique:supplier,name,'.$id.',id',
                       'address' => 'required|alpha_num|max:50',
                       'phone'   => 'numeric',
                       'email'   => 'required|email|unique:supplier,email,'.$id.',id'
                      );

        $this->validate($request, $rules);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Updated Supplier "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('supplier')->with('successMessage', 'Berhasil Mengupdate Supplier');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $name = Supplier::findOrFail($id)->value('name');
            Supplier::findOrFail($id)->delete();
            HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Deleted Supplier "' . $name . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        }

        catch(\Illuminate\Database\QueryException $e){
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, gagal menghapus data!');
            
        }

        DB::commit();
        return redirect('supplier')->with('successMessage', 'Berhasil Menghapus Data');
    }

    
}
