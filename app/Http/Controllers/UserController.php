<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Model\User;
use App\Model\Question;
use App\Model\Answer;
use App\Notifications\RewardedPoints;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        if(request()->expectsJson())
            return $users;

        return view('users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ));

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if(request()->expectsJson())
            return User::all();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(request()->expectsJson())
            return new UserResource($user);

        return view('users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ));

        $user = User::update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if(request()->expectsJson())
            return $user;

        return redirect()->route('users.show')->withUser($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($this->isAdmin()){
            $user = User::find($id);
            $user->questions()->detach();
            $user->answers()->detach();
            $user->delete();

            $users = User::all();
            if(request()->expectsJson())
                return $users;

            return redirect()->route('users.index')->withUsers($users);
        }
    }

    public function suspend(User $user){
        $user->status = 0;
        $user->update();
        $users = User::all();

        if(request()->expectsJson())
            return $users;

        return redirect()->route('users.index')->withUsers($users);
    }

    public function activate(User $user){
        $user->status = 1;
        $user->update();
        $users = User::all();

        if(request()->expectsJson())
            return $users;

        return redirect()->route('users.index')->withUsers($users);
    }

    public function reward(Request $request, User $user){
        $this->validate($request, array(
            'points' => 'required',
        ));
        $user->increment('reputation', $request->points);
        $user->notify(new RewardedPoints($request->points));
        return redirect()->route('users.show', $user);
    }

    public function makeAdmin(User $user){
        $user->is_admin = 1;
        $user->update();

        $users = User::all();
        if(request()->expectsJson())
            return $users;

        return redirect()->route('users.index')->withUsers($users);
    }
}
