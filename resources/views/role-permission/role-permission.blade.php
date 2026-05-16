@extends('news.parent')
@section('title', '| عرض الادوار')
@section('styles')
    <link rel="stylesheet" href="{{ asset('implication/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
@section('content')
    <div class="container my-5" style="max-width: 900px;">
        {{-- جدول الادوار --}}
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th> الدور</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="permission_{{ $permission->id }}"
                                    onchange="upadteRolePermission('{{ $permission->id }}')" @checked($permission->assigned)>
                                <label for="permission_{{ $permission->id }}"></label>
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
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function upadteRolePermission(permissionId) {
            axios.put('{{ route('role-update-permission') }}',{
                permission_id: permissionId,
                role_id: '{{ $role->id }}'
            })
                .then(response => {
                    toastr.success(response.data.message)
                })
                .catch(error => {
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection
