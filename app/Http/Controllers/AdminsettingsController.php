<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\user;
use Redirect;
use Auth;
class AdminsettingsController extends Controller
{
    public function index(){
        $user_specific = user::find(Auth::id());
        if ($user_specific->admin->type == 1){
            return view('dashboard/asettings')->with('users',user::all());
        }
        return Redirect::back()->withInput()->withErrors('U sneaky bitch');

    }
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $user = user::where('id', $request->input('id'));
        $user->delete();

    }
}
