<?php

use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class CreateJalanTable extends Migration
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
        DB::unprepared("CREATE TYPE kondisiJalanEnum AS ENUM ('baik', 'sedang', 'rusak', 'rusak_sedang', 'rusak_berat');");
        DB::unprepared("CREATE TYPE statusJalanEnum AS ENUM ('lokal', 'kabupaten', 'provinsi', 'nasional', 'lainnya');");
        DB::unprepared("CREATE TYPE jenisPerkerasanEnum AS ENUM ('aspal', 'hotmix', 'tanah', 'beton');");
        DB::unprepared("CREATE TYPE kelasJalanEnum AS ENUM ('I', 'II', 'IIIA', 'IIIB', 'IIIC');");

        Schema::create('jalan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruas', 100);
            $table->addColumn('raw', 'kondisi_jalan', ['raw_type' => 'kondisiJalanEnum'] )->nullable();
            $table->addColumn('raw', 'status_jalan', ['raw_type' => 'statusJalanEnum'] )->nullable();
            $table->float('panjang')->default(0);
            $table->float('lebar')->default(0);
            $table->addColumn('raw', 'jenis_perkerasan', ['raw_type' => 'jenisPerkerasanEnum'] )->nullable();
            $table->addColumn('raw', 'kelas_jalan', ['raw_type' => 'kelasJalanEnum'] )->nullable();
            $table->text('geojson');
            $table->string('style', 10);
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');
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
        DB::unprepared("DROP TYPE kondisiJalanEnum");
        DB::unprepared("DROP TYPE statusJalanEnum");
        DB::unprepared("DROP TYPE jenisPerkerasanEnum");
        DB::unprepared("DROP TYPE kelasJalanEnum");
        Schema::dropIfExists('jalan');
    }
}
