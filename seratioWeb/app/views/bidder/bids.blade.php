@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('Bidder'))
Seratio::Bidder::All Initiaives
@endif
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View  All Initiatives for {{$contract->contract_name}}
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
               <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Initiative</th>
                           <th>Cost</th>
                           <th>People</th>
                           <th>Environment</th>
                           <th>Hyperlocality</th>
                           <th>Created on</th>
                           <th>Added SV %</th>
                           <th>Added SV Financial Sum in UK £m</th>
                           <th>Social Value as a Percentage of a Target</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     @if(Auth::user()->has_role('Bidder') || Auth::user()->has_role('admin'))
                     <tbody>
                        @foreach($initiatives as $initiative)
                        <tr>
                           <td>{{ $initiative->initiative ? $initiative->initiative : 'Unknown'}}</td>
                           <td>{{ $initiative->cost ? $initiative->cost : 'N/A' }} </td>
                           <td>{{ $initiative->people ? $initiative->people :'N/A' }} </td>
                           <td>{{ $initiative->environment ? $initiative->environment :'N/A' }} </td>
                           <td>{{ $initiative->hyperlocality ? $initiative->hyperlocality :'N/A' }} </td>
                           <td>{{ $initiative->created_at ? date('d-m-Y H:i:s', strtotime($initiative->created_at)) :'N/A' }} </td>
                           <td>{{ $initiative->added_sv ? $initiative->added_sv : 'N/A' }} </td>
                           <td>{{ $initiative->added_sv_financial_sum ? $initiative->added_sv_financial_sum :'N/A' }} </td>
                           <td>{{ $initiative->sv_percentage_of_target ? $initiative->sv_percentage_of_target :'N/A' }} </td>
                           <td>
                              <!-- <a href= "#" class="btn btn-primary btn-xs" title="View Result" data-toggle="modal" data-target="#myModal{{$initiative->id}}">
                                 <span class="glyphicon glyphicon-eye-open"></span></a>
                                 <div class="modal fade" id="myModal{{$initiative->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Result</h4>
                                            </div>
                                            <div class="modal-body">
                                               @if($initiative->added_sv && $initiative->added_sv_financial_sum)
                                                 <div class="row">
                                                   <div class="col-lg-4">
                                                      <h4>Added Social Value % - <b>({{$initiative->added_sv}})</b></h4>
                                                      <div id="light">
                                                        @if($initiative->added_sv >= $initiative->sv_percentage_of_target)
                                                          <span id="red"></span>
                                                          <span id="orange"></span>
                                                          <span class="active" id="green"></span>
                                                        @elseif($initiative->added_sv >= ($initiative->added_sv/2))
                                                          <span id="red"></span>
                                                          <span class="active" id="orange"></span>
                                                          <span id="green"></span>
                                                        @elseif($initiative->added_sv < ($initiative->added_sv/2))
                                                          <span class="active" id="red"></span>
                                                          <span id="orange"></span>
                                                          <span id="green"></span>
                                                       @endif
                                                      </div>
                                                   </div>
                                                   <div class="col-lg-4">
                                                     <h4>Social Value as a Percentage of a Target - <b>({{$initiative->sv_percentage_of_target}})</b></h4>
                                                     <div id="light">
                                                       @if($initiative->sv_percentage_of_target >= '0' && $initiative->sv_percentage_of_target <= '14.1')
                                                         <span class="active" id="red"></span>
                                                         <span id="orange"></span>
                                                         <span id="green"></span>
                                                       @elseif($initiative->sv_percentage_of_target >= '14.2' && $initiative->sv_percentage_of_target <= '19.98' )
                                                         <span id="red"></span>
                                                         <span class="active" id="orange"></span>
                                                         <span id="green"></span>
                                                       @elseif($initiative->sv_percentage_of_target >= '19.9')
                                                         <span id="red"></span>
                                                         <span id="orange"></span>
                                                         <span class="active" id="green"></span>
                                                      @endif
                                                     </div>
                                                   </div>
                                                   <div class="col-lg-4">
                                                     <h4>Added SV Financial Sum - <b>({{$initiative->added_sv_financial_sum}})</b></h4>
                                                   </div>

                                                 </div>
                                               @else
                                                 <div class="row">
                                                   <p>Your data is being processed, please allow up to 24 hours for your results</p>
                                                 </div>
                                               @endif
                                            </div>
                                         </div>
                                     </div>
                                 </div> -->
                              @if(Auth::user()->has_role('Bidder'))
                                {{ Form::open(array('route' => array('bidders.destroy', $initiative->id), 'method' => 'delete', 'onsubmit' => 'return confirmDelete()')) }}
                                <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus-sign"></span></button>
                                {{ Form::close() }}
                              @endif
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     @endif
                  </table>
               </div>
               <!-- /.box-body -->
               <div class="box-body table-responsive">
                  <h2>Total Results</h2>
                  <table id="example2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Initiative</th>
                           <th>Cost</th>
                           <th>People</th>
                           <th>Environment</th>
                           <th>Hyperlocality</th>
                           <th>Added SV %</th>
                           <th>Added SV Financial Sum in UK £m</th>
                           <th>Social Value as a Percentage of a Target</th>
                        </tr>
                     </thead>
                     @if(Auth::user()->has_role('Bidder') || Auth::user()->has_role('admin'))
                     <tbody>
                        @foreach($totalResults as $initiative)
                        <tr>
                           <td>{{ $initiative['initiative'] ?  $initiative['initiative'] : 'Unknown'}}</td>
                           <td>{{ $initiative['cost'] ? $initiative['cost'] : 'N/A' }} </td>
                           <td>{{ $initiative['people'] ?  $initiative['people'] :'N/A' }} </td>
                           <td>{{ $initiative['environment'] ? $initiative['environment'] :'N/A' }} </td>
                           <td>{{ $initiative['hyperlocality'] ? $initiative['hyperlocality'] :'N/A' }} </td>
                           <td>{{ $initiative['added_sv'] ? $initiative['added_sv'] : 'N/A' }} </td>
                           <td>{{ $initiative['added_sv_financial_sum'] ? $initiative['added_sv_financial_sum'] :'N/A' }} </td>
                           <td>{{ $initiative['sv_percentage_of_target'] ? $initiative['sv_percentage_of_target'] :'N/A' }} </td>
                        </tr>
                        @endforeach
                     </tbody>
                     @endif
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
<!-- <script type="text/javascript">
   $(function() {
       $("#example1").dataTable();
   });
   </script> -->
