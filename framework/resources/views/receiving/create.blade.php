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
      @include('layouts.partials.alert')
      @include('layouts.partials.validation')
      <br>
      @include('receiving.form')
@endsection

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">

$(function(){

    $('.save').click(function(){
    var po_no        = $('#po_no').val();
    var supplier     = $('#supplier').val();
    var faktur_no    = $('#faktur_no').val();
    var date         = $('#date').val();
    var person       = $('#person').val();
    var description  = $('#description').val();

    $.ajax({
            url : '{{ URL::to('/insert_receiving') }}',
            type: "POST",
            data: {
                'po_no'      : po_no,
                'supplier'   : supplier,
                'faktur_no'  : faktur_no,
                'date'       : date,
                'person'     : person,
                'description': description 
            },
            
            dataType: "JSON",
            success: function(data)
            {
               document.location.href = 'receiving';

            },
            
        });
  });
});

</script>
<script>
$(function() {

$('.date-picker').datepicker({
    showOn: "button",
    changeMonth: true,
    changeYear: true,
    yearRange: "-1:+0",
    format: "yyyy-mm-dd",
    maxDate: '0',
    language: 'id',
    autoclose: true
});


});
</script>
<script type="text/javascript">
  $(function(){
        $('#qty').bind('keyup', function() {
            cost_total();
        });

        $('#price').bind('keyup', function() {
            cost_total();
        });

        $('#discount_per').bind('keyup', function() {
            discount_total();
        });

        function cost_total() {
            var price = 0;
            var totalprice = 0;
            var totaldiscount = 0;
            var discount_per = $('#discount_per').val();
            var qty = $('#qty').val();
            var sell_price = $('#price').val();

            if (qty > 0 && sell_price > 0) {
                price = (qty * sell_price);
                totaldiscount = (qty * sell_price) * (discount_per / 100);
                totalprice = price - totaldiscount;
                $('#amount').val(totalprice);
                $('#diskonrpshow').text(totaldiscount);
                $('#diskonrp').val(totaldiscount);
            }
            
            total = 0;
            $('#amount').each(function() {
                var val = $(this).val();
                total = total ;
            });

            
        }

        function discount_total() {
            var totalprice = 0;
            var totaldiscount = 0;
            var totalAmount = 0;
            var discount_per = $('#discount_per').val();
            var qty = $('#qty').val();
            var sell_price = $('#price').val();

            if (qty > 0 && sell_price > 0) {
                totalprice = (qty * sell_price);
                totaldiscount = (qty * sell_price) * (discount_per / 100);
                totalAmount = totalprice - totaldiscount;
                $('#amount').val(totalAmount);
                $('#diskonrpshow').text(totaldiscount);
                $('#diskonrp').val(totaldiscount);
            }
            
            total = 0;
            $('#amount').each(function() {
                var val = $(this).val();
                total = total;
            });
        }

  });
</script>


