<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationTableDetailsVentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_details_ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('r_produit',false);
            $table->integer('r_quantite', false);
            $table->integer('r_prix_unitaire', false);
            $table->integer('r_sous_total', false);

            $table->unsignedBigInteger('r_vente',false);
            $table->integer('r_creer_par',false);
            $table->integer('r_modifier_par',false);

            $table->timestamps();

            $table->foreign('r_produit')->on('t_produitventes')->references('id');
            $table->foreign('r_vente')->on('t_ventes')->references('id');

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
        Schema::dropIfExists('t_details_ventes');
    }
}
