<?php namespace Xitara\DynamicContent\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateBlockListsTable extends Migration
{
    public function up()
    {
        Schema::create('xitara_dynamiccontent_block_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 191)->nullable();
            $table->string('slug', 191)->nullable();
            // $table->text('excerpt')->nullable();
            // $table->mediumtext('text')->nullable();
            $table->boolean('is_active')->nullable();
            $table->mediumtext('blocks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xitara_dynamiccontent_block_lists');
    }
}
