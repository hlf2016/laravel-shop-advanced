<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Exceptions\InvalidRequestException;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);
        // 判断是否 search 参数，如果有就赋值给 $search 参数
        // search 用于商品模糊搜索
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))){
            // 如果这是一个父类目
            if ($category->is_directory) {
                // 则筛选出该父类目下所有子类目的商品
                $builder->whereHas('category', function($query)use ($category){
                    $query->where('path', 'like', $category->path.$category->id.'-%');
                });
            } else {
                // 如果不是父类目，直接筛选此类目下的商品
                $builder->where('category_id', $category->id);
            }
        }

        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            // 是否是以 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(16);
        return view('products.index', [
            'products' => $products,
            'filters' => [
                'search' => $search,
                'order' => $order,
            ],
            'category' => $category ?? null,
        ]);
    }

    // 详情
    public function show(Product $product, Request $request)
    {
        // 判断商品是否已经已经上架 否则抛出异常
        if (!$product->on_sale) {
            throw new InvalidRequestException('商品未上架');
        }

        // 表示该商品是否被该用户收藏
        $favored = false;
        if ($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }

        $reviews = OrderItem::query()
            ->with(['order.user', 'productSku'])
            ->where('product_id', $product->id)
            ->whereNotNull('reviewed_at')
            ->orderBy('reviewed_at', 'desc')
            ->limit(10)
            ->get();
        return view('products.show', ['product' => $product, 'favored' => $favored, 'reviews' => $reviews]);
    }

    // 收藏
    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        // 若该商品已经被用户收藏过
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        }
        // 采用attach 将用户与商品绑定 attach 中可以是对象的id  也可以是对象本身
        $user->favoriteProducts()->attach($product);
        return [];
    }

    // 取消收藏
    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }

    // 收藏列表
    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);

        return view('products.favorites', ['products' => $products]);
    }
}
