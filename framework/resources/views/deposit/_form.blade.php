<div class="form-body">

    <div class="form-group">

        {!! Form::label('customer_code', 'Customer', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::select('customer_id', $customer, null, array('class' => 'form-control select2me')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('payment_method', 'Payment Method', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::select('payment_method', $payment_method, 1, array('class' => 'form-control select2me', 'id' => 'payment_method', 'onChange' => 'payment()')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('bank_id', 'Bank', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::select('bank_id', $bank, null, array('class' => 'form-control select2me input-sm', 'id' => 'bank')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('card_no', 'Card No.', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::text('card_no', null, array('class' => 'form-control', 'id' => 'card_no')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('giro_no', 'Giro No.', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::text('giro_no', null, array('class' => 'form-control', 'id' => 'giro_no')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('amount', 'Amount Deposit', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount_deposit', 'onkeypress' => 'validate(event)', 'onchange' => 'deposit()')) !!}

        </div>

    </div>



    <div class="form-actions">

        <div class="row">

            <div class="col-md-offset-3 col-md-9">

                {!! Form::submit('Save', array('class' => 'btn green')) !!}

                <a href="{{ URL::previous() }}" class="btn default">Cancel</a>

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

function validate_form()

{

    valid = true;

    if(document.myform.customer_code.value == "")

    {

        bootbox.alert ("The Customer field is required!");

        valid = false;

    }



    if (document.myform.payment_method.value == 1)

    {

        if (document.myform.amount.value == ""){

           bootbox.alert ("The Amount Deposit field is required!");

           valid = false;

        }

    }



    if (document.myform.payment_method.value == 2 || document.myform.payment_method.value == 3)

    {

        if (document.myform.card_no.value == ""){

           bootbox.alert ("The Credit Card No. field is required!");

           valid = false;

        }



        if (document.myform.bank_id.value == ""){

           bootbox.alert ("The Bank field is required!");

           valid = false;

        }

    }



    if (document.myform.payment_method.value == 4)

    {

        if (document.myform.bank_id.value == ""){

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



        if (document.myform.bank_id.value == ""){

           bootbox.alert ("The Bank field is required!");

           valid = false;

        }

    }

    

    return valid;

}



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

</script>

<script>

function payment(){



if(document.myform.payment_method.value == 1) {

   document.getElementById('card_no').disabled =true;

   document.getElementById('bank').disabled =true;

   document.getElementById('giro_no').disabled =true;

   

}



else if(document.myform.payment_method.value==2) {

        document.getElementById('card_no').disabled =false;

        document.getElementById('giro_no').disabled =true;

        document.getElementById('bank').disabled =false;

        

}



else if(document.myform.payment_method.value==3) {

        document.getElementById('card_no').disabled =false;

        document.getElementById('giro_no').disabled =true;

        document.getElementById('bank').disabled =false;

        

}



else if(document.myform.payment_method.value==4) {

        document.getElementById('bank').disabled =false;

        document.getElementById('card_no').disabled =true;

        document.getElementById('giro_no').disabled =true;

        

}



else if(document.myform.payment_method.value==5) {

        document.getElementById('bank').disabled =false;

        document.getElementById('card_no').disabled =true;

        document.getElementById('giro_no').disabled =false;

        

}



}



function deposit()

{

    var amount_deposit=getNumber(document.getElementById("amount_deposit").value);

    document.getElementById("amount_deposit").value = formatNumber(amount_deposit);

  

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