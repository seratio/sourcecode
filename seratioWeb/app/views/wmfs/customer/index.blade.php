@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::All Contracts
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::All Contracts
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::All Contracts
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::All Contracts
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::All Contracts
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::All Contracts
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::All Contracts
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::All Contracts
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::All Contracts
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::All Contracts
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::All Contracts
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::All Contracts
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::All Contracts
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::All Contracts
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

          </div><!-- /.box-header -->
          @if (Session::has('message'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong> {{ Session::get('message') }}</strong>
          </div>
          @endif

          @if ($no_of_contracts > 0)
          <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong> Please find below all listed contracts, you can view each of the contract details by pressing the green symbol in the action column</strong>
          </div>
          @endif


          <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Contract Holder</th>
                  <th>Name of Contract</th>
                  <th>Value of Contract (£m)</th>
                  <th>Reference of Contract</th>
                  <th>Start Date</th>
                  <th>Length of Contract</th>
                  @if(Auth::user()->has_subrole('supplier'))
                  <th>Measured Year</th>
                  @endif
                  <th>Actions</th>

                </tr>
              </thead>

              @if(Auth::user()->has_role('admin') || Auth::user()->has_subrole('customer'))
              <tbody>

                @foreach($contracts as $contract)
                <tr>
                  <td>{{$contract->public_sector_organisation ? $contract->public_sector_organisation : 'Unknown'}}</td>
                  <td>{{ $contract->contract_name ? $contract->contract_name  : 'N/A' }} </td>
                  <td>{{ $contract->contract_value ? $contract->contract_value :'N/A' }} </td>
                  <td>{{ $contract->contract_reference ? $contract->contract_reference :'N/A' }} </td>
                  <td>{{ $contract->date_start ? date('d-m-Y', strtotime($contract->date_start)) :'N/A' }} </td>
                  <td>{{ $contract->contract_length ? $contract->contract_length :'N/A' }} </td>
                  <td>
                    @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                    Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                    Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                    Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                    Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                    Auth::user()->has_subrole('customer'))
                    <a href= "{{URL::route('customer.show',['$id'=>$contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                      <span class="glyphicon glyphicon-eye-open"></span></a>
                    {{ Form::open(array('route' => array('customer.destroy', $contract->id), 'method' => 'delete', 'onsubmit' => 'return confirmDelete()')) }}
                    <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus-sign"></span></button>
                    {{ Form::close() }}
                      @elseif(Auth::user()->has_role('admin'))
                      <a href= "{{URL::route('customer.show',['$id'=>$contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                        <span class="glyphicon glyphicon-eye-open"></span></a>
                        @endif
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                  @elseif(Auth::user()->has_subrole('supplier'))
                  <tbody>

                    @foreach($contracts as $contract)
                    <tr>
                      <td>{{$contract->contract ? $contract->contract->public_sector_organisation : 'Unknown'}}</td>
                      <td>{{ $contract->contract ? $contract->contract->contract_name : 'N/A' }} </td>
                      <td>{{ $contract->contract ? $contract->contract->contract_value :'N/A' }} </td>
                      <td>{{ $contract->contract ? $contract->contract->contract_reference :'N/A' }} </td>
                      <td>{{ $contract->contract ?  date('d-m-Y', strtotime($contract->contract->date_start)) :'N/A' }} </td>
                      <td>{{ $contract->contract ?  $contract->contract->contract_length :'N/A' }} </td>
                      <td>{{ $contract->contract ?  $contract->financial_year :'N/A' }} </td>
                      <td>
                        @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                        Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                        Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                        Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                        Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                        Auth::user()->has_subrole('supplier'))
                        <a href= "{{URL::route('customer.show',['$id'=>$contract->contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                          <span class="glyphicon glyphicon-eye-open"></span></a>
                          @endif
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                    @endif
                    <tfoot>

                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>

        </section><!-- /.content -->
      </div>


      @stop
      @section('scripts')

      <!-- page script -->
      <script type="text/javascript">
      $(function() {
        $("#example1").dataTable();
      });

      function confirmDelete() {
        var result = confirm('The contract will be deleted and all associated initiatives will be deleted as well. Do you want to proceed?');

        if (result) {
          return true;
        } else {
          return false;
        }
      }
    </script>
    @stop
