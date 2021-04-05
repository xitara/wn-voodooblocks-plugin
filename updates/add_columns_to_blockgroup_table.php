<?php namespace Xitara\DynamicContent\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class AddColumnsToBlockgroupTable extends Migration
{
    public function up()
    {
        Schema::table('xitara_dynamiccontent_block_groups', function ($table) {
            $table->string('subheading', 191)->nullable();
            $table->mediumtext('content')->nullable();
            $table->boolean('is_heading')->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('blockgroup')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasColumn('xitara_dynamiccontent_block_groups', 'subheading')) {
            Schema::table('xitara_dynamiccontent_block_groups', function ($table) {
                $table->dropColumn('subheading');
                $table->dropColumn('content');
                $table->dropColumn('is_heading');
                $table->dropColumn('is_active');
                $table->dropColumn('blockgroup');
            });
        }
    }
}
