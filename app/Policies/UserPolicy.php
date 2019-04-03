<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 用户更新资料的权限;
     * update方法接收2个参数，第一个是默认的当前用户的实例，第二个是要进行授权的用户实例，当
     * 两个id相同时，则代表两个用户时相同的用户，用户通过授权，可以接着进行下一个操作，
     * 如果id不相同，则抛出403异常信息来拒绝访问     
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    /**
     * 用户管理员删除权限；
     * destroy，当用户为管理员时有权限删除用户，同时不能删除自己的账号
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
