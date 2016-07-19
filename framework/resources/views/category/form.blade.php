<!--div class="alert alert-danger info" style="display:none;">

    <ul></ul>

</div-->

<div class="form-body">

    <div class="form-group">

        {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::text('name', null, array('class' => 'form-control', 'id' => 'name')) !!}

        </div>

    </div>



    <div class="form-group">

        {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 5, 'id' => 'description')) !!}

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



