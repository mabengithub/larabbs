<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    // 如果用户拥有管理内容权限的话， 立即授权通过
    public function before($user, $ability)
	{
	    if ($user->can('manage_contents')) {
            return true;
        }
	}
}
