<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/main.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/mdb.min.css') }}">

	@yield('styles')
</head>
<body style="background-color:#00796B">

	@include('includes.header')
	<div class="main">
		@yield('content')
	</div>
</body>
</html>