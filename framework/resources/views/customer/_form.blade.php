

<div class="form-body">

    <div class="form-group">

        {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('name', null, array('class' => 'form-control', 'id' => 'name')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('address', 'Address', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::textarea('address', null, array('class' => 'form-control', 'rows' => 5, 'id' => 'address')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('city', 'City', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('city', null, array('class' => 'form-control', 'id' => 'city')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('zip_code', 'Postal Code', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('zip_code', null, array('class' => 'form-control', 'id' => 'zip_code')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('phone', 'Phone', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('phone', null, array('class' => 'form-control', 'id' => 'phone')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-5">

            {!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email')) !!}

        </div>

    </div>



    <div class="form-actions">

        <div class="row">

            <div class="col-md-offset-3 col-md-9">

                {!! Form::submit('Save', array('class' => 'btn green')) !!}

                {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn default']) !!}

            </div>

        </div>

    </div>

</div>





