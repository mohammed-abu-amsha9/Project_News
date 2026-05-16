@extends('news.parent')
@section('title', '| تعديل التصنيف')

@section('content')
    <div class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center">إنشاء تصنيف جديد</h2>

    {{-- عرض رسائل الأخطاء --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- نموذج الإضافة --}}
    <form action="{{ route('categories.update', $categories->id) }}" method="POST"
        class="p-4" style="box-shadow: -5px 2px  72px -22px rgba(0, 0, 0, 0.285); border-radius:10px;" >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">اسم التصنيف <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="أدخل اسم التصنيف" value="{{ old('name') ?? $categories->name}}" required autofocus>
        </div>

        <button type="submit"  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"  class="btn text-white btn-block mt-4">حفظ التصنيف</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-block mt-2">إلغاء</a>
    </form>
</div>
@endsection
@section('scripts')
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
