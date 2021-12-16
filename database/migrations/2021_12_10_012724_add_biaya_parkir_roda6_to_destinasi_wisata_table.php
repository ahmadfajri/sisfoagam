<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiayaParkirRoda6ToDestinasiWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('destinasi_wisata', function (Blueprint $table) {
            //
            $table->bigInteger('biaya_parkir_roda_6')->default(0)->after('biaya_parkir_roda_4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('destinasi_wisata', function (Blueprint $table) {
            //
            $table->dropColumn(['biaya_parkir_roda_6']);
        });
    }
}
