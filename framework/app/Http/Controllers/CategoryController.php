<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HistoryUser;
use URL, DB,Validator,Input,Redirect,Session,Response,Carbon\Carbon,Sentinel, Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('webAuth');
    }
    
    public function index()
    {
        return view('category.index')->withTitle('Manage Category');
    }

    public function data()
    {
        $category = Category::select(['id', 'name', 'description', 'status']);

        return Datatables::of($category)
            ->addColumn('action', function ($ctg) {
                return '
                        <a href="'. URL::route('category.edit', $ctg->id) .'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                        <a href="'. URL::route('category.delete', $ctg->id) .'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash" onClick="return onDelete();"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function create()
    {
      return view('category.create')->withTitle('Category');
    }

    public function store(Request $request)
    {
        $rules     = array(
                           'name' => 'required|unique:category',
                           'description' => 'max:255'
                          );

        $this->validate($request, $rules);

        $category = Category::create(Input::all());

        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Category "' . $request->input('name') . '" was created',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('category')->with('successMessage', 'Berhasil Menambah Kategori');
        
        
    }

    public function edit($id)
    {
        $data['data'] = Category::find($id);
        return view('category.edit', $data)->withTitle('Edit Category');
    }

    public function update(Request $request, $id)
    {
        $rules     = array(
                           'name'         => 'required|unique:category,name,'.$id.',id',
                           'description'  => 'max:255'
                          );

        $this->validate($request, $rules);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        
        HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Updated Category "' . $request->input('name') . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);

        return redirect('category')->with('successMessage', 'Berhasil Mengupdate Kategori');
    }

    public function destroy($id)
    {
        
        DB::beginTransaction();
        try
        {
            $name = Category::findOrFail($id)->value('name');
            Category::findOrFail($id)->delete();
            HistoryUser::create([
                   'entry_time'  => Carbon::now()->toDateTimeString(),
                   'role_id'     => Sentinel::getUser()->role_id,
                   'user_id'     => Sentinel::getUser()->id,
                   'description' => 'Deleted Category "' . $name . '"',
                   'created_at'  => Carbon::now()->toDateTimeString(),
                   'updated_at'  => Carbon::now()->toDateTimeString()
                   ]);
        }

        catch(\Illuminate\Database\QueryException $e){
            
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Integrity Constraint, gagal menghapus data!');
        }

        DB::commit();
        return redirect('category')->with('successMessage', 'Berhasil Menghapus Data');
        
    }

    public function autocomplete()
    {
        $term = Input::get('term');
    
        $results = array();
        
        $queries = Category::where('name', 'LIKE', '%'.$term.'%')
                   ->orWhere('categorycode', 'LIKE', '%'.$term.'%')
                   ->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->categorycode, 'value' => $query->name ];
        }

        return Response::json($results);
    }
}
