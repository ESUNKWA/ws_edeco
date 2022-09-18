<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutColonnesTableFournisseur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_fournisseurs', function (Blueprint $table) {
            $table->string('r_ets',45)->before('r_nom_fournisseur')->unique();
            $table->integer('r_creer_par',false)->before('created_at');
            $table->integer('r_modifier_par',false);

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
        Schema::table('t_fournisseurs', function (Blueprint $table) {
            $table->dropColumn(['r_ets','r_creer_par','r_modifier_par']);
        });
    }
}
