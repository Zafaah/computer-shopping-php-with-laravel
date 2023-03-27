@extends ('layout.main')

@section('body')
 <div class="card-box mb-30">
  <div class="pd-20 flex">
    <h4 class="text-blue h4">Sales Table</h4>
    <button class="btn btn-primary "  data-toggle="modal" data-target="#form-model">Add New Sale</button>
  </div>
  <div class="pb-20">
    <table class="table hover data-table-export nowrap">
      <thead >
        <tr>
          <th class="table-plus datatable-nosort">No.</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Discount</th>
          <th>Total Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sales as $ind=>$sale)
            <tr>
              <td> {{ ++$ind}} </td>
              <td> {{ $sale->customer_name }} </td>
              <td> {{ $sale->product_name }} </td>
              <td> {{ $sale->quantity }} </td>
              <td> ${{ $sale->price }} </td>
              <td> {{ $sale->discount }}%</td>
              <td> ${{ $sale->total_amount }} </td>
              <td>
                <a href="{{route('sales.delete', ['id'=>$sale->sale_id])}}" class="btn btn-danger">
                  <i class="icon-copy dw dw-delete-3 text-white h6"></i>
                </a>
                <button value="{{$sale->sale_id}}" class="btn btn-primary update" >
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
      $("#customer").val('--Select Customer--');
      $("#product").val('--Select Product--');
      $("#quantity").val('');
      $("#discount").val('');
    });

    $('.update').click(function(){
      $.get(`sales/edit/${this.value}`, function(data){
        $("#id").val(data.sale_id);
        $("#customer").val(data.customer_id);
        $("#product").val(data.product_id);
        $("#quantity").val(data.quantity);
        $("#discount").val(data.discount);

         $('#form-model').modal('show');
      })
    })
  });
</script>

{{--  form model  --}}
<div class="modal fade bs-example-modal-lg" id="form-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <form action="sales/" method="post" class="modal-content" onsubmit="(e)=>e.preventDefault()">
        @csrf
        <input type="hidden" value="" name="id" id="id">
        <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Add new sale</h4>
          <button type="button" class="close close-model" data-dismiss="modal" aria-hidden="true" >×</button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer</label>
                  <select type="text" id="customer"  name="customer" class="form-control"  value="{{ old('customer') }}"
                  >
                    <option value="">--Select Customer--</option>
                    @foreach ($customers as $customer)
                        <option value="{{$customer->customer_id}}">{{$customer->customer_name}}</option>
                    @endforeach
                  </select>
                  @error('customer')
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
                  <label>Discount</label>
                  <input type="number" min="0" max="10"  id="discount" name="discount" class="form-control" placeholder="Discount in percentage" value="{{ old('discount') }}"
                  >
                  @error('discount')
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
