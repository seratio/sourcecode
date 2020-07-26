@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('admin'))
Seratio::Bidders::Manage Contracts
@endif
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Manage Contracts
         <a href="#" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal">Assign contract</a>
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
               <div class="box-body table-responsive" style="overflow: scroll;">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Contract Name</th>
                           <th>Bidder Name</th>
                           <th>Created At</th>
                           <th>Actions</th>
                        </tr>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($values as $value)
                        <tr>
                           <td>{{ $value->contract_id ? Wmcuscontract::find($value->contract_id)->contract_name : 'N/A'}}</td>
                           <td>{{ $value->user_id ? User::find($value->user_id)->firstname : 'N/A' }}</td>
                           <td>{{ $value->created_at ? date('d-m-Y H:i:s', strtotime($value->contract->created_at)): 'N/A' }}</td>
                           <td>
                              <a href="{{URL::route('bidders.index', ['contract_id' => $value->contract_id])}}" class="btn btn-info btn-xs" title="View Initiatives">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('bidder.delete', ['id' => $value->id]) }}" title="Delete Tender">
                              <span class="glyphicon glyphicon-minus-sign"></span>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog custom-modal">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Manage Contracts</h4>
         </div>
         <div class="modal-body">
            @if (Session::has('message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
               <strong> {{ Session::get('message') }}</strong>
            </div>
            @endif
            {{ Form::open(array('route' => array('bidder.assign'), 'method' => 'POST')) }}
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label>Contract Name</label>
                     {{ Form::select('contract_id', Wmcuscontract::forSelect(), '',  array('id' => 'contract_dropdown', 'class' => 'form-control', 'required')) }}
                     @if ($errors->has('contract_id'))
                     <p class="help-block" style="color:red">{{ $errors->first('contract_id') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Bidder Name</label>
                     {{ Form::select('user_id', User::forSelectBidders(), '',  array('class' => 'form-control', 'required')) }}
                     @if ($errors->has('user_id'))
                     <p class="help-block" style="color:red">{{ $errors->first('user_id') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Financial Year</label>
                     {{ Form::select('financial_year', [], '',  array('id' => 'financial_year', 'class' => 'form-control', 'required')) }}
                     @if ($errors->has('financial_year'))
                     <p class="help-block" style="color:red">{{ $errors->first('financial_year') }}</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
            {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
         </div>
         {{ Form::close() }}
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@stop
@section('scripts')
<!-- page script -->
<script type="text/javascript">
   $(function() {
     $("#example1").dataTable();
     $('#contract_dropdown').on('change', function() {
       console.log("Success");
       $('#financial_year').empty();
       var id = $('#contract_dropdown').val();
       $('#financial_year').html('<option selected="selected" value="">Loading...</option>');

        $.ajax({
            url: 'getFinancialYearforBidder/{id}',
            type: "GET",
            dataType: "json",
            data: {id: id},
            success:function(data) {
                console.log(data);
                $('#financial_year').html('<option selected="selected" value="">Select Financial Year</option>');
                $.each(data, function(key, value) {

                    $('#financial_year').append('<option value="'+value+'">'+value+'</option>');
                });

            }
        });
        });
   });
</script>
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
<script type="text/javascript">
   $(function() {
       $('#myModal').modal('show');
   });
</script>
@elseif(!empty(Session::get('success_code')) && Session::get('success_code') == 1)
<script type="text/javascript">
   $(function() {
       $('#myModal').modal('show');
   });
</script>
@endif
@stop
