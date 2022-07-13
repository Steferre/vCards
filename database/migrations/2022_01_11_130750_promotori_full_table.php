<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PromotoriFullTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promoters', function (Blueprint $table) {

            $table->string('area', 96)->nullable();
            $table->string('company', 32)->nullable();
            $table->string('team', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('firma', 255)->nullable();
            $table->string('cap1', 5)->nullable();
            $table->string('city1', 255)->nullable();
            $table->string('prov1', 2)->nullable();
            $table->string('addr1', 1024)->nullable();
            $table->string('phone1', 32)->nullable();
            $table->string('cap2', 5)->nullable();
            $table->string('city2', 255)->nullable();
            $table->string('prov2', 2)->nullable();
            $table->string('addr2', 1024)->nullable();
            $table->string('phone2', 32)->nullable();
            $table->string('cap3', 5)->nullable();
            $table->string('city3', 255)->nullable();
            $table->string('prov3', 2)->nullable();
            $table->string('addr3', 1024)->nullable();
            $table->string('phone3', 32)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promoters', function (Blueprint $table) {

            $table->dropColumn('area');
            $table->dropColumn('company');
            $table->dropColumn('team');
            $table->dropColumn('firma');
            $table->dropColumn('cap1');
            $table->dropColumn('city1');
            $table->dropColumn('prov1');
            $table->dropColumn('addr1');
            $table->dropColumn('phone1');
            $table->dropColumn('cap2');
            $table->dropColumn('city2');
            $table->dropColumn('prov2');
            $table->dropColumn('addr2');
            $table->dropColumn('phone2');
            $table->dropColumn('cap3');
            $table->dropColumn('city3');
            $table->dropColumn('prov3');
            $table->dropColumn('addr3');
            $table->dropColumn('phone3');

        });
    }
}
