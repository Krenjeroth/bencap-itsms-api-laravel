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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_model_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->string('parent_component')->nullable();
            $table->integer('code')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('property_number');
            $table->string('ics_number')->nullable();
            $table->timestamp('date_acquired')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('status')->nullable();
            $table->string('inventory_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
