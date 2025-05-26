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
        Schema::create('item_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->decimal('cost', 12, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable()->comment('Null = Current Cost');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_costs');
    }
};
