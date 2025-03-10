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

        Schema::table('templates', function (Blueprint $table) {
            $table->integer('page_width')->nullable();
            $table->integer('page_height')->nullable();
        });
    
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
