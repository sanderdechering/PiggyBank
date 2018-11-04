<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\user;
use Redirect;
class AdminsettingsController extends Controller
{
    public function index(){

        return view('dashboard/asettings')->with('users', user::all());
    }
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $user = user::where('id', $request->input('id'));
        $user->delete();

        return Redirect::back()->withInput()->with('succes', ['User is deleted']);
    }
}
