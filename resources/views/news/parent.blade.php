<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>News @yield('title')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('implication/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('implication/css/modern-business.css') }}" rel="stylesheet">
    @yield('styles')
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            position: absolute;
            display: none;
            min-width: 200px;
            z-index: 1000;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            background-color: #2c2f33;
            color: white;
        }

        .dropdown-item:hover {
            background-color: #424549;
        }
    </style>
    <style>
        /* زر العودة للأعلى */
        #backToTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: none;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
            border: none;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            font-size: 28px;
            cursor: pointer;
            z-index: 1050;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        #backToTopBtn:hover {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            transform: scale(1.1);
        }

        /* زر العودة للخلف */
        #goBackBtn {
            position: fixed;
            bottom: 100px;
            /* فوق زر العودة للأعلى */
            right: 30px;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
            border: none;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            font-size: 28px;
            cursor: pointer;
            z-index: 1050;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        #goBackBtn:hover {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            transform: scale(1.1);
        }

        /* أيقونات داخل الأزرار */
        #backToTopBtn i,
        #goBackBtn i {
            pointer-events: none;
            /* لا تؤثر على التفاعل */
        }
    </style>
    <style>
        /* بطاقات الأخبار */
        section.news-section {
            max-width: 1200px;
            margin: 3rem auto 5rem;
            padding: 0 1rem;
        }

        section.news-section h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            color: #444;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.8rem;
        }

        .news-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 30px rgba(102, 126, 234, 0.3);
        }

        .news-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .news-card:hover img {
            transform: scale(1.08);
        }

        .news-content {
            padding: 1.3rem 1.5rem 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-content h4 {
            margin: 0 0 0.7rem;
            font-weight: 700;
            color: #222;
        }

        .news-content p {
            flex-grow: 1;
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        .news-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        .btn-read {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 7px 18px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-read:hover {
            background: #667eea;
            color: #fff;
            box-shadow: 0 8px 18px rgba(102, 126, 234, 0.5);
        }
    </style>
</head>

<body>
    <!-- داخل body - مكان الـ navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top"
        style="background: linear-gradient(135deg, #081215, #203a43, #2c5364);">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
                <i class="fas fa-newspaper me-2"></i>News
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <!-- القوائم العادية -->
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="{{ route('news.local') }}">الأخبار المحلية</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="{{ route('news.international') }}">الأخبار العالمية</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link fw-semibold" href="{{ route('news.sport') }}">أخبار الرياضة</a>
                    </li>

                    <!-- إشعارات -->
                    <li class="nav-item dropdown mx-2 position-relative">
                        <a class="nav-link" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            @php $unreadCount = auth()->user()->unreadNotifications->count() @endphp
                            @if ($unreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                    <span class="visually-hidden">إشعارات جديدة</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow bg-white"
                            aria-labelledby="notificationsDropdown"
                            style="min-width: 300px; max-height: 400px; overflow-y: auto;">

                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="dropdown-item py-2 border-bottom">
                                    <a href="{{ route('articles.drafts') }}"
                                        class="text-decoration-none small text-dark">
                                        <strong>{{ $notification->data['title'] ?? 'إشعار جديد' }}</strong><br>
                                        <small>{{ $notification->data['body'] ?? '' }}</small><br>

                                        <i class="bi bi-hourglass-split me-1"></i> المقالات المعلقة
                                    </a>
                                </li>
                            @empty
                                <li class="dropdown-item text-center text-muted">لا توجد إشعارات جديدة</li>
                            @endforelse

                        </ul>
                    </li>

                    <!-- Dropdown مع submenu -->
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                            role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile"
                                class="rounded-circle" width="38" height="38"
                                style="object-fit: cover; border: 2px solid #6c757d; box-shadow: 0 2px 8px rgba(0,0,0,0.25);">
                            <span class="d-none d-lg-inline text-white fw-semibold">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown"
                            style="background: linear-gradient(135deg, #081215, #203a43, #2c5364); min-width: 250px;">
                            <li>
                                <h6 class="dropdown-header text-white">{{ auth()->user()->name }}، مرحباً</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-light">
                            </li>
                            <li>
                                <a class="dropdown-item text-light" href="{{ route('user.profile') }}"><i
                                        class="fas fa-user me-2"></i> الملف الشخصي</a>
                            </li>

                            @canany(['Create Role', 'Read Role', 'Read Permission'])
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle text-light" href="#">🛡️ الأدوار
                                        والصلاحيات</a>
                                    <ul class="dropdown-menu bg-dark rounded mt-1">
                                        @can('Read Role')
                                            <li><a class="dropdown-item text-light" href="{{ route('roles.index') }}">📋 عرض
                                                    الأدوار</a></li>
                                        @endcan
                                        @can('Create Role')
                                            <li><a class="dropdown-item text-light" href="{{ route('roles.create') }}">➕ إنشاء
                                                    دور</a></li>
                                        @endcan
                                        @can('Read Permission')
                                            <li><a class="dropdown-item text-light" href="{{route('permissions.index')}}">🔐 عرض الصلاحيات</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['Create User', 'Read Users'])
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle text-light" href="#">👥 إدارة
                                        المستخدمين</a>
                                    <ul class="dropdown-menu bg-dark rounded mt-1">
                                        @can('Read Users')
                                            <li><a class="dropdown-item text-light" href="{{ route('users.index') }}">📋 عرض
                                                    المستخدمين</a></li>
                                        @endcan
                                        @can('Create User')
                                            <li><a class="dropdown-item text-light" href="{{ route('users.create') }}">➕
                                                    إنشاء
                                                    مستخدم</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['Create Category', 'Read Categories'])
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle text-light" href="#">🗂 إدارة
                                        التصنيفات</a>
                                    <ul class="dropdown-menu bg-dark rounded mt-1">
                                        <li><a class="dropdown-item text-light" href="{{ route('categories.index') }}">📋
                                                عرض التصنيفات</a></li>
                                        <li><a class="dropdown-item text-light" href="{{ route('categories.create') }}">➕
                                                إضافة تصنيف</a></li>
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['Read Articles', 'Create Article', 'Drafts Article', 'Delete Article'])
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle text-light" href="#">📰 إدارة
                                        المقالات</a>
                                    <ul class="dropdown-menu bg-dark rounded mt-1">
                                        @can('Read Articles')
                                            <li><a class="dropdown-item text-light" href="{{ route('articles.index') }}">📋
                                                    عرض المقالات</a></li>
                                        @endcan
                                        @can('Create Article')
                                            <li><a class="dropdown-item text-light" href="{{ route('articles.create') }}">✍️
                                                    إنشاء مقال</a></li>
                                        @endcan
                                        @can('Drafts Article')
                                            <li><a class="dropdown-item text-light" href="{{ route('articles.drafts') }}">
                                                    <i class="bi bi-hourglass-split me-2"></i> المقالات المعلقة
                                                </a></li>
                                        @endcan
                                        @can('Delete Article')
                                            <li><a class="dropdown-item text-light" href="{{ route('articles.deleted') }}">❌
                                                    المقالات المرفوضة</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['Blocked Comments'])
                                <li><a class="dropdown-item text-light" href="{{ route('blockedComments.index') }}">🚫
                                        التعليقات المحظورة</a></li>
                            @endcanany

                            @canany(['Create User', 'Read Users', 'Create Article', 'Read Articles', 'Drafts Article',
                                'Delete Article', 'Create Category', 'Read Categories', 'Blocked Comments'])
                                <hr class="dropdown-divider border-light">
                            @endcanany

                            <li><a class="dropdown-item text-white fw-bold" href="{{ route('edit-password') }}"><i
                                        class="fas fa-key me-2"></i> تغيير كلمة المرور</a></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="{{ route('logout') }}"><i
                                        class="fas fa-sign-out-alt"></i> تسجيل الخروج</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    <!-- زر ارجع لفوق -->
    <button id="backToTopBtn" title="العودة للأعلى">
        <i class="fas fa-arrow-up"></i>
    </button>
    <button id="goBackBtn" title="العودة للخلف">
        <i class="fas fa-arrow-left"></i>
    </button>
    {{-- أزرار العودة لاعلى وللخلف --}}
    <script>
        // زر العودة للأعلى
        const backToTopBtn = document.getElementById("backToTopBtn");
        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }
        });
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // زر العودة للخلف
        const goBackBtn = document.getElementById("goBackBtn");
        goBackBtn.addEventListener('click', () => {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/'; // عدل الرابط حسب الصفحة الرئيسية
            }
        });
    </script>
    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #081215, #203a43, #2c5364);" class="py-5 ">
        <div class="container">
            <p class="m-0 text-center text-white"> &copy; Mohammed Abu Amsha 2022</p>
        </div>
        <!-- /.container -->
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('implication/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('implication/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // إغلاق أي قائمة مفتوحة مسبقًا
                    document.querySelectorAll('.dropdown-submenu .dropdown-menu').forEach(function(
                        submenu) {
                        if (submenu !== this.nextElementSibling) {
                            submenu.classList.remove('show');
                        }
                    }.bind(this));

                    // فتح/إغلاق القائمة التابعة
                    let submenu = this.nextElementSibling;
                    if (submenu) {
                        submenu.classList.toggle('show');
                    }
                });
            });
        });
    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('implication/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('implication/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu > a');

            dropdownSubmenus.forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var submenu = el.nextElementSibling;
                    if (submenu) {
                        // Toggle submenu visibility
                        if (submenu.classList.contains('show')) {
                            submenu.classList.remove('show');
                        } else {
                            // Close other open submenus at this level
                            var openSubmenus = el.closest('.dropdown-menu').querySelectorAll(
                                '.show');
                            openSubmenus.forEach(function(open) {
                                open.classList.remove('show');
                            });
                            submenu.classList.add('show');
                        }
                    }
                });
            });

            // Close all submenus when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu .show').forEach(function(submenu) {
                    submenu.classList.remove('show');
                });
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
