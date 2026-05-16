@extends('news.parent')
@section('title', '| بيانات الخبر')

@section('styles')
    <style>
        .article-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .article-title {
            font-weight: 700;
            border-bottom: 3px solid #667eea;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        .carousel-inner img {
            max-height: 450px;
            object-fit: cover;
            border-radius: 12px;
        }

        .short-desc {
            background: #f0f4ff;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: #666;
            font-style: italic;
            margin-bottom: 1.8rem;
            font-size: 1.1rem;
        }

        .article-content {
            line-height: 1.8;
            font-size: 1.15rem;
            color: #444;
            margin-bottom: 2rem;
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 1.3rem;
            color: #555;
            font-size: 0.9rem;
        }

        .article-meta i {
            color: #667eea;
            font-size: 1.1rem;
        }

        .btn-like {
            background: #667eea;
            border: none;
            color: #fff;
            transition: background 0.3s ease;
        }

        .btn-like:hover {
            background: #5a67d8;
        }

        .comments-wrapper {
            display: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.5s ease;
            opacity: 0;
            margin-top: 1.5rem;
        }

        .comments-wrapper.active {
            display: block;
            max-height: 5000px;
            opacity: 1;
        }

        .comment {
            background: #fafafa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .comment-header img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
        }

        .comment-author {
            font-weight: 600;
            color: #2c3e50;
        }

        .comment-date {
            font-size: 0.85rem;
            color: #999;
        }

        .comment-text {
            color: #555;
            font-size: 1rem;
            line-height: 1.4;
            white-space: pre-line;
        }

        .dropdown-menu li button,
        .dropdown-menu li form button {
            width: 100%;
            text-align: start;
        }

        #emoji-picker button {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .like-comment-btn {
            border: none;
            background: none;
            color: #e0245e;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .like-comment-btn:hover {
            color: #c2185b;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
@endsection

@section('content')
    <div class="container py-5">
        <div class="article-container">
            <h1 class="article-title">{{ $article->title }}</h1>

            @if ($article->images->count())
                <div class="row mb-4 g-3">
                    @foreach ($article->images as $image)
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ asset('storage/' . $image->path) }}" class="glightbox" data-gallery="article-images">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="صورة الخبر"
                                    class="img-fluid rounded shadow-sm"
                                    style="object-fit: cover; height: 200px; width: 100%;">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <p class="short-desc">{{ $article->Short_description }}</p>
            <div class="article-content">{!! nl2br(e($article->info)) !!}</div>

            <div class="article-meta mb-4 d-flex align-items-center flex-wrap gap-3">
                <img src="{{ asset('storage/' . $article->user->image) }}" alt="Profile" class="rounded-circle"
                    width="30" height="30" style="object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.25);">
                <span><i class="bi bi-person"></i> {{ $article->user->name ?? 'مجهول' }}</span>
                <span><i class="bi bi-tag"></i> {{ $article->category->name }}</span>
                <span><i class="bi bi-calendar"></i> {{ $article->created_at->format('d-m-Y') }}</span>
                <span><i class="bi bi-eye"></i> {{ $article->views }}</span>
                <span><i class="bi bi-hand-thumbs-up"></i> {{ $article->likes->count() }}</span>
                <button id="toggle-comments" class="btn btn-info ms-auto" type="button">
                    <i class="bi bi-chat-left-text"></i> التعليقات ({{ $article->comments->count() }})
                </button>
            </div>

            <form action="{{ route('articleLikes.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <button type="submit" class="btn btn-like"><i class="bi bi-hand-thumbs-up"></i> إعجاب</button>
            </form>

            <div class="">
                <form action="{{ route('comments.store') }}" method="POST" class="mb-4 position-relative">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea id="comment-input" name="comment" class="form-control" rows="3" placeholder="اكتب تعليقك..."></textarea>

                    <button type="button" id="emoji-btn" class="btn btn-light position-absolute"
                        style="top: 8px; right: 8px;">😊</button>

                    <div id="emoji-picker"
                        style="display:none; position:absolute; right: 8px; top: 50px; background: #fff; border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;">
                        <button type="button" onclick="insertEmoji('😀')">😀</button>
                        <button type="button" onclick="insertEmoji('😂')">😂</button>
                        <button type="button" onclick="insertEmoji('😍')">😍</button>
                        <button type="button" onclick="insertEmoji('🔥')">🔥</button>
                        <button type="button" onclick="insertEmoji('👍')">👍</button>
                        <button type="button" onclick="insertEmoji('🙏')">🙏</button>
                    </div>

                    <button class="btn btn-primary mt-2" style="width: 100px" type="submit"><i
                            class="fas fa-paper-plane"></i></button>
                </form>

                @foreach ($article->comments as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            <img src="{{ asset('storage/' . ($comment->user->image ?? 'default-avatar.png')) }}"
                                alt="{{ $comment->user->name ?? 'مجهول' }}">
                            <div>
                                <h6 class="comment-author mb-0">{{ $comment->user->name ?? 'مجهول' }}</h6>
                                <small class="comment-date"
                                    title="{{ $comment->created_at->format('d/m/Y H:i') }}">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="comment-text mt-2">{{ $comment->comment }}</p>
                        {{-- <form action="{{route('commentLikes.store')}}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <button type="submit" class="like-comment-btn">
                                ❤️ {{ $comment->likes->count() ?? 0 }}
                            </button>
                        </form> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
        const toggleBtn = document.getElementById('toggle-comments');
        const commentsSection = document.querySelector('.comments-wrapper');
        const emojiBtn = document.getElementById('emoji-btn');
        const emojiPicker = document.getElementById('emoji-picker');
        const commentInput = document.getElementById('comment-input');

        toggleBtn.addEventListener('click', () => {
            commentsSection.classList.toggle('active');
        });

        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiPicker.style.display = (emojiPicker.style.display === 'none' || emojiPicker.style.display === '') ?
                'block' : 'none';
        });

        function insertEmoji(emoji) {
            const start = commentInput.selectionStart;
            const end = commentInput.selectionEnd;
            const text = commentInput.value;
            commentInput.value = text.slice(0, start) + emoji + text.slice(end);
            commentInput.focus();
            commentInput.selectionEnd = start + emoji.length;
        }

        document.addEventListener('click', function(event) {
            if (!emojiPicker.contains(event.target) && event.target !== emojiBtn) {
                emojiPicker.style.display = 'none';
            }
        });
    </script>
@endsection
