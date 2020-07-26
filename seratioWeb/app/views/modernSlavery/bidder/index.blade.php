@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('Bidder'))
Seratio::Bidder::Modern Slavery Entries
@endif
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View  All Entries
      </h1>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               @if (Session::has('message'))
               <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong> {{ Session::get('message') }}</strong>
               </div>
               @endif
               <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>The RAG results identify how well your company is complying to the Modern Slavery Act 2015 </strong>
               </div>
               <div class="box-body table-responsive">
                  <table id="mslavery" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Financial Year</th>
                           <th>Total Salary (£)</th>
                           <th>Total Staff (#)</th>
                           <th>Sentiment (%)</th>
                           <th>Created At</th>
                           <th>Result</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($modernSlavery as $value)
                        <tr>
                           <td>{{ $value->financial_year ? $value->financial_year :'N/A' }} </td>
                           <td>{{ $value->total_salary ? $value->total_salary :'N/A' }} </td>
                           <td>{{ $value->total_staff ? $value->total_staff :'N/A' }} </td>
                           <td>{{ $value->sentiment ? $value->sentiment :'N/A' }} </td>
                           <td>{{ $value->created_at ? date ('d-m-Y H:i:s', strtotime($value->created_at)) :'N/A' }} </td>
                           <td>
                              <div id="light">
                                 @if($value->result > 2)
                                 <span id="red"></span>
                                 <span id="orange"></span>
                                 <span class="active" id="green"></span>
                                 @elseif($value->result >= 0.5 && $value->result <= 2)
                                 <span id="red"></span>
                                 <span class="active" id="orange"></span>
                                 <span id="green"></span>
                                 @elseif($value->result < 0.5)
                                 <span class="active" id="red"></span>
                                 <span id="orange"></span>
                                 <span id="green"></span>
                                 @else
                                 <span id="red"></span>
                                 <span id="orange"></span>
                                 <span id="green"></span>
                                 @endif
                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- ./wrapper -->
@stop
@section('scripts')
<!-- page script -->
<script type="text/javascript">
   $(function() {
     $("#mslavery").dataTable({
       "pageLength": 5,
       "bLengthChange": false
     });
   });
</script>
@stop
