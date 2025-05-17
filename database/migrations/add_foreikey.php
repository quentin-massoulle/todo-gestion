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
        Schema::table('groupe_user', function (Blueprint $table) {
            if (!Schema::hasColumn('groupe_user', 'user_id')) return;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (!Schema::hasColumn('groupe_user', 'groupe_id')) return;

            $table->foreign('groupe_id')->references('id')->on('groupe')->onDelete('cascade');
        });
        // Ajout de la FK taches.user_id vers users.id
        Schema::table('taches', function (Blueprint $table) {
            if (!Schema::hasColumn('taches', 'user_id')) return;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (!Schema::hasColumn('taches', 'groupe_id')) return;

            $table->foreign('groupe_id')->references('id')->on('groupe')->onDelete('cascade');
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
        
        Schema::table('groupe_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['groupe_id']);
        });
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['groupe_id']);
        });

        Schema::table('rappels', function (Blueprint $table) {
            $table->dropForeign(['tache_id']);
        });
    }
};