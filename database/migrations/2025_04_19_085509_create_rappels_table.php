<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rappels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id');
            $table->enum('frequence', ['une_fois', 'quotidien', 'hebdomadaire']);
            $table->dateTime('date_rappel'); // Quand le rappel doit être envoyé
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rappels');
    }
};