<script type="text/javascript">
   $(document).ready(function() {
     var table = $('#example1').DataTable({
         "columnDefs": [
             { "visible": false, "targets": 0 }
         ],
         "order": [[ 0, 'asc' ]],
         "displayLength": 25,
         "drawCallback": function ( settings ) {
             var api = this.api();
             var rows = api.rows( {page:'current'} ).nodes();
             var last=null;

             api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                 if ( last !== group ) {
                     $(rows).eq( i ).before(
                         '<tr class="group"><td style="background-color:yellow;" colspan="10">'+group+'</td></tr>'
                     );

                     last = group;
                 }
             } );
         }
     } );

     // Order by the grouping
     $('#example1 tbody').on( 'click', 'tr.group', function () {
         var currentOrder = table.order()[0];
         if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
             table.order( [ 0, 'desc' ] ).draw();
         }
         else {
             table.order( [ 0, 'asc' ] ).draw();
         }
     } );
   } );

   var table = $('#example2').DataTable({
       "columnDefs": [
           { "visible": true, "targets": 0 }
       ],
       "order": [[ 0, 'asc' ]],
       "displayLength": 25,
   } );

   function confirmDelete() {
     var result = confirm('Are you sure you want to delete?');

     if (result) {
       return true;
     } else {
       return false;
     }
   }
</script>
@stop
