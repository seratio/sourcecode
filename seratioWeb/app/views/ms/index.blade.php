@extends('layout.dashboard_default')
@section('title')
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Dashboard
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Dashboard</li>
      </ol>
   </section>
   </br>
   <!-- Left col -->
   <section class="content">
      <div class="row">
         <section class="col-lg-12 connectedSortable">
            <!-- Map box -->
            <div class="row wrapper">
               <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-warning">
                     <div class="panel-heading">
                        <h1 class="panel-title">Waiting for a confirmation from admin</h1>
                     </div>
                     <p align="justify">
                        Thank you for signing up as a user of seratio.com. Once we have confirmed your details, your account will be approved by the administrators. You will be notified by e-mail when this is complete
                        <br>
                        We apologise for any inconvenience this may cause.
                     </p>
                  </div>
               </div>
            </div>
         </section>
         <!-- /.Left col -->
      </div>
   </section>
   <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- add new calendar event modal -->
@stop
