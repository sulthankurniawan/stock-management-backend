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
        Schema::create('stock_entry_details', function (Blueprint $table) {
            $table->id('entry_detail_id');
            $table->unsignedBigInteger('entry_id');
            $table->string('item_code');
            $table->unsignedBigInteger('batch_id');
            $table->date('expiry_date');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entry_details');
    }
};
