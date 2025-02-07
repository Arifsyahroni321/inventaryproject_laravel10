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
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable">
                Tambah
            </button>
            <div class="table-responsive pt-1">
                <table id="productTable" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>minimum stock level</th>
                            {{-- <th>Tanggal Dibuat</th>
                            <th>Tanggal Diubah</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDialogScrollable" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf <!-- Token CSRF Laravel -->
                    <div class="modal-header">
                        <h5 class="modal-title">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_product" class="form-label">ID Product</label>
                            <input type="text" class="form-control" name="id_product" id="id_product"
                                placeholder="Insert ID Category">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name Product</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Insert Name Product">
                        </div>
                        <div class="mb-3">
                            <label for="tambah_categori_id" class="form-label">Category</label>
                            <select class="form-select select2" name="categori_id" id="tambah_categori_id" required>
                                <option value="" disabled selected>Chose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_categori }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" name="desc" id="desc" rows="3" placeholder="Insert Description Product"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Masukkan Price Produk">
                        </div>
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" name="stock_quantity" id="stock_quantity"
                                placeholder="Insert Total Stock">
                        </div>
                        <div class="mb-3">
                            <label for="minimum_stock_level" class="form-label">Minimum Stock Level</label>
                            <input type="number" class="form-control" name="minimum_stock_level" id="minimum_stock_level"
                                placeholder="Insert Minimum Stock Level">
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
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="editProductForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_product" name="id_product">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Product</label>
                            <input type="text" class="form-control" name="name" id="edit_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_categori_id" class="form-label">Categori</label>
                            <select class="form-select select2" name="categori_id" id="edit_categori_id">
                                <option value="" disabled selected>Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_categori }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_desc" class="form-label">Description</label>
                            <textarea class="form-control" name="desc" id="edit_desc"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="edit_price">
                        </div>
                        <div class="mb-3">
                            <label for="edit_stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" name="stock_quantity" id="edit_stock_quantity">
                        </div>
                        <div class="mb-3">
                            <label for="edit_minimum_stock_level" class="form-label">Minimum Stock Level</label>
                            <input type="number" class="form-control" name="minimum_stock_level"
                                id="edit_minimum_stock_level">
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
    <div class="modal fade" id="showProductModal" tabindex="-1" aria-labelledby="showProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showProductModalLabel">Detail Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Product</th>
                            <td id="product-id"></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td id="product-name"></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td id="product-category"></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td id="product-desc"></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td id="product-price"></td>
                        </tr>
                        <tr>
                            <th>Stock Quantity</th>
                            <td id="product-stock-quantity"></td>
                        </tr>
                        <tr>
                            <th>Minimum Stock Level</th>
                            <td id="product-minimum-stock-level"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="product-created-at"></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td id="product-updated-at"></td>
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
        // datatables yajra
        $(document).ready(function() {
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.data') }}',
                columns: [{
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Menambahkan nomor otomatis berdasarkan urutan
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id_product',
                        name: 'id_product'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'desc',
                        name: 'desc'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'stock_quantity',
                        name: 'stock_quantity'
                    },
                    {
                        data: 'minimum_stock_level',
                        name: 'minimum_stock_level'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
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
            let productId = $(this).data('id');
            $.ajax({
                url: `/product/${productId}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#edit_id_product').val(data.id_product);
                    $('#edit_name').val(data.name);
                    $('#edit_categori_id').val(data.categori_id);
                    $('#edit_desc').val(data.desc);
                    $('#edit_price').val(data.price);
                    $('#edit_stock_quantity').val(data.stock_quantity);
                    $('#edit_minimum_stock_level').val(data.minimum_stock_level);

                    $('#editProductForm').attr('action', `/product/${data.id_product}`);
                    $('#editProductModal').modal('show');
                },
                error: function(err) {
                    alert('Gagal mengambil data produk!');
                }
            });
        });
        // select2
        $('#editProductModal').on('shown.bs.modal', function() {
            $('#edit_categori_id').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                dropdownParent: $('#editProductModal')
            });
        });
        $('#modalDialogScrollable').on('shown.bs.modal', function() {
            $('#tambah_categori_id').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                dropdownParent: $('#modalDialogScrollable')
            });
        });
        // Submit Form untuk Tambah Produk
        // $('#modalDialogScrollable form').on('submit', function(e) {
        //     e.preventDefault();
        //     let form = $(this);
        //     let actionUrl = form.attr('action');

        //     $.ajax({
        //         url: actionUrl,
        //         method: 'POST',
        //         data: form.serialize(),
        //         success: function(response) {
        //             $('#modalDialogScrollable').modal('hide');
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Succes!',
        //                 text: 'Product has been added!',
        //                 timer: 2000,
        //                 showConfirmButton: false
        //             }).then(() => {
        //                 window.location.reload(); // Refresh halaman setelah sukses
        //             });
        //         },
        //         error: function(xhr) {
        //             let errors = xhr.responseJSON?.errors;
        //             let errorMessages = errors ? Object.values(errors).flat().join('\n') :
        //                 'Terjadi kesalahan!';
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Gagal!',
        //                 text: errorMessages
        //             });
        //         }
        //     });
        // });
        // Submit Form untuk Edit Produk
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                method: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    $('#editProductModal').modal('hide');
                    $('#productTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product has been updated!',
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
                    $('#product-id').text(response.id_product);
                    $('#product-name').text(response.name);
                    $('#product-category').text(response.category ? response.category.name :
                        'Uncategorized');
                    $('#product-desc').text(response.desc);
                    $('#product-price').text(response.price);
                    $('#product-stock-quantity').text(response.stock_quantity);
                    $('#product-minimum-stock-level').text(response.minimum_stock_level);
                    $('#product-created-at').text(response.created_at);
                    $('#product-updated-at').text(response.updated_at);
                    $('#showProductModal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
