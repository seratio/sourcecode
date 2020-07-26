<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Social Value Test</title>

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


    </head>

    <body>

   <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" style="background-color:black;">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

               {{ HTML::image('assets_backend/images/fiware.png', 'SE Ratio', array('width' => '250')) }}

            </div>
            <div id="google_translate_element" class="navbar-brand navbar-right"></div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header_eu">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">

                            <h3>SERATIO is the world leader in measuring the value of the people family, communities, organisation, regions, nations and even our thoughts<br><br>

                                </h3>
                                <hr class="intro-divider">
                            </div>
                        </div>
                    </div>

                </div>

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


                <div class="row">
                    <h2><p align="center"> Thank you! We will be in touch with you in a month with your portal access details </p></h2>

        <div style="text-align: center">
           <a href="{{URL::to('http://www.cceg.org.uk/')}}" target="_blank" align="center" class="btn btn-primary btn-md" title="CCEG">CCEG</a>
             <a href="{{URL::to('https://seratio.com/home')}}" target="_blank" align="center" class="btn btn-info btn-md" title="Seratio">Seratio</a>
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
