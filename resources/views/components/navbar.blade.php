<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
     id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Поиск по сайту..."
                       aria-label="Поиск..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            <li class="nav-item me-3">
                <div class="balance">
                    <button data-bs-toggle="modal" data-bs-target="#balance" class="left-side">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAAAYpJREFUaEPtmd1RwzAQhL9UQKgAqACoBDqAdBAqIR3QAlQAVAAlQAVABcnsjDNjK/5ROI/Onjk9+cG2dm9Xp9NpwczHYub4CQLeCoYCU1fgDlgDV45Av4BP4AHQc2N0WWgJvDoDT7H+AtcpiS4CHxMDvyfzAtzWmbURkGUeHS3TN7UsdDFEII3+O3Df5r9CJLd9tm9TIP1AjA8WTyHwmsZMwHuvCAKhgHG9TMJC51Vq1o6uZ8toOCInC1ktJMBKzdrdxxjFCTwDN2Mgr/5RnMDPiNEXh+IEehdhhjLuizgIWGshaxYKBUKBjEzR90pYyNtCOoyfGFXsPEWWqIVmX0qomFNfZywVipcSkl8kNlWr5sxoJxcCFszutZAFfHQlDupvazj/8b3ZQqeAcrnXOJqAUt5lDe0bsHLszh1NQH3QJ69wD8z7nXY1umr9VIWp8MlqrwusWiCyTt1K3iT+qo2w0WgeOm3JTrov8CQi28gRwpF9xeQd7ez5hxTI/pHXi0HAK/L7eUMBbwV2lkpcMVHAWNkAAAAASUVORK5CYII="/>
                        Баланс
                    </button>
                    <div class="right-side">
                        <p>{{ auth()->user()->balance }}$</p>
                    </div>
                </div>

                <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                   data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                             class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="profile.html">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                             class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->name }} {{ auth()->user()->surname }}</span>
                                    <small class="text-muted">Пользователь</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="profile.html">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Мой профиль</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="addresses.html">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Адреса</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="invoices-and-payments.html">
                                                <span class="d-flex align-items-center align-middle">
                                                    <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                    <span class="flex-grow-1 align-middle">Счета и платежи</span>
                                                    <span
                                                        class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="document.querySelector('#logout').submit()">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Выйти</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="logout">@csrf</form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- / Navbar -->
