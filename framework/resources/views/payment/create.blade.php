<link rel="stylesheet" href="http://codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

@extends('template')
@section('content')

<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="#">Home</a>
      <i class="fa fa-angle-right"></i>
    </li>
    <li>
      <a href="#">{{ $title }}</a>
    </li>
  </ul>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    @include('layouts.partials.alert')
    <div class="portlet-body form">
      <form class="form-horizontal" role="form">
        <div class="form-body">
          <h3 class="form-section">Customer Info</h3>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">Name:</label>
                <div class="col-md-9">
                  <p class="form-control-static">
                     {{ $customer->name }}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">Receipt No:</label>
                <div class="col-md-9">
                  <p class="form-control-static">
                     {{ $receipt_no }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">City:</label>
                <div class="col-md-9">
                  <p class="form-control-static">
                     {{ $customer->city }}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">Payment Date:</label>
                <div class="col-md-9">
                  <p class="form-control-static">
                     {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-M-Y') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3">Address:</label>
                <div class="col-md-9">
                  <p class="form-control-static">
                     {{ $customer->address }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-cogs"></i>Sale Detail
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
        </div>
      </div>
      <div class="portlet-body">
        <div class="table-scrollable">
          <table class="table table-hover">
          <thead>
          <tr>
            <th>No.</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Discount (%)</th>
            <th>Discount ($)</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
            <?php $i=1; ?>
            @foreach($dataSale as $row)
              <tr>
                <td style="text-align:center;width:5%;">{{ $i++ }}</td>
                <td>{{ $row->product }}</td>
                <td style="text-align:right;">{{ $row->qty }}</td>
                <td style="text-align:right;">{{ $row->price }}</td>
                <td style="text-align:right;">{{ $row->discount_per }}</td>
                <td style="text-align:right;">{{ $row->discount_value }}</td>
                <td style="text-align:right;">{{ $row->amount }}</td>
              </tr>
            @endforeach
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>  
</div>

<div class="row">
  <div class="col-md-12">
    <div class="portlet box purple">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-gift"></i>Add Payment
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
        </div>
      </div>
      <div class="portlet-body form">
        {!! Form::open(array('route' => 'payment.store', 'class' => 'form-horizontal', 'name' => 'myform', 'onsubmit' => "return validate_form();")) !!}
          {!! Form::hidden('invoice_no', \Request::segment(3)) !!}
          <div class="form-body">
            <h3 class="form-section">Payment Method</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Sub Total</label>
                  <div class="col-md-5">
                    {!! Form::text('subtotal', $subtotal, array('class' => 'form-control input-sm', 'id' => 'subtotal' , 'readonly' => true)) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Payment Method</label>
                  <div class="col-md-5">
                    {!! Form::select('payment_method', $payment_method, 1, array('class' => 'form-control select2me input-sm', 'id' => 'payment_method', 'onChange' => 'payment()')) !!}
                  </div>
                  <div class="col-md-4">
                    {!! Form::select('bank', $bank, null, array('class' => 'form-control select2me input-sm', 'id' => 'bank')) !!}
                    @if($errors->has('bank'))
                        <span class="help-block" style="color:red;">{{ $errors->first('bank') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total Discount</label>
                  <div class="col-md-5">
                    {!! Form::text('totaldisc', $totalDisc, array('class' => 'form-control input-sm', 'id' => 'totaldisc' , 'readonly' => true)) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Card No.</label>
                  <div class="col-md-5">
                  {!! Form::text('card_no', null, array('class' => 'form-control input-sm', 'id' => 'card_no')) !!}
                  @if($errors->has('card_no'))
                        <span class="help-block" style="color:red;">{{ $errors->first('card_no') }}</span>
                  @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Tax 5%</label>
                  <div class="col-md-5">
                    {!! Form::text('totaltax', number_format($tax, 2), array('class' => 'form-control input-sm', 'id' => 'totaltax' , 'readonly' => true)) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Giro No.</label>
                  <div class="col-md-5">
                  {!! Form::text('giro_no', null, array('class' => 'form-control input-sm', 'id' => 'giro_no')) !!}
                  @if($errors->has('giro_no'))
                        <span class="help-block" style="color:red;">{{ $errors->first('giro_no') }}</span>
                  @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Total</label>
                  <div class="col-md-5">
                    {!! Form::text('total', $total, array('class' => 'form-control input-sm', 'id' => 'total' , 'readonly' => true)) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Amount Paid</label>
                  <div class="col-md-5">
                  {!! Form::text('amount_paid', null, array('class' => 'form-control input-sm', 'onkeypress' => 'validate(event)', 'onchange' => 'calculate_change()', 'id' => 'amount_paid')) !!}
                  @if($errors->has('amount_paid'))
                        <span class="help-block" style="color:red;">{{ $errors->first('amount_paid') }}</span>
                  @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3"></label>
                  <div class="col-md-5">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">Amount Change</label>
                  <div class="col-md-5">
                  {!! Form::text('amount_change', null, array('class' => 'form-control input-sm', 'readonly' => true, 'id' => 'amount_change')) !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('Save', array('name' => 'op', 'class' => 'btn btn-sm purple')) !!}
                    <a href="<?php echo URL::previous() ?>" class="btn default btn-sm"> Cancel</a>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
              </div>
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

@endsection

<script type="text/javascript">
function validate_form()
{
    valid = true;
    if (document.myform.payment_method.value == 1)
    {
        if (document.myform.amount_paid.value == ""){
           bootbox.alert ("The Amount Paid field is required!");
           valid = false;
        }
    }

    if (document.myform.payment_method.value == 2 || document.myform.payment_method.value == 3)
    {
        if (document.myform.card_no.value == ""){
           bootbox.alert ("The Credit Card No. field is required!");
           valid = false;
        }

        if (document.myform.bank.value == ""){
           bootbox.alert ("The Bank field is required!");
           valid = false;
        }
    }

    if (document.myform.payment_method.value == 4)
    {
        if (document.myform.bank.value == ""){
           bootbox.alert ("The Bank field is required!");
           valid = false;
        }
    }

    if (document.myform.payment_method.value == 5)
    {
        if (document.myform.giro_no.value == ""){
           bootbox.alert ("The Giro No. field is required!");
           valid = false;
        }

        if (document.myform.bank.value == ""){
           bootbox.alert ("The Bank field is required!");
           valid = false;
        }
    }
    
    return valid;
}
</script>

<script>
function payment(){

if(document.myform.payment_method.value == 1){
document.getElementById('card_no').disabled =true;
document.getElementById('bank').disabled =true;
document.getElementById('giro_no').disabled =true;
document.getElementById('amount_paid').disabled =false;
document.getElementById('amount_change').disabled =false;

}
else if(document.myform.payment_method.value==2){
document.getElementById('card_no').disabled =false;
document.getElementById('giro_no').disabled =true;
document.getElementById('bank').disabled =false;
document.getElementById('amount_paid').disabled =true;
document.getElementById('amount_change').disabled =true;
}
else if(document.myform.payment_method.value==3){
document.getElementById('card_no').disabled =false;
document.getElementById('giro_no').disabled =true;
document.getElementById('bank').disabled =false;
document.getElementById('amount_paid').disabled =true;
document.getElementById('amount_change').disabled =true;
}
else if(document.myform.payment_method.value==4){
document.getElementById('bank').disabled =false;
document.getElementById('card_no').disabled =true;
document.getElementById('giro_no').disabled =true;
document.getElementById('amount_paid').disabled =true;
document.getElementById('amount_change').disabled =true;

}
else if(document.myform.payment_method.value==5){
document.getElementById('bank').disabled =false;
document.getElementById('card_no').disabled =true;
document.getElementById('giro_no').disabled =false;
document.getElementById('amount_paid').disabled =true;
document.getElementById('amount_change').disabled =true;
}
}

function calculate_change()
{
  var total=getNumber(document.getElementById("total").value);
  var amount_paid=getNumber(document.getElementById("amount_paid").value);
  var amount_change=amount_paid-total;
  document.getElementById("amount_change").value=formatNumber(amount_change);
  document.getElementById("amount_paid").value=formatNumber(amount_paid);
  
}

</script>
<script type="text/javascript">
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function getNumber(value)
{ 
  var currency = value;
  var number = Number(currency.replace(/[^-0-9\.]+/g,""));
  return number;
}

function formatNumber(num)
{
num = num.toString().replace(/\$|\,/g,'');
if(isNaN(num))
num = "0";
sign = (num == (num = Math.abs(num)));
num = Math.floor(num*100+0.50000000001);
cents = num%100;
num = Math.floor(num/100).toString();
if(cents<10)
cents = "0" + cents;
for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
num = num.substring(0,num.length-(4*i+3))+','+
num.substring(num.length-(4*i+3));
return (((sign)?'':'-') + num + '.' + cents);
}
</script>

