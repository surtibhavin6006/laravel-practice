
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Event</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        /*.loader {
            position: absolute;
            left: 50%;
            top: 50%;
            border: 16px solid #f3f3f3; !* Light grey *!
            border-top: 16px solid #3498db; !* Blue *!
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }*/

        .loader {
            width:100%;

            /*-Lets Center the Spinner-*/
            position:fixed;
            left:0;
            right:0;
            top:0;
            bottom:0;

            /*Centering my shade */
            margin-bottom: 40px;
            margin-top: 60px;

            background-color: rgba(255,255,255,0.7);
            z-index:9999;
            display: none;
        }

        @-webkit-keyframes spin {
            from {-webkit-transform:rotate(0deg);}
            to {-webkit-transform:rotate(360deg);}
        }

        @keyframes spin {
            from {transform:rotate(0deg);}
            to {transform:rotate(360deg);}
        }

        .loader::after {
            content:'';
            display:block;
            position:absolute;
            left:48%;top:40%;
            width:80px;height:80px;
            border-style:solid;
            border: 5px solid black;
            border-top-color: #6CC4EE;
            border-width: 7px;
            border-radius:50%;
            -webkit-animation: spin .8s linear infinite;

            /* Lets make it go round */
            animation: spin .8s linear infinite;
        }

    </style>
</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Event Demo</a>
        </div>
        <ul class="nav navbar-nav">
        </ul>
    </div>
</nav>

<main role="main" class="container">
    <div class="loader"></div>
    @yield('content')
</main><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
--}}
{{--<script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
{{--<script>window.jQuery || document.write('<script src="{{ asset('js/jquery-slim.min.js') }}"><\/script>')</script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
{{--<script src="{{ asset('js/popper.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

@yield('javascriptBlock')


</body>
</html>
