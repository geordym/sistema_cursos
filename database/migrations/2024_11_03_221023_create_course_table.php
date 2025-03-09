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
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('collaborator_id'); // Correctamente definido
            $table->unsignedBigInteger('template_id')->nullable(); // Cambiado de integer a unsignedBigInteger
            $table->string('name');
            $table->integer('hour_load');
            $table->timestamps();
        
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
