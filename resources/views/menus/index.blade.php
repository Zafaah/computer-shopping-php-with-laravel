@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Menu Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New menu</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">#</th>
          <th>Menu Name</th>
          <th>Link</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($menus as $ind=>$menu)
            <tr>
              <td> {{ ++$ind}} </td>
              <td> {{ $menu->menu_name }} </td>
              <td> 
                <a href="{{ $menu->link }} ">{{ $menu->link }} </a> 
              </td>
              <td>
                <a href="{{route('menus.delete', ['id'=>$menu->menu_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$menu->menu_id}}" class="btn btn-primary update" >
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
        $("#link").val('');
        $("#icon").val('');
    });

    $('.update').click(function(){
      $.get(`menus/edit/${this.value}`, function(data){
        $("#id").val(data.menu_id);
        $("#name").val(data.menu_name);
        $("#link").val(data.link);
        $("#icon").val(data.icon);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="menus/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new menu</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Menu Name</label>
                  <input type="text" id="name"  name="name" class="form-control" placeholder="Menu Name"  value="{{ old('name') }}"
                  >
                  @error('name')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Link</label>
                  <input type="text" id="link" name="link" class="form-control" placeholder="Link" value="{{ old('link') }}"
                  >
                  @error('link')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label>Icon</label>
                  <input list="icons" name="icon" id="icon" class="form-control">
                  <datalist id="icons">
                    <option value="dw dw-house-1">Home</option>
                    <option value="icon-copy ti-user">User</option>
                    <option value="icon-copy fi-star">Star</option>
                    <option value="icon-copy fi-torso-business">Business</option>
                    <option value="icon-copy fi-monitor">Monitor</option>
                    <option value="icon-copy fi-laptop">Laptop</option>
                    <option value="icon-copy fi-pricetag-multiple">Pricetag</option>
                    <option value="icon-copy fi-asterisk">Asterisk</option>
                  </datalist>
                  @error('icon')
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
