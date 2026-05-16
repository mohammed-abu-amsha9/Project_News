@extends('news.parent')
@section('title', 'الملف الشخصي')

@section('styles')
    <!-- Cropper CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-header {
            background: linear-gradient(to right, #2e5c70, #0f2027);
            color: white;
            padding: 2rem 1rem;
            border-radius: 0 0 1.5rem 1.5rem;
            text-align: center;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .profile-header img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .profile-name {
            margin-top: 1rem;
            font-size: 2.4rem;
            font-weight: 700;
        }

        .profile-info {
            background: linear-gradient(135deg, #4ab2df, #1d7492, #121314);
            padding: 2rem;
            border-radius: 1rem;
            max-width: 720px;
            margin: -70px auto 2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        }

        .info-item {
            font-size: 1.1rem;
            color: #555;
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .btn-edit {
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.6rem;
            border-radius: 50px;
        }

        .btn-edit:hover {
            color: rgba(255, 255, 255, 0.521)
        }
    </style>
@endsection

@section('content')
    <header class="profile-header">
        <!-- صورة المستخدم مع فتح المودال -->
        <img src="{{ asset('storage/' . $users->image) }}" alt="صورة المستخدم" id="profileImagePreview" data-bs-toggle="modal"
            data-bs-target="#cropImageModal" />

        <h1 class="profile-name">{{ $users->name }}</h1>
        <p class="profile-role text-white">
            @php
                $user = Auth::user();
                $guardName = $user->hasRole('Content Managment')
                    ? 'مشرف'
                    : ($user->hasRole('News Publisher')
                        ? 'كاتب'
                        : ($user->hasRole('Project Editor')
                            ? 'محرر'
                            : 'مستخدم عادي'));
            @endphp
            {{ $guardName }}
        </p>
    </header>

    <section class="profile-info">
        <h3 class="d-flex justify-content-end text-white">معلومات شخصية</h3>

        <div class="info-item text-white">
            <i class="fas fa-user"></i>
            <span>البريد الالكتروني: <u>{{ $users->email }}</u></span>
        </div>

        <div class="info-item text-white">
            <i class="fas fa-map-marker-alt"></i>
            <span>العنوان: {{ $users->location }}</span>
        </div>

        <div class="info-item text-white">
            <i class="fas fa-calendar"></i>
            <span>تاريخ التسجيل: {{ $users->created_at->format('d-m-Y') }}</span>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('users.edit', $users->id) }}"
                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);" class="btn btn-edit">تعديل الملف
                الشخصي</a>
        </div>
    </section>

    <section class="news-section">
        @if ($articles->count())
            <h3>منشوراتي</h3>
            <div class="news-grid">
                @foreach ($articles as $article)
                    @php $firstImage = $article->images->first(); @endphp
                    <article class="news-card" aria-labelledby="news-title-{{ $article->id }}">
                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->path) }}" alt="صورة {{ $article->title }}"
                                loading="lazy" />
                        @endif
                        <div class="news-content">
                            <h4 id="news-title-{{ $article->id }}">{{ $article->title }}</h4>
                            <p>{{ $article->Short_description }}</p>
                        </div>
                        <footer class="news-footer">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn-read"
                                style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);"
                                aria-label="اقرأ المزيد عن {{ $article->title }}">اقرأ المزيد</a>
                        </footer>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <!-- 🟡 Crop Modal لقص الصورة -->
    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="cropForm" method="POST" enctype="multipart/form-data"
                class="modal-content shadow rounded-4 border-0 overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="modal-header bg-gradient bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-crop-alt me-2"></i> تعديل الصورة الشخصية
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 text-center bg-light">
                    <p class="mb-3 text-muted">
                        حدد الجزء المناسب من الصورة ثم اضغط "حفظ".
                    </p>

                    <div class="d-flex justify-content-center">
                        <div class="border rounded shadow-sm overflow-hidden" style="max-width: 100%; max-height: 400px;">
                            <img id="imageToCrop" src="{{ asset('storage/' . $users->image) }}" class="img-fluid"
                                style="max-height: 400px; object-fit: contain;">
                        </div>
                    </div>

                    <input type="hidden" name="cropped_image" id="croppedImageInput">
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-white border-top-0 justify-content-between px-4 py-3">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>

                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </button>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- CropperJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        let cropper;
        const modal = document.getElementById('cropImageModal');

        modal.addEventListener('shown.bs.modal', () => {
            const image = document.getElementById('imageToCrop');
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        });

        modal.addEventListener('hidden.bs.modal', () => {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('cropForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
            });

            canvas.toBlob(function(blob) {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');
                formData.append('cropped_image', blob);

                fetch("{{ route('users.cropImage', $users->id) }}", {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            document.getElementById('profileImagePreview').src = data.image_url +
                                '?v=' + Date.now();
                            bootstrap.Modal.getInstance(modal).hide();
                        }
                    });
            }, 'image/jpeg');
        });
    </script>
@endsection
