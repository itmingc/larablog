<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * 执行迁移
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table){
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name')->default('')->comment('名称');
            $table->string('title')->default('')->comment('标题');
            $table->string('url')->default('')->comment('地址');
            $table->integer('sort')->default(50)->comment('排序');
        });
    }

    /**
     * 回滚迁移
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
