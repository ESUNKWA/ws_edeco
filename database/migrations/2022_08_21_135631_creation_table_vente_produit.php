<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationTableVenteProduit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_ventes', function (Blueprint $table) {
            $table->id();
            $table->string('r_reference',10)->unique();
            $table->integer('r_mnt_total',false);
            $table->integer('r_creer_par',false);
            $table->integer('r_modifier_par',false);
            $table->timestamps();

            $table->foreign('r_creer_par')->on('t_utilisateurs')->references('r_i');
            $table->foreign('r_modifier_par')->on('t_utilisateurs')->references('r_i');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_ventes');
    }
}
