<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pi_folio');
            $table->text('pi_property_address');
            $table->text('pi_owner');
            $table->text('pi_mail_address');
            $table->text('pi_primary_zone');
            $table->text('pi_primary_land_use');
            $table->text('pi_bed_bath_half');
            $table->text('pi_living_area');
            $table->text('pi_year_built');
            $table->text('assessment_info');
            $table->text('full_legal_description');
            $table->text('sales_info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrapers');
    }
}
