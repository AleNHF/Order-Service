<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Order::factory(1000)->create()->each(function ($order) use ($faker) {
            $applicationDate = $faker->dateTimeBetween('2020-01-01', '2023-12-31')->format('Y-m-d');
            $deliveryDate = Carbon::createFromFormat('Y-m-d', $applicationDate)->addDays($faker->randomElement([3, 5]))->format('Y-m-d');

            $order->update([
                'status' => $faker->randomElement(['pending', 'shipped', 'delivered']),
                'deliveryDate' => $deliveryDate,
                'applicationDate' => $applicationDate,
                'supplierId' => $faker->numberBetween(1, 20),
            ]);

            $numberOfDetails = rand(1, 10);

            for ($i = 0; $i < $numberOfDetails; $i++) {
                $price = $faker->randomFloat(2, 1, 50);
                $quantity = $faker->numberBetween(1, 200);
                OrderDetail::factory()->create([
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $price * $quantity,
                    'productId' => str_pad($faker->numberBetween(1, 111), 6, '0', STR_PAD_LEFT),
                    'orderId' => $order->id,
                ]);
            }

            $order->update([
                'total' => $order->details->sum('total'),
                'qtyOrdered' => $order->details->sum('quantity'),
            ]);
        });
    }
}
