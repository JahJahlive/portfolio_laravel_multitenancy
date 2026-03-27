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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id'); // Isolation multi-tenant
            $table->string('customer_name');
            $table->string('origin_address');
            $table->string('destination_address');
            $table->dateTime('pickup_time');
            
            // Relations avec nos Enums et modèles stabilisés
            $table->foreignId('vehicle_id')->nullable()->constrained();
            $table->foreignId('driver_id')->nullable()->constrained();
            
            // Statut de la commande (Nouveau Enum à créer : pending, assigned, completed, cancelled)
            $table->string('status')->default('pending');
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
