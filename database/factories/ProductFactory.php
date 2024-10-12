<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->ean8,
            'name' => $this->faker->unique()->name,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->text,
            'tags' => $this->faker->word,
            'price' => $this->faker->randomNumber(5),
            'stock' => $this->faker->randomNumber(2),
            'weight' => $this->faker->randomNumber(3),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'dimension' => $this->faker->randomNumber(1) . 'x' . $this->faker->randomNumber(1) . 'x' . $this->faker->randomNumber(1),
            'discount' => $this->faker->randomElement([$this->faker->randomNumber(1), 0]),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'is_active' => $this->faker->boolean,
            'is_selected' => $this->faker->boolean,
            'shipment' => $this->faker->randomElement(['expedition', 'takeaway']),
            'payment' => $this->faker->randomElement(['cash', 'transfer']),
        ];
    }
}
