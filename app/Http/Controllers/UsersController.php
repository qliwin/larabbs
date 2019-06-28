<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    // 个人展示页面
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // 个人编辑页面
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // 个人编辑逻辑
    public function update(UserRequest $request, User $user)
    {
        // dd($request->all());
        $data = ['introduction'=>$request['introduction']];
        $user->update($data);
        // $user->update($request->all());
        return redirect()->route('users.show',$user);
    }
}
