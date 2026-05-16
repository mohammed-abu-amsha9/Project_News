@extends('news.parent')
@section('styles')
    <!-- CSS إضافي لتحسين الشكل -->
    <style>
        .carousel-image-wrapper {
            height: 85vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .carousel-image-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            /* طبقة شفافة */
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            padding-left: 3rem;
            padding-right: 3rem;
            max-width: 700px;
        }

        @media (max-width: 768px) {
            .carousel-caption h2 {
                font-size: 1.75rem;
            }

            .carousel-caption p {
                font-size: 1rem;
            }
        }
    </style>
    <style>
        .hero-section {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .hero-article-section {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            padding: 80px 0;
            border-bottom-left-radius: 80px;
            border-bottom-right-radius: 80px;
            overflow: hidden;
            position: relative;
        }

        .hero-img {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.5s ease;
        }

        .hero-img:hover {
            transform: scale(1.03);
        }

        .hero-caption h3 {
            font-size: 2.2rem;
            font-weight: bold;
        }

        .hero-caption p {
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .badge-popular {
            background: #ffc107;
            color: #000;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            position: absolute;
            top: -20px;
            left: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        .hero-section {
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
        }

        :root {
            --main-color: #667eea;
            --secondary-color: #843ccc;
            --accent-color: #ffc107;
            --text-light: #ecf0f1;
            --text-dark: #000;
            --font-primary: 'Cairo', sans-serif;
        }

        @media (max-width: 768px) {
            .row {
                display: flex;
                overflow-x: auto;
                gap: 1rem;
                scroll-snap-type: x mandatory;
            }

            .col-lg-4 {
                flex: 0 0 80%;
                scroll-snap-align: start;
            }
        }
    </style>
@endsection
@section('content')
    @if ($mostLikedArticle)
        <section class="main-banner py-5 position-relative"
            style="background: linear-gradient(to right, #2e5c70, #0f2027); overflow: hidden;">
            <!-- ديكورات خلفية -->
            <div
                style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; filter: blur(100px); z-index: 0;">
            </div>
            <div
                style="position: absolute; bottom: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255, 255, 255, 0.07); border-radius: 50%; filter: blur(120px); z-index: 0;">
            </div>

            <div class="container position-relative" style="z-index: 2;">
                <div class="row align-items-center">

                    <!-- النصوص -->
                    <div class="col-md-6 text-white" style="box-shadow: 0 5px 30px rgba(0, 0, 0, 0.20); padding:50px;"
                        data-aos="fade-right">
                        <h1 class="display-4 fw-bold mb-4" style="font-family: 'Cairo', sans-serif; color: rgb(99, 99, 251)">الخبر الأكثر حديثًا
                        </h1>
                        <h3 class="fw-semibold mb-3">{{ $mostLikedArticle->title }}</h3>
                        <p class="lead mb-4" style="line-height: 1.8;">{{ $mostLikedArticle->Short_description }}</p>

                        <div class="d-flex gap-4 mb-4 fs-5">
                            <div><i class="bi bi-hand-thumbs-up-fill text-warning"></i> {{ $mostLikedArticle->likes_count }}
                                إعجاب</div>
                            <div><i class="bi bi-eye-fill text-info"></i> {{ $mostLikedArticle->views }} مشاهدة</div>
                        </div>

                        <a href="{{ route('articles.show', $mostLikedArticle->id) }}"
                            style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color:white;"
                            class="btn fw-bold px-4 py-2 rounded-pill shadow">
                            اقرأ المزيد <i class="bi bi-arrow-left ms-2"></i>
                        </a>
                    </div>

                    <!-- الصورة -->
                    <div class="col-md-6 position-relative" data-aos="fade-left">
                        <div class="rounded-4 overflow-hidden shadow-lg" style="max-height: 450px;">
                            <img src="{{ asset('storage/' . ($mostLikedArticle->images[0]->path ?? auth()->user()->image)) }}"
                                class="img-fluid w-100" style="object-fit: cover; height: 100%;" alt="صورة الخبر">
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <!-- last News -->
    <section class="news-section" aria-label="اخر الاخبار ">
        @if ($lastArticles->count())
            <h3>اخر الاخبار </h3>
            <div class="news-grid">
                @foreach ($lastArticles as $article)
                    @php $firstImage = $article->images->first(); @endphp
                    <article class="news-card" aria-labelledby="news-title-{{ $article->id }}">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}"
                                loading="lazy" />
                        @endif
                        <div class="news-content">
                            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
                            <p>{{ $article->Short_description }}</p>
                        </div>
                        <footer class="news-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn-read"
                                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);"
                                aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
                        </footer>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Local News -->
    <section class="news-section" aria-label="الاخبار المحلية">
        @if ($localArticles->count())
            <h3>الاخبار المحلية</h3>
            <div class="news-grid">
                @foreach ($localArticles as $article)
                    @php $firstImage = $article->images->first(); @endphp
                    <article class="news-card" tabindex="0" role="article"
                        aria-labelledby="news-title-{{ $article->id }}">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}"
                                loading="lazy" />
                        @endif
                        <div class="news-content">
                            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
                            <p>{{ $article->Short_description }}</p>
                        </div>
                        <footer class="news-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn-read"
                                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);"
                                aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
                        </footer>
                    </article>
                @endforeach
                <div style="text-align:center; margin-top: 1.7rem;">
                    <a href="{{ route('news.local') }}" class="btn-read "
                        style="border:none; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color:#fff; padding:10px 30px; border-radius: 30px;">المزيد
                        من
                        الأخبار</a>
                </div>
            </div>
        @endif
    </section>

    <!-- Sport News -->
    <section class="news-section" aria-label="الاخبار الرياضية">
        @if ($sportArticles->count())
            <h3>الاخبار الرياضية</h3>
            <div class="news-grid">
                @foreach ($sportArticles as $article)
                    @php $firstImage = $article->images->first(); @endphp
                    <article class="news-card" tabindex="0" role="article"
                        aria-labelledby="news-title-{{ $article->id }}">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}"
                                loading="lazy" />
                        @endif
                        <div class="news-content">
                            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
                            <p>{{ $article->Short_description }}</p>
                        </div>
                        <footer class="news-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn-read"
                                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);"
                                aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
                        </footer>
                    </article>
                @endforeach
                <div style="text-align:center; margin-top: 1.7rem;">
                    <a href="{{ route('news.sport') }}" class="btn-read"
                        style="border:none; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color:#fff; padding:10px 30px; border-radius: 30px;">المزيد
                        من
                        الأخبار</a>
                </div>
            </div>
        @endif
    </section>

    <!-- International News -->
    <section class="news-section" aria-label="الاخبار العالمية">
        @if ($internationalArticles->count())
            <h3>الاخبار العالمية</h3>
            <div class="news-grid">
                @foreach ($internationalArticles as $article)
                    @php $firstImage = $article->images->first(); @endphp
                    <article class="news-card" tabindex="0" role="article"
                        aria-labelledby="news-title-{{ $article->id }}">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}"
                                loading="lazy" />
                        @endif
                        <div class="news-content">
                            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
                            <p>{{ $article->Short_description }}</p>
                        </div>
                        <footer class="news-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn-read"
                                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);"
                                aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
                        </footer>
                    </article>
                @endforeach
                <div style="text-align:center; margin-top: 1.7rem;">
                    <a href="{{ route('news.international') }}" class="btn-read"
                        style="border:none; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color:#fff; padding:10px 30px; border-radius: 30px;">المزيد
                        من
                        الأخبار</a>
                </div>
            </div>
        @endif
    </section>

    <footer
        style="background: linear-gradient(to right, #2e5c70, #0f2027);
            color: #ecf0f1; padding: 40px 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div
            style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px;">

            <div style="flex: 1 1 250px; min-width: 250px;">
                <h3 style="color: #ffffff; margin-bottom: 15px;">تواصل معنا</h3>
                <p>هل لديك أسئلة؟ نحن هنا لمساعدتك! تواصل معنا عبر الطرق التالية:</p>
                <ul style="list-style: none; padding: 0; margin-top: 20px;">
                    <li style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-map-marker-alt" style="color: #ffffff;"></i>
                        <span>غزة، فلسطين</span>
                    </li>
                    <li style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-phone-alt" style="color: #ffffff;"></i>
                        <a href="tel:+970123456789" style="color: #ecf0f1; text-decoration: none;">+970 597 946 180</a>
                    </li>
                    <li style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-envelope" style="color: #ffffff;"></i>
                        <a href="mailto:info@example.com"
                            style="color: #ecf0f1; text-decoration: none;">mohammedabuamsha8@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div style="flex: 1 1 300px; min-width: 300px;">
                <h3 style="color: #ffffff; margin-bottom: 15px;">ارسل لنا رسالة</h3>
                <form action="{{ route('contact.send') }}" method="POST"
                    style="display: flex; flex-direction: column; gap: 12px;">
                    @csrf
                    <input type="text" name="name" placeholder="اسمك" required
                        style="padding: 10px; border-radius: 6px; border: none; outline: none;">
                    <input type="email" name="email" placeholder="البريد الإلكتروني" required
                        style="padding: 10px; border-radius: 6px; border: none; outline: none;">
                    <textarea name="message" placeholder="رسالتك" rows="3" required
                        style="padding: 10px; border-radius: 6px; border: none; outline: none; resize: vertical;"></textarea>
                    <button type="submit"
                        style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); color: white; border: none; padding: 12px; border-radius: 30px; font-weight: 600; cursor: pointer; transition: background-color 0.3s ease;">
                        ارسال
                    </button>
                </form>
            </div>

        </div>

        <div style="text-align: center; margin-top: 30px; font-size: 14px; color: #ffffff;">
            &copy; {{ date('Y') }} جميع الحقوق محفوظة
        </div>
    </footer>

    <!-- FontAwesome CDN لأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@section('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
@endsection
@endsection
