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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_model_id')->nullable()
              ->constrained()
              ->nullOnDelete();
            $table->foreignId('employee_id')->comment('Issued To')->nullable()
              ->constrained()
              ->nullOnDelete();
            $table->string('parent_component')->nullable();
            $table->integer('code')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('property_number');
            $table->string('control_number')->comment('Pre and Post - Repair Inspection Report Number / Control Number')->nullable();
            $table->timestamp('date_issued')->nullable();
            $table->timestamp('date_acquired')->nullable();
            $table->timestamp('date_accepted')->nullable();
            $table->timestamp('date_installed')->nullable();
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
        Schema::dropIfExists('inventories');
    }
};
