<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            Pannio Shop
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- 登录注册链接开始 -->
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img
                                src="https://locaffcdn.phphub.org/uploads/images/201806/01/5320/82Wf2sg8gM.jpg"
                                class="img-responsive img-circle" width="30px" height="30px">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user_addresses.index') }}">
                                收货地址
                            </a>
                            <a class="dropdown-item" href="{{ route('products.favorites') }}">
                                我的收藏
                            </a>
                            <a class="dropdown-item" href="{{ route('cart.index') }}">
                                我的购物车
                            </a>
                            <a class="dropdown-item" href="{{ route('orders.index') }}">
                                订单中心
                            </a>
                            <a class="dropdown-item" id="logout" href="#"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                注销
                            </a>
                        </div>
                    </li>
            @endguest
            <!-- 登录注册链接结束 -->
            </ul>
        </div>
    </div>
</nav>
