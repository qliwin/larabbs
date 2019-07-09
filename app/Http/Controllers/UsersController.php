<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;


class UsersController extends Controller
{
    // 限制游客访问
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['show']]);
    }

    // 个人展示页面
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // 个人编辑页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 个人编辑逻辑
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        // dd($request->avatar);
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar']  = $result['path'];
            }
        }
        $user->update($data);
        // session()->flash('success', '个人资料更新成功');
        return redirect()->route('users.show',$user)->with('success', '个人资料更新成功');
    }
}
