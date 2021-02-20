@extends('layout.global')

@section('title')
    Sales
@endsection

@section('pagetitle')
    Sales
@endsection

@section('pagetitledes')
    You have {{$total}} total Sales.
@endsection

@section('content')

<div class="card card-bordered card-preview">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabItem1">List Sales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabItem2">Create Sales</a>
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
                                <th>Sales Number</th>
                                <th>Total</th>
                                <th>Buyer Name</th>
                                <th>Buyer Email</th>
                                <th>Buyer Telp</th>
                                <th>Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tabItem2">
                <div class="card-inner">
                    <form id="purchaseStore" action="{{route('sales.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="full-name-1">Sales Number</label>
                                    <div class="form-control-wrap">
                                        <input type="text" name='so_number' class="form-control" id="full-name-1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="bname">Buyer Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="buyer_name" id="bname" value='' required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="bmail">Buyer Email</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" name="buyer_email" id="bmail" value='' required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="buyer_telp">Buyer Telp</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="buyer_telp" id="buyer_telp" value='' required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="40%">Product Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id='tbody'>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm" id="addProduct">add product</a>
                                            </td>
                                        </tr>
                                        <tr class="tr" id="tr1">
                                            <td>
                                                <select name="product_id[1]" class="form-control select_product">
                                                    <option value="-">--Choose One--</option>
                                                    @foreach($product as $item)
                                                        <option value="{{$item->id}}">{{$item->vehicle_name}}</option>s
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="price[1]"class="form-control price" required>
                                            </td>
                                            <td>
                                                <input type="number" name="qty[1]" class="form-control qty" required>
                                            </td>
                                            <td>
                                                <input type="number" name="subtotal[1]" class="form-control total" required>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" onclick="remove(1)"><span class="icon ni ni-trash"></span></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br><br>
                                <div class="form-group float-right">
                                    <button type="reset" class="btn btn-round btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-round btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div><!-- .card-preview -->
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#purchaseStore').validate();
            $("#addProduct").click(function(){
                var len = $('.tr').length + 1;
                var html = '';
                html +='<tr class="tr" id="tr'+len+'">'
                html +='<td>'
                html +='<select name="product_id['+len+']" class="form-control select_product">'
                html +='<option value="-">--Choose One--</option>'
                html +='@foreach($product as $item)'
                html +='<option value="{{$item->id}}">{{$item->vehicle_name}}</option>'
                html +='@endforeach'
                html +='</select>'
                html +='</td>'
                html +='<td>'
                html +='<input type="number" name="price['+len+']"class="form-control price" required>'
                html +='</td>'
                html +='<td>'
                html +='<input type="number" name="qty['+len+']" class="form-control qty" required>'
                html +='</td>'
                html +='<td>'
                html +='<input type="number" name="subtotal['+len+']" class="form-control total" required>'
                html +='</td>'
                html +='<td>'
                html +='<button class="btn btn-danger" onclick="remove('+len+')"><span class="icon ni ni-trash"></span></button>'
                html +='</td>'
                html +='</tr>'
                $('#tbody').append(html);
                // $('.select_product').select2();
                $('.select_product').on('change', function() {
                    var th = $(this).parent().parent().children().find('.price')
                    $.ajax({
                        type: "post",
                        
                        url: "/product/price",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id:this.value
                        },
                        success: function (response) {
                            var price;
                            price = response.price;
                            th.val(Number(price));
                        }
                    });
                });

                $('.qty').on('change',function(){
                    price = $(this).parent().parent().children().find('.price').val();
                    qty = this.value;
                    total = price * qty;
                    var th = $(this).parent().parent().children().find('.total').val(total);
                });
            }); 

            $('.select_product').on('change', function() {
                var th = $(this).parent().parent().children().find('.price')
                $.ajax({
                    type: "post",
                    
                    url: "/product/price",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id:this.value
                    },
                    success: function (response) {
                        var price;
                        price = response.price;
                        th.val(Number(price));
                    }
                });
            });

            $('.qty').on('change',function(){
                price = $(this).parent().parent().children().find('.price').val();
                qty = this.value;
                total = price * qty;
                var th = $(this).parent().parent().children().find('.total').val(total);
            });
        });


        // $('.select_product').select2();
        $('#purchaseStore').validate();

        function remove(id){
            $('#tr'+id).replaceWith('');
        }

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
                        url: "/sales/delete/"+id,
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
                                ajax: "{{ route('sales.all') }}",
                                columns: [
                                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                    {data: 'so_number', name: 'so_number'},
                                    {data: 'total', name: 'total'},
                                    {data: 'buyer_name', name: 'buyer_name'},
                                    {data: 'buyer_email', name: 'buyer_email'},
                                    {data: 'buyer_telp', name: 'buyer_telp'},
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
            ajax: "{{ route('sales.all') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'so_number', name: 'so_number'},
                {data: 'total', name: 'total'},
                {data: 'buyer_name', name: 'buyer_name'},
                {data: 'buyer_email', name: 'buyer_email'},
                {data: 'buyer_telp', name: 'buyer_telp'},
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
