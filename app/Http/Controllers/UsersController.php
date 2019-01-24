<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //用户个人信息页
    public function show(User $user)
    {
    	return view('users.show', compact('user'));
    }

    //用户详情编辑页面
    public function edit(User $user)
    {
    	return view('users.edit', compact('user'));
    }

    //用户修改功能
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        if (!empty($request->avatar)) {
            //上传文件信息，保存路径，用户id，图片最大宽度
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

    	$user->update($data);
    	return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }

}
