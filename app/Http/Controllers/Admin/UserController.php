<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

/**
 * 管理账号.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class UserController extends Controller
{
    /**
     * 修改密码.
     *
     * @return Response
     */
    public function getPassword()
    {
        return admin_view('user.password');
    }

    /**
     * 更新密码.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function postUpdate(Request $request, $id)
    {
        $rules = [
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($id)->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->withMessage('更新成功！');
    }
}
