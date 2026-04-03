<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="{{url('admin')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        <h6>Dashboard</h6>
                    </a>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{url('admin')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="sb-nav-link-icon"><i class="fa-brands fa-shopify"></i></div> Manage Product
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.add-product') }}">Add</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.view-product') }}">View</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{url('admin')}}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div> Manage Category
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.add-category') }}">Add-Category</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.view-category') }}">View</a></li>
                        </ul>
                    </li>

                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        <h6>Manage Users</h6>
                    </a>
                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            Manage Inventory
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('inventory.create') }}">
                                    Add Inventory
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('inventory.index') }}">
                                    View Inventory
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                            Generate Report
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('sales.report') }}">
                                    Sales Report
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('purchase.report') }}">
                                    Purchase Report
                                </a>
                            </li>
                        </ul>
                    </li>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                User name
            </div>
        </nav>
    </div>
