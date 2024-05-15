<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}" style="color: #6666ff">
                <img src="{{ asset('backend/assets/img/logo.png') }}"
                     height="30px" alt="prime store logo"> Prime Store
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">
                <img src="{{ asset('backend/assets/img/logo.png') }}" height="30px" alt="prime store logo">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown active">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Ecommerce</li>

            <li class="dropdown {{ setActive([
                'admin.category.*',
                'admin.subcategory.*',
                'admin.child-category.*'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list-alt"></i>
                    <span>Manage Categories</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.category.*']) }}">
                        <a class="nav-link" href="{{ route('admin.category.index') }}">Category</a>
                    </li>
                    <li class="{{ setActive(['admin.subcategory.*']) }}">
                        <a class="nav-link" href="{{ route('admin.subcategory.index') }}">Subcategory</a>
                    </li>
                    <li class="{{ setActive(['admin.child-category.*']) }}">
                        <a class="nav-link" href="{{ route('admin.child-category.index') }}">Child Category</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ setActive([
                'admin.brand.*',
                'admin.products.*',
                'admin.seller-products.*',
                'admin.products-image-gallery.*',
                'admin.products-variant.*',
                'admin.products-variant-option.*',
                'admin.reviews.*'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box-open"></i>
                    <span>Manage Products</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.brand.*']) }}">
                        <a class="nav-link" href="{{ route('admin.brand.index') }}">Brands</a>
                    </li>
                    <li class="{{ setActive([
                        'admin.products.*',
                        'admin.products-image-gallery.*',
                        'admin.products-variant.*',
                        'admin.products-variant-option.*',
                        'admin.seller-products.*'
                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                    </li>
                    <li class="{{ setActive(['admin.seller-products.index']) }}">
                        <a class="nav-link" href="{{ route('admin.seller-products.index') }}">Approved Products</a>
                    </li>
                    <li class="{{ setActive(['admin.seller-products.pending']) }}">
                        <a class="nav-link" href="{{ route('admin.seller-products.pending') }}">Pending Products</a>
                    </li>
                    <li class="{{ setActive(['admin.reviews.*']) }}">
                        <a class="nav-link" href="{{ route('admin.reviews.index') }}">Product Reviews</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setActive([
                'admin.order.*',
                'admin.order-pending',
                'admin.order-processed-and-ready-to-ship',
                'admin.order-dropped-off',
                'admin.order-shipped',
                'admin.order-out-for-delivery',
                'admin.order-delivered',
                'admin.order-cancelled'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-basket"></i>
                    <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.order.*']) }}">
                        <a class="nav-link" href="{{ route('admin.order.index') }}">All Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-pending']) }}">
                        <a class="nav-link" href="{{ route('admin.order-pending') }}">Pending Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-processed-and-ready-to-ship']) }}">
                        <a class="nav-link" href="{{ route('admin.order-processed-and-ready-to-ship') }}">
                            Processed Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-dropped-off']) }}">
                        <a class="nav-link" href="{{ route('admin.order-dropped-off') }}">Dropped-Off Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-shipped']) }}">
                        <a class="nav-link" href="{{ route('admin.order-shipped') }}">Shipped Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-out-for-delivery']) }}">
                        <a class="nav-link" href="{{ route('admin.order-out-for-delivery') }}">
                            Out-for-Delivery Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-delivered']) }}">
                        <a class="nav-link" href="{{ route('admin.order-delivered') }}">Delivered Orders</a>
                    </li>
                    <li class="{{ setActive(['admin.order-cancelled']) }}">
                        <a class="nav-link" href="{{ route('admin.order-cancelled') }}">Cancelled Orders</a>
                    </li>
                </ul>
            </li>

            <li class="{{ setActive(['admin.transaction']) }}">
                <a class="nav-link" href="{{ route('admin.transaction') }}">
                    <i class="fas fa-exchange-alt"></i> <span>Transactions</span></a>
            </li>

            <li class="dropdown {{ setActive([
                'admin.vendor-profile.*',
                'admin.flash-sale.*',
                'admin.coupons.*',
                'admin.shipping-rules.*',
                'admin.payment-setting'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.flash-sale.*']) }}">
                        <a class="nav-link" href="{{ route('admin.flash-sale.index') }}">Flash Sale</a>
                    </li>
                    <li class="{{ setActive(['admin.coupons.*']) }}">
                        <a class="nav-link" href="{{ route('admin.coupons.index') }}">Coupons</a>
                    </li>
                    <li class="{{ setActive(['admin.shipping-rules.*']) }}">
                        <a class="nav-link" href="{{ route('admin.shipping-rules.index') }}">Shipping Rule</a>
                    </li>
                    <li class="{{ setActive(['admin.vendor-profile.*']) }}">
                        <a class="nav-link" href="{{ route('admin.vendor-profile.index') }}">Vendor Profile</a>
                    </li>
                    <li class="{{ setActive(['admin.payment-setting']) }}">
                        <a class="nav-link" href="{{ route('admin.payment-setting') }}">Payment Settings</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ setActive([
                'admin.withdraw-method.*',
                'admin.withdraw.*'
            ]) }}">
                <a href="javascript:" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-wallet"></i><span>Withdraw Payments</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.withdraw-method.*']) }}">
                        <a class="nav-link" href="{{ route('admin.withdraw-method.index') }}">
                            Withdraw Method</a></li>
                    <li class="{{ setActive(['admin.withdraw.*']) }}">
                        <a class="nav-link" href="{{ route('admin.withdraw.index') }}">
                            Withdraw List</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setActive([
                'admin.slider.*',
                'admin.home-page-setting',
                'admin.vendor-condition.index',
                'admin.about.index',
                'admin.terms-and-conditions.index'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-globe"></i><span>Manage Website</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.slider.*']) }}">
                        <a class="nav-link" href="{{ route('admin.slider.index') }}">Slider</a>
                    </li>
                    <li class="{{ setActive(['admin.home-page-setting']) }}">
                        <a class="nav-link" href="{{ route('admin.home-page-setting') }}">Home Page</a>
                    </li>
                    <li class="{{ setActive(['admin.vendor-condition.index']) }}">
                        <a class="nav-link" href="{{ route('admin.vendor-condition.index') }}">
                            Vendor Condition</a></li>
                    <li class="{{ setActive(['admin.about.index']) }}">
                        <a class="nav-link" href="{{ route('admin.about.index') }}">About Page</a></li>
                    <li class="{{ setActive(['admin.terms-and-conditions.index']) }}">
                        <a class="nav-link" href="{{ route('admin.terms-and-conditions.index') }}">Terms Page</a></li>
                </ul>
            </li>

            <li><a class="nav-link {{ setActive(['admin.advertisement.*']) }}" href="{{
                route('admin.advertisement.index') }}">
                    <i class="fas fa-ad"></i> <span>Advertisement</span></a></li>

            <li class="dropdown {{ setActive([
                    'admin.blog-category.*',
                    'admin.blog.*',
                    'admin.blog-comments.index'
                    ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fab fa-blogger-b"></i> <span>Manage Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.blog-category.*']) }}">
                        <a class="nav-link" href="{{ route('admin.blog-category.index') }}">Categories</a>
                    </li>
                    <li class="{{ setActive(['admin.blog.*']) }}">
                        <a class="nav-link" href="{{ route('admin.blog.index') }}">Blogs</a>
                    </li>
                    <li class="{{ setActive(['admin.blog-comments.index']) }}">
                        <a class="nav-link" href="{{ route('admin.blog-comments.index') }}">Blog Comments</a>
                    </li>
                </ul>
            </li>

            <li><a class="nav-link {{ setActive(['admin.messages.index']) }}"
                   href="{{ route('admin.messages.index') }}">
                    <i class="fas fa-comments"></i><span>Messages</span></a></li>

            <li><a class="nav-link {{ setActive(['admin.referral-code.index']) }}"
                   href="{{ route('admin.referral-code.index') }}">
                    <i class="fas fa-code"></i><span>Referral Code</span></a></li>

            <li class="menu-header">Settings & More</li>

            <li class="dropdown {{ setActive([
                'admin.footer-info.index',
                'admin.footer-socials.*',
                'admin.footer-grid-two.*',
                'admin.footer-grid-three.*',
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-th-large"></i><span>Footer</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.footer-info.index']) }}">
                        <a class="nav-link" href="{{ route('admin.footer-info.index') }}">Footer Info</a>
                    </li>
                    <li class="{{ setActive(['admin.footer-socials.*']) }}">
                        <a class="nav-link" href="{{ route('admin.footer-socials.index') }}">Footer Socials</a>
                    </li>
                    <li class="{{ setActive(['admin.footer-grid-two.*']) }}">
                        <a class="nav-link" href="{{ route('admin.footer-grid-two.index') }}">Footer Grid Two</a></li>
                    <li class="{{ setActive(['admin.footer-grid-three.*']) }}">
                        <a class="nav-link" href="{{
                            route('admin.footer-grid-three.index') }}">Footer Grid Three</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setActive([
                    'admin.vendor-applications.index',
                    'admin.customer.index',
                    'admin.vendor-list.index',
                    'admin.manage-user.index',
                    'admin-list.index',
                ]) }}">
                <a href="javascript:" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.customer.index']) }}">
                        <a class="nav-link" href="{{ route('admin.customer.index') }}">Customer List</a></li>
                    <li class="{{ setActive(['admin.vendor-list.index']) }}">
                        <a class="nav-link" href="{{ route('admin.vendor-list.index') }}">Vendor List</a></li>
                    <li class="{{ setActive(['admin.vendor-applications.index']) }}">
                        <a class="nav-link" href="{{ route('admin.vendor-applications.index') }}">
                            Pending Vendors</a></li>
                    <li class="{{ setActive(['admin.admin-list.index']) }}">
                        <a class="nav-link" href="{{ route('admin.admin-list.index') }}">Admin List</a></li>
                    <li class="{{ setActive(['admin.manage-user.index']) }}">
                        <a class="nav-link" href="{{ route('admin.manage-user.index') }}">Manage Users</a></li>
                </ul>
            </li>

            <li><a class="nav-link {{ setActive(['admin.subscribers.*']) }}"
                   href="{{ route('admin.subscribers.index') }}"><i class="fas fa-user"></i>
                    <span>Subscribers</span></a></li>

            <li class="{{ setActive(['admin.settings.index']) }}">
                <a class="nav-link" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog"></i> <span>Settings</span></a>
            </li>
        </ul>
    </aside>
</div>
