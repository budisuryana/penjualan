<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Validator,Input,Redirect,Session,Response,Carbon\Carbon,Sentinel;
use App\Models\Employee;
use App\Models\HistoryUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }

    public function index()
    {
        $data['title'] = 'Manage Employee';
        $data['data']  = Employee::all();
        return view('employee.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Create Employee';
        return view('employee.create', $data);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
                'employeecode'    => 'required|max:10|unique:employee,employeecode',
                'name'    => 'required|unique:employee,name|min:3',
                'address' => 'required',
                'phone'   => 'numeric',
                'email'   => 'required|email|unique:employee,email'
                ]);

        Employee::create($request->all());
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Employee "' . $request->input('name') . '" was created',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);

        Session::flash('successMessage', 'Employee Created');
        return redirect('employee');
        
        
    }

    
    public function edit($id)
    {
        $data['title'] = 'Edit Employee';
        $data['data'] = Employee::find($id);
        return view('employee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'employeecode' => 'required|unique:employee,employeecode,'.$id.',employeecode',
                'name'         => 'required|unique:employee,name,'.$id.',employeecode|min:3',
                'address'      => 'required',
                'phone'        => 'numeric',
                'email'        => 'required|email|unique:employee,email,'.$id.',employeecode'
                ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Employee "' . $request->input('name') . '" was updated',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);

        Session::flash('successMessage', 'Employee Updated');
        return redirect('employee');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            
            $name   = Employee::getName($id);
            $strSQL = Employee::where('employeecode', $id)->delete();
            HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Employee "' . $name . '" was deleted',
                   'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                   ]);
        }
        catch(\Illuminate\Database\QueryException $e){
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, failed deleted data!');
        }
        
        DB::commit();
        Session::flash('successMessage', 'Employee Deleted');
        return Redirect('customer');
    }
}
