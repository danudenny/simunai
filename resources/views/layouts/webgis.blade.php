<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>@yield('title','') | SIMUNAI</title>
	<!-- initiate head with meta tags, css and script -->
	@include('include.head')

</head>
<body id="app" >
    	<!-- initiate header-->
    	@include('include.header-webgis')
	    	<!-- initiate sidebar-->
	    	<div class="main-map">
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>

	<!-- initiate scripts-->
	@include('include.script')
</body>
</html>
