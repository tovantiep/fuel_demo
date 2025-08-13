<?php

namespace Fuel\Migrations;

class Add_default_category_to_categories
{
    public function up()
    {
        \DB::insert('categories')
            ->columns(['id', 'name'])
            ->values([
                [1, 'Tin mới nhất'],
                [2, 'Kinh doanh'],
                [3, 'Xã hội'],
                [4, 'Thể thao'],
            ])
            ->execute();
    }

    public function down()
    {
        \DB::delete('categories')->where('id', '=', 1)->execute();
    }
}