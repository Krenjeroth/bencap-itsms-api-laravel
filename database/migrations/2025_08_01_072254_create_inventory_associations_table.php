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
        Schema::create('inventory_associations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_inventory_id')->nullable()
              ->constrained('inventories')
              ->cascadeOnDelete()->comment('Inventories typically the Desktop/CPU');
            $table->foreignId('target_inventory_id')->nullable()
              ->constrained('inventories')
              ->cascadeOnDelete()->comment('Inventories typically the Monitor, Printer, UPS, etc.');
            $table->string('association_type')->nullable();
            $table->string('connection_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_associations');
    }
};
