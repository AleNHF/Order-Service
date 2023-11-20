<?php

namespace Database\Factories;

use App\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            /* 'total' => $this->faker->randomFloat(2, 10, 100),
            'qtyOrdered' => $this->faker->randomNumber(),
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered']),
            'deliveryDate' => $this->faker->date,
            'applicationDate' => $this->faker->date,
            'userId' => $this->faker->randomElement([1, 2]), 
            'supplierId' => $this->faker->randomElement([1, 20]), */
        ];
    }
}
