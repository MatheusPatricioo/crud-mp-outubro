<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->integer('border')->default(0); // ajuste o tipo de dado conforme necessário
        });
    }
    
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('border');
        });
    }
    
};
