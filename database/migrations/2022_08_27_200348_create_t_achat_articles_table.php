<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAchatArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_achat_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('r_fournisseur',false);
            $table->unsignedBigInteger('r_produit',false);
            $table->integer('r_quantite')->nullable();
            $table->integer('r_prix_achat')->nullable();
            $table->integer('r_creer_par')->nullable();
            $table->integer('r_modifier_par')->nullable();
            $table->timestamps();

            $table->foreign('r_produit')->on('t_produitventes')->references('id');
            $table->foreign('r_fournisseur')->on('t_fournisseurs')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_achat_articles');
    }
}
