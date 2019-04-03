<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use function GuzzleHttp\Psr7\readline;

class SessionsController extends Controller
{
    /**
    * 登录页面显示控制器函数
    */
    public function create()
    {
        return view('sessions.create');
    }
    /**
     * 登录数据提交控制器
     * intended方法可将页面重定向到上一次请求尝试访问的页面上，
     * 并接收一个默认的跳转地址参数，当上一次请求记录为空时，跳转到默认的地址上
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！');
            $fallback = route('users.show', Auth::user());

            return redirect()->intended($fallback);
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
        session()->flash('success', '您已经成功退出！');
        return redirect('login');
    }

    /**
     * 通过中间件auth提供的guest选项，指定只允许未登录用户访问的动作
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
}
