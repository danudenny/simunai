<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLampiranJembatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lampiran_jembatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jembatan_id');
            $table->foreign('jembatan_id')->references('id')->on('jembatan')->onDelete('cascade');
            $table->string('file_name');
            $table->string('url')->nullable(true);
            $table->boolean('is_video')->nullable(true);
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
        Schema::dropIfExists('lampiran_jembatan');
    }
}
