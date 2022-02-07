<?php namespace Xitara\DynamicContent\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class AddIsRawColumnToBlocklistTable extends Migration
{
    public function up()
    {
        Schema::table('xitara_dynamiccontent_block_lists', function ($table) {
            $table->boolean('is_raw')->default(0);
        });
    }

    public function down()
    {
        if (Schema::hasColumn('xitara_dynamiccontent_block_lists', 'subheading')) {
            Schema::table('xitara_dynamiccontent_block_lists', function ($table) {
                $table->dropColumn('is_raw');
            });
        }
    }
}
