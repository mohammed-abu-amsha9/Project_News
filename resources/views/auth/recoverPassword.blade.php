<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تسجيل الدخول - News</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('implication/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/dist/css/bootstrap-5.3.0-dist/css/bootstrap.min.css') }}">
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
            max-width: 1000px;
            width: 50%;
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
            font-size: 55px;
            margin-bottom: 30px;
            color: #00c6ff;
            text-align: center;
        }

        .form-side form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-side input {
            padding: 15px;
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
            <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                <div class="input-group">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                تغيير كلمة المرور
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-white text-decoration-none">
                    <i class="fas fa-arrow-right"></i> العودة لتسجيل الدخول
                </a>
            </div>
        </form>
        </div>

        <div class="image-side"></div>
    </div>
</body>

</html>




