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
    Schema::create('sales', function (Blueprint $table) {
      $table->id();
      $table->foreignId('document_id')->nullable()->constrained(table: 'document_numbers')->nullOnDelete();
      $table->foreignId('product_id')->nullable()->constrained(table: 'products')->nullOnDelete();
      $table->integer('quantity')->default(0);
      $table->decimal('price', '20', 2)->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sales');
  }
};
