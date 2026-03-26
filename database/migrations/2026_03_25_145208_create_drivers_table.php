<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
  public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id'); // Isolation multi-tenant
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->index(); // Index pour la recherche rapide
            $table->string('license_number')->unique();
            
            // Statuts : 'available', 'on_mission', 'off_duty'
            $table->enum('status', ['available', 'on_mission', 'off_duty'])->default('available');
            
            // Relation avec le véhicule (BelongsTo)
            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null'); // Si le camion est supprimé, le chauffeur reste

            $table->timestamps();

            // Indexation du tenant pour la performance
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
