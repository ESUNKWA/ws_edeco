<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationTableFournisseur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('r_nom_fournisseur',45)->unique();
            $table->string('r_contact',10)->unique();
            $table->json('r_produit_fourni');
            $table->integer('r_lieu_de_vente');
            $table->mediumText('r_description');
            $table->boolean('r_status')->default(1);
            $table->timestamps();


            $table->foreign('r_lieu_de_vente')->on('t_communes')->references('r_i');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_fournisseurs');
    }
}
