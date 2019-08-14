<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            // 使用 with 方法预加载，避免N + 1问题
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        // load 与之前使用的with 功能都是一样的，用于数据的预加载，成为'延迟预加载'。
        // 不同的是，load()是在已经查询出来的模型上调用，而with()是在ORM查询构造器上使用。
        return view('orders.show', ['order' => $order->load(['items.product', 'items.productSku'])]);
    }

    public function store(OrderRequest $request, OrderService $orderService)
    {
        // 利用 Laravel 的自动解析功能注入 CartService 类
        $user = $request->user();
        $address = UserAddress::find($request->input('address_id'));

        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'));
    }

    // 收获
    public function received(Order $order, Request $request)
    {
        // 校验权限
        $this->authorize('own', $order);

        // 判断订单的状态是否是已发货
        if ($order->ship_status !== Order::SHIP_STATUS_DELIVERED) {
            throw new InvalidRequestException('发货状态不正确');
        }
        // 更新订单信息为已发货
        $order->update([
            'ship_status' => Order::SHIP_STATUS_RECEIVED
        ]);

        // 返回订单信息
        return $order;
    }
}
