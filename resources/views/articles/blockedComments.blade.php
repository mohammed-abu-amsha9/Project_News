@extends('news.parent')
@section('title', '| مراجعة التعليقات المحظورة')
@section('styles')
<style>
    .badge.bg-danger {
        font-size: 0.8rem;
        vertical-align: middle;
    }
    .btn-outline-primary i, .btn-danger i {
        vertical-align: middle;
    }
    .border-danger {
        border-width: 2px !important;
    }
</style>

@endsection
@section('content')
    <div class="container py-4">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="alert text-white text-center mb-4">
            <h4>مراجعة التعليقات المحظورة</h4>
            <p class="text-center mb-0" >عدد التعليقات المحظورة ({{ $article->count() }})</p>
        </div>

        @forelse ($article as $comments)
            <div class="mb-3 p-3 bg-white rounded shadow-sm d-flex justify-content-between align-items-start border border-danger position-relative" style="opacity: 0.9;">
                <div>
                    <strong>{{ $comments->user ? $comments->user->name : 'مجهول' }}</strong>
                    <span class="badge bg-danger ms-2" title="تعليق محظور">
                        <i class="fas fa-ban"></i> محظور
                    </span>
                    <p class="mb-1 mt-2" style="white-space: pre-line; color:#555;">{{ $comments->comment }}</p>
                    <small class="text-muted">{{ $comments->created_at->diffForHumans() }}</small>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <form action="{{ route('comments.recover', $comments->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="استعادة">
                            <i class="fas fa-undo-alt me-1"></i> استرجاع
                        </button>
                    </form>
                    <form action="{{ route('comments.destroy', $comments->id) }}" method="post" onsubmit="return confirm('هل أنت متأكد من حذف التعليق نهائياً؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                            <i class="fas fa-trash-alt me-1"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">لا توجد تعليقات محظورة حالياً.</p>
        @endforelse
    </div>

@endsection
@section('scripts')
<script>
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const commentId = this.getAttribute('data-comment-id');
            document.getElementById('parent_id').value = commentId;
            document.querySelector('textarea[name="comment"]').focus();
        });
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            bsCustomFileInput.init();
        });

        // إشعارات Toastr باستخدام Swal كما في كودك
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        const status = @json(session('status'));
        const icon = @json(session('icon'));
        const message = @json(session('message'));

        if (status) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }

        @if ($errors->any())
            let errorMessages = {!! json_encode($errors->all()) !!};
            Toast.fire({
                icon: 'error',
                html: errorMessages.join('<br>')
            });
        @endif
    </script>
@endsection

