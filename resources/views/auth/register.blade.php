<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تسجيل الدخول - News</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('implication/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Google Font & Bootstrap 5 RTL -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('implication/dist/css/bootstrap.rtl.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('implication/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4);
            max-width: 700px;
            width: 40%;
            flex-wrap: wrap;
        }

        .form-side {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
        }

        .form-side h1 {
            font-size: 42px;
            margin-bottom: 30px;
            color: #00c6ff;
            text-align: center;
        }

        .form-side form {
            display: flex;
            flex-direction: column;
            /* gap: 20px; */
        }

        .form-side input {
            /* padding: 15px; */
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 16px;
            transition: 0.3s;
        }

        .form-side input::placeholder {
            color: #ccc;
        }

        .form-side input:focus {
            background: rgba(255, 255, 255, 0.2);
            outline: none;
        }

        .form-side button {
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .form-side button:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .form-side a {
            text-align: center;
            color: #aadfff;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
        }

        .form-side hr {
            border: none;
            height: 1px;
            background-color: #444;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column-reverse;
            }

            .image-side {
                min-height: 200px;
            }

            .form-side {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-side">
            <h1 style="font-family: 'Script MT';">News</h1>
            <form action="{{ route('add-user') }}" enctype="multipart/form-data" method="POST" novalidate
                class="p-4">
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
                    <input type="file" class="d-none @error('image') is-invalid @enderror" id="image"
                        name="image" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" id="name" name="name" placeholder="Enter Name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">الايميل</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" placeholder="Enter Email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- رقم الهاتف --}}
                <div class="mb-3">
                    <label for="input_mobile" class="form-label">رقم الهاتف</label>
                    <input type="tel" id="input_mobile" name="mobile" placeholder="Mobile"
                        class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Password"
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
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location') }}" required autofocus>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn text-white w-100 mt-4">حفظ المستخدم</button>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none ">
                        <i class="fas fa-arrow-right"></i> العودة لتسجيل الدخول
                    </a>
                </div>
            </form>
        </div>

        <div class="image-side"></div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('implication/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('implication/plugins/toastr/toastr.min.js') }}"></script>
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

</body>

</html>
