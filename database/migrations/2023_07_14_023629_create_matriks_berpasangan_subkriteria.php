<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriks_berpasangan_subkriteria', function (Blueprint $table) {
            $table->id();
            $table->string('subkriteria_1');
            $table->string('subkriteria_2');
            $table->float('nilai');
            $table->integer('id_kriteria');
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
        Schema::dropIfExists('matriks_berpasangan_subkriteria');
    }
};
