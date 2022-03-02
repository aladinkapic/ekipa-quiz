<div id="page-menu">
    <div class="page-menu-icon-w">
        @yield('ph-icon')
    </div>
    <div class="page-menu-header">
        <h4>
            @yield('ph-main')
        </h4>
        <p>
            @yield('ph-short')
        </p>
    </div>
    <div class="page-menu-navigation">
        <div class="page-menu-nav-icon">
            <i class="fas fa-home"></i>
        </div>
        <a href="#"> {{ __('Dashboard') }} </a>
        @yield('ph-navigation')
    </div>
    <div class="menu-line"></div>
</div>
