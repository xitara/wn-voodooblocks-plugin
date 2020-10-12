<?php namespace Xitara\DynamicContent\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

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
