<div class="header-center">
    <div class="topbar"></div>
    <div class="header-center-main">
        <div class="logo-header">
            <a href="{{ route('users.index') }}"><img src="{{ asset('/frontend/img/logo1.png') }}" class="travel-logo-header" alt="Lỗi" /></a>
        </div>
        <div class ="header-content nav__pc">
            <div class = "header-menu-sticky">


                <ul id="list-menu-top">
                   <li>
                    <a id="header-menu-sticky" href="{{ route('category.show', ['categorySlug' => 'Nam']) }}">Nam</a>
                   </li>
                   <li>
                    <a id="header-menu-sticky" href="{{ route('category.show', ['categorySlug' => 'Nữ']) }}">Nữ</a>
                   </li>
                   <li><a id="header-menu-sticky" href="">Mới</a></li>
                   <li><a id="header-menu-sticky" href=""></a></li> 
                   <li><a id="header-menu-sticky" href="">Flash sale</a></li>
                </ul>
            </div>
        </div>
        <div class="header-menu-content-right">
            <div class="search-header">
                <form id="search-header" method="get" action="{{ route('search') }}">
                    <div class="input-search"><input class="nav__pc"id="input" name="q" placeholder="Bạn tìm gì..." /> </div>
                    <div class="btn-search"> <button id="btn-search"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button></div>
                </form>
            </div>
            @if(auth()->check())
                <!-- Nếu người dùng đã đăng nhập -->
                <div class="header-customer">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="">Hi, {{ Auth::user()->name }}</a></li>
                        <li><a class="dropdown-item" href="">Thông tin</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.order.show',['id'=>Auth::id()]) }}">Đơn hàng của tôi</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng Xuất</a>
                        </li>
                        <!-- Ví dụ với liên kết -->
                        <!-- Form ẩn để thực hiện đăng xuất -->
                        <form id="logout-form" action="{{ route('user.logout') }}" method="post" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            @else
                <!-- Nếu người dùng chưa đăng nhập -->
                <div class="header-customer">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.login') }}">Đăng Nhập</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.register') }}">Đăng Ký</a></li>
                    </ul>
                </div>
            @endif
            <div class="minicart">
                <a href="{{ route('cart.view')}}">
                    <i class="fa-solid fa-cart-shopping fa-xl"></i>
                    <span class="badge badge-danger navbar-badge"> {{ $cartProducts->count() }} </span>
                </a>

            </div>
        </div>           
    </div>
</div> 