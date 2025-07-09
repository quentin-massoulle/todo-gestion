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
             $table->enum('etat', ['nouveau', 'planifie', 'en_cours', 'termine'])->default('nouveau');
             $table->boolean('rappel_active')->default(false);
             $table->date('date_fin')->nullable();
             $table->date('date_debut')->nullable();
             $table->foreignId('groupe_id')->nullable();
             $table->timestamps();
         });
     }
 
     public function down(): void
     {
         Schema::dropIfExists('taches');
     }
};
