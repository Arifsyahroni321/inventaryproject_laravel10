@extends('layouts.index')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            max-height: 400px;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-dropdown {
            z-index: 9999 !important;
        }

        .btn-group .btn {
            margin-right: 5px;
            /* Add spacing between buttons */
        }
    </style>

    <div class="card ">
        <div class="card-body">
            <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal"
                data-bs-target="#modalDialogScrollable">
                + Add
            </button>
            <div class="table-responsive pt-1">
                <table id="stockouts-table" class="table table-of-contents">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Stockin</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Added </th>
                            <th>Description</th>
                            <th>ِAction</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDialogScrollable" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form action="{{ route('stockin.store') }}" method="POST">
                    @csrf <!-- Token CSRF Laravel -->
                    <div class="modal-header">
                        <h5 class="modal-title">Add Stock In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambah_product_id" class="form-label">Product</label>
                            <select class="form-select select2" name="product_id" id="tambah_product_id" required>
                                <option value="" disabled selected>Chose Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_user_id" class="form-label">user</label>
                            <select class="form-select select2" name="removed_by" id="tambah_user_id" required>
                                <option value="" disabled selected>Chose user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"
                                placeholder="Insert Description Product"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label"> Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                placeholder="Insert Total Stock">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editStockoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="editStockoutForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Stock Out</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_product_id" class="form-label">stockout</label>
                            <select class="form-select select2" name="product_id" id="edit_product_id" required>
                                <option value="" disabled selected>Chose Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_user_id" class="form-label">user</label>
                            <select class="form-select select2" name="removed_by" id="edit_user_id" required>
                                <option value="" disabled selected>Chose user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="edit_description" rows="3"
                                placeholder="Insert Description Product"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label"> Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="edit_quantity"
                                placeholder="Insert Total Stock">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label"> Date</label>
                            <input type="date" class="form-control" name="date" id="edit_date"
                                placeholder="Insert Date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- detail/ show  --}}
    <div class="modal fade" id="showStockoutModal" tabindex="-1" aria-labelledby="showStockoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showStockoutModalLabel">Detail Stockout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Stockout</th>
                            <td id="id-stockout"></td>
                        </tr>
                        <tr>
                            <th>Name product</th>
                            <td id="stockout-product-name"></td>
                        </tr>
                        <tr>
                            <th>Removed by</th>
                            <td id="stockou-user-name"></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td id="stockout-desc"></td>
                        </tr>
                        <tr>
                            <th>Date Stockout</th>
                            <td id="stockout-date"></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td id="stockout-quantity"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="stockout-created-at"></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td id="stockout-updated-at"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- //end detail --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#stockouts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/stockin') }}',
                // ajax: '{{ route('stockout.index') }}',
                columns: [
                    {
                        data:null,
                        name:'no',
                        render: function(data, type, row, meta){
                            return meta.row + 1;
                        },
                        orderable:false,
                        searchable:false
                    },
                    {
                        data: 'id_stockin',
                        name: 'id_stockin'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }

                ]
            });
        });
    </script>
    <script>
        //date format  only per date, month & year
        function formatDate(dateString) {
            if (!dateString) return '';
            let date = new Date(dateString);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            let year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
        //alert berhasil atau gagal
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
        //edit form
        $('body').on('click', '.btn-edit', function() {
            let stockout_Id = $(this).data('id');
            $.ajax({
                url: `/stockout/${stockout_Id}/edit`,
                method: 'GET',
                success: function(data) {
                    console.log(data);

                    $('#edit_product_id').val(data.product_id).trigger('change');
                    $('#edit_user_id').val(data.removed_by).trigger('change');
                    $('#edit_description').val(data.description);
                    $('#edit_quantity').val(data.quantity);
                    $('#edit_date').val(data.date);

                    $('#editStockoutForm').attr('action', `/stockout/${data.id_stockout}`);
                    $('#editStockoutModal').modal('show');
                },
                error: function(err) {
                    console.log(err.responseText); // Debug jika ada error
                    alert('Gagal mengambil data stockout!');
                }
            });
        });
        // select2
        $('#editStockoutModal').on('shown.bs.modal', function() {
            $('#edit_product_id,#edit_user_id').select2({
                placeholder: "Pilih ",
                allowClear: true,
                dropdownParent: $('#editStockoutModal')
            });
        });
        $('#modalDialogScrollable').on('shown.bs.modal', function() {
            $('#tambah_product_id, #tambah_user_id').select2({
                placeholder: "Pilih",
                allowClear: true,
                dropdownParent: $('#modalDialogScrollable')
            });
        });

        // Submit Form untuk Edit Produk
        $('#editStockoutForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                method: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    $('#editStockoutModal').modal('hide');
                    $('#stockouts-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Stockout has been updated!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let errorMessages = errors ? Object.values(errors).flat().join('\n') :
                        'there is error!';

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessages
                    });
                }
            });
        });
        //hapus
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are You sure Delete this?',
                text: "You can not return it !",
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
        //detail show modal
        $(document).on('click', '.btn-info', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#id-stockout').text(response.id_stockout);
                    $('#stockout-product-name').text(response.product ? response.product.name :
                        'Uncategorized');
                    $('#stockou-user-name').text(response.user ? response.user.name : 'Uncategorized');
                    $('#stockout-desc').text(response.description);
                    $('#stockout-date').text(formatDate(response.date));
                    $('#stockout-quantity').text(response.quantity);
                    $('#stockout-created-at').text(formatDate(response.created_at));
                    $('#stockout-updated-at').text(formatDate(response.updated_at));
                    $('#showStockoutModal').modal('show');

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
        function formatDate(dateString) {
            if (!dateString) return '-'; // Jika tidak ada tanggal, tampilkan "-"

            let date = new Date(dateString);
            return date.toISOString().split('T')[0]; // Mengambil hanya YYYY-MM-DD
        }
    </script>
@endsection
