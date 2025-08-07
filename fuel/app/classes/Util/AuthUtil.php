<?php
namespace Util;

class AuthUtil
{
    public static function isAdmin()
    {
        $groupId = 100;
        return \Auth::get('group') == $groupId;
    }
}
