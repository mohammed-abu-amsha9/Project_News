@extends('news.parent')

@section('title', '| Edit Permission')

@section('styles')
    {{-- phone --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />
@endsection

@section('content')
    <div class="container my-5" style="max-width: 600px;">
        <h2 class="mb-4 text-center">تعديل الصلاحية</h2>
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
        <form action="{{route('permissions.update', $permission->id)}}" enctype="multipart/form-data" method="POST" novalidate
            class="p-4" style="box-shadow: -5px 2px  72px -22px rgba(0, 0, 0, 0.285); border-radius:10px;">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">الصلاحية</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $permission->name}}"
                        required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                class="btn text-white w-100 mt-4">حفظ التغيير</button>
        </form>
    </div>
@endsection

@section('scripts')
    {{-- مكتبة الهاتف --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            bsCustomFileInput.init();
        });

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
