@extends('news.parent')
@section('title', '| جميع الاخبار')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">جميع الأخبار</h2>

    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                @if($article->images->first())
                    <img src="{{ asset('storage/' . $article->images->first()->path) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text text-muted">{{ $article->Short_description }}</p>
                    <p class="card-text mt-auto">
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ optional($article->user)->name ?? 'مجهول' }} |
                            <i class="bi bi-calendar"></i> {{ $article->created_at->format('Y-m-d') }}
                        </small>
                    </p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline-primary btn-sm mt-2">اقرأ المزيد</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

