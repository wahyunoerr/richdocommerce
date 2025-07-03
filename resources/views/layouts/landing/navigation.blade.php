<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="../../index3.html" class="navbar-brand">
            <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('landing') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                </li>
            </ul>
        </div>

        <!-- Right navbar links -->
        @php
            $cart = session('cart', []);
            $cartCount = count(array_keys($cart));
            $cartProducts = [];
            if ($cartCount > 0) {
                $cartProducts = \App\Models\Product::whereIn('id', array_keys($cart))->get();
            }
        @endphp
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge badge-danger navbar-badge">{{ $cartCount ?? 0 }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                    style="left: inherit; right: 0px; min-width:320px;">
                    @php $total = 0; @endphp
                    @if ($cartCount > 0)
                        @foreach ($cartProducts as $product)
                            @php
                                $subtotal = $product->price * $cart[$product->id];
                                $total += $subtotal;
                            @endphp
                            <div class="dropdown-item d-flex align-items-center gap-2">
                                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                    style="width:48px; height:48px; object-fit:cover; border-radius:6px;">
                                <div class="flex-grow-1 ms-2">
                                    <strong>{{ $product->name }}</strong><br>
                                    <small>x{{ $cart[$product->id] }} &middot;
                                        Rp{{ number_format($product->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="text-success">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST"
                                    style="display:inline-block; margin-left:10px;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus dari keranjang"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforeach
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <strong>Total</strong>
                            <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('checkout.index') }}"
                            class="dropdown-item dropdown-footer text-center btn btn-primary">Checkout</a>
                    @else
                        <div class="dropdown-item text-center text-muted">Keranjang anda kosong</div>
                    @endif
                </div>
            </li>
            <!-- User Dropdown/Login -->
            @if (auth()->check())
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="far fa-user"></i> {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="far fa-user"></i> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
