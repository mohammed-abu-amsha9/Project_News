<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تفعيل البريد الإلكتروني</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="{{ asset('implication/dist/css/bootstrap.rtl.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('implication/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('implication/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('implication/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
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
            max-width: 500px;
            width: 100%;
            padding: 50px;
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
        <div class="verify-box text-center">
            <div class="mb-4">
                <i class="fas fa-envelope fa-3x text-primary"></i>
            </div>
            <h4 class="mb-3">تفعيل البريد الإلكتروني</h4>

            <p class=" mb-4">البريد الإلكتروني غير مفعل. يرجى النقر على الزر أدناه لإرسال رابط التحقق.</p>

            <form method="GET" action="{{ route('verification.request') }}">
                @csrf
                <button type="submit" class="btn  w-100 mb-3">
                    <i class="fas fa-paper-plane me-2"></i>إرسال رابط التفعيل
                </button>
            </form>
        </div>
    </div>
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
