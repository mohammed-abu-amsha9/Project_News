@extends('news.parent')

@section('title', '| Create User')

@section('styles')
    {{-- phone --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />
@endsection

@section('content')
    <div class="container my-5" style="max-width: 600px;">
        <h2 class="mb-4 text-center">إنشاء مستخدم جديد</h2>

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
        <form action="{{ route('users.store') }}" enctype="multipart/form-data" method="POST" novalidate class="p-4"
            style="box-shadow: -5px 2px  72px -22px rgba(0, 0, 0, 0.285); border-radius:10px;">
            @csrf
            {{-- رفع صورة --}}
            <div class="mb-3 text-center position-relative" style="width: 200px; margin: auto;">
                {{-- صورة المستخدم --}}
                <img id="profileImage" src="{{ asset('implication/img/avatar4.png') }}" alt="صورة المستخدم"
                    class="rounded-circle border"
                    style="width: 150px; height: 150px; object-fit: cover; cursor: pointer; box-shadow: 5px 5px 15px rgba(0,0,0,0.15);">

                {{-- أيقونة تعديل الصورة --}}
                <label for="image"
                    class="position-absolute top-100 start-50 translate-middle bg-primary rounded-circle p-2 text-white"
                    style="cursor: pointer; border: 2px solid white;">
                    <i class="fas fa-camera"></i>
                </label>

                {{-- input file مخفي --}}
                <input type="file" class="d-none @error('image') is-invalid @enderror" id="image" name="image"
                    accept="image/*">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                        autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">الايميل</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- رقم الهاتف --}}
            <div class="mb-3">
                <label for="input_mobile" class="form-label">رقم الهاتف</label>
                <input type="tel" id="input_mobile" name="mobile"
                    class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- العنوان --}}
            <div class="mb-3">
                <label for="location" class="form-label">العنوان</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" id="location" name="location" placeholder="بيت حانون - شارع البنات"
                        class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required
                        autofocus>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- الدور --}}
            <div class="mb-3">
                <label for="role-id" class="form-label">الدور</label>
                <select id="role-id" name="role-id" class="form-select @error('role-id') is-invalid @enderror">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }} </option>
                    @endforeach

                </select>
                @error('role-id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                class="btn text-white w-100 mt-4">حفظ المستخدم</button>
        </form>
    </div>
@endsection

@section('scripts')
    {{-- مكتبة الهاتف --}}
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        const input = document.querySelector("#input_mobile");
        if (input) {
            const iti = window.intlTelInput(input, {
                initialCountry: "ps",
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
            });
        }
    </script>
    <script>
        // عند اختيار صورة جديدة، يتم تحديث المعاينة فوراً
        document.getElementById('image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('profileImage').src = URL.createObjectURL(file);
            }
        });

        // اختياري: يمكن إضافة تأثير hover على الصورة
        const profileImage = document.getElementById('profileImage');
        profileImage.addEventListener('mouseenter', () => {
            profileImage.style.opacity = '0.9';
        });
        profileImage.addEventListener('mouseleave', () => {
            profileImage.style.opacity = '1';
        });
    </script>
    <script src="{{ asset('implication/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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
