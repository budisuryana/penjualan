<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Input;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('password.reset');
    }

    public function update() {
        $hasher = Sentinel::getHasher();

        $oldPassword  = Input::get('old_password');
        $password     = Input::get('password');
        $passwordConf = Input::get('password_confirmation');

        $user = Sentinel::getUser();

        if (!$hasher->check($oldPassword, $user->password) || $password != $passwordConf) {
            Session::flash('error', 'Check input is correct.');
            return view('password.reset');
        }

        Sentinel::update($user, array('password' => $password));

        return Redirect::to('/');
    }

    
}
