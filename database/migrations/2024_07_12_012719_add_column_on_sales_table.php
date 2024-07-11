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
    Schema::table('sales', function (Blueprint $table) {
      $table->after('price', function (Blueprint $table) {
        $table->decimal('total', 20, 2)->default(0);
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('sales', function (Blueprint $table) {
      $table->dropColumn('total');
    });
  }
};
