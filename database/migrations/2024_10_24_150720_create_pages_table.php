<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('op_font_color');
            $table->string('op_bg_type');
            $table->string('op_bg_value');
            $table->string('op_profile_image'); // Ajuste conforme necessário para armazenar a URL ou caminho da imagem
            $table->string('op_title');
            $table->text('op_description');
            $table->string('op_fb_pixel')->nullable(); // Permite que o valor seja nulo, caso não queira preencher
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
