<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // this function use for user authentication
    public function authentication(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'user_role' => 'required | in:staff,admin',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
        
            return redirect()->route('welcome')->withInput()->withErrors($validator);
        }else{ 

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password , 'role' => $request->user_role])) 
            { 
                if (Auth::user() && (Auth::user()->role == 'staff' || Auth::user()->role == 'admin') ) 
                {
                    return redirect()->route('account.dashboard'); 

                }else{
                    Auth::logout();
                    return redirect()->route('welcome')->with('error','Invalid User Role selected');
    
                }

            }else{

                return redirect()->route('welcome')->with('error','Invalid Credentials')->withInput()->withErrors($validator);;

            }

        }


    }
    
    public function create(Request $request)
    {
        $rules = [

            'user_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'user_role' => 'required | in:admin,staff',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
        
                return redirect()->route('register')->withInput()->withErrors($validator);
        }

        $user = new User();

        $user->name = $request->user_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->user_role;
        $user->save();

        return redirect()->route('welcome')->with('success','User Register Sucessfully');



    }

    public function staff_logout()
    {

        Auth::logout();
        session()->forget('web');
        return redirect()->route('welcome');
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        session()->forget('admin');
        return redirect()->route('admin.login');
    }
}

###################################################################################### old multi guard use code hide here
/*
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // this function use for user authentication
    public function authentication(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'user_role' => 'required | in:staff',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
        
            return redirect()->route('welcome')->withInput()->withErrors($validator);
        }else{ 

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
            { 
                if (Auth::user() && Auth::user()->role == 'staff') 
                {
                    return redirect()->route('account.dashboard'); 

                }else{
                    Auth::logout();
                    return redirect()->route('welcome')->with('error','Invalid User Role selected');
    
                }

            }else{

                return redirect()->route('welcome')->with('error','Invalid Credentials')->withInput()->withErrors($validator);;

            }

        }


    }
    
    // this function user for admin authentication
    public function admin_authentication(Request $request)
    {
        //return $request;
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'user_role' => 'required | in:admin',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
        
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }else{ 
            
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) 
            { 
                // Authentication passed
                if (Auth::guard('admin')->user()->role == 'admin') 
                {   #echo "innn";die();
                    return redirect()->route('admin.dashboard'); 
                    //return redirect()->route('account.dashboard'); 

                }else{

                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','Invalid User Role selected');
    
                }

            }else{

                return redirect()->route('admin.login')->with('error','Invalid Credentials');

            } 

        }
    }

    public function create(Request $request){
        #return $request;
        $rules = [

            'user_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'user_role' => 'required | in:admin,staff',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
        
                return redirect()->route('register')->withInput()->withErrors($validator);
        }

        $user = new User();

        $user->name = $request->user_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->user_role;
        $user->save();

        return redirect()->route('welcome')->with('success','User Register Sucessfully');



    }

    public function staff_logout()
    {

        Auth::logout();
        session()->forget('web');
        return redirect()->route('welcome');
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        session()->forget('admin');
        return redirect()->route('admin.login');
    }
}
*/