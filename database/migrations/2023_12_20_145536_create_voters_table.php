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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table -> string('code');
            $table->timestamps();
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table -> foreignId('voter_id') -> constrained();
            $table -> foreignId('resource_id') -> constrained();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
};
