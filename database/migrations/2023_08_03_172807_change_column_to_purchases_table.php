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
      // $table->integer('quantity')->default(0)->change();
      // $table->decimal('price', 20, 2)->default(0)->change();
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
