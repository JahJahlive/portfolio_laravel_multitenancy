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
            $table->string('tenant_id')->index();
            
            // Informations Client
            $table->string('customer_name');
            $table->string('customer_phone');
            
            // Logistique
            $table->dateTime('scheduled_at'); // Date et heure du déménagement
            $table->text('pickup_address');
            $table->text('delivery_address');
            
            // Liens opérationnels (Optionnels au début)
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('set null');
            
            // État et Finance
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->decimal('price', 10, 2)->nullable(); // Pour la facturation à la prestation
            
            $table->timestamps();
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
