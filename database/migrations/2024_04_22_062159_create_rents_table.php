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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penalties')->nullable();
            $table->foreign('id_penalties')->references('id')->on('penalties');
            $table->unsignedBigInteger('tenant');
            $table->foreign('tenant')->references('id')->on('tenants');
            $table->unsignedBigInteger('no_car');
            $table->foreign('no_car')->references('id')->on('cars');
            $table->date('date_borrow');
            $table->date('date_return');
            $table->integer('down_payment');
            $table->integer('discount');
            $table->integer('total');
            $table->enum('status', ['return', 'borrow']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
