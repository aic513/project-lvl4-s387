<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user->id !== User::find($id)->id) {
            redirect()->route('users.show', ['id' => $user->id]);
        }

        return view('users.show', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255']
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        flash('User info is updated successful')->success();

        return redirect()->route('users.show', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        flash('Your account deleted successful')->error();

        return redirect('/');
    }

    public function changePasswordShow()
    {
        return view('users.password');
    }

    public function changePasswordStore(Request $request)
    {
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|different:current-password|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->get('current-password'), $user->password)) {
            flash('The password is incorrect')->error();

            return redirect()->back();
        }

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        flash('Password changed successfully !')->success();

        return redirect()->route('users.show', ['id' => $user->id]);
    }
}
