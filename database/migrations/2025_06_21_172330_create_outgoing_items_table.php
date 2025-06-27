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
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('description', 100)->nullable(false);
            $table->string('quantity', 100)->nullable(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_items');
    }
};
