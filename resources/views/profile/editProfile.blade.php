@extends('news.parent')
@section('title', '| Edit Profile')
@section('styles')

@endsection
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
    <form action="{{ route('users.update', $users->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">الاسم<span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ?? $users->name }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="email">الايميل<span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') ?? $users->email }}" required autofocus>
        </div>

        <div class="col-md-12">
            <label for="role" class="form-label">الدور</label>
            <select id="role"
                    name="role"
                    class="form-control @error('role') is-invalid @enderror">
                <option value="user" @selected(old('role', $users->role) === 'user')>User</option>
                <option value="admin" @selected(old('role', $users->role) === 'admin')>Admin</option>
                <option value="writer" @selected(old('role', $users->role) === 'writer')>Writer</option>
                <option value="editor" @selected(old('role', $users->role) === 'editor')>Editor</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit"  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"  class="btn text-white btn-block mt-4">حفظ التصنيف</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block mt-2">إلغاء</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('implication/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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
