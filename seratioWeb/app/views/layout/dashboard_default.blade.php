<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>
         @section('title')
         @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third'))
         @elseif(Auth::user()->has_role('individual'))
         @endif
         @show
      </title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      {{ HTML::style('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
      <!-- Font Awesome -->
      {{ HTML::style('assets/bower_components/font-awesome/css/font-awesome.min.css') }}
      <!-- Ionicons -->
      {{ HTML::style('assets/bower_components/Ionicons/css/ionicons.min.css') }}
      {{ HTML::style('plugins/bootstrap-slider/slider.css')}}
      <!-- Theme style -->
      {{ HTML::style('assets/css/AdminLTE.css') }}
      <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
      {{ HTML::style('assets/css/skins/_all-skins.min.css') }}
      <!-- Morris chart -->
      {{ HTML::style('assets/bower_components/morris.js/morris.css') }}
      <!-- jvectormap -->
      {{ HTML::style('assets/bower_components/jvectormap/jquery-jvectormap.css') }}
      <!-- Date Picker -->
      {{ HTML::style('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
      <!-- Daterange picker -->
      {{ HTML::style('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}
      <!-- bootstrap wysihtml5 - text editor -->
      {{ HTML::style('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}
      {{ HTML::style('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}
      {{ HTML::style('assets/css/datatables/dataTables.colVis.css')}}
      {{ HTML::style('assets/js/amcharts_stock/style.css')}}
      {{ HTML::style('assets/css/wizard.css') }}
      {{ HTML::style('assets/css/dropdown.css') }}
      {{ HTML::script('https://www.google.com/jsapi')}}
      @yield('css')
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Google Font -->
      {{ HTML::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') }}
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <header class="main-header">
            @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third') || Auth::user()->has_role('CUSWM001') ||
            Auth::user()->has_role('eu') || Auth::user()->has_role('ms') || Auth::user()->has_role('pslight') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') ||
            Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') || Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
            Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') ||
            Auth::user()->has_role('CUSNM014') || Auth::user()->has_role('Bidder'))
            <a href="{{URL::route('home.index')}}" class="logo">
               <!-- Add the class icon to your logo image or logo icon to add the margining -->
               {{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '50')) }}
            </a>
            @elseif(Auth::user()->has_role('individual'))
            <a href="{{URL::route('home.index')}}" class="logo">
               <!-- Add the class icon to your logo image or logo icon to add the margining -->
               {{ HTML::image('assets_backend/images/personal_value.png', 'SE Ratio', array('width' => '50')) }}
            </a>
            @endif
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
               <!-- Sidebar toggle button-->
               <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <span class="sr-only">Toggle navigation</span>
               </a>
               <div class="navbar-custom-menu">
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
                                 @if(Auth::user()->has_role('individual'))
                                 <a href="{{URL::route('users.edit', ['id' => Auth::user()->id])}}" class="btn btn-default btn-flat">Edit Profile</a>
                                 @else
                                 <a href="#" class="btn btn-default btn-flat">Profile</a>
                                 @endif
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
         <!-- Left side column. contains the logo and sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
               <!-- Sidebar user panel -->
               <div class="user-panel">
                  <div class="pull-left image">
                     {{ HTML::image('assets/img/user.png' ,'', array('class' => 'img-circle', 'alt' => 'User Image')) }}
                  </div>
                  <div class="pull-left info">
                     <p>Hello, {{Auth::user()->getRealnameAttribute('id')}}</p>
                  </div>
               </div>
               <!-- search form -->
               <!-- <form action="#" method="get" class="sidebar-form">
                  <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                          </button>
                        </span>
                  </div>
                  </form> -->
               <!-- /.search form -->
               <!-- sidebar menu: : style can be found in sidebar.less -->
               <ul class="sidebar-menu" data-widget="tree">
                  @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third'))
                  <li><a href="{{URL::route('dashboard.index') }}">
                     <i class="fa fa-smile-o"></i>
                     <span>Welcome</span>
                     </a>
                  </li>
                  @endif
                  @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third') || ((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                  Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                  Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                  Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->user_defined))
                  <li class="{{ (URL::route('dashboard.index') === URL::current()) || (URL::route('dashboard.create') === URL::current())  ? 'active treeview' : 'treeview'}}">
                     <a href="{{URL::route('dashboard.index') }}">
                     <i class="fa fa-dashboard"></i>
                     @if(Auth::user()->has_role('admin') || ((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                     Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                     Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                     Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                     Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                     Auth::user()->user_defined))
                     <span>Dashboard</span>
                     @else
                     <span>Demo</span>
                     @endif
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        @if(Auth::user()->has_role('admin') || Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third'))
                        <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-angle-double-right"></i> PLC Demo</a></li>
                        <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-angle-double-right"></i> Pilot Demo</a></li>
                        @endif
                        @if( Auth::user()->user_defined && Auth::user()->has_subrole('customer'))
                        <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-angle-double-right"></i>
                           @if(Auth::user()->has_role('CUSWM001'))
                           WMFS
                           @elseif(Auth::user()->has_role('CUSWC002'))
                           WCC
                           @elseif(Auth::user()->has_role('CUSBN003'))
                           B&NESC
                           @elseif(Auth::user()->has_role('CUSEC004'))
                           EC
                           @elseif(Auth::user()->has_role('CUSSC005'))
                           SCC
                           @elseif(Auth::user()->has_role('CUSBS006'))
                           B&SUH
                           @elseif(Auth::user()->has_role('CUSCB007'))
                           CBC
                           @elseif(Auth::user()->has_role('CUSHC008'))
                           HC
                           @elseif(Auth::user()->has_role('CUSHC009'))
                           HC
                           @elsif(Auth::user()->has_role('CUSWF010'))
                           WFC
                           @elseif(Auth::user()->has_role('CUSCL011'))
                           COL
                           @elseif(Auth::user()->has_role('CUSWU012'))
                           WU
                           @elseif(Auth::user()->has_role('CUSWD013'))
                           WD
                           @elseif( Auth::user()->has_role('CUSNM014'))
                           NMUH
                           @endif
                           </a>
                        </li>
                        @elseif(((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                        Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                        Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                        Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                        Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                        Auth::user()->user_defined && Auth::user()->has_subrole('supplier')))
                        <li class="{{(URL::route('suppliers.index') === URL::current()) ? 'active' : ''}}"><a href="{{URL::route('suppliers.index')}}"><i class="fa fa-angle-double-right"></i> Results</a></li>
                        @elseif(Auth::user()->has_role('admin'))
                        <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-angle-double-right"></i> WMFS</a></li>
                        @endif
                     </ul>
                  </li>
                  @endif
                  @if(Auth::user()->has_role('admin'))
                  <li class="{{ (URL::route('users.index') === URL::current()) || (URL::route('users.create') === URL::current()) || (URL::route('subscribe.index') === URL::current())  ? 'active treeview' : 'treeview'}}">
                     <a href="#">
                     <i class="fa fa-user"></i>
                     <span>Users</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        <li class="{{(URL::route('users.index') === URL::current()) ? 'active' : ''}}"><a href="{{URL::route('users.index')}}"><i class="fa fa-angle-double-right"></i> View All Users</a></li>
                        <li class="{{(URL::route('users.create') === URL::current()) ? 'active' : ''}}"><a href="{{URL::route('users.create')}}"><i class="fa fa-angle-double-right"></i> Add a User</a></li>
                        <li class="{{(URL::route('subscribe.index') === URL::current()) ? 'active' : ''}}"><a href="{{URL::route('subscribe.index')}}"><i class="fa fa-angle-double-right"></i> View All Subscribers</a></li>
                     </ul>
                  </li>
                  @endif
                  @if(Auth::user()->has_role('admin') || (Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                  Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                  Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                  Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                  Auth::user()->user_defined)
                  <li class="{{ (URL::route('contracts.manage') === URL::current()) || (URL::route('suppliers.create') === URL::current()) || (URL::route('organisation.index') === URL::current()) || (URL::route('organisation.create') === URL::current()) || (URL::route('customer.index') === URL::current()) || (URL::route('customer.create') === URL::current())  ? 'active treeview' : 'treeview'}}">
                     <a href="#">
                     <i class="fa fa-desktop"></i>
                     @if(Auth::user()->has_role('admin'))
                     <span>Manage Organisations</span>
                     @else
                     <span>Social Value</span>
                     @endif
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                        Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                        Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                        Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                        Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                        Auth::user()->has_subrole('customer') && Auth::user()->user_defined)
                        <li class="{{ (URL::route('organisation.index') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('organisation.index') }}"><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                        <li class="{{ (URL::route('organisation.create') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('organisation.create')}}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                        <li class="{{ (URL::route('customer.index') === URL::current()) || (URL::route('customer.create') === URL::current())  ? 'active treeview' : 'treeview'}}">
                           <a href="#">
                           <i class="fa fa-book"></i>
                           <span>Contracts</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li class="{{ (URL::route('customer.index') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('customer.index') }}"><i class="fa fa-angle-double-right"></i> View all Contracts</a></li>
                              <li class="{{ (URL::route('customer.create') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('customer.create')}}"><i class="fa fa-angle-double-right"></i> Add a Contract</a></li>
                           </ul>
                        </li>
                        @else((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                        Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                        Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                        Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->has_subrole('supplier') && Auth::user()->user_defined)
                        <li class="{{ (URL::route('suppliers.create') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('suppliers.create')}}"><i class="fa fa-angle-double-right"></i>General Info</a></li>
                        @endif
                        @if(Auth::user()->has_role('admin'))
                        <li class="{{ (URL::route('wmfs.users') === URL::current()) ? 'active': ''}}" ><a href="{{URL::route('wmfs.users') }}"><i class="fa fa-user"></i>View Users</a></li>
                        <li class="{{ (URL::route('organisation.index') === URL::current()) || (URL::route('customer.index') === URL::current()) || (URL::route('contracts.manage') === URL::current())  ? 'active treeview' : 'treeview'}}">
                           <a href="#">
                           <i class="fa fa-users"></i>
                           <span>Customers</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li class="{{ (URL::route('organisation.index') === URL::current()) ? 'active': ''}}" ><a href="{{URL::route('organisation.index')}}"><i class="fa fa-angle-double-right"></i> Social Value Entries</a></li>
                              <li class="{{ (URL::route('customer.index') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('customer.index')}}"><i class="fa fa-angle-double-right"></i> All Contracts</a></li>
                              <li class="{{ (URL::route('contracts.manage') === URL::current()) ? 'active': ''}}" ><a href="{{URL::route('contracts.manage')}}"><i class="fa fa-angle-double-right"></i> Manage Contracts</a></li>
                           </ul>
                        </li>
                        @endif
                        @if(Auth::user()->has_role('admin'))
                        <li class="{{ (URL::route('customer.index') === URL::current()) || (URL::route('contracts.view') === URL::current()) || (URL::route('contracts.manage') === URL::current())  ? 'active treeview' : 'treeview'}}">
                           <a href="#">
                           <i class="fa fa-users"></i>
                           <span>Bidders</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li class="{{ (URL::route('customer.index') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('customer.index')}}"><i class="fa fa-angle-double-right"></i> All Contracts</a></li>
                              <li class="{{ (URL::route('contracts.view') === URL::current()) ? 'active': ''}}" ><a href="{{URL::route('contracts.view')}}"><i class="fa fa-angle-double-right"></i> Manage Contracts</a></li>
                           </ul>
                        </li>
                        @endif
                     </ul>
                  </li>
                  @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                  Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                  Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                  Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->has_subrole('customer') && Auth::user()->user_defined)
                  <li class="{{ (URL::route('mslavery.create') === URL::current()) ? 'active treeview' : 'treeview'}}">
                     <a href="#">
                     <i class="fa fa-user-secret"></i>
                     <span>Modern Slavery</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        <li class="{{ (URL::route('mslavery.create') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('mslavery.create') }}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                     </ul>
                  </li>
                  @endif
                  @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                  Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                  Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                  Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->has_subrole('supplier') && Auth::user()->user_defined)
                  <li class="{{ (URL::route('customer.index') === URL::current()) ? 'active': ''}}"><a href="{{URL::route('customer.index') }}"><i class="fa fa-book"></i><span>Contracts</span><i class="fa fa-angle-left pull-right"></i></a></li>
                  @endif
                  @endif
                  @if(Auth::user()->has_role('ms') || Auth::user()->has_role('admin'))
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-user-secret"></i>
                     <span>Modern Slavery</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     @if(Auth::user()->has_role('ms'))
                     <ul class="treeview-menu">
                        <li class="treeview">
                           <a href="#">
                           <i class="fa fa-user"></i>
                           <span>Customer</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{URL::asset('assets_frontend/ms/seratio_ms.png')}}" download><i class="fa fa-angle-double-right"></i>Download Logo</a></li>
                              <li><a href="{{URL::route('modernslavery.create', 'basic')}}"><i class="fa fa-angle-double-right"></i>Basic Details</a></li>
                              <li><a href="{{URL::route('modernslavery.create', 'pay')}}"><i class="fa fa-angle-double-right"></i>Pay</a></li>
                              <li><a href="{{URL::route('modernslavery.create', 'sentiment')}}"><i class="fa fa-angle-double-right"></i>Sentiment</a></li>
                              <li><a href="{{URL::route('modernslavery.create', 'statement')}}"><i class="fa fa-angle-double-right"></i>Statement</a></li>
                              <li><a href="{{URL::route('survey.results')}}"><i class="fa fa-angle-double-right"></i>Survey Results</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#">
                           <i class="fa fa-users"></i>
                           <span>Supplier</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{URL::route('mssupplier.index')}}"><i class="fa fa-angle-double-right"></i>View all Suppliers</a></li>
                              <li><a href="{{URL::route('mssupplier.create')}}"><i class="fa fa-angle-double-right"></i>Add a Supplier</a></li>
                           </ul>
                        </li>
                        @if(isset($ms))
                        @if($ms->modern_slavery)
                        <li class="">
                           <a href="{{URL::route('modernslavery.report', $ms->id)}}">
                           <i class="fa fa-hand-o-right"></i>
                           <span>Reports</span>
                           </a>
                        </li>
                        @endif
                        @endif
                     </ul>
                     @elseif(Auth::user()->has_role('admin'))
                     <ul class="treeview-menu">
                        <li><a href="{{URL::route('modernslavery.users')}}"><i class="fa fa-angle-double-right"></i>View All Customers</a></li>
                        <li><a href="{{URL::route('users.create', 'ms')}}"><i class="fa fa-angle-double-right"></i> Add a Customer</a></li>
                     </ul>
                     @endif
                  </li>
                  @endif
                  @if(Auth::user()->has_role('pslight') || Auth::user()->has_role('admin'))
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-arrows"></i>
                     <span>PS Microsite</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     @if(Auth::user()->has_role('pslight'))
                     <ul class="treeview-menu">
                        <li class="treeview">
                           <a href="#">
                           <i class="fa fa-user"></i>
                           <span>Customer</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{URL::route('microsite.create')}}"><i class="fa fa-angle-double-right"></i>Customer Details</a></li>
                              <li><a href="{{URL::route('microsite.overview', ['$id'=> Auth::user()->microsite->id ])}}"><i class="fa fa-angle-double-right"></i>Customer Overview</a></li>
                              <li><a href="{{URL::route('microsite.sentiment', ['$id'=> Auth::user()->microsite->id ])}}"><i class="fa fa-angle-double-right"></i>Sentiment Analysis</a></li>
                              <li><a href="{{URL::route('microsite.entries', ['$id'=> Auth::user()->microsite->id ])}}"><i class="fa fa-angle-double-right"></i>View All Entries</a></li>
                           </ul>
                        </li>
                        <li class="treeview">
                           <a href="#">
                           <i class="fa fa-pencil-square-o"></i>
                           <span>Bid Assessment</span>
                           <i class="fa fa-angle-left pull-right"></i>
                           </a>
                           <ul class="treeview-menu">
                              <li><a href="{{URL::route('microbids.index')}}"><i class="fa fa-angle-double-right"></i>View all Bids</a></li>
                              <li><a href="{{URL::route('microbids.create')}}"><i class="fa fa-angle-double-right"></i>Add a Bid</a></li>
                           </ul>
                        </li>
                     </ul>
                     @elseif(Auth::user()->has_role('admin'))
                     <ul class="treeview-menu">
                        <li><a href="{{URL::route('microsite.users')}}"><i class="fa fa-angle-double-right"></i>View All Customers</a></li>
                        <li><a href="{{URL::route('users.create', 'pslight')}}"><i class="fa fa-angle-double-right"></i> Add a Customer</a></li>
                     </ul>
                     @endif
                  </li>
                  @endif
                  @if(Auth::user()->has_role('Bidder'))
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-arrows"></i>
                     <span>Contracts</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     @if(Auth::user()->has_role('Bidder'))
                     <ul class="treeview-menu">
                        <li><a href="{{URL::route('dashboard.index') }}"><i class="fa fa-angle-double-right"></i> View all Contracts</a></li>
                     </ul>
                     @endif
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-user-secret"></i>
                     <span>Modern Slavery</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="{{URL::route('mslavery.index') }}"><i class="fa fa-angle-double-right"></i> View Entries</a></li>
                        <li><a href="{{URL::route('mslavery.create') }}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
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
                        <li><a href="{{URL::route('socialvalue.index') }}"><i class="fa fa-angle-double-right"></i> View all Entries</a></li>
                        <li><a href="{{URL::route('socialvalue.create')}}"><i class="fa fa-angle-double-right"></i> Add a Record</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="{{URL::to('http://serat.io/')}}" target="_blank" >
                     <i class="fa fa-eye"></i>
                     <span>Personal Value</span>
                     </a>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-flash"></i>
                     <span>Impact Investment</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
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
                     <i class="fa fa-table"></i>
                     <span>Reports</span>
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
                     <span>Ethical Leadership</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                  </li>
                  @endif
                  @if(Auth::user()->has_role('individual'))
                  <li>
                     <a href="{{URL::route('dashboard.index') }}">
                     <i class="fa fa-dashboard"></i>
                     <span>Dashboard</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{URL::route('personalvalue.edit', ['id'=> $quick_pv->id]) }}">
                     <i class="fa fa-pencil"></i>
                     <span>Redo Your Quick PV</span>
                     </a>
                  </li>
                  <!--<a href="#">
                     <i class="fa fa-table"></i>
                     <span>Provide More Detailed Response</span>

                     </a>-->
                  <!--<a href="#" data-toggle="modal" data-target="#real">
                     <i class="fa fa-dashboard"></i>
                     <span>Dynamic Real-Time PV</span>

                     </a>-->
                  @if($count>0)
                  <li>
                     <a id="btnSave" href="#">
                     <i class="fa fa-download"></i>
                     <span>Get your PV Badge</span>
                     </a>
                  </li>
                  @endif
                  @endif
               </ul>
            </section>
            <!-- /.sidebar -->
         </aside>
         @yield('content')
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <div class="pull-right">
               <a class="btn btn-social-icon btn-twitter" href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank"><i class="fa fa-twitter"></i></a>
               <a class="btn btn-social-icon btn-facebook" href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank"><i class="fa fa-facebook"></i></a>
               <a class="btn btn-social-icon btn-linkedin" href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank"><i class="fa fa-linkedin"></i></a>
               <a class="btn btn-social-icon btn-google-plus" href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank"><i class="fa fa-google-plus"></i></a>
               <a class="btn btn-social-icon" href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank"><i class="fa fa-youtube"></i></a>
               <a class="btn btn-social-icon btn-vk" href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" target="_blank"><i class="fa fa-bitcoin"></i></a>
               <a class="btn btn-social-icon btn-instagram" href="{{URL::to('https://instagram.com/theseratio')}}" target="_blank"><i class="fa fa-instagram"></i></a>
               <a class"btn btn-social-icon" href="{{URL::to('https://www.seratio.org')}}" target="_blank"><i class="fa fa-">{{ HTML::image('assets_frontend/images/learn.png', 'Education', array('width' => '50', 'height' => '40')) }}</i></a>
               <a class="btn btn-social-icon btn-instagram" href="{{URL::to('http://theseratio.tumblr.com')}}" target="_blank"><i class="fa fa-tumblr-square"></i></a>
            </div>
            <strong>Copyright &copy;<a href="{{URL::route('home.index')}}">2020 seratio®</a>.</strong> All rights
            reserved.<br>
            <a href="{{URL::route('home.index')}}">About</a> |
            <a href="{{URL::route('home.index')}}">Citizenship</a> |
            <a href="{{URL::route('home.index')}}">S/E Ratio</a> |
            <a href="{{URL::to('https://www.seratio.org/home')}}" target="_blank">MOOC</a> |
            <a href="{{URL::to('http://ow.ly/LN0zX')}}" target="_blank">Review</a> |
            <a href="{{URL::route('home.index')}}">Benchmark</a> |
            <a href="{{URL::route('home.index')}}">Partners</a>|
            <a href="{{URL::route('sessions.login')}}">My Account</a>|
            <a href="{{URL::route('home.index')}}">Support</a>|
            <a href="{{URL::route('home.index')}}">Legal</a>|
            <a href="{{URL::route('home.index')}}">News</a>|
            <a href="{{URL::route('home.index')}}">Contact</a>
         </footer>
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
               <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
               <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <!-- Home tab content -->
               <div class="tab-pane" id="control-sidebar-home-tab">
                  <h3 class="control-sidebar-heading">Recent Activity</h3>
                  <ul class="control-sidebar-menu">
                     <li>
                        <a href="javascript:void(0)">
                           <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                           <div class="menu-info">
                              <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                              <p>Will be 23 on April 24th</p>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <i class="menu-icon fa fa-user bg-yellow"></i>
                           <div class="menu-info">
                              <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                              <p>New phone +1(800)555-1234</p>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                           <div class="menu-info">
                              <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                              <p>nora@example.com</p>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <i class="menu-icon fa fa-file-code-o bg-green"></i>
                           <div class="menu-info">
                              <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                              <p>Execution time 5 seconds</p>
                           </div>
                        </a>
                     </li>
                  </ul>
                  <!-- /.control-sidebar-menu -->
                  <h3 class="control-sidebar-heading">Tasks Progress</h3>
                  <ul class="control-sidebar-menu">
                     <li>
                        <a href="javascript:void(0)">
                           <h4 class="control-sidebar-subheading">
                              Custom Template Design
                              <span class="label label-danger pull-right">70%</span>
                           </h4>
                           <div class="progress progress-xxs">
                              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <h4 class="control-sidebar-subheading">
                              Update Resume
                              <span class="label label-success pull-right">95%</span>
                           </h4>
                           <div class="progress progress-xxs">
                              <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <h4 class="control-sidebar-subheading">
                              Laravel Integration
                              <span class="label label-warning pull-right">50%</span>
                           </h4>
                           <div class="progress progress-xxs">
                              <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <h4 class="control-sidebar-subheading">
                              Back End Framework
                              <span class="label label-primary pull-right">68%</span>
                           </h4>
                           <div class="progress progress-xxs">
                              <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                           </div>
                        </a>
                     </li>
                  </ul>
                  <!-- /.control-sidebar-menu -->
               </div>
               <!-- /.tab-pane -->
               <!-- Stats tab content -->
               <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
               <!-- /.tab-pane -->
               <!-- Settings tab content -->
               <div class="tab-pane" id="control-sidebar-settings-tab">
                  <form method="post">
                     <h3 class="control-sidebar-heading">General Settings</h3>
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                           Some information about this general settings option
                        </p>
                     </div>
                     <!-- /.form-group -->
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                           Other sets of options are available
                        </p>
                     </div>
                     <!-- /.form-group -->
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                           Allow the user to show his name in blog posts
                        </p>
                     </div>
                     <!-- /.form-group -->
                     <h3 class="control-sidebar-heading">Chat Settings</h3>
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                        </label>
                     </div>
                     <!-- /.form-group -->
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                        </label>
                     </div>
                     <!-- /.form-group -->
                     <div class="form-group">
                        <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                     </div>
                     <!-- /.form-group -->
                  </form>
               </div>
               <!-- /.tab-pane -->
            </div>
         </aside>
         <!-- /.control-sidebar -->
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- jQuery 3 -->
      {{ HTML::script('assets/bower_components/jquery/dist/jquery.min.js') }}
      <!-- jQuery UI 1.11.4 -->
      {{ HTML::script('assets/bower_components/jquery-ui/jquery-ui.min.js') }}
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
         $.widget.bridge('uibutton', $.ui.button);
      </script>
      <!-- Bootstrap 3.3.7 -->
      {{ HTML::script('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
      <!-- Morris.js charts -->
      {{ HTML::script('assets/bower_components/raphael/raphael.min.js') }}
      {{ HTML::script('assets/bower_components/morris.js/morris.min.js') }}
      <!-- Sparkline -->
      {{ HTML::script('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}
      <!-- jvectormap -->
      {{ HTML::script('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
      {{ HTML::script('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
      <!-- jQuery Knob Chart -->
      {{ HTML::script('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}
      <!-- daterangepicker -->
      {{ HTML::script('assets/bower_components/moment/min/moment.min.js') }}
      {{ HTML::script('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}
      <!-- datepicker -->
      {{ HTML::script('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
      <!-- Bootstrap WYSIHTML5 -->
      {{ HTML::script('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
      <!-- Slimscroll -->
      {{ HTML::script('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
      <!-- FastClick -->
      {{ HTML::script('assets/bower_components/fastclick/lib/fastclick.js') }}
      <!-- AdminLTE App -->
      {{ HTML::script('assets/js/AdminLTE/app.js') }}
      {{ HTML::script ('assets/js/amcharts.js') }}
      {{ HTML::script ('assets/js/radar.js')}}
      {{ HTML::script ('assets/js/amcharts_stock/amcharts.js')}}
      {{ HTML::script ('assets/js/amcharts_stock/serial.js')}}
      {{ HTML::script('http://www.amcharts.com/lib/3/amstock.js')}}
      {{ HTML::script ('assets/js/amcharts_stock/amstock.js')}}
      {{ HTML::script ('assets/js/amcharts_pie/pie.js')}}
      <!-- DATA TABES SCRIPT -->
      {{ HTML::script ('assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}
      {{ HTML::script ('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}
      {{ HTML::script ('assets/js/plugins/datatables/dataTables.colVis.js')}}
      {{ HTML::script ('assets/js/forms.js')}}
      {{ HTML::script('assets_frontend/js/modernizr.js')}}
      {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js')}}
      {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/Base64/0.3.0/base64.js')}}
      {{ HTML::script('https://cdn.jsdelivr.net/canvas2image/0.1/canvas2image.js')}}
      {{ HTML::script ('assets/js/wizard.js')}}
      {{ HTML::script ('assets/js/dropdown.js')}}
      {{ HTML::script('plugins/bootstrap-slider/bootstrap-slider.js')}}
      @yield('scripts')
      @yield('charts')
   </body>
</html>
