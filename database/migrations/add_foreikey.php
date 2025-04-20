<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Add foreign key constraints.
     */
    public function up(): void
    {
        // Ajout de la FK taches.user_id vers users.id
        Schema::table('taches', function (Blueprint $table) {
            if (!Schema::hasColumn('taches', 'user_id')) return;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Ajout de la FK rappels.tache_id vers taches.id
        Schema::table('rappels', function (Blueprint $table) {
            if (!Schema::hasColumn('rappels', 'tache_id')) return;

            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
        });

    }

    /**
     * Remove foreign key constraints.
     */
    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('rappels', function (Blueprint $table) {
            $table->dropForeign(['tache_id']);
        });
    }
};