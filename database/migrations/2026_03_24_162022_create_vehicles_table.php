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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id'); // La clé magique pour le multi-tenant
            $table->string('name');      // ex: Camion Ford Transit
            $table->string('model');     // ex: Transit 2016
            $table->string('plate_number')->unique(); // Plaque d'immatriculation
            $table->enum('status', ['available', 'on_mission', 'maintenance'])->default('available');
            $table->timestamps();

            // Indexation pour la sécurité
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
