<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLarablogDatabase extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
         public function up()
         {
            
	    /**
	     * Table: hd_admin
	     */
	    Schema::create('hd_admin', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('username', 50);
                $table->string('password', 255);
            });


	    /**
	     * Table: hd_article
	     */
	    Schema::create('hd_article', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('title', 100);
                $table->text('content');
                $table->integer('time')->unsigned();
                $table->string('description', 255)->nullable();
                $table->string('thumb', 255)->nullable();
                $table->string('author', 50);
                $table->integer('click');
                $table->integer('cid')->unsigned();
                $table->index('title');
                $table->index('time');
                $table->index('description');
                $table->index('author');
            });


	    /**
	     * Table: hd_article_tag
	     */
	    Schema::create('hd_article_tag', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('aid')->unsigned();
                $table->integer('tid')->unsigned();
                $table->index('aid');
                $table->index('tidt');
            });


	    /**
	     * Table: hd_category
	     */
	    Schema::create('hd_category', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name', 50);
                $table->string('title', 255)->nullable();
                $table->string('description', 255)->nullable();
                $table->string('keywords', 255)->nullable();
                $table->integer('click')->nullable()->unsigned();
                $table->boolean('sort')->nullable()->unsigned();
                $table->integer('pid')->unsigned();
            });


	    /**
	     * Table: hd_config
	     */
	    Schema::create('hd_config', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('title', 45)->default('''');
                $table->string('name', 45)->default('''');
                $table->text('content')->nullable();
                $table->integer('sort')->nullable()->unsigned();
                $table->string('tips', 255)->nullable()->default('''');
                $table->string('fieldtype', 45)->nullable()->default('''');
                $table->string('fieldvalue', 45)->nullable()->default('''');
            });


	    /**
	     * Table: hd_links
	     */
	    Schema::create('hd_links', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name', 255);
                $table->string('title', 255)->nullable()->default('''');
                $table->string('url', 255)->default('''');
                $table->integer('sort')->nullable();
            });


	    /**
	     * Table: hd_migrations
	     */
	    Schema::create('hd_migrations', function(Blueprint $table) {
                $table->string('migration', 255);
                $table->integer('batch');
            });


	    /**
	     * Table: hd_tag
	     */
	    Schema::create('hd_tag', function(Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name', 45);
                $table->integer('count');
                $table->index('name');
            });


         }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
         public function down()
         {
            
	            Schema::drop('hd_admin');
	            Schema::drop('hd_article');
	            Schema::drop('hd_article_tag');
	            Schema::drop('hd_category');
	            Schema::drop('hd_config');
	            Schema::drop('hd_links');
	            Schema::drop('hd_migrations');
	            Schema::drop('hd_tag');
         }

}