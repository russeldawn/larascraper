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
            $table->text('pi_folio')->nullable();
            $table->text('pi_property_address')->nullable();
            $table->text('pi_owner')->nullable();
            $table->text('pi_mail_address')->nullable();
            $table->text('pi_primary_zone')->nullable();
            $table->text('pi_primary_land_use')->nullable();
            $table->text('pi_bed_bath_half')->nullable();
            $table->text('pi_living_area')->nullable();
            $table->text('pi_year_built')->nullable();
            $table->text('assessment_info')->nullable();
            $table->text('full_legal_description')->nullable();
            $table->text('sales_info')->nullable();
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
