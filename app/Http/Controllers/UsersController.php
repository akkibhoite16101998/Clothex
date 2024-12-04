<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{

    public function userslist()
    {
        $user = User::select('id','name','email','role')->get();

        Cache::put('new_list',$user,$sec = '10');
        return view('users.list',['users_list'=>$user]);
    }

    public function cache_data(){

        $value = Cache::get('new_list');

        if (Cache::has('new_list')) {
            
            echo "this cache data";
        }else{

            echo "cahe end";
        } die();
        
        
    }

    public function create_user(Request $request)
    {
        $rules = [

            'user_name' => 'required|string',
            'user_eamil' => 'required|email',
            'password' => 'required',
            'user_role' => 'required | in:admin,staff',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
            
            return redirect()->route('user.add_user')->withInput()->withErrors($validator);
        }
        
        $user = new User();

        $user->name = $request->user_name;
        $user->email = $request->user_eamil;
        $user->password = $request->password;
        $user->role = $request->user_role;
        $user->save();

        return redirect()->route('users.userslist')->with('success','User Register Sucessfully');

    } 

    public function user_view($action,$id){

        $user_info = User::find($id);

        switch ($action) {
            case 'view':
                return view('users.user_view', ['data'=>$user_info]);
                
            case 'edit':
                return view('users.user_edit', ['data'=>$user_info]);
            default:
                abort(404); 
        }

    }

    public function user_update(Request $request, $id){

        $user = User::find($id);

        $rules = [

            'user_name' => 'required|string',
            'user_eamil' => 'required|email',
            'user_role' => 'required | in:admin,staff',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){  
            
            return redirect()->route('user.view',['action'=> 'edit', 'id'=> $id])->withInput()->withErrors($validator);
        }
        
        $user->name = $request->user_name;
        $user->email = $request->user_eamil;
        $user->role = $request->user_role;
        $user->save();

        return redirect()->route('user.view',['action'=> 'edit', 'id'=> $id])->with('success','User Update Sucessfully');

    }

    
    public function user_destroy(Request $request, $id){

        return $id;
        $product = User::findOrfail($id);
        $product->delete();
        return redirect()->route('users.userslist')->with('success','User Delete Successfully.');
    }
}
