<?php namespace Xitara\DynamicContent\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class AddTextColumnToBlocklistTable extends Migration
{
    public function up()
    {
        Schema::table('xitara_dynamiccontent_block_lists', function ($table) {
            $table->string('subheading', 191)->nullable();
            $table->mediumtext('content')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasColumn('xitara_dynamiccontent_block_lists', 'subheading')) {
            Schema::table('xitara_dynamiccontent_block_lists', function ($table) {
                $table->dropColumn('subheading');
            });
        }
        if (Schema::hasColumn('xitara_dynamiccontent_block_lists', 'content')) {
            Schema::table('xitara_dynamiccontent_block_lists', function ($table) {
                $table->dropColumn('content');
            });
        }
    }
}
