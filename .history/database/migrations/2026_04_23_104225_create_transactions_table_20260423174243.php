<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->decimal('amount', 15, 2);
        $table->enum('type', ['income', 'expense']); // Pemasukan atau Pengeluaran
        $table->string('category'); // e.g., Makanan, Gaji, Transportasi
        $table->date('date');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
