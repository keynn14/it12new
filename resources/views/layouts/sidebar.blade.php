@php
    $purchasingActive = request()->routeIs('purchase-requests.*') ||
        request()->routeIs('quotations.*') ||
        request()->routeIs('purchase-orders.*') ||
        request()->routeIs('goods-returns.*');
    
    $inventoryActive = request()->routeIs('inventory.*') ||
        request()->routeIs('goods-receipts.*') ||
        request()->routeIs('material-issuance.*');
@endphp

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 d-flex flex-column h-100">
        <div class="text-center text-white mb-4">
            <div class="sidebar-logo p-3 rounded-4 shadow-sm mx-auto">
                <img src="{{ asset('images/davao.png') }}" alt="Davao Modern Glass" class="img-fluid sidebar-logo-img">
            </div>
        </div>
        
        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                    <i class="bi bi-folder"></i> Projects
                </a>
            </li>
            
            <li class="nav-item">
                <button class="nav-link nav-link-group {{ $purchasingActive ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#purchasingMenu" aria-expanded="{{ $purchasingActive ? 'true' : 'false' }}">
                    <span><i class="bi bi-bag-check me-2"></i>Purchasing</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="collapse {{ $purchasingActive ? 'show' : '' }}" id="purchasingMenu">
                    <ul class="nav flex-column sub-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchase-requests.*') ? 'active' : '' }}" href="{{ route('purchase-requests.index') }}">
                                <i class="bi bi-file-earmark-text"></i> Purchase Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}" href="{{ route('quotations.index') }}">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Quotations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}" href="{{ route('purchase-orders.index') }}">
                                <i class="bi bi-cart-check"></i> Purchase Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('goods-returns.*') ? 'active' : '' }}" href="{{ route('goods-returns.index') }}">
                                <i class="bi bi-box-arrow-up"></i> Goods Returns
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item">
                <button class="nav-link nav-link-group {{ $inventoryActive ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#inventoryMenu" aria-expanded="{{ $inventoryActive ? 'true' : 'false' }}">
                    <span><i class="bi bi-boxes me-2"></i>Inventory Management</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="collapse {{ $inventoryActive ? 'show' : '' }}" id="inventoryMenu">
                    <ul class="nav flex-column sub-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                                <i class="bi bi-list-ul"></i> Goods List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('goods-receipts.*') ? 'active' : '' }}" href="{{ route('goods-receipts.index') }}">
                                <i class="bi bi-box-arrow-in-down"></i> Goods Receipts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('material-issuance.*') ? 'active' : '' }}" href="{{ route('material-issuance.index') }}">
                                <i class="bi bi-box-arrow-right"></i> Goods Issue
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('fabrication.*') ? 'active' : '' }}" href="{{ route('fabrication.index') }}">
                    <i class="bi bi-tools"></i> Fabrication
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <i class="bi bi-truck"></i> Suppliers
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="bi bi-graph-up"></i> Reports
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>
        </ul>

        <div class="sidebar-footer mt-auto text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="sidebar-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ auth()->user()->name ?? 'User' }}</div>
                        <small class="text-white-50">{{ auth()->user()->email ?? 'user@example.com' }}</small>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle px-3" type="button" id="sidebarAccountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="sidebarAccountDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.sidebar {
    min-height: 100vh;
    padding-top: 1rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 65%, #0f172a 100%);
    color: #e2e8f0;
    box-shadow: 4px 0 24px rgba(15, 23, 42, 0.45);
}
.sidebar .position-sticky {
    top: 0;
}
.nav-link {
    color: #cbd5f5;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    transition: all 0.2s ease;
    font-weight: 500;
    margin-bottom: 0.35rem;
}
.nav-link-group {
    width: 100%;
    text-align: left;
    border: none;
    background: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav-link-group i:last-child {
    transition: transform 0.2s ease;
}
.nav-link-group[aria-expanded="true"] i:last-child {
    transform: rotate(180deg);
}
.sub-nav {
    padding-left: 0.5rem;
    margin-top: 0.35rem;
}
.sub-nav .nav-link {
    font-size: 0.9rem;
    padding: 0.6rem 1rem 0.6rem 2.2rem;
    border-radius: 10px;
    color: #e2e8f0;
}
.sub-nav .nav-link i {
    font-size: 0.9rem;
}
.nav-link i {
    margin-right: 0.5rem;
    font-size: 1rem;
}
.nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
    transform: translateX(4px);
}
.nav-link.active {
    color: #ffffff;
    font-weight: 600;
    background: rgba(59, 130, 246, 0.25);
    border-left: 3px solid #3b82f6;
    transform: translateX(4px);
    box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.15);
}
.sidebar-footer {
    padding-top: 1.5rem;
    padding-bottom: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    margin-bottom: 0.75rem;
}
.sidebar-avatar {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}
.sidebar-footer .dropdown-toggle::after {
    display: none;
}

.sidebar-logo {
    width: 110px;
    height: 110px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    backdrop-filter: blur(12px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.sidebar-logo::after {
    content: '';
    position: absolute;
    inset: 3px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    pointer-events: none;
}
.sidebar-logo:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.4);
}
.sidebar-logo-img {
    max-width: 90px;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.35));
}
</style>
