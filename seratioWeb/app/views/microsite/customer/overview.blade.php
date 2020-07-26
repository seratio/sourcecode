@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::Customer Overview
@stop
@section('css')
<!--<style type='text/css'>
   .box{
    padding: 20px;
    display: none;
    margin-top: 20px;
    border: 1px solid #000;
   }
   .red{ background: #ff0000; }
   .green{ background: #00ff00; }
   .blue{ background: #0000ff; }
   </style>-->
<style type="text/css">
   div.parent > div {
   display: none;
   }
</style>
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Customer-Overview
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Info</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-7 col-md-offset-2">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <div class="box-body">
                  <table class="table table-bordered">
                     <tr>
                        <th>#</th>
                        <th>Index</th>
                        <th style="width: 40px">Value</th>
                     </tr>
                     <tr>
                        <td>1</td>
                        <td> SER </td>
                        <td>{{ $microvalue->ser ? $microvalue->ser :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td>2</td>
                        <td> Social Impact (&#163;m) </td>
                        <td>{{ $microvalue->social_impact ? $microvalue->social_impact :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td> 3 </td>
                        <td> Social Impact as a percentage of Capitalization (%)</td>
                        <td>{{ $microvalue->social_impact_asap_cap ? $microvalue->social_impact_asap_cap :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td> 4 </td>
                        <td> Added Value</td>
                        <td>{{ $microvalue->added_value ? $microvalue->added_value :'N/A'}}</td>
                     </tr>
                  </table>
               </div>
               <br>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <!--/.col (right) -->
   </section>
   <!-- /.right-side -->
</div>
@stop
