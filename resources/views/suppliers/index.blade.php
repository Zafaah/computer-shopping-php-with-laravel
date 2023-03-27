@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Suppliers Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New Supplier</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">Supplier ID</th>
          <th>Supplier Name</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($suppliers as $supplier)
            <tr>
              <td> {{ $supplier->supplier_id }} </td>
              <td> {{ $supplier->supplier_name }} </td>
              <td> {{ $supplier->contact }} </td>
              <td> {{ $supplier->address }} </td>
              <td>
                <form action="" method="post"></form>
                <a href="{{route('suppliers.delete', ['id'=>$supplier->supplier_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$supplier->supplier_id}}" class="btn btn-primary update">
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
      $("#address").val('');
      $("#contact").val('');
    });

    $('.update').click(function(){
      $.get(`suppliers/edit/${this.value}`, function(data){
        $("#id").val(data.supplier_id);
        $("#name").val(data.supplier_name);
        $("#address").val(data.address);
        $("#contact").val(data.contact);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="suppliers/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">    
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new supplier</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Supplier Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Company Name" 
                    value="{{ old('name') }}"/>
                  @error('name')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tell</label>
                  <input type="text" id="contact"  name="contact" class="form-control" placeholder="+1 000 000" 
                    value="{{ old('contact') }}"
                  >
                  @error('contact')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" id="address" name="address" class="form-control" placeholder="Mogadishu" 
                    value="{{ old('address') }}" >
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
