@extends('news.parent')

@section('title', 'اتصل بنا')

@section('styles')
    <style>
        body {
            background: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contact-container {
            max-width: 600px;
            margin: 3rem auto;
            background: #ffffff;
            padding: 2.5rem 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4a47a3;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            letter-spacing: 1px;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: none !important;
            border: 1.8px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a47a3;
            box-shadow: 0 0 8px rgba(74, 71, 163, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.7rem;
            font-weight: 700;
            border-radius: 50px;
            width: 100%;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .input-group-text {
            background: #667eea;
            border: none;
            color: white;
            border-radius: 8px 0 0 8px;
        }

        .alert-success {
            border-radius: 10px;
            font-weight: 600;
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            margin-bottom: 1.5rem;
            text-align: center;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }
    </style>
@endsection

@section('content')
    <div class="contact-container shadow-sm">
        <h2>تواصل معنا</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="" method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                        placeholder="أدخل اسمك الكامل">
                </div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                        placeholder="example@example.com">
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="subject" class="form-label">الموضوع <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="text" id="subject" name="subject"
                        class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required
                        placeholder="موضوع الرسالة">
                </div>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="message" class="form-label">الرسالة <span class="text-danger">*</span></label>
                <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                    required placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                إرسال الرسالة
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
