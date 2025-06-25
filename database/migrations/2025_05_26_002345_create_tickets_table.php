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
            $table->string('ticket_number')->unique();
            $table->text('concern');
            $table->string('query_status')->nullable();
            $table->string('request_status')->nullable();
            $table->enum('service_method', ['on_site', 'pulled_out'])->nullable();
            $table->string('priority')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('released_at')->nullable();
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
