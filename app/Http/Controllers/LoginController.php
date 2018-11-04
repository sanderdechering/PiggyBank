<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use Redirect;
use App\User;
use App\admin;

class LoginController extends Controller
{
    public function index(){
        return view('login/index');
    }

    public function attemptlogin(Request $request)
    {
        // validate request
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:3'
        ]);

        $user_data = [
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        ];
        // Auth:attempt probeert met opgegeven data in te loggen
        if (Auth::attempt($user_data))
        {
            return redirect('dashboard');
        }
        return Redirect::back()->withErrors(['Login failed']);

    }
    public function register(){
        return view('register/index');
    }
    public function attemptregister(Request $request){

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        try{
            User::create([
                'name' => $request->get('name'),
                'email' =>$request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            $user = User::where('email',$request->get('email'))->get();
            foreach($user as $user_){
                $admin = new admin();
                $admin->user_id = $user_->id;
                $admin->type = 0;
                $admin->save();
            }

        }catch (\Exception $exception){
            return Redirect::back()->withInput()->withErrors([$exception->getMessage()]);
        }
        return Redirect::back()->withInput()->withErrors(['Registration succesfull']);
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

}
