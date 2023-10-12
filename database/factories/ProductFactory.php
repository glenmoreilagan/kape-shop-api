<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  protected $model = Product::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'sku' => Str::random(8),
      'uuid' => Str::uuid(),
      'name' => fake()->word(),
      'description1' => fake()->sentence(10),
      'description2' => fake()->sentence(12),
      'brand_id' => rand(1, 10),
      'category_id' => rand(1, 10),
      'price' => fake()->randomFloat(2, 100, 1000),
      'product_status' => fake()->numberBetween(0, 1),
    ];
  }
}
