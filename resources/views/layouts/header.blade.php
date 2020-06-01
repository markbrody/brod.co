<nav class="main-nav row row justify-content-between m-0 bg-light border-bottom">
    <div class="main-nav-component flex-shrink">
        <a href="javascript:;"><span id="main-nav-menu-icon" class="mdi mdi-menu d-inline-block d-lg-none mt-1"></span></a>
    </div>
    <div id="main-nav-search" class="main-nav-component flex-fill d-lg-none" style="z-index:2">
        <div class="input-group pt-2">
            <input id="main-nav-search-input" class="box-shadow-none form-control" type="text" placeholder="Search this site">
            <div class="input-group-append">
                <span id="cancel-search-icon" class="input-group-text bg-white border-0 mdi mdi-close"></span>
            </div>
        </div>
    </div>
    <div class="main-nav-component flex-fill col-12 col-lg-auto" style="z-index:1">
        <ul class="main-nav-menu mx-0">
            <li>Projects Directory:</li>
            <li><a href="{{ url('/') }}">/home</a></li>
            <li><a rel="noopener" target="_blank" href="https://asciify.me">/ascii-art</a></li>
            <li><a rel="noopener" target="_blank" href="https://googlyizer.com">/googly-eyes</a></li>
            <li><a rel="noopener" target="_blank" href="https://simpledns.net">/managed-dns</a></li>
            <li><a rel="noopener" target="_blank" href="https://sudoku.brod.co">/sudoku</a></li>
        </ul>
    </div>
    <div class="main-nav-component d-none d-lg-block flex-shrink">
        <a href="javascript:;"><span id="main-nav-search-icon" class="mdi mdi-magnify d-none d-lg-inline-block mt-1"></span></a>
    </div>
</nav>
