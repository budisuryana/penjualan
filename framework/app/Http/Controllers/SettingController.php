<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingGeneral;
use App\Models\SettingSystem;
use Redirect, DB, Input;
use App\Http\Requests;

class SettingController extends Controller
{
    public function general()
    {
    	$data['data'] = SettingGeneral::find(1);
    	return view('setting.general', $data)->withTitle('Setting General');
    }

    public function storeGeneral(Request $request)
    {
    	$rules = [
    		'app_name' => 'required',
    		'company' => 'required',
    		'company_address' => 'required',
    		'email' => 'required|email'
    	];

    	$this->validate($request ,$rules);
    	$general = SettingGeneral::findOrFail(1); 
    	$general->update($request->all());

        if (Input::hasFile('logo')) 
        {
            $upload_logo = Input::file('logo');

            $extension = $upload_logo->getClientOriginalExtension();

            $filename = $upload_logo->getClientOriginalName();
            $destinationPath = 'assets/img';

            $upload_logo->move($destinationPath, $filename);

            $general->logo = $filename;
            $general->save();
        }

    	return Redirect::back()->with('successMessage', 'Setting Updated');
    }

    public function system()
    {
        $data['data'] = SettingSystem::find(1);
        $data['timezone'] = DB::table('zone')->orderBy('zone_name', 'asc')->pluck('zone_name', 'zone_id');
        return view('setting.system', $data)->withTitle('Setting System');
    }

    public function storeSystem(Request $request)
    {
        $rules = [
            'page_per_rows'  => 'required|numeric',
            'prefix_invoice' => 'required|min:3|max:3|alpha',
            'timezone'       => 'required',
        ];

        $this->validate($request ,$rules);
        $general = SettingSystem::findOrFail(1); 
        $general->update($request->all()); 
        return Redirect::back()->with('successMessage', 'Setting System Updated');
    }
}
