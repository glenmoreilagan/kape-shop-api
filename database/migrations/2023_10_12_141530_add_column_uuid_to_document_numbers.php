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
    Schema::table('document_numbers', function (Blueprint $table) {
      $table->after('id', function (Blueprint $table) {
        if (!Schema::hasColumn('document_numbers', 'uuid')) {
          $table->uuid();
        }
        if (!Schema::hasColumn('document_numbers', 'description1')) {
          $table->string('description1')->nullable();
        }
        if (!Schema::hasColumn('document_numbers', 'description2')) {
          $table->string('description2')->nullable();
        }
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('document_numbers', function (Blueprint $table) {
      //
    });
  }
};
