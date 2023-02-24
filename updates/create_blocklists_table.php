<?php

namespace Xitara\VoodooBlocks\Updates;

use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateBlocklistsTable extends Migration
{
    public function up()
    {
        Schema::create('xitara_voodooblocks_blocklists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            // $table->string('slug')->nullable();
            // $table->text('excerpt')->nullable();
            // $table->mediumtext('text')->nullable();
            $table->boolean('is_heading')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_default_css')->nullable();
            $table->boolean('is_raw')->nullable();
            // $table->mediumtext('blocks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xitara_voodooblocks_blocklists');
    }
}
