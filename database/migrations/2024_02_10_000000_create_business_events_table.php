<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_events', function (Blueprint $table) {
            $table->id();
            $table->enum('model_type', ['order', 'store_product', 'print_request', 'book', 'book_print_template']);
            $table->string('model_id');
            $table->string('name');
            $table->json('event_data');
            $table->enum('state', ['queue', 'processing', 'fail', 'success'])->default('queue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_events');
    }
};