<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaParawisatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_parawisata', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('narasi');
            $table->string('posting_by');
            $table->string('foto')->nullable();
            $table->string('slug_berita_parawisata');
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
        Schema::dropIfExists('berita_parawisata');
    }
}
