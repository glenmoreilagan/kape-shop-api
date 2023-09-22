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
    Schema::create('purhcase_headers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('document_id')->nullable()->constrained(table: 'document_numbers')->nullOnDelete();
      $table->string('description1')->nullable();
      $table->string('description2')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('purhcase_headers');
  }
};
