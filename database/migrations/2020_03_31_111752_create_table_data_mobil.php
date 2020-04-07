<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDataMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_mobil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_jenis');
            $table->string('nama_mobil', 100);
            $table->string('merk', 100);
            $table->string('plat_nomor', 100);
            $table->string('keterangan', 100);
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
        Schema::dropIfExists('data_mobil');
    }
}
