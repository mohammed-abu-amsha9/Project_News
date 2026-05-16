@extends('news.parent')
@section('title', '| اضافة خبر')

@section('content')
    <div class="container my-5" style="max-width: 800px;">
    <h2 class="mb-4 text-center">✍️ إضافة مقال جديد</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>حدثت الأخطاء التالية:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data"
        class="p-4" style="box-shadow: -5px 2px  72px -22px rgba(0, 0, 0, 0.285); border-radius:10px;" >
    @csrf

    <div class="form-group">
        <label for="category_id">التصنيف</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- اختر تصنيف --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="title">عنوان الخبر</label>
        <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
    </div>

    <div class="form-group">
        <label for="info">المحتوى الكامل</label>
        <textarea name="info" class="form-control" rows="7" required>{{ old('info') }}</textarea>
    </div>

    <div class="form-group">
        <label for="Short_description">وصف مبسط للخبر</label>
        <input type="text" name="Short_description" class="form-control" required value="{{ old('Short_description') }}">
    </div>

    <div class="col-md-12">
    <label for="image" class="form-label">صور الخبر</label>
    <input
        type="file"
        class="form-control @error('image') is-invalid @enderror"
        id="image"
        name="images[]"
        accept="image/*"
        multiple>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- صندوق عرض الصور -->
<div id="previewImages" style="margin-top: 15px; display: flex; flex-wrap: wrap; gap: 10px;"></div>



    <button type="submit"  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"  class="btn text-white btn-block">💾 نشر المقال</button>
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
<script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('previewImages');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = ''; // نظف الصندوق قبل عرض الصور الجديدة

        const files = this.files;
        if (files.length === 0) return;

        Array.from(files).forEach(file => {
            if(!file.type.startsWith('image/')) return; // يتجاهل غير الصور

            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
                previewContainer.appendChild(img);
            }

            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
