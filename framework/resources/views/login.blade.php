<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="utf-8"/>
<title>Laravel POS System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
{!! Html::style("assets/global/plugins/font-awesome/css/font-awesome.min.css") !!} 
{!! Html::style("assets/global/plugins/simple-line-icons/simple-line-icons.min.css") !!} 
{!! Html::style("assets/global/plugins/bootstrap/css/bootstrap.min.css") !!} 
{!! Html::style("assets/global/plugins/uniform/css/uniform.default.css") !!} 
{!! Html::style("assets/admin/pages/css/login.css") !!} 
{!! Html::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css") !!} 
{!! Html::style("assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css") !!} 
{!! Html::style("assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css") !!} 
{!! Html::style("assets/global/plugins/fullcalendar/fullcalendar.min.css") !!} 
{!! Html::style("assets/global/plugins/jqvmap/jqvmap/jqvmap.css") !!} 
{!! Html::style("assets/admin/pages/css/tasks.css") !!} 
{!! Html::style("assets/global/css/components.css") !!} 
{!! Html::style("assets/global/css/plugins.css") !!} 
{!! Html::style("assets/admin/layout/css/layout.css") !!} 
{!! Html::style("assets/admin/layout/css/themes/darkblue.css") !!} 
{!! Html::style("assets/admin/layout/css/custom.css") !!} 
{!! Html::style("favicon.ico", array('rel' => 'shortcut icon')) !!}

</head>

<body class="login">
<div class="menu-toggler sidebar-toggler">
</div>
<div class="logo">
	<a href="">
	<img src="{{ ("assets/img/laravos.png") }}" alt="Laravel POS System" width="250px" height="51px" />
	</a>
</div>

<div class="content">
	
	{!! Form::open(array('route' => 'login.process', 'class' => 'login-form')) !!}
	<h3 class="form-title">Sign In</h3>
	@include('layouts.partials.validation')
    @include('layouts.partials.alert')
	<br/><br/>
	<div class="form-group">
	{!! Form::text('user', null, array('placeholder' => 'Username or E-mail', 'class' => 'form-control form-control-solid placeholder-no-fix')) !!}
	</div>
	<div class="form-group">
	{!! Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control form-control-solid placeholder-no-fix')) !!}		
	</div>
	<div class="form-actions">
	{!! Form::submit('Login', array('class' => 'btn btn-success uppercase')) !!}
	</div>

	{!! Form::close() !!}
	
</div>



<div class="copyright">
	 <?php echo date('Y')?> © Laravel POS System.
</div>

{!! Html::script("assets/global/plugins/jquery.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery-migrate.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery-ui/jquery-ui.min.js") !!}  
{!! Html::script("assets/global/plugins/bootstrap/js/bootstrap.min.js") !!}  
{!! Html::script("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery.blockui.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery.cokie.min.js") !!}  
{!! Html::script("assets/global/plugins/uniform/jquery.uniform.min.js") !!}  
{!! Html::script("assets/global/plugins/jquery-validation/js/jquery.validate.min.js") !!}  
{!! Html::script("assets/global/scripts/metronic.js") !!}  
{!! Html::script("assets/admin/layout/scripts/layout.js") !!}  
{!! Html::script("assets/admin/layout/scripts/quick-sidebar.js") !!}  
{!! Html::script("assets/admin/layout/scripts/demo.js") !!}  
{!! Html::script("assets/admin/pages/scripts/login.js") !!}  

<script>
jQuery(document).ready(function() {     
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>