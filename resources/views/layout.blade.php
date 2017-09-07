<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusher</title>
    <!-- Styles -->
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- /Styles -->
	
	<script src="//js.pusher.com/4.1/pusher.min.js"></script>
</head>

<body id="app-layout">
    <!-- NAV -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{route('home.pusher')}}">Pusher</a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{route('home.pusher')}}">Home</a></li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="javascript:;">Login</a></li>
                    <li><a href="javascript:;">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /NAV -->
    <!-- /MAINCONTENT -->
    <div class="container">
        <div class="row">
            <!-- ROW -->
            <div class="col-md-12">
                <div class="page-header hide" id="startusername">
                    <h1>Are you ready to Chat?
                       <button class="btn btn-default" autocomplete="off" id="start">Yes!</button>
                    </h1>
                </div>
				 @yield('mainContent')
            </div>
        </div>
        <!-- /ROW -->
    </div>
    <!-- /MAINCONTENT -->

    <script type="text/javascript" charset="utf-8">
		var crsf = "{{ csrf_token() }}";
		var pusherKey = "{{env("PUSHER_KEY")}}";
		var authEndpoint = '{{route('home.pusherauth')}}';
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="/js/js.cookie.js"></script>
	<script src="/js/jquery-form-serializer.js"></script>
	<script src="/js/pusherapp.js"></script>
	
</body>

</html>