@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Users Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New User</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">User ID</th>
          <th>Username</th>
          <th>Employee ID</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
            <tr>
              <td> {{ $user->user_id }} </td>
              <td> {{ $user->username }} </td>
              <td> {{ $user->employee_id }} </td>
              <td>
                @if ($user->status=='active')
                  <span class="badge bg-success text-white">{{ $user->status }}</span> 
                @else
                    <span class="badge bg-danger text-white">{{ $user->status }}</span>
                @endif
              </td>
              <td>
                <a href="{{route('users.delete', ['id'=>$user->user_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$user->user_id}}" class="btn btn-primary update" >
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
      $("#username").val('');
      $("#password").val('--Select gender--');
      $("#employee_id").val('');
      $("#status").val('');
    });

    $('.update').click(function(){
      $.get(`users/edit/${this.value}`, function(data){
        console.log(data);
        $("#id").val(data.user_id);
        $("#username").val(data.username);
        $("#password").val(data.password);
        $("#employee_id").val(data.employee_id);
        $("#status").val(data.status);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="users/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new user</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" 
                  value="{{ old('username') }}"
                  />
                  @error('username')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Employee ID</label>
                  <select class="form-control" id="employee_id" name="employee_id" style="width: 100%;" value={{old('employee_id')}}>
                    <option value="">--Select Employee--</option>
                    @foreach ($employees as $employee)
                        <option value="{{$employee->employee_id}}">
                          {{$employee->employee_id}} - {{$employee->employee_name}}
                        </option>
                    @endforeach
                  </select>
                  @error('employee_id')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" id="password"  name="password" class="form-control" placeholder="********"  value="{{ old('password') }}"
                  >
                  @error('password')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status</label>
                  <select  id="status" name="status" class="form-control"value="{{ old('status') }}"
                  >
                    <option value="">--Select Status--</option>
                    <option value="active">Active</option>
                    <option value="inactive">In Active</option>
                  </select>
                  @error('status')
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

  @if (session('form') || $errors->any())
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
