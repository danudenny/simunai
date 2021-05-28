<?php

use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class CreateJembatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Grammar::macro('typeRaw', function (Fluent $column) {
            return $column->get('raw_type');
        });
        DB::unprepared("CREATE TYPE tipeLintasanEnum AS ENUM ('Jalan', 'Kereta Api', 'Sungai');");
        DB::unprepared("CREATE TYPE kondisiJembatanEnum AS ENUM ('Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat');");
        DB::unprepared("CREATE TYPE tipePondasiEnum AS ENUM ('Langsung', 'Dangkal', 'Telapak');");

        Schema::create('jembatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jembatan', 100);
            $table->float('panjang')->default(0)->nullable();
            $table->float('lebar')->default(0)->nullable();
            $table->float('elevasi')->default(0)->nullable();
            $table->float('lat')->default(0)->nullable();
            $table->float('long')->default(0)->nullable();
            $table->addColumn('raw', 'tipe_lintasan', ['raw_type' => 'tipeLintasanEnum'] )->nullable();
            $table->addColumn('raw', 'kondisi_jembatan', ['raw_type' => 'kondisiJembatanEnum'] )->nullable();
            $table->addColumn('raw', 'tipe_pondasi', ['raw_type' => 'tipePondasiEnum'] )->nullable();
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->unsignedBigInteger('ruas_jalan_id');
            $table->foreign('ruas_jalan_id')->references('id')->on('jalan')->onDelete('cascade');
            $table->string('foto');
            $table->string('video');
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
        Schema::dropIfExists('jembatan');
    }
}
