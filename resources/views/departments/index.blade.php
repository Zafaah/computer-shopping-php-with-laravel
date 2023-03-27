@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Department Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New Department</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">No.</th>
          <th>Department Name</th>
          <th>Location</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($departments as $ind=>$department)
            <tr>
              <td> {{ ++$ind }} </td>
              <td> {{ $department->department_name }} </td>
              <td> {{ $department->location }} </td>
              <td>
                <a href="{{route('departments.delete', ['id'=>$department->department_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$department->department_id}}" class="btn btn-primary update">
                  <i class="icon-copy dw dw-edit-1 text-white h6"></i>
                </button>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function(){
    $(".close-model").click(function(){
      $("#id").val('');
      $("#name").val('');
      $("#location").val('');
    });

    $('.update').click(function(){
      $.get(`departments/edit/${this.value}`, function(data){
        $("#id").val(data.department_id);
        $("#name").val(data.department_name);
        $("#location").val(data.location);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="departments/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">    
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new department</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Department Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Department Name" 
                    value="{{ old('name') }}"/>
                  @error('name')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <label>Location</label>
                  <input type="text" class="form-control" id="location" name="location" placeholder="Location" 
                    value="{{ old('name') }}"/>
                  @error('location')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="close-model btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- success model --}}

<div class="modal" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center font-18">
        <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
        {{@session('message')}}
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>

{{-- modal control --}}

  @if ($errors->any())
    <script type="text/javascript">
      $(window).on('load', function() {
        $('#form-model').modal('show');
      });
    </script>
  @endif

  @if (session('message'))
    <script type="text/javascript">
      $(window).on('load', function() {
        $('#success-modal').modal('show');
      });
    </script>
  @endif

@stop
