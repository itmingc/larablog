<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * 执行数据库填充
     *
     * @return void
     */
    public function run()
    {
        $this->call(LinksTableSeeder::class);
    }
}
