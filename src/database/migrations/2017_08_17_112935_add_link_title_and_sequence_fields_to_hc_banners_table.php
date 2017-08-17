<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkTitleAndSequenceFieldsToHcBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hc_banners', function (Blueprint $table) {
            $table->string('link_title', '255')->nullable();
            $table->integer('sequence')->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hc_banners', function (Blueprint $table) {
            $table->dropColumn('link_title', 'sequence');
        });
    }
}
