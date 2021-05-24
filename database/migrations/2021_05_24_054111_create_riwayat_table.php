<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('kegiatan');
            $table->double('nilai');
            $table->string('sumber_dana');
            $table->string('status')->nullable(true);
            $table->unsignedBigInteger('jalan_id');
            $table->foreign('jalan_id')->references('id')->on('jalan')->onDelete('cascade');
            $table->unsignedBigInteger('kontraktor_id');
            $table->foreign('kontraktor_id')->references('id')->on('kontraktor')->onDelete('cascade');
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
        Schema::dropIfExists('riwayat');
    }
}
