@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('Bidder'))
Seratio::Bidder::All Initiatives
@endif
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit an Initiative for {{$contract->contract_name}}
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
               {{ Form::open(array('route'=> 'bidders.store', 'class' => 'form')) }}
               {{ Form::hidden('user_id', Auth::user()->id)}}
               {{ Form::hidden('contract_id', $contract->id)}}
               {{ Form::hidden('initiative', $initiative->initiative)}}
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
                           <label>Bid Value <label data-toggle="tooltip" data-placement="right" title="Bid offer for the tender"><a href="#">(?)</a></label></label>
                           {{ Form::text('bid_value', $initiative->bid_value, array('class' => 'form-control', 'placeholder' => 'Bid Value', 'required')) }}
                           @if ($errors->has('bid_value'))
                           <p class="help-block" style="color:red">{{ $errors->first('bid_value') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Social Value Investment <label data-toggle="tooltip" data-placement="right" title="Bidders financial investment for social initiatives"><a href="#">(?)</a></label></label>
                           {{ Form::text('sv_investment', $initiative->sv_investment, array('class' => 'form-control', 'placeholder' => 'Social Value Investment', 'required')) }}
                           @if ($errors->has('sv_investment'))
                           <p class="help-block" style="color:red">{{ $errors->first('sv_investment') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Initiative <label data-toggle="tooltip" data-placement="right" title="Name of the initiative"><a href="#">(?)</a></label></label>
                           {{ Form::text('initiative', $initiative->initiative, array('class' => 'form-control', 'placeholder' => 'Initiative', 'disabled')) }}
                           @if ($errors->has('initiative'))
                           <p class="help-block" style="color:red">{{ $errors->first('initiative') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Cost <label data-toggle="tooltip" data-placement="right" title="Cost to bidder of initiative"><a href="#">(?)</a></label></label>
                           {{ Form::text('cost', $initiative->cost, array('class' => 'form-control', 'placeholder' => 'Cost', 'required')) }}
                           @if ($errors->has('cost'))
                           <p class="help-block" style="color:red">{{ $errors->first('cost') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>People <label data-toggle="tooltip" data-placement="right" title="Number of people initiative will benefit"><a href="#">(?)</a></label></label>
                           {{ Form::text('people', $initiative->people, array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
                           @if ($errors->has('people'))
                           <p class="help-block" style="color:red">{{ $errors->first('people') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sentiment-Positive <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Positive feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('positive', $initiative->positive, array('class' => 'form-control', 'placeholder' => 'Sentiment-Positive', 'required')) }}
                           @if ($errors->has('positive'))
                           <p class="help-block" style="color:red">{{ $errors->first('positive') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Neutral <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Neutral feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('neutral', $initiative->neutral, array('class' => 'form-control', 'placeholder' => 'Neutral', 'required')) }}
                           @if ($errors->has('neutral'))
                           <p class="help-block" style="color:red">{{ $errors->first('neutral') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sentiment-Negative <label data-toggle="tooltip" data-placement="right" title="A prediction of how many Negative feedbacks the initiative will receive"><a href="#">(?)</a></label></label>
                           {{ Form::text('negative', $initiative->negative, array('class' => 'form-control', 'placeholder' => 'Sentiment-Negative', 'required')) }}
                           @if ($errors->has('negative'))
                           <p class="help-block" style="color:red">{{ $errors->first('negative') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Environment <label data-toggle="tooltip" data-placement="right" title="How much tCO2e will be saved – if applicable"><a href="#">(?)</a></label></label>
                           {{ Form::text('environment', $initiative->environment, array('class' => 'form-control', 'placeholder' => 'Environment', 'required')) }}
                           @if ($errors->has('environment'))
                           <p class="help-block" style="color:red">{{ $errors->first('environment') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Hyperlocality <label data-toggle="tooltip" data-placement="right" title="How far, in miles, the initiative will reach."><a href="#">(?)</a></label></label>
                           {{ Form::text('hyperlocality', $initiative->hyperlocality, array('class' => 'form-control', 'placeholder' => 'Hyperlocality', 'required')) }}
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
