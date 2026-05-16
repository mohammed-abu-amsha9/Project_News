    @extends('news.parent')
    @section('styles')
        <style>
            body {
                background: linear-gradient(135deg, #764ba2 0%, #764ba2 100%);
                font-family: 'Cairo', sans-serif;
            }

            .password-box {
                max-width: 500px;
                margin: 80px auto;
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            }

            .form-control:focus {
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.3);
                border-color: #764ba2;
            }

            .btn-primary {
                background-color: #764ba2;
                border: none;
            }

            .btn-primary:hover {
                background-color: #5a3d84;
            }
        </style>
    @endsection

    @section('content')
        <div class="password-box">
            <h4 style="color: #764ba2" class="text-center mb-4"><i class="fas fa-key me-2"></i>تعديل كلمة المرور</h4>

            <form action="{{ route('update-password') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- كلمة المرور الحالية -->
                <div class="mb-3">
                    <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                        <input type="password" name="old-password" class="form-control" required>
                    </div>
                </div>

                <!-- كلمة المرور الجديدة -->
                <div class="mb-3">
                    <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="new-password" class="form-control" required>
                    </div>
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="mb-3">
                    <label for="new-password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <input type="password" name="new-password_confirmation" class="form-control" required>
                    </div>
                </div>

                <!-- زر الحفظ -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    @endsection
    @section('scripts')
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
