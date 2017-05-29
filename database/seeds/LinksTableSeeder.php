<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * 执行数据库填充
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Laravel 中文社区',
                'title' => 'Laravel China 社区 - 高品质的 Laravel 和 PHP 开发者社区 - Powered by PHPHub',
                'url' => 'https://laravel-china.org/',
                'sort' => '49'
            ],
            [
                'name' => 'GitHub',
                'title' => 'GitHub is where people build software. More than 21 million people use...',
                'url' => 'https://github.com',
                'sort' => '49'
            ]
        ];

        DB::table('links')->insert($data);
    }
}
