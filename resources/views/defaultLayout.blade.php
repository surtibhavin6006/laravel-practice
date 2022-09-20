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

@include('defaultNavBar')

<main role="main" class="container">
    <div class="loader"></div>
    @yield('content')
</main><!-- /.container -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

@yield('javascriptBlock')


</body>
</html>
