<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>@yield('title','') | SIMUNAI</title>
	<!-- initiate head with meta tags, css and script -->
	@include('include.head')

</head>
<body id="app" >
    <div class="wrapper">
    	<!-- initiate header-->
    	@include('include.header-webgis')
    	<div class="page-wrap">
	    	<!-- initiate sidebar-->
	    	<div class="main-content">
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>


    	</div>
    </div>

	<!-- initiate scripts-->
	@include('include.script')
</body>
</html>
