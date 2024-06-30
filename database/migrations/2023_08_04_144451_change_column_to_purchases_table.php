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
    Schema::table('purchases', function (Blueprint $table) {
      $table->after('id', function (Blueprint $table) {
        $table->foreignId('document_id')->nullable()->constrained(
          table: 'document_numbers',
          indexName: 'document_id'
        )->nullOnDelete();
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('purchases', function (Blueprint $table) {
      $table->dropColumn('document_no');
      $table->dropColumn('document_id');
    });
  }
};
