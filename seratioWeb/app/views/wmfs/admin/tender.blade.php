@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Tender
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::Tender
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::Tender
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::Tender
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::Tender
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::Tender
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::Tender
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::Tender
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::Tender
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::Tender
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::Tender
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::Tender
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::Tender
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::Tender
@endif
@parent
@stop

@section('content')

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View All Tenders / {{$user->organisation}}
      <a href="#" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal">Add a Tender</a>
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
          <div class="box-body table-responsive" style="overflow: scroll;">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Contract Name</th>
                  <th>Estimated Price</th>
                  <th>Tender</th>
                  <th>Social Value Act</th>
                  <th>Modern Slavery Act</th>
                  <th>Contract Value(£)</th>
                  <th>Added Social Value(£)</th>
                  <th>People</th>
                  <th>Cash</th>
                  <th>Environment</th>
                  <th>Hyperlocality</th>
                  <th>Pay Disparity</th>
                  <th>Tax Avoidance</th>
                  <th>Social Value as a % of Contract Value</th>
                  <th>KPI 1</th>
                  <th>KPI 2</th>
                  <th>Final Score</th>
                  <th>Price Scoring</th>
                  <th>Quality Scoring</th>
                  <th>Social Value Scoring</th>
                  <th>Actions</th>
                </tr>

              </tr>
            </thead>
            <tbody>
              @foreach($tenders as $tender)
              <tr>
                <td>{{ $tender->contract_name ? $tender->contract_name : 'N/A'}}</td>
                <td>{{ $tender->estimated_price ? $tender->estimated_price : 'N/A' }}</td>
                <td>{{ $tender->tender ? $tender->tender : 'N/A' }}</td>
                @if($tender->social_value_act == "Green")
                <td style="background-color:green;"></td>
                @elseif($tender->social_value_act == "Amber")
                <td style="background-color:#ffc200;"></td>
                @elseif($tender->social_value_act == "Red")
                <td style="background-color:red;"></td>
                @else
                <td></td>
                @endif
                @if($tender->modern_slavery_act == "Green")
                <td style="background-color:green;"></td>
                @elseif($tender->modern_slavery_act == "Amber")
                <td style="background-color:#ffc200;"></td>
                @elseif($tender->modern_slavery_act == "Red")
                <td style="background-color:red;"></td>
                @else
                <td></td>
                @endif
                <td>{{ $tender->contract_value ? $tender->contract_value : 'N/A' }}</td>
                <td>{{ $tender->added_social_value ? $tender->added_social_value : 'N/A' }}</td>
                <td>{{ $tender->people ? $tender->people : 'N/A' }}</td>
                <td>{{ $tender->cash ? $tender->cash : 'N/A' }}</td>
                <td>{{ $tender->environment ? $tender->environment : 'N/A' }}</td>
                <td>{{ $tender->hyperlocality ? $tender->hyperlocality : 'N/A' }}</td>
                <td>{{ $tender->pay_disparity ? $tender->pay_disparity : 'N/A' }}</td>
                <td>{{ $tender->tax_avoidance ? $tender->tax_avoidance : 'N/A' }}</td>
                <td>{{ $tender->sv_as_perc_contract_value ? $tender->sv_as_perc_contract_value : 'N/A' }}</td>
                <td>{{ $tender->kpi1 ? $tender->kpi1 : 'N/A' }}</td>
                <td>{{ $tender->kpi2 ? $tender->kpi2 : 'N/A' }}</td>
                <td>{{ $tender->final_score ? $tender->final_score : 'N/A' }}</td>
                <td>{{ $tender->price_scoring ? $tender->price_scoring : 'N/A' }}</td>
                <td>{{ $tender->quality_scoring ? $tender->quality_scoring : 'N/A' }}</td>
                <td>{{ $tender->social_value_scoring ? $tender->social_value_scoring : 'N/A' }}</td>
                <td>
                  <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('tenders.destroy', ['id' => $tender->id]) }}" title="Delete Tender">
                    <span class="glyphicon glyphicon-minus-sign"></span>
                  </td>


                </tr>
                @endforeach

              </tbody>

            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
    
  </section><!-- /.content -->

