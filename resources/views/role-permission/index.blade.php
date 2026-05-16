@extends('news.parent')
@section('title', '| عرض الادوار')

@section('content')
    <div class="container my-5" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>الادوار</h2>
            <a href="{{ route('roles.create') }}" class="btn btn-success">➕ إضافة دور جديد</a>
        </div>
        {{-- جدول الادوار --}}
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th> الدور</th>
                    <th> نوع المستخدم</th>
                    <th> الصلاحيات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>{{ $role->permissions_count }}</td>
                        <td>
                            <div class="btn-group d-flex gap-1">
                                <a href="{{ route('roles.show', $role->id) }}" type="button" class="btn btn-primary"><i
                                        class="fas fa-user-shield"></i></a>
                                <a href="" type="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">لا توجد ادوار حتى الآن.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
