<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Order::factory(1000)->create()->each(function ($order) use ($faker) {
            // Mover la generación aleatoria de 'status' dentro del bucle each
            $order->update([
                'status' => $faker->randomElement(['pending', 'shipped', 'delivered']),
                'deliveryDate' => $faker->date,
                'applicationDate' => $faker->date,
                'supplierId' => $faker->numberBetween(1, 20),
            ]);

            $numberOfDetails = rand(1, 10);

            // Para cada orden, crea un número aleatorio de detalles
            for ($i = 0; $i < $numberOfDetails; $i++) {
                $price = $faker->randomFloat(2, 1, 50);
                $quantity = $faker->numberBetween(1, 500);
                OrderDetail::factory()->create([
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $price * $quantity,
                    'productId' => $faker->numberBetween(1, 800), //String id
                    'orderId' => $order->id,
                ]);
            }

            // Actualizar la orden con el total y la cantidad de todos los detalles
            $order->update([
                'total' => $order->details->sum('total'),
                'qtyOrdered' => $order->details->sum('quantity'),
            ]);
        });
    }
}
