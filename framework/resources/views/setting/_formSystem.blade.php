<div class="tab-pane active" id="tab_0">

    <div class="portlet-body form">

        <div class="form-body">

        <div class="form-group">

            {!! Form::label('page_per_rows', 'Rows Per Page', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('page_per_rows', $data->page_per_rows, array('class' => 'form-control')) !!}

                @if($errors->has('page_per_rows'))

                <span class="help-block" style="color:red;">{{ $errors->first('page_per_rows') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">

            {!! Form::label('prefix_invoice', 'Prefix Invoice', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('prefix_invoice', $data->prefix_invoice, array('class' => 'form-control')) !!}

                @if($errors->has('prefix_invoice'))

                <span class="help-block" style="color:red;">{{ $errors->first('prefix_invoice') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">

            {!! Form::label('timezone', 'Timezone', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::select('timezone', $timezone, $data->timezone, array('class' => 'form-control select2me')) !!}

                @if($errors->has('timezone'))

                <span class="help-block" style="color:red;">{{ $errors->first('timezone') }}</span>

                @endif

            </div>

        </div>

        </div>

    </div>

</div>


{!! Html::script("/assets/global/plugins/jquery.min.js") !!}

{!! Html::script("/assets/jquery.elevatezoom.js") !!}

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

</script>