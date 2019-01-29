<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/posts';

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
        if(boolval($data['isFixed'])){
            $data['fixed_nickname'] = $data['nickname'];
            $data['unfixed_nickname'] = null;

        }else{
            $data['unfixed_nickname'] = $data['nickname'];
            $data['fixed_nickname'] = null;

        }

        return Validator::make($data, [
            'login_id' => ['required', 'string', 'max:255', 'unique:users'],
            'fixed_nickname' => ['required_without:unfixed_nickname', 'string', 'max:255','nullable', 'unique:users'],
            'unfixed_nickname' => ['required_without:fixed_nickname', 'string', 'max:255','nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
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
        if(boolval($data['isFixed'])){
        $data['fixed_nickname'] = $data['nickname'];
        $data['unfixed_nickname'] = null;

        }else{
            $data['unfixed_nickname'] = $data['nickname'];
            $data['fixed_nickname'] = null;

        }

        return User::create([
            'login_id' => $data['login_id'],
            'fixed_nickname' => $data['fixed_nickname'],
            'unfixed_nickname' => $data['unfixed_nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
