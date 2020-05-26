<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_no' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['image']) 
        {
            $image=$data['image'];
            $upload_path=public_path().'/image/profile/';
            $name=uniqid().time().'.'.$image->getClientOriginalExtension();
            $image->move($upload_path,$name);
            $path='/image/profile/'.$name;
        }else
        {
            $path="/admin.png";
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_no' => $data['phone_no'],
            'address' => $data['address'],
            'image' => $path,
        ]);

        $user->assignRole('user');
        return $user;


    }

     public function authenticated($request,$user){

       
        if($user->hasRole('admin')){
            
            return redirect(RouteServiceProvider::DASHBOARD);

        }elseif($user->hasRole('user')){
            return redirect(RouteServiceProvider::MAIN);
        }
    }
}
