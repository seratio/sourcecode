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
         Add an Initiative for {{$contract->contract}}
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
               {{ Form::open(array('route' => array('bidders.store'), 'method' => 'POST')) }}
               {{ Form::hidden('user_id', Auth::user()->id)}}
               {{ Form::hidden('contract_id', $contract->id)}}
               <div class="box-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label>Name of Customer <label data-toggle="tooltip" data-placement="right" title="Authority who has issued tender"><a href="#">(?)</a></label></label>
                           {{ Form::text('name_of_customer', $contract->public_sector_organisation, array('class' => 'form-control', 'placeholder' => 'Name of Customer', 'disabled')) }}
                        </div>
                        <div class="form-group">
                           <label>Name of Contract <label data-toggle="tooltip" data-placement="right" title="The contract currently bidding for"><a href="#">(?)</a></label></label>
                           {{ Form::text('name_of_contract', $contract->contract_name, array('class' => 'form-control', 'placeholder' => 'Name of Contract', 'disabled')) }}
                        </div>
                        <div class="form-group">
                           <label>Bid Value (£m) <label data-toggle="tooltip" data-placement="right" title="The total value of the bid for the full contract"><a href="#">(?)</a></label></label>
                           {{ Form::text('bid_value', '', array('class' => 'form-control', 'placeholder' => 'Bid Value', 'required')) }}
                           @if ($errors->has('bid_value'))
                           <p class="help-block" style="color:red">{{ $errors->first('bid_value') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Social Value Investment(£)<label data-toggle="tooltip" data-placement="right" title="The total financial investment for social initiatives throughout the life of the contract"><a href="#">(?)</a></label></label>
                           {{ Form::text('sv_investment', '', array('class' => 'form-control', 'placeholder' => 'Social Value Investment', 'required')) }}
                           @if ($errors->has('sv_investment'))
                           <p class="help-block" style="color:red">{{ $errors->first('sv_investment') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Initiative <label data-toggle="tooltip" data-placement="right" title="The name of the initiative/project creating Social Value"><a href="#">(?)</a></label></label>
                           {{ Form::text('initiative', '', array('class' => 'form-control', 'placeholder' => 'Initiative', 'required')) }}
                           @if ($errors->has('initiative'))
                           <p class="help-block" style="color:red">{{ $errors->first('initiative') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Cost(£m) <label data-toggle="tooltip" data-placement="right" title="The cost of this single initiative/project, includes the cost of staff (day/hourly rate), admin, course, room hire etc."><a href="#">(?)</a></label></label>
                           {{ Form::text('cost', '', array('class' => 'form-control', 'placeholder' => 'Cost', 'required')) }}
                           @if ($errors->has('cost'))
                           <p class="help-block" style="color:red">{{ $errors->first('cost') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>People(#m) <label data-toggle="tooltip" data-placement="right" title="Number of people initiative will benefit"><a href="#">(?)</a></label></label>
                           {{ Form::text('people', '', array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
                           @if ($errors->has('people'))
                           <p class="help-block" style="color:red">{{ $errors->first('people') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sentiment-Positive (#) <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Positive feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('positive', '', array('class' => 'form-control', 'placeholder' => 'Sentiment-Positive', 'required')) }}
                           @if ($errors->has('positive'))
                           <p class="help-block" style="color:red">{{ $errors->first('positive') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Neutral (#) <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Neutral feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('neutral', '', array('class' => 'form-control', 'placeholder' => 'Neutral', 'required')) }}
                           @if ($errors->has('neutral'))
                           <p class="help-block" style="color:red">{{ $errors->first('neutral') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sentiment-Negative (#) <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Negative feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('negative', '', array('class' => 'form-control', 'placeholder' => 'Sentiment-Negative', 'required')) }}
                           @if ($errors->has('negative'))
                           <p class="help-block" style="color:red">{{ $errors->first('negative') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Target Population (#) <label data-toggle="tooltip" data-placement="right" title="This is the total number of people in the area who require the support offered for example, there are 2000 people unemployed in the area, therefore 2000 would be inputted here."><a href="#">(?)</a></label></label>
                           {{ Form::text('target_population', '', array('class' => 'form-control', 'placeholder' => 'Target Population', 'required')) }}
                           @if ($errors->has('target_population'))
                           <p class="help-block" style="color:red">{{ $errors->first('target_population') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Margin of errors (%) <label data-toggle="tooltip" data-placement="right" title="The predicted sentiment data provided is open to error, please state an error % allowance.  10% is the recommended amount."><a href="#">(?)</a></label></label>
                           {{ Form::text('margin_errors', '', array('class' => 'form-control', 'type'=>'number', 'min' => '0', 'max'=> '100', 'placeholder' => 'Margin of errors', 'required')) }}
                           @if ($errors->has('margin_errors'))
                           <p class="help-block" style="color:red">{{ $errors->first('margin_errors') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Environment(tCO2e) <label data-toggle="tooltip" data-placement="right" title="How much tCO2e will be saved – if applicable"><a href="#">(?)</a></label></label>
                           {{ Form::text('environment', '', array('class' => 'form-control', 'placeholder' => 'Environment', 'required')) }}
                           @if ($errors->has('environment'))
                           <p class="help-block" style="color:red">{{ $errors->first('environment') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Hyperlocality (Km) <label data-toggle="tooltip" data-placement="right" title="Distance between the epicentre of your initiative and the targeted epicentre required by the customer (if none provided use customer’s HQ address"><a href="#">(?)</a></label></label>
                           {{ Form::text('hyperlocality', '', array('class' => 'form-control', 'placeholder' => 'Hyperlocality', 'required')) }}
                           @if ($errors->has('hyperlocality'))
                           <p class="help-block" style="color:red">{{ $errors->first('hyperlocality') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>
                  {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                  {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                  {{ Form::close() }}
               </div>
            </div>
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
