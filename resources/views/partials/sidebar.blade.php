<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-text mx-3">{{ __(' Byucan Resto') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('admin/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <li class="nav-item {{ request()->is('admin/categories') || request()->is('admin/categories') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>{{ __('Kategori') }}</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/products') || request()->is('admin/products') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>{{ __('Menu') }}</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/pos') || request()->is('admin/pos') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pos.index') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>{{ __('Transaksi') }}</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/transactions') || request()->is('admin/transactions') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>{{ __('Detail Transaksi') }}</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/reports/revenue') || request()->is('admin/reports/revenue') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.reports.revenue') }}">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>{{ __('Pembukuan Pendapatan') }}</span></a>
            </li>


        </ul>
