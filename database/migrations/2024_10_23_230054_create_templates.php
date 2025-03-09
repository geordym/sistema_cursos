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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_image_path');
            $table->string('name');
            $table->decimal('qr_x', 8, 2); 
            $table->decimal('qr_y', 8, 2);
            $table->decimal('alumn_name_x', 8, 2);
            $table->decimal('alumn_name_y', 8, 2);
            $table->decimal('alumn_finishCourseDate_x', 8, 2);
            $table->decimal('alumn_finishCourseDate_y', 8, 2);
            $table->decimal('alumn_courseName_x', 8, 2);
            $table->decimal('alumn_courseName_y', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
