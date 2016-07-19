<div class="tab-pane active" id="tab_0">

    <div class="portlet-body form">

        <div class="form-body">

        <div class="form-group">

            {!! Form::label('app_name', 'Application Name', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('app_name', $data->app_name, array('class' => 'form-control')) !!}

                @if($errors->has('app_name'))

                <span class="help-block" style="color:red;">{{ $errors->first('productcode') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">

            {!! Form::label('app_description', 'Description', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('app_description', $data->app_description, array('class' => 'form-control')) !!}

                @if($errors->has('app_description'))

                <span class="help-block" style="color:red;">{{ $errors->first('app_description') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">

            {!! Form::label('company', 'Company Name', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('company', $data->company, array('class' => 'form-control')) !!}

                @if($errors->has('company'))

                <span class="help-block" style="color:red;">{{ $errors->first('company') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">

            {!! Form::label('company_address', 'Company Address', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::textarea('company_address', $data->company_address, array('class' => 'form-control', 'rows' => 5)) !!}

                @if($errors->has('company_address'))

                <span class="help-block" style="color:red;">{{ $errors->first('company_address') }}</span>

                @endif

            </div>

        </div>

        <div class="form-group">
            {!! Form::label('logo', 'Logo', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-5">
                {!! Form::file('logo', array('class' => 'form-control')) !!}
                <img src="{{ url('/assets/img/' . $data->logo) }}" height="100px" width="300px">
                @if($errors->has('logo'))
                <span class="help-block" style="color:red;">{{ $errors->first('logo') }}</span>
                @endif
            </div>

        </div>

        <div class="form-group">

                {!! Form::label('fax', 'Fax', array('class' => 'col-md-3 control-label')) !!}

                <div class="col-md-4">

                    {!! Form::text('fax', $data->fax, array('class' => 'form-control', 'onkeypress' => 'validate(event)')) !!}

                    @if($errors->has('fax'))

                    <span class="help-block" style="color:red;">{{ $errors->first('fax') }}</span>

                    @endif

                </div>

            </div>

            <div class="form-group">

                {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}

                <div class="col-md-4">

                    {!! Form::text('email', $data->email, array('class' => 'form-control', 'onkeypress' => 'validate(event)')) !!}

                    @if($errors->has('email'))

                    <span class="help-block" style="color:red;">{{ $errors->first('email') }}</span>

                    @endif

                </div>

            </div>

        <div class="form-group">

            {!! Form::label('phone', 'Phone', array('class' => 'col-md-3 control-label')) !!}

            <div class="col-md-4">

                {!! Form::text('phone', $data->phone, array('class' => 'form-control', 'onkeypress' => 'validate(event)')) !!}

                @if($errors->has('phone'))

                <span class="help-block" style="color:red;">{{ $errors->first('phone') }}</span>

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