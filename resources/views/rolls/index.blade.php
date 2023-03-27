@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Users Roll Table</h4>
    <button class="btn btn-primary"  data-toggle="modal" data-target="#form-model">Add New Roll</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">#</th>
          <th>User</th>
          <th>Menu</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($rolls as $ind=>$roll)
            <tr>
              <td> {{ ++$ind}} </td>
              <td> {{ $roll->username }} </td>
              <td> 
                <a href="{{ $roll->link }} ">{{ $roll->menu_name }} </a> 
              </td>
              <td>
                <a href="{{route('rolls.delete', ['id'=>$roll->id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
               <button value="{{$roll->user_id}}" class="btn btn-primary update" >
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
      $("#user").val('');
      $("#menus").val('');
     });
     
    $('.update').click(function(){
      $.get(`rolls/edit/${this.value}`, function(data){
        console.log(data);
        $("#id").val(data.user);
        $("#user").val(data.user);
        $("#menus").val(data.menus);

         $('#form-model').modal('show');
      })
    })
    
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="rolls/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new roll</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>User</label>
                  <select  id="user"  name="user" class="form-control" value="{{ old('user') }}"
                  >
                  <option value="">--Select User--</option>
                  @foreach ($users as $user)
                      <option value="{{$user->user_id}}">{{$user->user_id }}- {{$user->username}}</option>
                  @endforeach
                </select>
                  @error('user')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Menu</label>
                  <select type="text" id="menus" name="menus[]" multiple class="form-control" placeholder="menu" value="{{ old('menu') }}"
                  >
                  @foreach ($menus as $menu)
                      <option value="{{$menu->menu_id}}">{{$menu->menu_name}}</option>
                  @endforeach
                  </select>
                  @error('menu')
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
