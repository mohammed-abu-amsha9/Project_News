@extends('news.parent')
@section('title', '| Read User')

@section('content')
    <div class="container my-5" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>المستخدمين</h2>
            <a href="{{ route('users.create') }}" class="btn btn-success">➕ إضافة مستخدم جديد</a>
        </div>

        {{-- عرض رسالة نجاح (إذا موجودة) --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- جدول التصنيفات --}}
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>الايميل</th>
                    <th>الموبايل</th>
                    <th>الدور</th>
                    <th>الصلاحيات</th>
                    <th>صلاحيات الاب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->roles[0]->name ?? '-' }}</td>
                        <td>{{ $user->permissions_count }}</td>
                        <td>{{ $user->getAllPermissions()->count() }}</td>
                        <td>
                            <div class="btn-group d-flex gap-1">
                                <a href="{{ route('users.permissions.edit', $user->id) }}" type="button" class="btn btn-primary"><i class="fas fa-user-shield"></i></a>
                                <a href="{{ route('users.edit', $user->id) }}" type="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا يوجد مستخدمين</td>
                    </tr>
                    <tr>
                        <td colspan="6">لا توجد تصنيفات حتى الآن.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
