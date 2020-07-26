@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::Customer Data
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
         Customer-Data
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Data</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <div class="box-body table-responsive" style="overflow: scroll;">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Target Audience</th>
                           <th>Date</th>
                           <th>Positive</th>
                           <th>Negative</th>
                           <th>Neutral</th>
                           <th>Sentiment Date</th>
                           <th>Non Statutory Spend</th>
                           <th>Number of Service Users</th>
                           <th>Net Asset Value</th>
                           <th>Number of Staff</th>
                           <th>Carbon Reduction</th>
                           <th>Carbon Offset</th>
                           <th>People</th>
                           <th>Money Leveraged</th>
                           <th>Year Directors Salary(cur)</th>
                           <th>Members Salary(cur)</th>
                           <th>Total Staff Salary Bill(cur)</th>
                           <th>Executive Board(cur)</th>
                           <th>Total Number of Councilers/Members(cur)</th>
                           <th>Total Number of Board/Senior executives/Directors(cur)</th>
                           <th>Total Number of Staff(cur)</th>
                           <th>Directors Salary(pre)</th>
                           <th>Members Salary(pre)</th>
                           <th>Total Staff Salary Bill(pre)</th>
                           <th>Executive Board(pre)</th>
                           <th>Total Number of Councilers/Members(pre)</th>
                           <th>Total Number of Board/Senior executives/Directors(pre)</th>
                           <th>Total Number of Staff(pre)</th>
                           <th>SER</th>
                           <th>Social Impact</th>
                           <th>Social Impact as a Percentage of Capitilisation </th>
                           <th>Added Value</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>{{ $microvalue->targeted_audience ? $microvalue->targeted_audience : 'N/A'}}</td>
                           <td>{{ $microvalue->sentiment_date ? $microvalue->sentiment_date : 'N/A' }} </td>
                           <td>{{ $microvalue->positive ? $microvalue->positive : 'N/A' }}</td>
                           <td>{{ $microvalue->negative ? $microvalue->negative : 'N/A' }}</td>
                           <td>{{ $microvalue->neutral ? $microvalue->neutral : 'N/A'}}</td>
                           <td>{{ $microvalue->sentiment_date ? $microvalue->sentiment_date : 'N/A' }}</td>
                           <td>{{ $microvalue->non_statutory_spend ? $microvalue->non_statutory_spend : 'N/A'  }}</td>
                           <td>{{ $microvalue->no_of_service_users ? $microvalue->no_of_service_users : 'N/A' }}</td>
                           <td>{{ $microvalue->net_asset_value ? $microvalue->net_asset_value : 'N/A' }} </td>
                           <td>{{ $microvalue->staff ? $microvalue->staff : 'N/A' }}</td>
                           <td>{{ $microvalue->carbon_reduction_t ? $microvalue->carbon_reduction_t : 'N/A' }}</td>
                           <td>{{ $microvalue->carbon_offset ? $microvalue->carbon_offset : 'N/A'}}</td>
                           <td>{{ $microvalue->people ? $microvalue->people : 'N/A' }}</td>
                           <td>{{ $microvalue->money_leveraged ? $microvalue->money_leveraged : 'N/A' }}</td>
                           <td>{{ $microvalue->cu_directors_salary ? $microvalue->cu_directors_salary : 'N/A' }}</td>
                           <td>{{ $microvalue->cu_members_salary ? $microvalue->cu_members_salary : 'N/A' }}</td>
                           <td>{{ $microvalue->cu_staff_salary_bill ? $microvalue->cu_staff_salary_bill : 'N/A' }} </td>
                           <td>{{ $microvalue->cu_executive_board ? $microvalue->cu_executive_board : 'N/A' }}</td>
                           <td>{{ $microvalue->cu_total_counc_members ? $microvalue->cu_total_counc_members : 'N/A'}}</td>
                           <td>{{ $microvalue->cu_total_board_senior_directors ? $microvalue->cu_total_board_senior_directors : 'N/A' }}</td>
                           <td>{{ $microvalue->cu_total_staff ? $microvalue->cu_total_staff : 'N/A' }}</td>
                           <td>{{ $microvalue->py_directors_salary ? $microvalue->py_directors_salary : 'N/A' }}</td>
                           <td>{{ $microvalue->py_members_salary ? $microvalue->py_members_salary : 'N/A' }}</td>
                           <td>{{ $microvalue->py_staff_salary_bill ? $microvalue->py_staff_salary_bill : 'N/A' }} </td>
                           <td>{{ $microvalue->py_executive_board ? $microvalue->py_executive_board : 'N/A'}}</td>
                           <td>{{ $microvalue->py_total_counc_members ? $microvalue->py_total_counc_members : 'N/A' }}</td>
                           <td>{{ $microvalue->py_total_board_senior_directors ? $microvalue->py_total_board_senior_directors : 'N/A' }}</td>
                           <td>{{ $microvalue->py_total_staff ? $microvalue->py_total_staff : 'N/A' }}</td>
                           <td>{{ $microvalue->ser ? $microvalue->ser : 'N/A' }}</td>
                           <td>{{ $microvalue->social_impact ? $microvalue->social_impact : 'N/A'}}</td>
                           <td>{{ $microvalue->social_impact_asap_cap ? $microvalue->social_impact_asap_cap : 'N/A'}}</td>
                           <td>{{ $microvalue->added_value ? $microvalue->added_value : 'N/A'}}</td>
                        </tr>
                     </tbody>
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
