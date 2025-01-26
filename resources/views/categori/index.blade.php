@extends('layouts.index')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Table Catagories</h5>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable">
                    Add
                </button>

                <!-- Table with stripped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">created</th>
                            <th scope="col">updated</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = ($kt->currentPage() - 1) * $kt->perPage() + 1;
                        @endphp
                        @forelse ($kt as $customer)
                            <tr>
                                <th scope="row">{{ $no++ }}</th>
                                <td>{{ $customer->id_categori }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>{{ $customer->updated_at }}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm editCategory"
                                        data-id="{{ $customer->id_categori }}">
                                        <i class="bi-pen-fill"></i>
                                    </a>
                                    <form action="{{ route('categori.destroy', $customer->id_categori) }}" method="POST"
                                        style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-button"
                                            ><i class="bi-trash-fill"></i></button>
                                    </form>
                                    {{-- <a class="btn btn-danger btn-sm "><i class="bi-trash-fill"></i></a> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No categori found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                <form action="{{ route('categori.store') }}" method="POST">
                    @csrf <!-- Token CSRF Laravel -->
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="id_categori" class="col-sm-2 col-form-label">ID Categori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_categori" id="id_categori"
                                    placeholder="Enter category id_categori">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter category name">
                            </div>
                        </div>
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
    <div class="modal fade" id="modalEditCategory" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="editCategoryForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close btn-lg" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="edit_id_categori" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_categori" id="edit_id_categori">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="edit_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="edit_name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Event untuk tombol Edit
        $('.editCategory').on('click', function() {
            var id = $(this).data('id');
            var url = '{{ route('categori.edit', ':id') }}'.replace(':id', id);

            $.get(url, function(data) {
                $('#edit_id_categori').val(data.id_categori);
                $('#edit_name').val(data.name);

                var updateUrl = '{{ route('categori.update', ':id') }}'.replace(':id', id);
                $('#editCategoryForm').attr('action', updateUrl);

                $('#modalEditCategory').modal('show');
            });
        });

        //alert
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
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
            title: 'Are you sure delete this category?',
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


    </script>
@endsection
