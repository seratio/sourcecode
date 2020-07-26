<!DOCTYPE html>
<html>
    <head>
    <link rel="icon" href="{{{ asset('assets_backend/images/logo.png') }}}">
        <meta charset="UTF-8">
         <title>
    @section('title')
            seratio
        @show
    </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
         {{ HTML::style('assets/css/bootstrap.min.css') }}
       
        <!-- font Awesome -->
        {{ HTML::style('assets/css/font-awesome.min.css') }}
       
        <!-- Ionicons -->
        {{ HTML::style('assets/css/ionicons.min.css') }}
        
        <!-- Morris chart -->
         {{ HTML::style('assets/css/morris/morris.css') }}
       
        <!-- jvectormap -->
         {{ HTML::style('assets/css/jvectormap/jquery-jvectormap-1.2.2.css') }}
       
        <!-- Date Picker -->
        {{ HTML::style('assets/css/datepicker/datepicker3.css') }}
       
        <!-- Daterange picker -->
        {{ HTML::style('assets/css/daterangepicker/daterangepicker-bs3.css') }}
       
        <!-- bootstrap wysihtml5 - text editor -->
         {{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}
      
        <!-- Theme style -->
         {{ HTML::style('assets/css/AdminLTE.css') }}

        {{ HTML::style('assets/css/datatables/dataTables.bootstrap.css')}}

        {{ HTML::style('assets/js/amcharts_stock/style.css')}}

         


       

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="{{URL::route('home.index')}}" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               {{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '50')) }}
              
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>{{Auth::user()->getRealnameAttribute('id')}} <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <p>
                                        {{Auth::user()->getRealnameAttribute('id')}}
                                        <small>Member since </small>
                                    </p>
                                </li>
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{URL::route('sessions.logout',['$id'=>Auth::user()->id])}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            
                        </div>
                        <div class="pull-left info">
                            <p>Hello, {{Auth::user()->getRealnameAttribute('id')}}</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="{{URL::route('dashboard.index') === URL::current() ? 'active' : ''}}">
                            <a href="{{ URL::route('dashboard.index') }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        @if(Auth::user()->has_role('admin'))
                        <li class="{{ (URL::route('users.index') === URL::current()) || (URL::route('users.create') === URL::current())  ? 'treeview' : 'treeview'}}">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Users</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{URL::route('users.index')}}"><i class="fa fa-angle-double-right"></i> View All Users</a></li>
                                <li><a href="{{URL::route('users.create')}}"><i class="fa fa-angle-double-right"></i> Add a User</a></li>
                                <li><a href="{{URL::route('subscribe.index')}}"><i class="fa fa-angle-double-right"></i> View All Subscribers</a></li>
                            </ul>
                        </li>
                        @endif 

                        @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third'))
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Social Value</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href="{{URL::route('dashboard.create')}}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>
                                
                        </li>
                        

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-male"></i>
                                <span>Modern Slavery</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href="{{URL::route('dashboard.create')}}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-medkit"></i>
                                <span>Health & Wellbeing</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>  
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-tasks"></i>
                                <span>Consumer Index</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>   
                        </li>

                         <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shield"></i>
                                <span>Domestic Violence</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>
                                
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-github-alt"></i>
                                <span>Animal Welfare</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>
                                
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-film"></i>
                                <span>The Arts</span>
                               <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                            </ul>    
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Benchmark</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                             </ul>   
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i>
                                <span>Reports</span>
                                <i class="fa fa-angle-left pull-right"></i>
                                
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                                <li><a href=""><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                             </ul>   
                        </li>
                        @endif
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

             <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        404 Error Page
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                        <li class="active">404 error</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="error-page">
                        <h2 class="headline text-info"> 404</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                            <p>
                                We could not find the page you were looking for.
                                Meanwhile, you may <a href="{{URL::route('dashboard.index') }}">return to dashboard</a> 
                        </div><!-- /.error-content -->
                    </div><!-- /.error-page -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
            <nav class="navbar navbar-default navbar-static-bottom" height="90" width="role="navigation"" style="margin-bottom: 0">
                                <ul class="nav navbar-bottom-links navbar-middle">
              
               
                 <div class="text-left">              
                                        
                        <a class="btn btn-social-icon btn-twitter" href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a class="btn btn-social-icon btn-facebook" href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a class="btn btn-social-icon btn-linkedin" href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a class="btn btn-social-icon btn-google-plus" href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank"><i class="fa fa-google-plus"></i></a>
                        <a class="btn btn-social-icon" href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank"><i class="fa fa-youtube"></i></a>
                        <a class="btn btn-social-icon btn-vk" href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" target="_blank"><i class="fa fa-bitcoin"></i></a>
                        <a class="btn btn-social-icon btn-instagram" href="{{URL::to('https://instagram.com/theseratio')}}" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a class"btn btn-social-icon" href="{{URL::to('https://www.seratio.org')}}" target="_blank"><i class="fa fa-">{{ HTML::image('assets_frontend/images/learn.png', 'Education', array('width' => '50', 'height' => '40')) }}</i></a>
                    </div>

                     <ul class="nav navbar-bottom-links navbar-right">
                    <p class="text-right">Copyright © <a href="{{URL::route('home.index')}}">seratio&trade;</a></p>
                        <span class="" align="right">
                            <a href="{{URL::route('home.index')}}">About</a> | 
                            <a href="{{URL::route('home.index')}}">S/E Ratio</a> | 
                            <a href="{{URL::to('https://www.seratio.org/home')}}" target="_blank">MOOC</a> |
                            <a href="{{URL::route('home.index')}}">Partners</a>|
                            <a href="{{URL::route('sessions.login')}}">My Account</a>|
                            <a href="{{URL::route('home.index')}}">Support</a>|
                            <a href="{{URL::route('home.index')}}">Legal</a>|
                            <a href="{{URL::route('home.index')}}">News</a>|
                            <a href="{{URL::route('home.index')}}">Contact</a>
                         </span>
                    </ul>
                        
                

       </nav>


     <!-- jQuery 2.0.2 -->
        {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js') }}
        
        <!-- jQuery UI 1.10.3 -->
        {{ HTML::script('assets/js/jquery-ui-1.10.3.min.js') }}
        
        <!-- Bootstrap -->
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        
        <!-- Bootstrap WYSIHTML5 -->
       
        
        <!-- iCheck -->
        
        {{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}

        <!-- AdminLTE App -->
        {{ HTML::script('assets/js/AdminLTE/app.js') }}

       
        {{ HTML::script ('assets/js/amcharts_stock/amcharts.js')}}

        {{ HTML::script ('assets/js/amcharts_stock/serial.js')}}

        {{ HTML::script('http://www.amcharts.com/lib/3/amstock.js')}} 

         {{ HTML::script ('assets/js/amcharts_stock/amstock.js')}}

         

        {{ HTML::script ('assets/js/amcharts_pie/pie.js')}}

        <!-- DATA TABES SCRIPT -->
        {{ HTML::script ('assets/js/plugins/datatables/jquery.dataTables.js')}}
        
        {{ HTML::script ('assets/js/plugins/datatables/dataTables.bootstrap.js')}}

        {{ HTML::script ('assets/js/forms.js')}}   

        

          @yield('scripts')
 

    </body>
</html>