<?php namespace Xitara\DynamicContent\Updates;

use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateTextGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('xitara_dynamiccontent_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 191)->nullable();
            $table->string('slug', 191)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('xitara_dynamiccontent_text_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('text_id')->default(0);
            $table->integer('group_id')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('xitara_dynamiccontent_groups');
        Schema::dropIfExists('xitara_dynamiccontent_text_groups');
    }
}
