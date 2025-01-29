@extends('layouts.index')
@section('content')
<style>
    .btn {
            margin-right: 5px;
            /* Add spacing between buttons */
        }
</style>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Table Users</h5>

                <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal"
                    data-bs-target="#modalDialogScrollable">
                    <b> + Add </b>
                </button>

                <!-- Table with stripped rows -->
                <div class="table-responsive pt-1">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created</th>
                                <th scope="col">updated</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = ($kt->currentPage() - 1) * $kt->perPage() + 1;
                            @endphp
                            @forelse ($kt as $user)
                                <tr>
                                    <th scope="row">{{ $no++ }}</th>
                                    <td>{{ $user->id_user }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $user->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div  class="btn-group">
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm editCategory"
                                            data-id="{{ $user->id_user }}">
                                            <i class="bi-pen-fill"></i>
                                        </a>
               {{-- <a href="/product/' . $row->id_product . '" class="btn btn-sm btn-info " title="Lihat"><i class="bi-eye-fill"></i></a> --}}
                                        <a href="{{ route('user.show', $user->id_user) }}" class="btn btn-info btn-sm"><i
                                                class="bi-eye-fill"></i></a>
                                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST"
                                            style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                    class="bi-trash-fill"></i></button>
                                        </form>
                                        {{-- <a class="btn btn-danger btn-sm "><i class="bi-trash-fill"></i></a> --}}
                                    </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No categori found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $kt->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- formmm modal --}}
    <div class="modal fade" id="modalDialogScrollable" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf <!-- Token CSRF Laravel -->
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="id_user" class="col-sm-2 col-form-label">ID User</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_user" id="id_user"
                                    placeholder="Enter category id_user">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter category name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Enter category username">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Passwrod</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter category password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Enter category email">
                            </div>
                        </div>
                        <fieldset class="row mb-3">
                            <label class="col-form-label col-sm-2 pt-0" for="role">Role</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="admin"
                                        value="admin">
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="petugas"
                                        value="petugas">
                                    <label class="form-check-label" for="petugas">
                                        Petugas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="pegawai"
                                        value="pegawai">
                                    <label class="form-check-label" for="pegawai">
                                        Pegawai
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="edit_id_user" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_user" id="edit_id_user">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="edit_name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="edit_username">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password" id="edit_password ">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_email" class="col-sm-2 col-form-label">email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="edit_email">
                            </div>
                        </div>
                        <fieldset class="row mb-3">
                            <label class="col-form-label col-sm-2 pt-0" for="role">Role</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="edit_admin"
                                        value="admin">
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="edit_petugas"
                                        value="petugas">
                                    <label class="form-check-label" for="petugas">
                                        Petugas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="edit_pegawai"
                                        value="pegawai">
                                    <label class="form-check-label" for="pegawai">
                                        Pegawai
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- detail user --}}
    <div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showUserModalLabel">Detail Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID User</th>
                            <td id="user-id-user"></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td id="user-name"></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td id="user-username"></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td id="user-password"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="user-email"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td id="user-role"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="created-at"></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td id="updated-at"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Event untuk tombol Edit//
        $('.editCategory').on('click', function() {
            var id = $(this).data('id');
            var url = '{{ route('user.edit', ':id') }}'.replace(':id', id);

            $.get(url, function(data) {
                $('#edit_id_user').val(data.id_user);
                $('#edit_name').val(data.name);
                $('#edit_username').val(data.username);
                $('#edit_password').val(data.password);
                $('#edit_email').val(data.email);
                if (data.role === 'admin') {
                    $('#edit_admin').prop('checked', true);
                } else if (data.role === 'petugas') {
                    $('#edit_petugas').prop('checked', true);
                } else if (data.role === 'pegawai') {
                    $('#edit_pegawai').prop('checked', true);
                }

                var updateUrl = '{{ route('user.update', ':id') }}'.replace(':id', id);
                $('#editUserForm').attr('action', updateUrl);

                $('#modalEditUser').modal('show');
            });
        });


        //alert
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure delete this User?',
                text: "you can't return this item!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        $(document).on('click', '.btn-info', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#user-id-user').text(response.id_user);
                    $('#user-name').text(response.name);
                    $('#user-username').text(response.username);
                    $('#user-passwrod').text(response.passwrod);
                    $('#user-email').text(response.email);
                    $('#user-role').text(response.role);
                    $('#created-at').text(response.created_at);
                    $('#updated-at').text(response.updated_at);
                    $('#showUserModal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
