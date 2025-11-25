<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center text-white mb-4">
            <h4><i class="bi bi-building"></i> ERP System</h4>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('projects.*') ? 'active bg-primary' : '' }}" href="{{ route('projects.index') }}">
                    <i class="bi bi-folder"></i> Projects
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('purchase-requests.*') ? 'active bg-primary' : '' }}" href="{{ route('purchase-requests.index') }}">
                    <i class="bi bi-file-earmark-text"></i> Purchase Requests
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('quotations.*') ? 'active bg-primary' : '' }}" href="{{ route('quotations.index') }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Quotations
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('purchase-orders.*') ? 'active bg-primary' : '' }}" href="{{ route('purchase-orders.index') }}">
                    <i class="bi bi-cart-check"></i> Purchase Orders
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('goods-receipts.*') ? 'active bg-primary' : '' }}" href="{{ route('goods-receipts.index') }}">
                    <i class="bi bi-box-arrow-in-down"></i> Goods Receipts
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('goods-returns.*') ? 'active bg-primary' : '' }}" href="{{ route('goods-returns.index') }}">
                    <i class="bi bi-box-arrow-up"></i> Goods Returns
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'active bg-primary' : '' }}" href="{{ route('inventory.index') }}">
                    <i class="bi bi-boxes"></i> Inventory
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('material-issuance.*') ? 'active bg-primary' : '' }}" href="{{ route('material-issuance.index') }}">
                    <i class="bi bi-box-arrow-right"></i> Material Issuance
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('fabrication.*') ? 'active bg-primary' : '' }}" href="{{ route('fabrication.index') }}">
                    <i class="bi bi-tools"></i> Fabrication
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('suppliers.*') ? 'active bg-primary' : '' }}" href="{{ route('suppliers.index') }}">
                    <i class="bi bi-truck"></i> Suppliers
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('reports.*') ? 'active bg-primary' : '' }}" href="{{ route('reports.index') }}">
                    <i class="bi bi-graph-up"></i> Reports
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-primary' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
.sidebar {
    min-height: 100vh;
    padding-top: 1rem;
}
.nav-link.active {
    font-weight: bold;
}
</style>
