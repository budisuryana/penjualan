@extends('template')
@section('content')

<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			@include('layouts.partials.alert')
			@include('layouts.partials.validation')
			<div class="portlet light">
				<div class="portlet-title tabbable-line">
					<div class="caption caption-md">
						<i class="icon-globe theme-font hide"></i>
						<span class="caption-subject font-blue-madison bold uppercase">{{ $title }}</span>
					</div>
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
						</li>
						<li>
							<a href="#tab_1_3" data-toggle="tab">Change Password</a>
						</li>
					</ul>
				</div>
				<div class="portlet-body">
					<div class="tab-content">
						<!-- PERSONAL INFO TAB -->
						<div class="tab-pane active" id="tab_1_1">
							{!! Form::open(array('url' => 'myprofile', 'role' => 'form')) !!}
								<div class="form-group">
									<label class="control-label">First Name</label>
									{!! Form::text('first_name', $data['first_name'], ['class' => 'form-control']) !!}
								</div>
								<div class="form-group">
									<label class="control-label">Last Name</label>
									{!! Form::text('last_name', $data['last_name'], ['class' => 'form-control']) !!}
								</div>
								<div class="form-group">
									<label class="control-label">Username</label>
									{!! Form::text('username', $data['username'], ['class' => 'form-control']) !!}
								</div>
								<div class="form-group">
									<label class="control-label">Email</label>
									{!! Form::text('email', $data['email'], ['class' => 'form-control']) !!}
								</div>
								<div class="form-group">
									<label class="control-label">Role</label>
									{!! Form::select('role_id', $roles, $data['roles'][0]->name, ['class' => 'form-control select2me']) !!}
								</div>
								<div class="margiv-top-10">
									{!! Form::submit('Save Changes', ['class' => 'btn green-haze']) !!}
								</div>
							{!! Form::close() !!}
						</div>
						<!-- END PERSONAL INFO TAB -->
						<!-- CHANGE AVATAR TAB -->
						<div class="tab-pane" id="tab_1_2">
							{!! Form::open(array('url' => 'change-avatar', 'role' => 'form', 'files' => true)) !!}
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
										{!! Html::image('/assets/img/avatar/' . Sentinel::getUser()->avatar, '', ['width' => '200px', 'height' => '150px']) !!}
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
										</div>
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new">
											Select image </span>
											<span class="fileinput-exists">
											Change </span>
											<input type="file" name="avatar">
											</span>
											<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
											Remove </a>
										</div>
									</div>
									
								</div>
								<div class="margin-top-10">
									{!! Form::submit('Save Changes', ['class' => 'btn green-haze']) !!}
								</div>
							{!! Form::close() !!}
						</div>
						<!-- END CHANGE AVATAR TAB -->
						<!-- CHANGE PASSWORD TAB -->
						<div class="tab-pane" id="tab_1_3">
							{!! Form::open(array('url' => 'change-password', 'class' => 'form-horizontal', 'role' => 'form')) !!}
								<div class="form-group">
									<label class="control-label">Current Password</label>
									{!! Form::password('old_password', array('class' => 'form-control')) !!}
								</div>
								<div class="form-group">
									<label class="control-label">New Password</label>
									{!! Form::password('password', array('class' => 'form-control')) !!}
								</div>
								<div class="form-group">
									<label class="control-label">Re-type New Password</label>
									{!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
								</div>
								<div class="margin-top-10">
									{!! Form::submit('Change Password', ['class' => 'btn green-haze']) !!}
								</div>
							{!! Form::close() !!}
						</div>
						<!-- END CHANGE PASSWORD TAB -->
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

@endsection