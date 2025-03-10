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
            $table->integer('qr_size')->nullable();
            $table->integer('alumn_name_text_size')->nullable();
            $table->string('alumn_name_text_color')->nullable();
            $table->string('alumn_name_text_align')->nullable();

            $table->integer('finish_course_text_size')->nullable();
            $table->string('finish_course_text_color')->nullable();
            $table->string('finish_course_text_align')->nullable();

            $table->integer('course_name_text_size')->nullable();
            $table->string('course_name_text_color')->nullable();
            $table->string('course_name_text_align')->nullable();

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
