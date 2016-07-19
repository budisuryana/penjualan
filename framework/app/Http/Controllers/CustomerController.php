<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Customer;

use App\Models\HistoryUser;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use URL, Excel, Carbon\Carbon, Session, Redirect, Input, Validator, DB, Sentinel, Response, Yajra\Datatables\Datatables;

class CustomerController extends Controller

{

    public function __construct() {
        $this->middleware('webAuth');
    }

    public function index()
    {
        //$data['title'] = 'Manage Customer';
        //$data['data']  = Customer::all();
        return view('customer.index')->withTitle('Manage Customer');
    }

    public function data()
    {
        $customers = Customer::select(['id', 'name', 'address', 'city', 'zip_code', 'phone', 'email']);

        return Datatables::of($customers)
            ->addColumn('action', function ($customer) {
                return '
                        <a href="'. URL::route('customer.edit', $customer->id) .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                        <a href="'. URL::route('customer.delete', $customer->id) .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash" onClick="return onDelete();"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function create()
    {
        $data['title'] = 'Create Customer';
        return view('customer.create', $data);
    }

    public function store(Request $request)
    {

        $rules     = array(
                            'name'         => 'required|unique:customer,name|min:3',
                            'address'      => 'required|max:50',
                            'phone'        => 'numeric',
                            'email'        => 'required|email|unique:customer,email'
                          );

        $this->validate($request, $rules);
        $customer = Customer::create($request->all());
        
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Created Customer "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('customer')->with('successMessage', 'Berhasil Menambah Customer');
    }

    public function edit($id)
    {
        $data['data'] = Customer::find($id);
        return view('customer.edit', $data)->withTitle('Edit Customer');
    }

    public function update(Request $request, $id)
    {

        $rules = array(
                       'name'    => 'required|unique:customer,name,'.$id.',id',
                       'address' => 'required',
                       //'phone'   => 'numeric',
                       'email'   => 'required|email|unique:customer,email,'.$id.',id'
                      );

        $this->validate($request, $rules);

        $customer = Customer::findOrFail($id);

        $customer->update($request->all());

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Updated Customer "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('customer')->with('successMessage', 'Berhasil Mengupdate Customer');

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $name = Customer::findOrFail($id)->value('name');
            Customer::findOrFail($id)->delete();
            HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Deleted Customer "' . $name . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);
        }

        catch(\Illuminate\Database\QueryException $e){

            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, gagal menghapus data!');
        }

        DB::commit();
        return redirect('customer')->with('successMessage', 'Berhasil Menghapus Data');
    }



    public function upload()
    {
        $data['title'] = 'Import Customer';
        return view('customer.upload', $data);
    }



    public function generateExcelTemplate()
    {

        Excel::create('Template Import Customer', function($excel){

            $excel->setTitle('Template Import Customer')

                  ->setCreator('Larapostory')

                  ->setCompany('Larapostory')

                  ->setDescription('Template import customer for Larapostory');



            $excel->sheet('Data Customer', function($sheet) {

                $row = 1;

                $sheet->row($row, array(

                    'Code',

                    'Name',

                    'Address',

                    'City',

                    'Postal Code',

                    'Phone',

                    'Email'

                ));

            });

        

        })->export('xls');



    }

    public function importExcel()
    {

        $rules     = ['excel' => 'required|mimes:xls'];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return Redirect::back()->withErrors($validator)->withInput();

        }

        $excel = Input::file('excel');

        $excels = Excel::selectSheetsByIndex(0)->load($excel, function($reader) {

        })->get();

        $counter = 0;

        $rowRules = [

            'Code'    => 'required|unique:customer,customercode',

            'Name'    => 'required|unique:customer,name',

            'Address' => 'required',

            'Phone'   => 'numeric',

            'Email'   => 'required|email|unique:customer,email'

            ];



        foreach ($excels as $row)

        {

            $validator = Validator::make($row->toArray(), $rowRules);

            if ($validator->fails()) continue;



            $customer = Customer::create([

                'customercode' => $row['Code'],

                'name'         => $row['Name'],

                'address'      => $row['Address'],

                'city'         => $row['City'],

                'zip_code'     => $row['Postal Code'],

                'phone'        => $row['Phone'],

                'email'        => $row['Email'],

                'created_at'   => Carbon::now()->format('Y-m-d'),

                'updated_at'   => Carbon::now()->format('Y-m-d')

            ]);



            $counter++;

        }

        return Redirect::route('customer.upload')->with("successMessage", "Successfully imported $counter customers.");

    }



    

}

