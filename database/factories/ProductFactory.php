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
    // $brand = Brand::inRandomOrder()->take(1)->first();
    // $category = Category::inRandomOrder()->take(1)->first();

    return [
      'sku' => Str::random(32),
      'name' => fake()->word(),
      'description1' => fake()->sentence(10),
      'description2' => fake()->sentence(12),
      // 'brand' => $brand->id,
      // 'category' => $category->id,
      'price' => fake()->randomFloat(2, 1, 1000),
      'product_status' => fake()->numberBetween(0, 1),
    ];
  }
}
