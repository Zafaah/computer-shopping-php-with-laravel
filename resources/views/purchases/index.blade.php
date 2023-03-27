@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Purchases Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New Purchase</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">No.</th>
          <th>Supplier</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Cost</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($purchases as $ind=>$purchase)
            <tr>
              <td> {{ ++$ind}} </td>
              <td> {{ $purchase->supplier_name }} </td>
              <td> {{ $purchase->product_name }} </td>
              <td> {{ $purchase->quantity }} </td>
              <td> ${{ $purchase->cost }} </td>
              <td>
                <form action="" method="post"></form>
                <a href="{{route('purchases.delete', ['id'=>$purchase->purchase_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$purchase->purchase_id}}" class="btn btn-primary update" >
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
      $("#supplier").val('--Select gender--');
      $("#unit_price").val('');
    });

    $('.update').click(function(){
      $.get(`purchases/edit/${this.value}`, function(data){
        console.log(data);
        $("#id").val(data.purchase_id);
        $("#supplier").val(data.supplier_id);
        $("#product").val(data.product_id);
        $("#quantity").val(data.quantity);
        $("#cost").val(data.cost);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="purchases/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new purchase</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Supplier</label>
                  <select type="text" id="supplier"  name="supplier" class="form-control"  value="{{ old('supplier') }}"
                  >
                    <option value="">--Select Supplier--</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                    @endforeach
                  </select>
                  @error('supplier')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Product</label>
                  <select type="text" id="product"  name="product" class="form-control"  value="{{ old('product') }}"
                  >
                    <option value="">--Select Product--</option>
                    @foreach ($products as $product)
                        <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                    @endforeach
                  </select>
                  @error('product')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Quantity</label>
                  <input type="number" min="1"  id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="{{ old('quantity') }}"
                  >
                  @error('quantity')
                    <small class="text-danger h6 ml-1">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Cost </label>
                  <input type="number" min="1"  id="cost" name="cost" class="form-control" placeholder="Cost" value="{{ old('cost') }}"
                  >
                  @error('cost')
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
