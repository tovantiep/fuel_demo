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
                [5, 'Sức khỏe'],
                [6, 'Công nghệ'],
                [7, 'Giáo dục'],
                [8, 'Pháp luật']
            ])
            ->execute();
    }

    public function down()
    {
        \DB::delete('categories')->where('id', '=', 1)->execute();
    }
}