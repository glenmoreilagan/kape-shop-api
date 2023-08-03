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
        $table->string('document_no')->nullable();
        $table->date('transaction_date')->nullable();
        $table->string('description')->default('');
        $table->string('description1')->default('');
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('purchases', function (Blueprint $table) {
      //
    });
  }
};
