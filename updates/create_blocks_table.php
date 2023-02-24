<?php

namespace Xitara\VoodooBlocks\Updates;

use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('xitara_voodooblocks_blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('heading')->default('');
            $table->string('subheading')->default('');
            $table->integer('blocklist_id')->nullable();
            $table->string('width')->default('');
            $table->string('height')->default('');
            $table->boolean('is_active')->default(0);
            $table->boolean('is_raw')->default(0);
            $table->boolean('is_heading')->default(0);
            $table->boolean('is_box')->default(0);
            $table->boolean('is_scrollbar')->default(0);
            $table->text('excerpt')->default('');
            $table->mediumtext('content')->nullable();
            $table->mediumtext('buttons_above')->nullable();
            $table->mediumtext('buttons')->nullable();
            $table->boolean('is_time_control')->default(0);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->mediumtext('images')->nullable();
            $table->boolean('is_image_text')->default(0);
            $table->boolean('is_slider')->default(0);
            $table->boolean('is_lightbox')->default(0);
            $table->mediumtext('slider')->nullable();
            $table->mediumtext('lightbox')->nullable();
            $table->mediumtext('modules')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xitara_voodooblocks_blocks');
    }
}
