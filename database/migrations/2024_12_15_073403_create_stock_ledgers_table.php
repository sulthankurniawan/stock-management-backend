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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->unsignedBigInteger('batch_id');
            $table->date('tanggal');
            $table->integer('last_stock')->default(0);
            $table->integer('qty_in')->default(0);
            $table->integer('qty_out')->default(0);
            $table->integer('current_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
