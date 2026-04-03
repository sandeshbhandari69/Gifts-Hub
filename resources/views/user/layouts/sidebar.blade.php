<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="{{url('user')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        <h6>Dashboard</h6>
                    </a>
                
                    <a class="nav-link" href="{{url('user/order-history')}}">
                        <div class="sb-nav-link-icon"><i class="fa-regular fa-clock"></i></div>
                        <h6>Order History</h6>
                    </a>
                    <a class="nav-link" href="{{url('user/settings')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                        <h6>Settings</h6>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                User name
            </div>
        </nav>
    </div>
