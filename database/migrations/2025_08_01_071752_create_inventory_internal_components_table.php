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
        Schema::create('inventory_internal_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desktop_inventory_id')->nullable()
              ->constrained('inventories')
              ->cascadeOnDelete()->comment('Inventories where item_type_id is Desktop/CPU');
            $table->foreignId('brand_model_id')->nullable()
              ->constrained()
              ->nullOnDelete();
            $table->string('specific_serial_number')->nullable();

            $table->string('property_number')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamp('date_acquired')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_internal_components');
    }
};
