<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_banners', function (Blueprint $table) {
            $table->integer('count', true);
            $table->string('id', 36)->unique('id_UNIQUE');
            $table->timestamps();
            $table->softDeletes();

            $table->string('banner_type_id', 36)->nullable();
            $table->string('resource_id', 36);

            $table->string('name', 255);
            $table->string('banner_url', 255);
            $table->enum('type', ['image', 'zip', 'video'])->nullable();

            $table->string('short_url_id', '36')->nullable();
            $table->enum('link_type', ['_self', '_blank'])->default('_blank');

            $table->timestamp('start_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_at')->nullable();

            $table->integer('shows')->unsigned()->default(0);

            $table->foreign('banner_type_id')->references('id')->on('hc_banners_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('resource_id')->references('id')->on('hc_resources')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('short_url_id')->references('id')->on('hc_short_url')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_banners');
    }
}
