<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
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
        if (auth()->user()->id !== User::find($id)->id) {
            redirect()->route('users.show', ['id' => auth()->user()->id]);
        }

        return view('users.show', ['user' => auth()->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $updated = auth()->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if (!$updated) {
            flash('Your input data is invalid!')->error()->important();

            return back();
        }
        flash('User info is updated successfully!')->success()->important();

        return redirect()->route('users.show', ['id' => auth()->user()->id]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy()
    {
        auth()->user()->delete();
        flash('Your account deleted successfully!')->error();

        return redirect('/');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePasswordShow()
    {
        return view('users.password');
    }

    /**
     * @param \App\Http\Requests\PasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordStore(PasswordRequest $request)
    {

        $request->validated();

        $user = Auth::user();
        if (!Hash::check($request->get('current-password'), $user->password)) {
            flash('The password is incorrect')->error();

            return redirect()->back();
        }

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        flash('Password changed successfully!')->success()->important();

        return redirect()->route('users.show', ['id' => $user->id]);
    }
}
