<?php



namespace App\Http\Controllers\Sentinel;



use Illuminate\Http\Request;



use App\Http\Requests;

use App\Http\Controllers\Controller;

use Sentinel, Redirect;



class AuthController extends Controller

{

	public $redirectTo = 'login';

    public function authenticate(Request $request) {

    	$rules = [

    		'user'		=> 'required',

    		'password'	=> 'required',

    	];

    	$this->validate($request, $rules);



    	$credentials = [

    		'login'		=> $request->input('user'),

    		'password'	=> $request->input('password'),

    	];



    	try {

	        $user = Sentinel::authenticate($credentials, false);

	        if ($user) {

	        	/*$ip = $_SERVER['REMOTE_ADDR'];

                $location = \GeoIP::getLocation($ip); 

                \App\Models\Geoip::create([

                    'user_id' => \Sentinel::getUser()->id,

                    'ip' => $ip,

                    'isocode' => $location['isoCode'],

                    'country' => $location['country'],

                    'city' => $location['city'],

                    'state' => $location['state'],

                    'postal_code' => $location['postal_code'],

                    'timezone' => $location['timezone'],

                    'lat' => $location['lat'],

                    'lon' => $location['lon'],

                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),

                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),

                ]);*/



                return redirect('dashboard')->with('successMessage', 'Welcome');

	        } else {

	        	return Redirect::back()->with('errorMessage','The Username or Password is incorrect.')->withInput();

	        }

		} catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {

	        return Redirect::back()->with('errorMessage','Suspicious activity has occured on your IP address and you have been denied access for another [397] second(s)');

	    } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {

	        return Redirect::back()->with('warningMessage','Your Account is not activated!');

	    } catch (Exception $e) {

	        return $e;

	    }

    }



    public function logout() {

        Sentinel::logout(null, true);

        return redirect($this->redirectTo);

    }

}

