<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('title')
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/style.css' ) }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg theme-navbar">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/images/product/logo.png') }}" class="navbar-logo rounded-circle" alt="Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-bold align-items-center" style="font-size: 0.95rem; gap: 0.5rem;">
        <li class="nav-item">
          <a class="nav-link text-dark px-2" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-2" href="{{ route('products') }}">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-2" href="{{ route('categories') }}">Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-2" href="{{ route('about') }}">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-2" href="{{ route('contact') }}">Contact Us</a>
        </li>
      </ul>

      <form class="d-flex mx-auto mb-2 mb-lg-0 d-none d-lg-block" role="search" action="{{ route('search') }}" method="GET" style="flex: 1; max-width: 500px; margin: 0 4rem;">
        <div class="search-modern position-relative">
            <input class="form-control form-control-sm border-0" type="search" name="q" id="searchInput" placeholder="Search for gifts, products..." aria-label="Search" autocomplete="off"/>
            <button class="btn btn-sm search-btn" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div id="autocompleteResults" class="position-absolute w-100 bg-white border rounded shadow-sm" style="top: 100%; z-index: 1000; display: none;"></div>
        </div>
      </form>

      <div class="d-flex align-items-center gap-2">
        <a href="{{url('cart-list/product')}}" class="btn btn-custom-black btn-sm rounded-pill px-2 py-2">
            <i class="fa-solid fa-cart-shopping me-1"></i>
            <span class="d-none d-md-inline">Cart</span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="btn btn-custom-black btn-sm rounded-pill px-2 py-2">
            <i class="fa-regular fa-heart me-1"></i>
            <span class="d-none d-md-inline">Wishlist</span>
        </a>
        
        @auth
            <div class="dropdown">
                <button class="btn btn-custom-black btn-sm rounded-pill px-3 py-2 dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user me-1"></i>
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="min-width: 200px; z-index: 1050;">
                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                        <i class="fa-solid fa-dashboard me-2"></i>Dashboard
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}/settings">
                        <i class="fa-solid fa-cog me-2"></i>Settings
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger w-100 text-start" style="display: block; width: 100%; padding: 0.5rem 1rem; background: transparent; border: none; text-align: left;">
                                <i class="fa-solid fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{url('register1')}}" class="btn btn-custom-black btn-sm rounded-pill px-3 py-2 fw-bold">Login</a>
            <a href="{{url('register')}}" class="btn theme-orange-btn btn-sm rounded-pill px-3 py-2 fw-bold">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const autocompleteResults = document.getElementById('autocompleteResults');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(debounceTimer);
        
        if (query.length < 1) {
            autocompleteResults.style.display = 'none';
            return;
        }
        
        debounceTimer = setTimeout(() => {
            fetch(`/search/autocomplete?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '';
                        data.forEach(item => {
                            html += `
                                <div class="autocomplete-item px-3 py-2 hover-bg-light" style="cursor: pointer;" onclick="selectSuggestion('${item.name}')">
                                    <i class="fa-solid fa-search text-muted me-2"></i>
                                    ${item.name}
                                </div>
                            `;
                        });
                        autocompleteResults.innerHTML = html;
                        autocompleteResults.style.display = 'block';
                    } else {
                        autocompleteResults.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    autocompleteResults.style.display = 'none';
                });
        }, 300);
    });

    searchInput.addEventListener('blur', function() {
        setTimeout(() => {
            autocompleteResults.style.display = 'none';
        }, 200);
    });

    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 1) {
            this.dispatchEvent(new Event('input'));
        }
    });
});

function selectSuggestion(name) {
    document.getElementById('searchInput').value = name;
    document.getElementById('autocompleteResults').style.display = 'none';
    document.querySelector('form[role="search"]').submit();
}
</script>
