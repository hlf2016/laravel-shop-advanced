<?php

namespace App\Http\Controllers;

use App\Events\OrderReviewed;
use Carbon\Carbon;
use App\Http\Requests\SendReviewRequest;
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

    // 评价页面
    public function review(Order $order)
    {
        $this->authorize('own', $order);
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单尚未支付，无法评价');
        }
        return view('orders.review', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    // 提交评价
    public function sendReview(Order $order, SendReviewRequest $request)
    {
        $this->authorize('own', $order);
        if (!$order->paid_at) {
            throw new InvalidRequestException('订单未支付，不可评价');
        }
        if ($order->reviewed) {
            throw new InvalidRequestException('订单已经评价');
        }
        $reviews = $request->input('reviews');
        \DB::transaction(function () use ($reviews, $order) {
            foreach ($reviews as $review) {
                $orderItem = $order->items()->find($review['id']);
                $orderItem->update([
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                    'reviewed_at' => Carbon::now()
                ]);
                $order->update(['reviewed' => true]);
                // 触发订单评价 事件
                event(new OrderReviewed($order));
            }
        });
        return redirect()->back();
    }
}
