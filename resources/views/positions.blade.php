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



<div class="modal fade" id="ajaxModel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                   <input type="hidden" name="position_id" id="position_id">


                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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









  $('#createNewProduct').click(function () {
       $('#saveBtn').val("create-product");
       $('#avatar').attr('src', '');
       $('#product_id').val('');
       $('#productForm').trigger("reset");
       // $('#productForm').data.reload();
       $('#modelHeading').html("Create New Product");
       $('#ajaxModel').modal('show');
   });


   $('body').on('click', '.editProduct', function () {
         $('.alert-danger').hide()

        var position_id = $(this).data('id');
        var url = '{{ route("positions.edit", ":id") }}';
        url = url.replace(":id", position_id);

        $.get(url, function (data) {
           console.log("boom",data.head_id );
            $('#modelHeading').html("Edit Product");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#name').val(data.name);
            $('#position_id').val(data.id);
        })
     });



     $('#saveBtn').click(function (e) {
         e.preventDefault();

         var form = $("#productForm");
         var data = new FormData();
         $.each(form.serializeArray(), function (key, input) {
         data.append(input.name, input.value);
         });

         $(this).html('Sending..');
         $.ajax({
            data: data,
            url: "{{ route('positions.store') }}",
            type: "POST",
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $('#saveBtn').html('Save Changes');
                $('#productForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                console.log('da drovaysya tu');

            },
            error: function (xhr, data) {
                 const response = JSON.parse(xhr.responseText);
                 $('.alert-danger').html('');
                 $.each(response.errors, function(key, value) {
                             console.log('Error:', response.errors);
                              $('.alert-danger').show();
                              $('.alert-danger').append('<strong><li>'+value+'</li></strong></div>');

                          });

                $('#saveBtn').html('Save Changes');
            }
        });
      });


      $('body').on('click', '.deleteProduct', function () {

          var position_id = $(this).data('id');
          const result =  confirm("Are You sure want to delete !");
          if (result){
            var url = '{{ route("positions.delete", ":id") }}';
            url = url.replace(":id", position_id);
            $.ajax({
                 headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                type: "DELETE",
                url: url,
                success: function (data) {

                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
          }


      });

    });



</script>




@endsection
