<?php

namespace App\Http\Controllers\Auth;

use App\Models\Employee;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:4|confirmed',
            'image' => 'mimes:jpg,jpeg,png',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Employee
     */
    protected function create(array $data)
    {
        $isInTeam = !is_null($data['team']) && !is_null($data['role']);

        $employee = Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'team_id' => $isInTeam ? $data['team'] : null,
            'role_id' => $isInTeam ? $data['role'] : null,
            'avatar_url' => null
        ]);

        if(isset($data['image'])) {
            $image = $data['image'];
            $imgType = str_replace('image/', '', $image->getMimeType());
            $imgName = str_random(10).'.'.$imgType;
            $imgPath = 'upload/';
            $image->move($imgPath, $imgName);
            $employee->update(['avatar_url' => $imgPath.$imgName]);
        }

        return $employee;
    }
}
