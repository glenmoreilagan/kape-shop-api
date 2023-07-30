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
    Schema::table('products', function (Blueprint $table) {
      $table->after('name', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->constrained(
          table: 'categories',
          indexName: 'product_category_id'
        )->nullOnDelete();
        $table->foreignId('brand_id')->nullable()
          ->constrained(
            table: 'brands',
            indexName: 'product_brand_id'
          )->nullOnDelete();
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('products', function (Blueprint $table) {
      //
    });
  }
};
