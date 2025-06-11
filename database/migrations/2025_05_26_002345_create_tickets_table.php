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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->foreignId('employee_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->foreignId('item_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->foreignId('it_service_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->text('concern');
            $table->string('status')->nullable();
            $table->string('request_status')->nullable();
            $table->string('priority')->nullable();
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
