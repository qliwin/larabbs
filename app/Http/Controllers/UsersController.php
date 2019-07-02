<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;


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
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();
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
