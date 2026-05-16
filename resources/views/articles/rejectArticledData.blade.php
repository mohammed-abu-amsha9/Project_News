@extends('news.parent')
@section('title', '| الاخبار المعلقة')

@section('content')
<div class="container py-5">
    @forelse ($articles as $article)
        <div class="d-flex align-items-start mb-4 p-3 border rounded shadow-sm">

            {{-- صورة المقال (أول صورة فقط) --}}
            @if($article->images->isNotEmpty())
                <img src="{{ asset('storage/' . $article->images->first()->path) }}" alt="صورة المقال" style="width: 160px; height: 120px; object-fit: cover;" class="me-3 rounded">
            @else
                <div style="width: 160px; height: 120px; background: #e9ecef;" class="me-3 rounded d-flex align-items-center justify-content-center text-muted">
                    لا توجد صورة
                </div>
            @endif

            {{-- محتوى المقال --}}
            <div class="flex-grow-1">

                <h5 class="mb-1">{{ $article->title }}</h5>

                <small class="text-muted d-block mb-2">
                    الكاتب: {{ $article->user->name ?? 'غير معروف' }} |
                    التصنيف: {{ $article->category->name }} |
                    {{ $article->created_at->format('Y-m-d') }}
                </small>

                <p class="text-secondary mb-2">{{ $article->Short_description }}</p>

                <div class="d-flex gap-2">
                    <form action="{{ route('articles.publish', $article->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info btn-sm">نشر</button>
                    </form>
                    <form action="{{ route('articles.delete', $article->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-danger">رفض</button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="alert  text-center">
            لا يوجد أخبار حالياً.
        </div>
    @endforelse
</div>
@endsection

