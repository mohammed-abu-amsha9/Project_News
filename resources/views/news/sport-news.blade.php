@extends('news.parent')
@section('title', '| الاخبار الرياضية')
@section('content')

<div class="container py-5">

    @if($sportArticles->count())
    <section class="news-section" aria-label="الاخبار الرياضية">
    <h3>الاخبار الرياضية</h3>
    <div class="news-grid">
        @foreach ($sportArticles as $article)
        @php $firstImage = $article->images->first(); @endphp
        <article class="news-card" tabindex="0" role="article" aria-labelledby="news-title-{{ $article->id }}">
            @if($firstImage)
            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}" loading="lazy" />
            @endif
            <div class="news-content">
            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
            <p>{{ \Illuminate\Support\Str::limit($article->Short_description, 130) }}</p>
            </div>
            <footer class="news-footer">
            <a href="{{ route('articles.show', $article->id) }}" class="btn-read" aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
            </footer>
        </article>
        @endforeach
    </div>
    </section>
    @else
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="alert text-white text-center">
            لا يوجد أخبار حالياً.
        </div>
    @endif
</div>

@endsection