</div><!-- ./wrapper -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add a Tender/{{$user->organisation}}</h4>
      </div>
      <div class="modal-body">
        @if (Session::has('message'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <strong> {{ Session::get('message') }}</strong>
        </div>
        @endif

        {{ Form::open(array('route' => array('tenders.store'), 'method' => 'POST')) }}
        {{ Form::hidden('user_id', $user->id)}}

        <div class="row">
          <div class="col-lg-6">

            <div class="form-group">
              <label>Contract Name</label>
              {{ Form::text('contract_name', '', array('class' => 'form-control', 'placeholder' => 'Contract Name', 'required')) }}
              @if ($errors->has('contract_name'))  <p class="help-block" style="color:red">{{ $errors->first('contract_name') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Tender</label>
              {{ Form::text('tender', '', array('class' => 'form-control', 'placeholder' => 'Tender', 'required')) }}
              @if ($errors->has('tender')) <p class="help-block" style="color:red">{{ $errors->first('tender') }}</p> @endif
            </div>


            <div class="form-group">
              <label>Modern Slavery Act</label>
              {{ Form::select('modern_slavery_act',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], '',  array('class' => 'form-control', 'required')) }}
              @if ($errors->has('modern_slavery_act')) <p class="help-block" style="color:red">{{ $errors->first('modern_slavery_act') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Added Social Value(£)</label>
              {{ Form::text('added_social_value', '', array('class' => 'form-control', 'placeholder' => 'Added Social Value(£)')) }}
              @if ($errors->has('added_social_value')) <p class="help-block" style="color:red">{{ $errors->first('added_social_value') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Cash</label>
              {{ Form::text('cash', '', array('class' => 'form-control', 'placeholder' => 'Cash')) }}
              @if ($errors->has('cash')) <p class="help-block" style="color:red">{{ $errors->first('cash') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Hyperlocality</label>
              {{ Form::text('hyperlocality', '', array('class' => 'form-control', 'placeholder' => 'Hyperlocality', 'required')) }}
              @if ($errors->has('hyperlocality')) <p class="help-block" style="color:red">{{ $errors->first('hyperlocality') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Tax Avoidance</label>
              {{ Form::text('tax_avoidance', '', array('class' => 'form-control', 'placeholder' => 'Tax Avoidance', 'required')) }}
              @if ($errors->has('tax_avoidance')) <p class="help-block" style="color:red">{{ $errors->first('tax_avoidance') }}</p> @endif
            </div>

            <div class="form-group">
              <label>KPI 1</label>
              {{ Form::text('kpi1', '', array('class' => 'form-control', 'placeholder' => 'KPI 1', 'required')) }}
              @if ($errors->has('kpi1')) <p class="help-block" style="color:red">{{ $errors->first('kpi1') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Final Score</label>
              {{ Form::text('final_score', '', array('class' => 'form-control', 'placeholder' => 'Final Score', 'required')) }}
              @if ($errors->has('final_score')) <p class="help-block" style="color:red">{{ $errors->first('final_score') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Quality Scoring</label>
              {{ Form::text('quality_scoring', '', array('class' => 'form-control', 'placeholder' => 'Quality Scoring', 'required')) }}
              @if ($errors->has('quality_scoring')) <p class="help-block" style="color:red">{{ $errors->first('quality_scoring') }}</p> @endif
            </div>


          </div>
          <div class="col-lg-6">

            <div class="form-group">
              <label>Contract Estimated Price(£)</label>
              {{ Form::text('estimated_price', '', array('class' => 'form-control', 'placeholder' => 'Contract Estimated Price', 'required')) }}
              @if ($errors->has('estimated_price')) <p class="help-block" style="color:red">{{ $errors->first('estimated_price') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Social Value Act</label>
              {{ Form::select('social_value_act',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], '',  array('class' => 'form-control', 'required')) }}
              @if ($errors->has('social_value_act'))  <p class="help-block" style="color:red">{{ $errors->first('social_value_act') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Contract Value(£)</label>
              {{ Form::text('contract_value', '', array('class' => 'form-control', 'placeholder' => 'Contract Value(£)', 'required')) }}
              @if ($errors->has('contract_value')) <p class="help-block" style="color:red">{{ $errors->first('contract_value') }}</p> @endif
            </div>


            <div class="form-group">
              <label>People</label>
              {{ Form::text('people', '', array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
              @if ($errors->has('people')) <p class="help-block" style="color:red">{{ $errors->first('people') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Environment</label>
              {{ Form::text('environment', '', array('class' => 'form-control', 'placeholder' => 'Environment', 'required')) }}
              @if ($errors->has('environment')) <p class="help-block" style="color:red">{{ $errors->first('environment') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Pay Disparity</label>
              {{ Form::text('pay_disparity', '', array('class' => 'form-control', 'placeholder' => 'Pay Disparity', 'required')) }}
              @if ($errors->has('pay_disparity')) <p class="help-block" style="color:red">{{ $errors->first('pay_disparity') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Social Value as a % of Contract Value</label>
              {{ Form::text('sv_as_perc_contract_value', '', array('class' => 'form-control', 'placeholder' => 'Social Value as a % of Contract Value', 'required')) }}
              @if ($errors->has('sv_as_perc_contract_value')) <p class="help-block" style="color:red">{{ $errors->first('sv_as_perc_contract_value') }}</p> @endif
            </div>

            <div class="form-group">
              <label>KPI 2</label>
              {{ Form::text('kpi2', '', array('class' => 'form-control', 'placeholder' => 'KPI 2', 'required')) }}
              @if ($errors->has('kpi2')) <p class="help-block" style="color:red">{{ $errors->first('kpi2') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Price Scoring</label>
              {{ Form::text('price_scoring', '', array('class' => 'form-control', 'placeholder' => 'Price Scoring', 'required')) }}
              @if ($errors->has('price_scoring')) <p class="help-block" style="color:red">{{ $errors->first('price_scoring') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Social Value Scoring</label>
              {{ Form::text('social_value_scoring', '', array('class' => 'form-control', 'placeholder' => 'Social Value Scoring', 'required')) }}
              @if ($errors->has('social_value_scoring')) <p class="help-block" style="color:red">{{ $errors->first('social_value_scoring') }}</p> @endif
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
});
</script>
@stop
