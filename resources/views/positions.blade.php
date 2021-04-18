@extends('adminlte')
@section('content')
<body>

<div class="container mt-5">
    <h2 class="mb-4">Positions</h2>
     <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>
    <table class="table table-bordered yajra-datatables ">
        <thead>
            <tr>
                <th>Name</th>
                <th>Last update</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


</body>
<script type="text/javascript">



  $(function () {
    console.log("boom")
    var table = $('.yajra-datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('positions.list') }}",
        columns: [

            {data: 'name', name: 'name'},
            {data: 'updated_at', name: 'updated_at'},


            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },

        ]
    });






  });

</script>

</html>
@endsection
