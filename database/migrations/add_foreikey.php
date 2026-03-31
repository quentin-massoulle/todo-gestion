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
        Schema::table('message', function (Blueprint $table) {
            if (!Schema::hasColumn('message', 'user_id')) return;
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (!Schema::hasColumn('message', 'groupe_id')) return;
            $table->foreign('groupe_id')->references('id')->on('groupe')->onDelete('cascade');
        });
        // Ajout de la FK taches.user_id vers users.id
        Schema::table('taches', function (Blueprint $table) {
            if (!Schema::hasColumn('taches', 'user_id')) return;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (!Schema::hasColumn('taches', 'groupe_id')) return;

            $table->foreign('groupe_id')->references('id')->on('groupe')->onDelete('cascade');
        });
        Schema::table('groupe',function (Blueprint $table){
            if (!Schema::hasColumn('groupe','proprietaire_id')) return ;
            $table->foreign('proprietaire_id')->references('id')->on('users')->onDelete('cascade');
            
        });
        // Ajout de la FK rappels.tache_id vers taches.id
        Schema::table('rappels', function (Blueprint $table) {
            if (!Schema::hasColumn('rappels', 'tache_id')) return;

            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
        });

        // Ajout de la FK taches_dependencies.tache_id et taches_dependencies.dependency_id
        Schema::table('taches_dependencies', function (Blueprint $table) {
            if (!Schema::hasColumn('taches_dependencies', 'tache_id')) return;

            $table->foreign('tache_id')->references('id')->on('taches')->onDelete('cascade');
            if (!Schema::hasColumn('taches_dependencies', 'dependency_id')) return;

            $table->foreign('dependency_id')->references('id')->on('taches')->onDelete('cascade');
        });
    }

public function down(): void
    {
        // On désactive les contraintes pour éviter les blocages SQL pendant le rollback
        Schema::disableForeignKeyConstraints();

        if (Schema::hasTable('groupe_user')) {
            Schema::table('groupe_user', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['groupe_id']);
            });
        }

        if (Schema::hasTable('taches')) {
            Schema::table('taches', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['groupe_id']);
            });
        }

        if (Schema::hasTable('rappels')) {
            Schema::table('rappels', function (Blueprint $table) {
                $table->dropForeign(['tache_id']);
            });
        }

        if (Schema::hasTable('message')) {
            Schema::table('message', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['groupe_id']);
            });
        }

        if (Schema::hasTable('groupe')) {
            Schema::table('groupe', function (Blueprint $table) {
                $table->dropForeign(['proprietaire_id']);
            });
        }

        if (Schema::hasTable('taches_dependencies')) {
            Schema::table('taches_dependencies', function (Blueprint $table) {
                $table->dropForeign(['tache_id']);
                $table->dropForeign(['dependency_id']);
            });
        }

        Schema::enableForeignKeyConstraints();
    }
};