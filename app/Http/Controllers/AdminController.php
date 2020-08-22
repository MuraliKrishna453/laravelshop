<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $request['id'] = null;
        $this->validator($request->all())->validate();
        $admin = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => 'admin',
                    'password' => Hash::make($request->password),
        ]);
        $token = $admin->createToken($admin->email)->accessToken;
        return response()->json(compact('admin', 'token'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        //
        if ($user->id != $this->user->id) {
            return response()->json("forbidden", 403);
        }
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        //
        if ($user->id != $this->user->id) {
            return response()->json("Cannot update", 403);
        }
        $request['id'] = $this->user->id;
        $this->validator($request->all())->validate();
        User::find($request->_id)->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->save();
        $admin = User::find($this->user->id);
        return response()->json($admin, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }

    /**
     * Get a validator for an incoming admin request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => ['required', 'string'],
                    'email' => ['required', 'email', 'unique:users,email,' . $data['id'] . ',id'],
                    'password' => ['required'],
        ]);
    }

}
