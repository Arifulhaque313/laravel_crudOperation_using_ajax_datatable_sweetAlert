@extends('layouts.app')
@section('content')


<div class="mt-5">
<div id="success_message" class></div>
<div class="card">
    <div class="card-header">
    <div class="row">
        <div class="col-6">

        </div>
        <div class="col-6 text-end px-5 py-2">
            <button  type="button"  class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#addStudent">Add Student</button>
        </div>
    </div>
    </div>

    <div class="card-body">
      <table class="table table-border table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>

        <tbody>
  
        </tbody>
      </table>
    </div>

</div>
</div>


<!-- Add Student Modal -->
<div class="modal modal-lg fade" id="addStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div >
          <ul id="saveform_errlist"></ul>
      </div>
      <div class="modal-body">
            <form action="">
                    <div class="mb-3">
                      <label for="" class="form-label">Name</label>
                      <input type="text" name="name" class="form-control name">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control email">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Mobile</label>
                      <input type="text" name="mobile" class="form-control mobile">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">password</label>
                      <input type="password" name="password" class="form-control password">
                    </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_students">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->


<!-- Edit Student Modal -->
<div class="modal modal-lg fade" id="editStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div >
          <ul id="update_errlist"></ul>
      </div>
      <div class="modal-body">
            <form action="">

                    <input type="hidden" name="id" id="id" >
                    <div class="mb-3">
                     
                      <label for="" class="form-label">Name</label>
                      <input type="text" name="name" id="name" class="form-control name">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Email</label>
                      <input type="email" name="email" id="email"  class="form-control email">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Mobile</label>
                      <input type="text" name="mobile" id="mobile"  class="form-control mobile">
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">password</label>
                      <input type="text" name="password" id="password" class="form-control password">
                    </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary studentUpdate">Update</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->


<!-- delete modal  -->

<div class="modal fade" id="deleteStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
      <div class="modal-body">
        Are You Sure ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="deleteStudentmodal btn btn-danger">Confirm Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- end delete modal  -->


@endsection



@section('script')

  <script>

    var deleteId = null;
    $(document).ready(function(){

      fetchStudent();
      function fetchStudent(){

        $.ajax({
          type: "get",
          url: "{{route('fetchStudent')}}",
          dataType: "json",
          success: function (response) {
              console.log(response.students);
              $('tbody').html('')
              $.each(response.students, function (key, items) { 
                 $('tbody').append(
                  '<tr>\
                      <td>'+items.id+'</td>\
                      <td>'+items.name+'</td>\
                      <td>'+items.email+'</td>\
                      <td>'+items.phone+'</td>\
                      <td><button type="button" value="'+items.id+'" class="editStudent btn btn-primary btn-sm">edit</button></td>\
                      <td><button type="button" value="'+items.id+'" class="deleteStudent btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudent" >delete</button></td>\
                    </tr>'
                 );
              });
          }
        });
      }

      // edit fetch section 
     $(document).on('click','.editStudent',function(e){
        var id = $(this).val();
        $('#editStudent').modal('show');
        $.ajax({
          type: "get",
          url: "{{route('student.edit')}}",
          data:{
            id:id,
            _token: '{{csrf_token()}}',
          },
          success: function (response) {

            if(response.status == 404 ){
              $('#success_message').html("");
              $('#success_message').addClass("alert alert_danger");
              $('#success_message').text(response.message);
            }
            else{
                $('#id').val(response.student.id);
                $('#name').val(response.student.name);
                $('#email').val(response.student.email);
                $('#mobile').val(response.student.phone);
                $('#password').val(response.student.password);
            }
          }
        });
        // 
     }); 
     // edit fetch section
    
    

     // update section 
    $(document).on('click','.studentUpdate',function(e){
       e.preventDefault(); 
       $(this).text("updating....")
       var data = {
         'id':$('#id').val(),
         'name':$('#name').val(),
         'email':$('#email').val(),
         'mobile':$('#mobile').val(),
         'password':$('#password').val(),
       }

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });

       $.ajax({
         type: "put",
         url: "{{route('student.update')}}",
         data: data,
         dataType: "json",
         success: function (response) {
          //  console.log(response);
          if(response.status == 400){
            $('#update_errlist').html("");
            $('#update_errlist').addClass("alert alert-danger");

            $.each(response.errors,function(key,err_values){
              $('#update_errlist').append('<li>'+err_values+'</li>')
              });
              $('.studentUpdate').text("updating....");
          }

          else if(response.status == 404){
            $('#update_errlist').html("");
                  $('#success_message').addClass("alert alert-danger");
                  $('#success_message').text(response.message);

                  $('.studentUpdate').text("updating....");
          } 

          else{
            $('#update_errlist').html("");
            $('#success_message').html("");
                  $('#success_message').addClass("alert alert-success");
                  $('#success_message').text(response.message);
                  
                  $('#editStudent').modal('hide');
                  $('#editStudent').find('input').val("");
                  $('.studentUpdate').text("updating....");
                  fetchStudent();
          }

         }
       });
    });
    // end update script 




    // delete ajax 

      $(document).on('click','.deleteStudent',function(){
        deleteId = $(this).val();
        
      });

      $(document).on('click','.deleteStudentmodal',function(e){
        $.ajax({
          type: "delete",
          url: "{{route('student.delete')}}",
          data: {
            id:deleteId,
            _token: '{{csrf_token()}}',
          },
          success: function (response) {
              if(response.status == 200){
                $('#success_message').html("");
                $('#success_message').addClass("alert alert-danger");
                $('#success_message').text(response.message);
                $('#deleteStudent').modal('hide');
                fetchStudent();
              }
          }
        });
        
      });
    // delete ajax end  







      // add student script 
        $('.add_students').on('click',function(e){
          e.preventDefault();

          var data = {
            'name': $('.name').val(),
            'email': $('.email').val(),
            'mobile': $('.mobile').val(),
            'password': $('.password').val()
          }

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });

          $.ajax({
            type:"post",
            url:"{{ route('students.store')}}",
            data:data,
            dataType:"json",
            success: function(response){
              
              if(response.status == 400){
                $('#saveform_errlist').html("");
                $('#saveform_errlist').addClass("alert alert-danger");

                $.each(response.errors,function(key,err_values){
                  $('#saveform_errlist').append('<li>'+err_values+'</li>')
                });
              }
              else {
                  $('#saveform_errlist').html("");
                  $('#success_message').addClass("alert alert-success");
                  $('#success_message').text(response.message);
                  $('#addStudent').modal('hide');
                  $('#addStudent').find('input').val("");
                  fetchStudent();
              }
            }
          });  
        });
    });
  </script>

@endsection

<!-- <script>
    $(document).ready(function(){
        $('.add_students').on('click',function(e){
          e.preventDefault();

          var data = {
            'name': $('.name').val(),
            'email': $('.email').val(),
            'mobile': $('.mobile').val(),
            'password': $('.password').val()
          }

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });

          $.ajax({
            type:"post",
            url:"{{ route('students.store')}}",
            data:data,
            dataType:"json",
            success: function(response){
              
              if(response.status == 400){
                $('#saveform_errlist').html("");
                $('#saveform_errlist').addClass("alert alert-danger");

                $.each(response.errors,function(key,err_values){
                  $('#saveform_errlist').append('<li>'+err_values+'</li>')
                });
              }
              else {
                  $('#saveform_errlist').html("");
                  $('#success_message').addClass("alert alert-success");
                  $('#success_message').text(response.message);
                  $('#addStudent').modal('hide');
                  $('#addStudent').find('input').val("");
              }
            }
          });   
        });
    });
  </script> -->