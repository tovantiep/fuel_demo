<?php

namespace Fuel\Migrations;

class Create_admin_seed
{
    public function up()
    {
        try {
            \Auth::create_user(
                'admin',
                'admin123',
                'admin@example.com',
                100
            );
        } catch (\SimpleUserUpdateException $e) {
            echo "Admin seed error: " . $e->getMessage() . "\n";
        }
    }

    public function down()
    {
        $user = \Model\Auth_User::find_by_username('admin');
        if ($user) {
            $user->delete();
        }
    }
}