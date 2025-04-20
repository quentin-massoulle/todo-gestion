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
         Schema::create('taches', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id');
             $table->string('titre');
             $table->text('description')->nullable();
             $table->boolean('est_termine')->default(false);
             $table->boolean('rappel_active')->default(false);
             $table->timestamps();
         });
     }
 
     public function down(): void
     {
         Schema::dropIfExists('taches');
     }
};
