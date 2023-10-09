<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>habsha</title>
    <!-- Favicons -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free-6.4.0-web/css/all.css') }}" rel="stylesheet">
    <style>
        #layoutSidenav #layoutSidenav_content {
            margin-left: 0;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 0px;
        }

        #layoutSidenav #layoutSidenav_nav {
            transform: translateX(225px)
        }

        @media (min-width: 992px) {
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content {
                margin-right: 225px;
                margin-left: 0;
            }

            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
                transform: translateX(0);
            }
        }
    </style>
    @yield('css')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand pe-3" href="{{ route('home') }}">Habsha</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="bi bi-list mobile-nav-toggle"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php
                        use App\Models\Message;
                        $Message = Message::where('read', 0)->count();
                        ?>
                        <a class="nav-link" href="{{ route('admin.message') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            الرسائل
                            @if ($Message != 0)
                                <span class="badge bg-danger">{{ $Message }}</span>
                            @endif
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsdelivary" aria-expanded="false"
                            aria-controls="collapseLayoutsdelivary">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            طلبات التوصيل
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsdelivary" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.delivary.create') }}">اضافة
                                    طلب توصيل
                                    جديد</a>
                                <a class="nav-link" href="{{ route('admin.delivary.New') }}">طلبات التوصيل الجديدة</a>
                                <a class="nav-link" href="{{ route('admin.delivary.Data') }}">طلبات التوصيل السابقة</a>

                            </nav>

                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsorder" aria-expanded="false"
                            aria-controls="collapseLayoutsorder">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            طلبات المطاعم
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsorder" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.order.New') }}">طلبات المطاعم الجديدة</a>
                                <a class="nav-link" href="{{ route('admin.order.Data') }}">طلبات المطاعم السابقة</a>
                            </nav>

                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsContributer" aria-expanded="false"
                            aria-controls="collapseLayoutsContributer">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            المدن
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsContributer" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.City.Model', ['create']) }}">اضافة
                                    مدينة
                                    جديدة</a>
                                <a class="nav-link" href="{{ route('admin.City.Data') }}">كل المدن</a>

                            </nav>

                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsCategory" aria-expanded="false"
                            aria-controls="collapseLayoutsCategory">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            التصنيفات
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsCategory" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.Category.Model', ['create']) }}">اضافة
                                    تصنيف
                                    جديد</a>
                                <a class="nav-link" href="{{ route('admin.Category.Data') }}">كل التصنيفات</a>
                            </nav>

                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsUser" aria-expanded="false"
                            aria-controls="collapseLayoutsUser">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            المستخدمين
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsUser" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="{{ route('admin.User.Model', ['view' => 'create', 'type' => 'user']) }}">اضافة
                                    مستخدم
                                    جديد</a>
                                <a class="nav-link" href="{{ route('admin.User.Data', ['type' => 'user']) }}">كل
                                    المستخدمين</a>
                                <a class="nav-link"
                                    href="{{ route('admin.User.notifications', ['type' => 'user']) }}">اشعارات</a>

                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsAdmin" aria-expanded="false"
                            aria-controls="collapseLayoutsAdmin">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            المشرفين
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsAdmin" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="{{ route('admin.User.Model', ['view' => 'create', 'type' => 'admin']) }}">اضافة
                                    مشرف
                                    جديد</a>
                                <a class="nav-link" href="{{ route('admin.User.Data', ['type' => 'admin']) }}">كل
                                    المشرفين</a>

                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsCaptin" aria-expanded="false"
                            aria-controls="collapseLayoutsCaptin">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            كابتن
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsCaptin" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="{{ route('admin.User.Model', ['view' => 'create', 'type' => 'captin']) }}">اضافة
                                    كابتن
                                    جديد</a>
                                <a class="nav-link" href="{{ route('admin.User.Data', ['type' => 'captin']) }}">كل
                                    كابتن</a>
                                <a class="nav-link"
                                    href="{{ route('admin.User.notifications', ['type' => 'captin']) }}">اشعارات</a>

                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsrestaurant" aria-expanded="false"
                            aria-controls="collapseLayoutsrestaurant">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            المطاعم
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsrestaurant" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="{{ route('admin.User.Model', ['view' => 'create', 'type' => 'restaurant']) }}">اضافة
                                    مطعم
                                    جديد</a>
                                <a class="nav-link"
                                    href="{{ route('admin.User.Data', ['type' => 'restaurant']) }}">كل
                                    المطاعم</a>
                                <a class="nav-link"
                                    href="{{ route('admin.User.notifications', ['type' => 'restaurant']) }}">اشعارات</a>

                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsPage" aria-expanded="false"
                            aria-controls="collapseLayoutsPage">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            الصفحات
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsPage" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.Page.Model', ['create']) }}">اضافة
                                    صفحة
                                    جديدة</a>
                                <a class="nav-link" href="{{ route('admin.Page.Data') }}">كل الصفحات</a>

                            </nav>

                        </div>
                        <a class="nav-link" href="{{ route('admin.setting') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            اعدادات الموقع
                        </a>
                        @auth()
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapselogin" aria-expanded="false" aria-controls="collapselogin">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                {{ Auth::user()->name }}
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapselogin" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </nav>
                            </div>
                        @endauth

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main class="d-flex flex-fill">
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; dragon tech 2022</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('script')
</body>

</html>
