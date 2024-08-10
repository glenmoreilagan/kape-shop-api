<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('sales', function (Blueprint $table) {
      $table->after('created_by', function (Blueprint $table) {
        $table->string('user_id')->nullable();
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('sales', function (Blueprint $table) {
      $table->dropColumn('user_id');
    });
  }
};
