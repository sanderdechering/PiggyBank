<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\piggy;
use App\user;
use Auth;
use Redirect;

class SettingsController extends Controller
{
    private $user;
    //
    public function index(){
        $this->user = user::find(Auth::id());
        $user_id = Auth::id();
        $piggy = piggy::where('user_id', $user_id)->get();

        return view('dashboard/settings')->with('piggy', $piggy)->with('user', $this->user);
    }


    /**
     * Uodate piggy status
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function update(Request $request){

        $user_id = Auth::id();
        $status = 0;
        $this->validate($request, [
            'piggy_id' => 'required|numeric',
        ]);
        if ($request->input('status') != null){
            $status = 1;
        }
        piggy::where('user_id', $user_id)->where('id',$request->input('piggy_id'))->update(['status' => $status]);
        return Redirect::back()->withInput();
    }
    /**
     * Delete spaarvarken
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);
        $user_id = Auth::id();
        $piggy = piggy::where('id', $request->input('id'))->where('user_id', $user_id);
        $piggy->delete();

        return Redirect::back()->withInput()->with('succes', ['PIGGY IS DESTROYED']);
    }
}
