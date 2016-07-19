<?php $setting = \App\Models\SettingGeneral::findOrFail(1); ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="utf-8"/>
<title>{{ $setting->app_name .' - '. $setting->app_description }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

{!! Html::style("/assets/global/plugins/font-awesome/css/font-awesome.min.css") !!} 
{!! Html::style("/assets/global/plugins/simple-line-icons/simple-line-icons.min.css") !!} 
{!! Html::style("/assets/global/plugins/bootstrap/css/bootstrap.min.css") !!} 
{!! Html::style("/assets/global/plugins/uniform/css/uniform.default.css") !!} 
{!! Html::style("/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css") !!} 
{!! Html::style("/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css") !!}
{!! Html::style("/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css") !!}
{!! Html::style("/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css") !!}
{!! Html::style("/assets/global/plugins/typeahead/typeahead.css") !!}
{!! Html::style("/assets/admin/pages/css/invoice.css") !!}
{!! Html::style("/assets/admin/pages/css/error.css") !!}
{!! Html::style("/assets/global/plugins/select2/select2.css") !!} 
{!! Html::style("/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css") !!} 
{!! Html::style("/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css") !!}
{!! Html::style("/assets/global/plugins/jquery-nestable/jquery.nestable.css") !!}
{!! Html::style("/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css") !!}
{!! Html::style("/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css") !!} 
{!! Html::style("/assets/global/plugins/fullcalendar/fullcalendar.min.css") !!} 
{!! Html::style("/assets/global/plugins/jqvmap/jqvmap/jqvmap.css") !!} 
{!! Html::style("/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") !!}
{!! Html::style("/assets/admin/pages/css/profile.css") !!}
{!! Html::style("/assets/admin/pages/css/tasks.css") !!} 
{!! Html::style("/assets/global/css/components.css") !!} 
{!! Html::style("/assets/global/css/plugins.css") !!} 
{!! Html::style("/assets/admin/layout/css/layout.css") !!} 
{!! Html::style("/assets/admin/layout/css/themes/darkblue.css") !!} 
{!! Html::style("/assets/admin/layout/css/custom.css") !!} 

{!! Html::style("favicon.ico", array('rel' => 'shortcut icon')) !!}

<style type="text/css">
    td.details-control {
    background: url('assets/img/open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('assets/img/close.png') no-repeat center center;
}
</style>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed-hide-logo page-container-bg-solid">
<div class="page-header -i navbar navbar-fixed-top">
	<div class="page-header-inner">
		<div class="page-logo">
			<a href="{{ url('/dashboard') }}">
			{!! Html::image('/assets/img/' .$setting->logo, $setting->app_name, array('class' => 'logo-default', 'height' => '20px', 'width' => '86px')) !!}
			</a>
			<div class="menu-toggler sidebar-toggler hide">
			</div>
		</div>
		
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown" id="notifications"></li>
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					{!! Html::image('/assets/img/avatar/' . Sentinel::getUser()->avatar, '', array('class' => 'img-circle')) !!}	
					<span class="username username-hide-on-mobile">
					{{ Sentinel::getUser()->first_name .' '. Sentinel::getUser()->last_name }} </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="{{ url('/myprofile') }}">
							<i class="icon-user"></i> Profile </a>
						</li>
						<li>
							<a href="{{ url('/logout') }}">
							<i class="icon-key"></i> Log Out </a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="clearfix">
</div>
<div class="page-container">
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler">
					</div>
				</li>
				<li class="sidebar-search-wrapper">
					<form class="sidebar-search " action="#" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
						</div>
					</form>
				</li>
				@include('includes.sidebarmenu')
				
			</ul>
		</div>
	</div>
	
	<!-- Main content -->
        <section class="content">
        <div class="page-content-wrapper">
		<div class="page-content">
            @yield('content')
        </div></div>
        </section>
    <!-- /.content -->

</div>

<div class="page-footer">
	<div class="page-footer-inner">
		 <?php echo date('Y')?> &copy; {{ $setting->app_name .' - '. $setting->app_description }}.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>

{!! Html::script("/assets/global/plugins/jquery.min.js") !!} 
{!! Html::script("/assets/global/plugins/jquery-migrate.min.js") !!} 
{!! Html::script("/assets/global/plugins/jquery-ui/jquery-ui.min.js") !!} 
{!! Html::script("/assets/global/plugins/bootstrap/js/bootstrap.min.js") !!} 
{!! Html::script("/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js") !!} 
{!! Html::script("/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js") !!} 
{!! Html::script("/assets/global/plugins/jquery.blockui.min.js") !!} 
{!! Html::script("/assets/global/plugins/jquery.cokie.min.js") !!} 
{!! Html::script("/assets/global/plugins/uniform/jquery.uniform.min.js") !!} 
{!! Html::script("/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js") !!}

{!! Html::script("/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js") !!}
{!! Html::script("/assets/global/plugins/jquery.sparkline.min.js") !!}

{!! Html::script("/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js") !!}
{!! Html::script("/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js") !!}
{!! Html::script("/assets/global/plugins/jquery-validation/js/jquery.validate.min.js") !!}
{!! Html::script("/assets/global/plugins/jquery-validation/js/additional-methods.min.js") !!}
{!! Html::script("/assets/global/plugins/select2/select2.min.js") !!} 
{!! Html::script("/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js") !!} 
{!! Html::script("/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js") !!} 
{!! Html::script("/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js") !!} 
{!! Html::script("/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!} 
{!! Html::script("/assets/global/scripts/metronic.js") !!} 
{!! Html::script("/assets/admin/layout/scripts/layout.js") !!} 
{!! Html::script("/assets/admin/layout/scripts/quick-sidebar.js") !!} 
{!! Html::script("/assets/admin/layout/scripts/demo.js") !!} 
{!! Html::script("/assets/admin/pages/scripts/components-pickers.js") !!} 
{!! Html::script("/assets/global/plugins/bootbox/bootbox.min.js") !!} 
{!! HTML::script('/assets/admin/pages/scripts/table-managed.js') !!}
{!! Html::script("/assets/handlebars.js") !!}
{!! HTML::script("/assets/form.validation.js") !!}
{!! HTML::script("/assets/admin/pages/scripts/profile.js") !!}

<script>
jQuery(document).ready(function() {    
Metronic.init();
Layout.init(); 
QuickSidebar.init(); 
Demo.init();
ComponentsPickers.init();
TableManaged.init();
Profile.init();
$('.demo-loading-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
    });
});
</script>
</body>
</html>