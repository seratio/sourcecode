<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Personal Value</title>

    {{ HTML::style('assets_frontend/bootstrap/css/bootstrap.min.css')}}

    {{ HTML::style('assets_frontend/css/font-awesome.min.css')}}

    {{ HTML::style('assets_frontend/css/landing-page.css')}}

    <!-- Custom Fonts -->
    {{ HTML::style('https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic')}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71812286-1', 'auto');
  ga('send', 'pageview');

</script>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav">
            <div class="container topnav">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand topnav" href="#">Personal Value</a>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>


        <!-- Header -->
        <a name="about"></a>
        <div class="intro-header">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-message">
                            <h3>SERATIO is the world leader in measuring the value of organisations, regions, nations, communities and even our thoughts. <br><br>
                                Discover your Personal Value for free in 60 seconds and just 6 questions - and see how you compare</h3>
                                <hr class="intro-divider">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container -->

            </div>
            <!-- /.intro-header -->

            <!-- Page Content -->

            <a  name="services"></a>

            <div class="content-section-b">

                <div class="container">
                 <p class="description">
                    @if (Session::has('message'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong> {{ Session::get('message') }}</strong>
                    </div>
                    @endif
                </p>

                <h2>Thank You</h2>
                <div class="row">
                    <p align="center"> SERATIO is the world leader in measuring the value of organisations, regions, nations, communities, family and even our thoughts
                    </br>
                    Discover your Personal Value for free in 60 seconds and just 6 questions - and see how you compare <br>
                    You can use PV in a variety of ways, for your CV, get jobs, shout out to friends, demonstrate your contribution to society, value the power of your networks …

        </br>
        <div style="text-align: center">
           <a href="{{URL::route('frontend.pv')}}" align="center" class="btn btn-primary btn-lg" title="New PV custome">Why not do you own Personal Value?</a>
             <a href="{{URL::route('sessions.signin')}}" align="center" class="btn btn-info btn-lg" title="Existing PV customer">Existing PV customer</a>
        </div>

    </div>

</div>
</div>
<!-- /.container -->

<a  name="contact"></a>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright text-muted small">Copyright &copy; Seratio 2020. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>

{{ HTML::script('assets_frontend/bootstrap/js/jquery.js')}}

{{ HTML::script('assets_frontend/bootstrap/js/bootstrap.min.js')}}


</body>

</html>
