<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>@yield('title') - Retellgram</title>

  <!-- Bootstrap -->    
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
  @yield('header')
  
  <link href="/css/navbar.css" rel="stylesheet">

</head>
<body>
  <div class="container">
    @include('flash::message')
  </div>
  @include('navigation')
   
  @yield('main')
   
  @include('footer')

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script>
  $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
  </script>
    


  @yield('footer')
</body>
</html>