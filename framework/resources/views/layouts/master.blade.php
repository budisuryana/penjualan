<!DOCTYPE html>
<html>
<head>
	<title>ini adalah title default</title>
</head>
<body>
	<p>@include('includes.header')</p>
	<p>Selamat datang di halaman BELAJAR</p>

	<p>
		Dibawah ini adalah isi Content <br/> <br/>
		<i>
		@yield('content')
		</i>
	</p>
	<br/>
	<div class='footer'>
		<p>
			@yield('footer')
		</p>
	</div>
</body>
</html>