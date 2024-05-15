<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>
    <a href="javascript:" class="dash_logo">
        <img src="{{ asset($logo_setting->logo) }}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="{{ setActive(['vendor.dashboard']) }}" href="{{ route('vendor.dashboard') }}">
                <i class="fas fa-tachometer"></i>Dashboard</a></li>
        <li><a class="{{ setActive(['vendor.messages.index']) }}" href="{{ route('vendor.messages.index')}}">
                <i class="fas fa-comments-alt"></i>Messages</a></li>
        <li><a class="" href="{{ url('/') }}"><i class="fas fa-home"></i>Go To Home Page</a></li>
        <li><a class="{{ setActive(['user.dashboard']) }}" href="{{ route('user.dashboard') }}">
                <i class="fas fa-tachometer"></i>User Dashboard</a></li>
        <li><a class="{{ setActive(['vendor.orders.*']) }}" href="{{ route('vendor.orders.index') }}">
                <i class="fas fa-shopping-basket"></i>Orders</a></li>
        <li><a class="{{ setActive(['vendor.products.*']) }}" href="{{ route('vendor.products.index') }}">
                <i class="fas fa-box-open"></i>Products</a></li>
        <li><a class="{{ setActive(['vendor.reviews.index']) }}" href="{{ route('vendor.reviews.index') }}">
                <i class="fas fa-star"></i>Review</a></li>
        <li><a class="{{ setActive(['vendor.withdraw.index']) }}" href="{{ route('vendor.withdraw.index') }}">
                <i class="fas fa-wallet"></i>Withdraw Income</a></li>
        <li><a class="{{ setActive(['vendor.shop-profile.index']) }}" href="{{ route('vendor.shop-profile.index') }}">
                <i class="fas fa-store-alt"></i>Shop Profile</a></li>
        <li><a class="{{ setActive(['vendor.profile']) }}" href="{{ route('vendor.profile') }}">
                <i class="far fa-user"></i> My Profile</a></li>
        <li><a class="{{ setActive(['vendor.packages.*']) }}" href="{{
                route('vendor.packages.index') }}">
                <i class="far fa-box"></i>Packages</a></li>
        <li><a class="{{ setActive(['vendor.referral-code.index']) }}"
               href="{{ route('vendor.referral-code.index') }}">
                <i class="fas fa-code"></i>Referral Code</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                    <i class="far fa-sign-out-alt"></i> Log out</a>
            </form>
        </li>
    </ul>
</div>
