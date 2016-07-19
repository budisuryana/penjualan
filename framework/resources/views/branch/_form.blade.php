

<div class="form-body">

    <div class="form-group">

        {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('name', null, array('class' => 'form-control')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 5)) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('address', 'Address', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::textarea('address', null, array('class' => 'form-control', 'rows' => 5)) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('city', 'City', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('city', null, array('class' => 'form-control')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('zip_code', 'Postal Code', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('zip_code', null, array('class' => 'form-control')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('phone', 'Phone', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('phone', null, array('class' => 'form-control')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('type', 'Type', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::select('type', $type, null, array('class' => 'form-control select2me')) !!}

        </div>

    </div>



    <div class="form-actions">

        <div class="row">

            <div class="col-md-offset-3 col-md-9">

                {!! Form::submit('Save', array('class' => 'btn green')) !!}

            </div>

        </div>

    </div>

</div>