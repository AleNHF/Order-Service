<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy("created_at", "desc")->paginate(10);

        return response()->json($orders, 200);
    }

    public function show($id)
    {
        $order = Order::with('supplier', 'orderDetails')->find($id);

        if (!$order) {
            return response()->json(['mensaje' => 'Pedido no encontrado'], 404);
        }

        return response()->json($order, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'deliveryDate' => 'required',
            'status' => 'required',
            'userId' => 'required',
            'supplierId' => 'required',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required',
            'details.*.quantity' => 'required',
            'details.*.price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'Error de validación', 'mensaje' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->status = $request->status;
            $order->deliveryDate = $request->deliveryDate;
            $order->userId = $request->userId;
            $order->supplierId = $request->supplierId;
            $order->save();

            $total = 0;
            $quantity = 0;
            $orderDetailsArray = [];

            foreach ($request->input('details') as $detail) {
                $orderDetail = new OrderDetail();
                $orderDetail->productId = $detail['product_id'];
                $orderDetail->quantity = $detail['quantity'];
                $orderDetail->price = $detail['price'];
                $orderDetail->total = $detail['quantity'] * $detail['price'];
                $orderDetail->orderId = $order->id;
                $orderDetail->save();

                $total += $orderDetail->quantity * $orderDetail->price;
                $quantity += $orderDetail->quantity;

                $orderDetailsArray[] = [
                    'product_id' => $orderDetail->productId,
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                    'total' => $orderDetail->total,
                ];
            }

            $order->total = $total;
            $order->qtyOrdered = $quantity;
            $order->save();

            DB::commit();

            return response()->json(['mensaje' => 'Orden y detalles creados con éxito', 'order' => $order, 'order_details' => $orderDetailsArray], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Error al crear la orden', 'mensaje' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'deliveryDate' => 'required',
            'status' => 'required',
            'userId' => 'required',
            'supplierId' => 'required',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required',
            'details.*.quantity' => 'required',
            'details.*.price' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'Error de validación', 'mensaje' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $order = Order::find($id);

            if (!$order) {
                return response()->json(['mensaje' => 'Orden no encontrada'], 404);
            }

            $order->update($request->only([
                'deliveryDate',
                'status',
                'userId',
                'supplierId'
            ]));

            $order->orderDetails()->delete();

            $total = 0;
            $quantity = 0;

            foreach ($request->input('details') as $detail) {
                $orderDetail = $order->orderDetails()->create([
                    'productId' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'total' => $detail['quantity'] * $detail['price']
                ]);

                $total += $orderDetail->quantity * $orderDetail->price;
                $quantity += $orderDetail->quantity;

                $orderDetailsArray[] = [
                    'product_id' => $orderDetail->productId,
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                    'total' => $orderDetail->total,
                ];
            }

            $order->total = $total;
            $order->qtyOrdered = $quantity;
            $order->save();

            DB::commit();

            return response()->json(['mensaje' => 'Orden y detalles actualizados con éxito', 'order' => $order, 'order_details' => $orderDetailsArray], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Error al actualizar la orden', 'mensaje' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['mensaje' => 'Orden no encontrada'], 404);
        }

        try {
            DB::beginTransaction();

            $order->orderDetails()->delete();
            $order->delete();

            DB::commit();

            return response()->json(['mensaje' => 'Orden y detalles eliminados con éxito'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Error al eliminar la orden', 'mensaje' => $e->getMessage()], 500);
        }
    }
}
