@extends('layout.global')

@section('title')
    Product
@endsection

@section('pagetitle')
    Products
@endsection

@section('pagetitledes')
    You have {{$total}} total product.
@endsection

@section('content')

<div class="card card-bordered card-preview">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabItem1">List Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabItem2">Create Product</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tabItem1">
                <div class="card-inner">
                    @if(session('status'))
                        <div class="alert alert-fill alert-icon alert-success alert-dismissible" role="alert">
                            <em class="icon ni ni-check-circle"></em>
                            {{session('status')}}
                            <button class="close" data-dismiss="alert"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover yajra">
                            <thead>
                                <th>No</th>
                                <th>Nama Product</th>
                                <th>stock</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tabItem2">
                <div class="card-inner">
                    <form id="product_store" action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="product_name">Product Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="product_name" name='product_name' placeholder="Input Product Name" required>
                            </div>
                            <br>
                            <label class="form-label" for="price">Price</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="price" name='price' placeholder="Input Price" required>
                            </div>
                            <br>
                            <div class='float-right'>
                                <button class='btn btn-round btn-primary' type='submit'>Save</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div><!-- .card-preview -->
@endsection

@section('scripts')

    <script>
        $('#product_store').validate();

        function deleteProduct(id){
            Swal.fire({
                title: 'Warning!',
                text: 'Do you want to Delete this Product?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
            }).then((result) =>{
                if(result.value){
                    Swal.fire(
                        'Deleted!',
                        'Your Product has been deleted.',
                        'success'
                    )
                    $.ajax({
                        type: "get",
                        url: "/product/delete/"+id,
                        success: function (response) {
                            $('.alert').replaceWith('');

                            $('.yajra').DataTable().clear().destroy();

                            $('.yajra').DataTable({
                                processing: true,
                                serverSide: true,
                                responsive: true,
                                colReorder: true,
                                buttons: [
                                    'copy', 'excel', 'pdf','colvis',
                                ],
                                dom: 'Bfrtip',
                                bStateSave: true,
                                ajax: "{{ route('product.all') }}",
                                columns: [
                                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                    {data: 'vehicle_name', name: 'vehicle_name'},
                                    {data: 'stock', name: 'stock'},
                                    {data: 'price', name: 'price'},
                                    {
                                        data: 'action', 
                                        name: 'action', 
                                        orderable: true, 
                                        searchable: true
                                    },
                                ]
                            });
                        }
                    });
                }
            })
        }

        $('.yajra').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            colReorder: true,
            buttons: [
                'copy', 'excel', 'pdf','colvis',
            ],
            dom: 'Bfrtip',
            bStateSave: true,
            ajax: "{{ route('product.all') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'vehicle_name', name: 'vehicle_name'},
                {data: 'stock', name: 'stock'},
                {data: 'price', name: 'price'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });
    </script>
@endsection
