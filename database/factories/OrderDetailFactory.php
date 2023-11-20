<?php

namespace Database\Factories;

use App\Model;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition(): array
    {
        /* $price = $this->faker->randomFloat(2, 1, 50);
        $quantity = $this->faker->numberBetween(1, 500);
 */
    	return [
    	    /* 'price' => $price,
            'total' => $price * $quantity,
            'quantity' => $quantity,
            'productId' => $this->faker->randomNumber(),
            'orderId' => $this->faker->numberBetween([1, 1000]), */
    	];
    }
}
