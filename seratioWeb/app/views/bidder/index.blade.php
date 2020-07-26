@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('Bidder'))
Seratio::Bidder::All Contracts
@endif
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View  All Contracts
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
               @if ($no_of_contracts > 0)
               <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong> Contract information and Social Value Expectations</strong>
                  <p>This section calculates the Social Value for each initiative/project you wish to offer in the bidding process, it provides you with a financial figure to help identify how efficient and effective your plans are.  Each initiative can be adjusted to assist you in creating the best possible impact, helping you to articulate your offerings in the bid submission.<br><br>
                     Please select the blue plus sign to the right of the contract information to add the details of each initiative/project.  To review and adjust the initiative information, select the blue eye symbol
                  </p>
               </div>
               @endif
               <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Contract Holder</th>
                           <th>Name of Contract</th>
                           <th>Value of Contract (£)</th>
                           <th>Reference of Contract</th>
                           <th>Dates of Contract</th>
                           <th>Length of Contract</th>
                           <th>Submission Deadline</th>
                           <!-- <th>Social Value % weight of final score</th> -->
                           <th>Actions</th>
                        </tr>
                     </thead>
                     @if(Auth::user()->has_role('admin') || Auth::user()->has_role('Bidder'))
                     <tbody>
                        @foreach($contracts as $contract)
                        <tr>
                           <td>{{ $contract->contract ? $contract->contract->public_sector_organisation : 'Unknown'}}</td>
                           <td>{{ $contract->contract ? $contract->contract->contract_name : 'N/A' }} </td>
                           <td>{{ $contract->contract ? $contract->contract->contract_value :'N/A' }} </td>
                           <td>{{ $contract->contract ? $contract->contract->contract_reference :'N/A' }} </td>
                           <td>{{ $contract->contract ? date('d-m-Y', strtotime($contract->contract->date_start)) :'N/A' }} </td>
                           <td>{{ $contract->contract ? $contract->contract->contract_length :'N/A' }} </td>
                           <td>{{ $contract->contract ? date('d-m-Y', strtotime($contract->contract->end_date)) :'N/A' }} </td>
                           <td>
                              @if(Auth::user()->has_role('Bidder'))
                              <a href= "{{URL::route('bidders.create',['contract_id'=> $contract->contract->id])}}" class="btn btn-primary btn-xs" title="Add an Initiative">
                              <span class="glyphicon glyphicon-plus"></span></a>
                              <a href="{{URL::route('bidders.index', ['contract_id' => $contract->contract->id])}}" class="btn btn-info btn-xs" title="View Initiatives">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              @elseif(Auth::user()->has_role('admin'))
                              <a href= "" class="btn btn-success btn-xs" title="View Results">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              @endif
                           </td>
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
<script type="text/javascript">
   $(function() {
       $("#example1").dataTable();
   });
</script>
@stop
