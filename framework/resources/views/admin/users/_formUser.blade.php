<div class="form-body">
    
    <div class="form-group {!! ($errors->has('role_id') ? 'has-error' : '' ) !!}">
        {!! Form::label('role_id', 'Role', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::select('role_id', $role, null, array('class' => 'form-control select2me')) !!}
            @if($errors->has('role_id'))
                <span class="help-block">{{ $errors->first('role_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('username') ? 'has-error' : '' ) !!}">
        {!! Form::label('username', 'Username', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('username', null, array('class' => 'form-control')) !!}
            @if($errors->has('username'))
                <span class="help-block">{{ $errors->first('username') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('email') ? 'has-error' : '' ) !!}">
        {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('email', null, array('class' => 'form-control')) !!}
            @if($errors->has('email'))
                <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('first_name') ? 'has-error' : '' ) !!}">
        {!! Form::label('first_name', 'First Name', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
            @if($errors->has('first_name'))
                <span class="help-block">{{ $errors->first('first_name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('last_name') ? 'has-error' : '' ) !!}">
        {!! Form::label('last_name', 'Last Name', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
            @if($errors->has('last_name'))
                <span class="help-block">{{ $errors->first('last_name') }}</span>
            @endif
        </div>
    </div>
    
    <div class="form-group {!! ($errors->has('password') ? 'has-error' : '' ) !!}">
        {!! Form::label('password', 'Password', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::password('password', array('class' => 'form-control')) !!}
            @if($errors->has('password'))
                <span class="help-block">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('password_confirmation') ? 'has-error' : '' ) !!}">
        {!! Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
            @if($errors->has('password_confirmation'))
                <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
            @endif
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


