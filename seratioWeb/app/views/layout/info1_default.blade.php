<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="icon" href="{{{ asset('assets_backend/images/logo.png') }}}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>
         @section('title')
            seratio&trade;
        @show
        </title>

        <!-- Bootstrap Core CSS -->
        {{ HTML::style('assets_frontend/bootstrap/css/bootstrap.min.css')}}
        

        <!-- Font Awesome CSS -->
         {{ HTML::style('assets_frontend/css/font-awesome.min.css')}}
        
		
		<!-- Custom CSS -->
		 {{ HTML::style('assets_frontend/css/animate.css')}}
        

        <!-- Custom CSS -->
        {{ HTML::style('assets_frontend/css/style.css')}}
        

        <!-- Custom Fonts -->
        {{ HTML::style('http://fonts.googleapis.com/css?family=Lobster')}}
        


        <!-- Template js -->
        {{ HTML::script('assets_frontend/js/jquery-2.1.1.min.js')}}
       
        {{ HTML::script('assets_frontend/bootstrap/js/bootstrap.min.js')}}
       
        {{ HTML::script('assets_frontend/js/jquery.appear.js')}}
         
        {{ HTML::script('assets_frontend/js/jqBootstrapValidation.js')}}
       
        {{ HTML::script('assets_frontend/js/modernizr.custom.js')}}
        
         {{ HTML::script('assets_frontend/js/script.js')}}

         {{ HTML::script ('assets/js/amcharts_front/amcharts.js')}}

         
        
        

        <!--[if lt IE 9]>
            {{ HTML::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}
            {{ HTML::script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')}}
        [endif]-->

   <meta name="google-site-verification" content="RneZ5tH3xTjlLWwIRe_dhHgwwXKd-zrjW9cMRBYrCyk" />

    </head>
    
    
    <body>
        
        <!-- Start Logo Section -->
        <section id="logo-section" class="text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="logo text-left">
                            <h1> <a href="{{URL::route('home.index')}}"> {{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '120')) }} </a> </h1>
                        </div>
                         <div class="logo text-center" style="color:white">
                                <h1>SEratio&trade;</h1>
                                <span>making everything intangible in the world<br>
                                        measurable, applicable and deliverable
                                </span>
                        </div>
                    </div>
                </div>
            
        </section>
        <!-- End Logo Section -->
    </br></br>

                  
            <h3 style="color:white; margin-left:10%; margin-right:10%;" align="center">OUR MISSION IS TO TRANSLATE COMPLEX INPUTS INTO SIMPLE,</br> SINGULAR MEASUREMENTS OF TRUE INTANGIBLE OUTCOMES </h3>                  
         

        
        
        
        <!-- Start Main Body Section -->
        <div class="mainbody-section text-center">
            <div class="container">
                <p class="description">
                        @if (Session::has('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <strong> {{ Session::get('message') }}</strong>
                                        </div>
                        @endif
                        @if($errors->has())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <strong> {{ $error }}</strong>
                                        </div>
                            @endforeach
                        @endif
               
                <div class="row">

                    
                    <div class="col-md-3">
                        
                        <div class="menu-item blue">
                            <a href="#svalue-modal" data-toggle="modal">
                                <i class="fa fa-users"></i>
                                <p>Social Value</p>
                            </a>
                        </div>

                        <div class="menu-item color responsive">
                            <a href="#mslavery-modal" data-toggle="modal">
                                <i class="fa fa-male"></i>
                                <p>Modern Slavery</p>
                            </a>
                        </div>

                         <div class="menu-item light-red">
                            <a href="#hw-modal" data-toggle="modal">
                                <i class="fa fa-medkit"></i>
                                <p>Health & Wellbeing</p>
                            </a>
                        </div>
                         <div class="menu-item color">
                            <a href="#dv-modal" data-toggle="modal">
                                <i class="fa fa-bolt"></i>
                                <p>Domestic Violence</p>
                            </a>
                        </div>

                    </div>

                    
                    <div class="col-md-6">
                        
                        <!-- Start Carousel Section -->
                        <div class="home-slider">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="padding-bottom: 30px;">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                    	{{ HTML::image('assets_frontend/images/slide8.jpg') }}                                        
                                    </div>
                                    <div class="item">
                                    	{{ HTML::image('assets_frontend/images/2.png') }}  
                                    </div>
                                    <div class="item">
                                    	{{ HTML::image('assets_frontend/images/slide7.jpg') }}                                        
                                    </div>
                                    <div class="item">
                                        {{ HTML::image('assets_frontend/images/slide6.jpg') }}                                        
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- Start Carousel Section -->
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="menu-item color responsive">
                                    <a href="#consumer-modal" data-toggle="modal">
                                        <i class="fa fa-tasks"></i>
                                        <p>Consumer Index</p>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="menu-item light-orange responsive-2">
                                    <a href="#per-modal" data-toggle="modal">
                                        <i class="fa fa-shield"></i>
                                        <p>Personal Value</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="menu-item light-orange responsive-2">
                                    <a href="#happy-modal" data-toggle="modal">
                                        <i class="fa fa-sitemap"></i>
                                        <p>Happy Cities</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="menu-item blue">
                                    <a href="#hyper-modal" data-toggle="modal">
                                        <i class="fa fa-map-marker"></i>
                                        <p>Hyperlocality</p>
                                    </a>
                                </div>
                            </div>
                            
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-3">
                        
                       <div class="menu-item blue">
                            <a href="#ii-modal" data-toggle="modal">
                                <i class="fa fa-bar-chart-o"></i>
                                <p>Impact Investment</p>
                            </a>
                        </div>
                        
                        <div class="menu-item color">
                            <a href="#arts-modal" data-toggle="modal">
                                <i class="fa fa-film"></i>
                                <p>The Arts</p>
                            </a>
                        </div>

                         <div class="menu-item blue">
                            <a href="#aw-modal" data-toggle="modal">
                                <i class="fa fa-github-alt"></i>
                                <p>Animal Welfare</p>
                            </a>
                        </div>
                        <div class="menu-item light-red">
                            <a href="" data-toggle="modal">
                                <i class="fa fa-gbp"></i>
                                <p>Capacity Development</p>
                            </a>
                        </div>
                        
                        <!--<div class="menu-item blue">
                            <a href="#" data-toggle="modal">
                                <i class="fa fa-bar-chart-o"></i>
                                <p>Benchmark</p>
                            </a>
                        </div>-->
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Body Section -->
        
            <h3 style="margin-left:10%; margin-right:10%; color:white;" align="center">We use a blended approach harnessing the power of social physics, big data, machine learning, sentiment analysis, neuroeconomics, impact analytics</br></br>
                            Understanding how to use big data to improve companies, cities and government … people’s lives … in a way that focuses first and foremost on APPLICATION</h3>                  
            
            </br>
        <!-- Start Copyright Section -->
        <div class="copyright text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       
                    	 <div class="footer-social text-left">

                         <p class="text-muted" >Copyright © <a href="{{URL::route('home.index')}}">seratio&trade; </a></p>
                            <div class="footer-social text-right">
                             <h8 style="color:white" class="text-muted" >Beta Version 1.3</h8>


                            </div>
                           
                            {{ Form::open(array('action' => 'SubscribeController@store')) }}                  
                            {{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'E-Mail', 'required', 'width' => '40')) }}

                            {{ Form::submit('Subscribe', ['class' => 'btn btn-success']) }} 

                            {{ Form::close() }}

                            <div class="footer-social text-right">
                            <ul>
                                    <li><a href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" target="_blank"><i class="fa fa-bitcoin"></i></a></li>
                                    <li><a href="{{URL::to('https://instagram.com/theseratio')}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="{{URL::to('https://www.seratio.org')}}" target="_blank"><i class="fa fa-">{{ HTML::image('assets_frontend/images/learn.png', 'Education', array('width' => '25', 'height' => '30')) }}</i></a></li>
                                    <li><a href="{{URL::to('http://theseratio.tumblr.com')}}" target="_blank"><i class="fa fa-tumblr-square"></i></a></li>     
                            </ul>
                              </div>
                          </br>

                            <span class="" align="right">
                    	 	<a href="#about-modal" data-toggle="modal">About</a> | 
                            <a href="#citizen-modal" data-toggle="modal">Citizenship</a> | 
                    	 	<a href="#seratio-modal" data-toggle="modal">S/E Ratio</a> | 
                    	 	<a href="{{URL::to('https://www.seratio.org/home')}}" target="_blank">MOOC</a> |
                            <a href="{{URL::to('http://ow.ly/LN0zX')}}" target="_blank">Review</a> |
                    	 	<a href="#benchmark-modal" data-toggle="modal">Benchmark</a> | 
                            <a href="#partners-modal" data-toggle="modal">Partners</a>|
                    	 	<a href="{{URL::route('sessions.login')}}">My Account</a>|
                            <a href="#team-modal" data-toggle="modal">Our Team</a> |
                    	 	<a href="#">Support</a>|
                    	 	<a href="#">Legal</a>|
                    	 	<a href="#">News</a>|
                    	 	<a href="#contact-modal" data-toggle="modal">Contact</a>
                    	 </span>

                          
                      </div>
                    </div>
                            </div>
                         
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready(function() {
                    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                });
                </script>


        <!-- End Copyright Section -->

        @yield('content')

        @yield('scripts')
         

    </body>
    
</html>