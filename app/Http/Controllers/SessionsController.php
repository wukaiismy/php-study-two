<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use function GuzzleHttp\Psr7\readline;

class SessionsController extends Controller
{
    /**
    * 登录控制器函数
    */
    public function create()
    {
        return view('sessions.create');
    }
    /**
     * 登录数据提交控制器
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }
    /**
     * 用户退出操作
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已经成功退出！0');
        return redirect('login');
    }
}
