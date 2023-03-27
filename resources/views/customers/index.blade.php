@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Customers Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New Customer</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">Customer ID</th>
          <th>Customer Name</th>
          <th>Gender</th>
          <th>Tell</th>
          <th>Address</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($customers as $customer)
            <tr>
              <td> {{ $customer->customer_id }} </td>
              <td> {{ $customer->customer_name }} </td>
              <td> {{ $customer->gender }} </td>
              <td> {{ $customer->tell }} </td>
              <td> {{ $customer->address }}</td>
              <td>
                <form action="" method="post"></form>
                <a href="{{route('customers.delete', ['id'=>$customer->customer_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$customer->customer_id}}" class="btn btn-primary update" >
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
      $("#gender").val('--Select gender--');
      $("#address").val('');
      $("#tell").val('');
    });

    $('.update').click(function(){
      $.get(`customers/edit/${this.value}`, function(data){
        console.log(data);
        $("#id").val(data.customer_id);
        $("#name").val(data.customer_name);
        $("#address").val(data.address);
        $("#tell").val(data.tell);
        $("#gender").val(data.gender);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="customers/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new customer</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Mohamed Abdullahi" 
                  value="{{ old('name') }}"
                  />
                  @error('name')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Gender</label>
                  <select class="form-control" id="gender" name="gender" style="width: 100%;" value={{old('gender')}}>
                    <option value="">--Select gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                  @error('gender')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tell</label>
                  <input type="text" id="tell"  name="tell" class="form-control" placeholder="+252 000 000"  value="{{ old('tell') }}"
                  >
                  @error('tell')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" id="address" name="address" class="form-control" placeholder="Mogadishu" value="{{ old('address') }}"
                  >
                  @error('address')
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
