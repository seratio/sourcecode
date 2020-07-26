@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::Sentiment
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
         Customer-Sentiment
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Sentiment</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-10 col-md-offset-1">
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
                        <th style="width:200px;">Value</th>
                     </tr>
                     <tr>
                        <td>1</td>
                        <td> Targeted Audience </td>
                        <td>{{ $microvalue->targeted_audience ? $microvalue->targeted_audience :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td>2</td>
                        <td> Positive</td>
                        <td>{{ $microvalue->positive ? $microvalue->positive :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td> 3</td>
                        <td> Neutral</td>
                        <td>{{ $microvalue->neutral ? $microvalue->neutral :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td> 4 </td>
                        <td> Negative</td>
                        <td>{{ $microvalue->negative ? $microvalue->negative :'N/A'}}</td>
                     </tr>
                     <tr>
                        <td> 5 </td>
                        <td> Sentiment Date</td>
                        <td>{{ $microvalue->sentiment_date ? $microvalue->sentiment_date :'N/A'}}</td>
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
