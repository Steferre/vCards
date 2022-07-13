<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromPromotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promoters', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropColumn('email_2');
            $table->dropColumn('phone');
            $table->dropColumn('phone_2');
            $table->dropColumn('file');
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
            $table->char('group', 1);
            $table->string('email_2')->nullable();
            $table->string('phone')->unique();
            $table->string('phone_2')->nullable();
            $table->string('file', 512)->nullable();
        }); 
    }
}
