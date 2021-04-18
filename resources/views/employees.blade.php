@extends('adminlte')
@section('content')
<body>

<div class="container mt-5">
    <h2 class="mb-4">Employees</h2>
     <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Position</th>
                <th>Date of employment</th>
                <th>Phone number</th>
                <th>Email</th>
                <th>Salary</th>
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
                   <input type="hidden" name="employee_id" id="employee_id">



                      <div class="form-group">
                        <label for="image">Choose Image</label>
                          <div id="avatar-image">
                            <img src="" alt="" id="avatar">
                          </div>
                        <input id="image" type="file" name="image" class="form-control" >
                      </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <textarea id="email" name="email" required="" placeholder="Enter Email" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-12">
                            <input id="position" name="position" required="" placeholder="Enter Position" class="form-control"></input>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Salary, $</label>
                        <div class="col-sm-12">
                            <textarea id="salary" name="salary" required="" placeholder="Enter Salary" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Head</label>
                        <div class="col-sm-12">
                            <textarea id="head" name="head" required="" placeholder="" class="form-control" ></textarea>

                        </div>
                    </div>


                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Date Of Employment</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control datePicker" id="employment_date" name="employment_date" placeholder="Enter DateOfEmployment" value="" maxlength="50" required="">

                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class='col-sm-6'>
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                            </div>
                      </div>
                  </div> -->


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
    // $('.edit').click(() => {console.log("boom")})
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employees.list') }}",
        columns: [

            {data: 'image_url', name: 'photo',
            render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"50\"  style=\"border-radius:50%\" \/>";
                    }
            },
            {data: 'full_name', name: 'full_name'},
            {data: 'name', name: 'name'},
            {data: 'employment_date', name: 'employment date'},
            {data: 'phone_number', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'salary', name: 'salary', render: $.fn.dataTable.render.number( ',', '.', 0, '$' )},

            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,

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
       var employee_id = $(this).data('id');
       var url = '{{ route("employees.edit", ":id") }}';
       url = url.replace(":id", employee_id);

       $.get(url, function (data) {
          console.log("boom",data.head_id );
           $('#modelHeading').html("Edit Product");
           $('#saveBtn').val("edit-user");
           $('#ajaxModel').modal('show');
           $('#position_id').val(data.position_name);
           $('#employee_id').val(data.id);
           $('#full_name').val(data.full_name);
           $('#employment_date').val(data.employment_date);
           $('#position').val(data.position_name);
           $('#phone_number').val(data.phone_number);
           $('#email').val(data.email);
           $('#salary').val(data.salary);
           $('#avatar').attr('src', data.image_url);
           if (data.hierarchy != 1)
           {
              $('#head').val(data.head_name);
          }else{
              $('#head').val('Top Manager'). attr('readonly', true);
         };
       })
    });

  $('#saveBtn').click(function (e) {
      e.preventDefault();

      var form = $("#productForm");
      var data = new FormData();
      var files = $("#image").get(0).files;
      if (files.length){
      data.append("image", files[0]);
      }
      $.each(form.serializeArray(), function (key, input) {
      data.append(input.name, input.value);
      });

      $(this).html('Sending..');
      $.ajax({
         data: data,
         url: "{{ route('employees.store') }}",
         type: "POST",
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function (data) {
             $('#saveBtn').html('Save Changes');
             $('#productForm').trigger("reset");
             $('#ajaxModel').modal('hide');
             table.draw();

         },
         error: function (xhr, data) {
              const response = JSON.parse(xhr.responseText);
              $('.alert-danger').html('');
              $.each(response.errors, function(key, value) {
                          console.log('Error:', response.errors);
                           $('.alert-danger').show();
                           $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                       });

             $('#saveBtn').html('Save Changes');
         }
     });
   });


   $('body').on('click', '.deleteProduct', function () {

       var employee_id = $(this).data('id');
       const result =  confirm("Are You sure want to delete !");
       if (result){
         var url = '{{ route("employees.delete", ":id") }}';
         url = url.replace(":id", employee_id);
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

   $('#position').autocomplete({
    source: function( request, response ) {
      // Fetch data
      $.ajax({
        url:"{{route('employees.autocomplete')}}",
        type: 'post',
        dataType: "json",
        headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
        data: {
           search: request.term

        },
        success: function( data ) {
           response( data );
                 }
              });
            },

      select: function (event, ui) {
           // Set selection

        $('#position').val(ui.item.label); // display the selected text
        $('#position_id').val(ui.item.value); // save selected id to input

         return false;
        }
         });


      $('#head').autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('employees.autocomplete')}}",
            type: 'post',
            dataType: "json",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
              data: {
                 search: request.term

              },
              success: function( data ) {
                 response( data );
                       }
                    });
                  },

            select: function (event, ui) {
                 // Set selection

              $('#head').val(ui.item.label); // display the selected text
            

               return false;
              }
               });









</script>

</html>
@endsection
