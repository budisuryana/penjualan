<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\JalankanProses;
use App\User;
use Sentinel;
use Input;
use Redirect;
use Activation;
use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $rules = [
            'uname'     => 'required',
            'passwd'    => 'required',
        ];
        $this->validate($request, $rules);

        $credentials = array(
            //'email' => Input::get('email'),
            'login' => Input::get('uname'),
            'password' => Input::get('passwd'),
        );

        try {
            //authentifikasi user
            $user = Sentinel::authenticate($credentials, false);

            if ($user) {
                return Redirect::intended('dashboard');
            } else {
                return Redirect::back()->with('errorMessage','Username or Password is wrong.');
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            return Redirect::to('/')->with('errorMessage','Suspicious activity has occured on your IP address and you have been denied access for another [397] second(s)');
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return Redirect::to('/')->with('errorMessage','Your Account is not activated!');
        } catch (Exception $e) {
            return $e;
        }
    }
}
