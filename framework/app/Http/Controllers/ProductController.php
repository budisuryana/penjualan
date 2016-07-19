<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\HistoryUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use URL, Response, Image, DB, Validator, Input, Redirect, Session, File, Carbon\Carbon, Sentinel, Excel;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        return view('product.index')->withTitle('Manage Product');
    }

    public function data()
    {
        $products = Product::with('category')->select('product.*');

        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                return '
                        <a href="'. URL::route('product.edit', $product->id) .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                        <a href="'. URL::route('product.delete', $product->id) .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function create()
    {
        $data['category'] = Category::drop_options();
        $data['title']    = 'Create Product';
        $data['supplier'] = Supplier::select('*', DB::raw("'0' as checked"))->get();
        return view('product.create', $data);
    }

    public function store(Request $request)
    {
        $idsupplier = $request->input('supplier_id');
        $this->validate($request, [
                'productcode' => 'required|alpha_num|max:10|unique:product,productcode',
                'name'        => 'required|alpha|unique:product,name|min:3|max:50',
                'category_id' => 'required',
                'stock'       => 'numeric',
                'cost_price'  => 'required',
                'sell_price'  => 'required',
                'supplier_id' => 'required'
                ]);

        $product = Product::create($request->all());
        $product->itemSupplier()->sync($idsupplier);
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->format('Y-m-d H:i:s'),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Created Product "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        Session::flash('successMessage', 'Product Created');
        return redirect('product');

    }

    public function edit($id)
    {
        $data['title'] = 'Edit Product';
        $data['category'] = Category::drop_options();
        $data['supplier'] = Supplier::select('*', DB::raw("'0' as checked"))->get();
        $data['data']  = Product::findOrFail($id);

        foreach ($data['supplier'] as $suppliers => $value) {
            $cekSUpplier = DB::table('item_supplier')
                ->where('product_id', '=', $id)
                ->where('supplier_id', '=', $value->id)
                ->count();

            if ($cekSUpplier) {
                $value->checked = 'checked';
            }
        }

        return view('product.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $idsupplier = $request->input('supplier_id');
        $this->validate($request, [
                'productcode' => 'required|alpha_num|max:10|unique:product,productcode,'.$id.',id',
                'name'        => 'required|alpha|max:50|unique:product,name,'.$id.',id',
                'category_id' => 'required',
                'stock'       => 'numeric',
                'cost_price'  => 'required',
                'sell_price'  => 'required',
                'supplier_id' => 'required'
                ]);

        $product = Product::findOrFail($id);
        $product->update($request->except(['_token', 'supplier_id']));
        $product->itemSupplier()->sync($idsupplier);
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Updated Product "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        Session::flash('successMessage', 'Product Updated');
        return redirect('product');
    }

    public function destroy($id)
    {
        
        DB::beginTransaction();
        
        try
        {
            $name      = Product::findOrFail($id)->value('name');
            Product::destroy($id);

            HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Deleted Product "'.$name.'"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);
        }

        catch(\Illuminate\Database\QueryException $e)
        {
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint');
            
        }

        DB::commit();
        Session::flash('successMessage', 'Product Deleted');
        return redirect('product');
    }

    public function upload()
    {
        return view('product.upload')->withTitle('Import Product');
    }



    public function generateExcelTemplate()
    {
        Excel::create('Template Import Product', function($excel){
            $excel->setTitle('Template Import Product');
            $excel->sheet('Data Product', function($sheet) {
                $row = 1;
                $sheet->row($row, array(
                    'Code',
                    'Name',
                    'Category',
                    'Stock',
                    'Cost Price',
                    'Sell Price',
                    'Discount'
                ));
            });
        })->export('xls');
    }

    public function importExcel()
    {

        $rules     = ['excel' => 'required'];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $excel  = Input::file('excel');
        $excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {

        })->get();

        $counter = 0;
        $rowrules = [
                    'code'       => 'required|alpha_num|unique:product,productcode',
                    'name'       => 'required|unique:product,name',
                    'category'   => 'required',
                    'stock'      => 'numeric',
                    'cost_price' => 'required|numeric',
                    'sell_price' => 'required|numeric',
                    'discount'   => 'numeric',
                    ];

        foreach ($excels as $row) 
        {
            $validator = Validator::make($row->toArray(), $rowrules);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $ctg = Category::where('name', $row['category'])->first();
            $cnt = count($ctg);
              
            if ($cnt > 0) {
                $ctg = $ctg->id; 
            }
            else
            {
                $insert = Category::create([
                       'name'=> $row['category'],
                       ]);

                $ctg    = $insert->id;
            }

            Product::create([

                'productcode'  => $row['code'],

                'name'         => $row['name'],

                'category_id'  => $ctg,

                'stock'        => $row['stock'],

                'cost_price'   => $row['cost_price'],

                'sell_price'   => $row['sell_price'],

                'discount'     => $row['discount'],

                'created_at'   => Carbon::now()->format('Y-m-d'),

                'updated_at'   => Carbon::now()->format('Y-m-d')

            ]);

            $counter++;

        }

        return Redirect::route('product.upload')->with("successMessage", "Berhasil mengimport $counter record.");

    }

}
