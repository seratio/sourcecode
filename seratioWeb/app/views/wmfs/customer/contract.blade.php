@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Add a Contract
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::Add a Contract
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::Add a Contract
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::Add a Contract
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::Add a Contract
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::Add a Contract
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::Add a Contract
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::Add a Contract
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::Add a Contract
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::Add a Contract
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::Add a Contract
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::Add a Contract
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::Add a Contract
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::Add a Contract
@endif
@parent
@stop

@section('css')
<style type='text/css'>
.well {
  background-color: #E8E7DA;
}

.slider-example {
  padding: 10px 0;
  margin: 35px 0;
}

#destroyEx5Slider, #ex6CurrentSliderValLabel, #ex7-enabled {
  margin-left: 45px;
}

#ex1SliderVal, #ex2SliderVal, #ex3SliderVal, #ex4SliderVal, #ex5SliderVal, #ex6SliderVal,
#ex7SliderVal, #ex8SliderVal, #ex9SliderVal {
  color: black;
}


#slider12a .slider-track-high, #slider12c .slider-track-high {
  background: green;
}

#slider12b .slider-track-low, #slider12c .slider-track-low {
  background: red;
}

#slider12c .slider-selection {
  background: yellow;
}
/* Example 1 custom styles */
#ex1Slider .slider-selection {
  background: #BABABA;
}

/* Example 3 custom styles */
#RGB {
  height: 20px;
  background: rgb(128, 128, 128);
}
#RC .slider-selection {
  background: #FF8282;
}
#RC .slider-handle {
  background: red;
}
#GC .slider-selection {
  background: #428041;
}
#GC .slider-handle {
  background: green;
}
#BC .slider-selection {
  background: #8283FF;
}
#BC .slider-handle {
  border-bottom-color: blue;
}
#R, #G, #B {
  width: 300px;
}

/* centered columns styles */
.row-centered {
  text-align:center;
}
.col-centered {
  display:inline-block;
  float:none;
  /* reset the text-align */
  text-align:left;
  /* inline-block space fix */
  margin-right:-4px;
}


</style>
@stop


@section('content')


<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add a Contract

    </h1>
    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Add a Contract</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <p class="description">
        @if (Session::has('message'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <strong> {{ Session::get('message') }}</strong>
        </div>
        @endif
      </p>
      <!-- left column -->
      <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">


          <div class="box-header">

          </div><!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">

            <div class="container">
              <div class="row">
                <div class="stepwizard">
                  <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                      <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                      <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                      <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                      <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                      <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                      <p>Step 3</p>
                    </div>
                  </div>
                </div>
              </div>
              {{ Form::open(array('route'=> 'customer.store', 'class' => 'form')) }}
              {{ Form::hidden('role_id', Auth::user()->role_id) }}
              <div class="row setup-content" id="step-1">
                <div class="col-lg-10">
                  <div class="col-md-10">
                    <h3> Contract Info</h3>

                    <div class="input-group">
                      <div class="input-group-addon"></div>
                      {{ Form::text('public_sector_organisation', '', array('class' => 'form-control', 'placeholder' => 'Name of Contractor', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Name of Contracted Organisation"><a href="#">Name of Contractor</a></label>
                      @if ($errors->has('public_sector_organisation')) <p class="help-block" style="color:red;">{{ $errors->first('public_sector_organisation') }}</p> @endif
                    </div>

                    <br>
                    <div class="input-group">
                      <div class="input-group-addon"></div>
                      {{ Form::text('contract_name', '', array('class' => 'form-control', 'placeholder' => 'Name of Contract', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Title of the contract as per the ITT"><a href="#">Name of Contract</a></label>
                    </div>
                    @if ($errors->has('contract_name')) <p class="help-block" style="color:red;">{{ $errors->first('contract_name') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">£m</div>
                      {{ Form::text('contract_value', '', array('class' => 'form-control', 'placeholder' => 'Value of Contract', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Value of the contract over the full term excluding optional extensions. May be estimated if dependent on usage"><a href="#">Value of Contract</a></label>
                    </div>
                    @if ($errors->has('contract_value')) <p class="help-block" style="color:red;">{{ $errors->first('contract_value') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon"></div>
                      {{ Form::text('contract_reference', '', array('class' => 'form-control', 'placeholder' => 'Reference # of contract', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Internal Reference (usually carries forward from ITT)"><a href="#">Reference # of contract</a></label>
                    </div>
                    @if ($errors->has('contract_reference')) <p class="help-block danger" style="color:red;">{{ $errors->first('contract_reference') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">dd-mm-yyyy</div>
                      {{ Form::text('date_start', '', array('class' => 'form-control datepicker', 'placeholder' => 'Date Start', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Official start date of contract"><a href="#">Date Start</a></label>
                    </div>
                    @if ($errors->has('date_start')) <p class="help-block" style="color:red;">{{ $errors->first('date_start') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">#</div>
                      {{ Form::number('contract_length', '', array('class' => 'form-control', 'placeholder' => 'Length of Contract', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Number of calendar days contract is valid"><a href="#">Length of Contract (Months)</a></label>
                    </div>
                    @if ($errors->has('contract_length')) <p class="help-block" style="color:red;">{{ $errors->first('contract_length') }}</p> @endif
                    <br>

                    <div class="input-group">
                      <div class="input-group-addon">%</div>
                      {{ Form::number('social_impact_min', '', array('class' => 'form-control', 'placeholder' => 'Social Impact Minimum', 'step' => '0.01')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Minimum Social Impact % set by the authority under this contract"><a href="#">Social Impact Minimum</a></label>
                    </div>
                    @if ($errors->has('social_impact_min')) <p class="help-block" style="color:red;">{{ $errors->first('social_impact_min') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">%</div>
                      {{ Form::number('social_value_target', '', array('class' => 'form-control', 'placeholder' => 'Social Value Target', 'step' => '0.01')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Overall Social Value Target for this contract, set by the authority, usually 20%."><a href="#">Social Value Target</a></label>
                    </div>
                    @if ($errors->has('social_value_target')) <p class="help-block" style="color:red;">{{ $errors->first('social_value_target') }}</p> @endif
                    <br>




                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-2">
                <div class="col-lg-12">
                  <h3> Targets of Public Sector Organisation for this contract:</h3>

                  <br>
                  <div class="col-lg-5">

                    <div class="form-group">
                      <label>Illustrated Social Value cash target</label>
                      <div class="input-group">

                        <div class="input-group-addon">£</div>
                        {{ Form::number('cash_target','', array('class' => 'form-control', 'placeholder' => 'Cash','step' => '0.01', 'required')) }}
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Illustrated Social Value cash target.  Cash target normally provided by supplier as part of ITT bid offer, bias % should be selected where applicable."><a href="#">Cash (?)</a></label>
                      </div>
                      @if ($errors->has('cash_target')) <p class="help-block" style="color:red;">{{ $errors->first('cash_target') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="well">
                        <input id="ex1" type="text" name="cash_imp" class="form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="100"/>
                        <span id="ex6CurrentSliderValLabel"><span id="label1"></span>&nbsp;<span id="ex1SliderVal">100%</span></span>
                      </div>
                      @if ($errors->has('cash_imp')) <p class="help-block" style="color:red">{{ $errors->first('cash_imp') }}</p> @endif
                    </div>

                    <div class="form-group">
                      <label>Illustrated people target’</label>
                      <div class="input-group">
                        <div class="input-group-addon">#</div>
                        {{ Form::number('people_target','', array('class' => 'form-control', 'placeholder' => 'People', 'step' => '0.01', 'required')) }}
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="People target normally provided by the supplier as part of the ITT bid, bias % should be selected where applicable"><a href="#">People (?)</a></label>
                      </div>
                      @if ($errors->has('people_target')) <p class="help-block" style="color:red;">{{ $errors->first('people_target') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="well">
                        <input id="ex2" type="text" name="people_imp" class="form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="100"/>
                        <span id="ex6CurrentSliderValLabel"><span id="label2"></span>&nbsp;<span id="ex2SliderVal">100%</span></span>
                      </div>
                      @if ($errors->has('people_imp')) <p class="help-block" style="color:red">{{ $errors->first('people_imp') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <label>Illustrated Environmental target’</label>
                      <div class="input-group">
                        <div class="input-group-addon">tCO2e</div>
                        {{ Form::number('environment_target','', array('class' => 'form-control', 'placeholder' => 'Environment', 'step' => '0.01', 'required')) }}
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Environmental target normally provided by the supplier as part of the ITT bid, bias % should be selected where applicable"><a href="#">Environment (?)</a></label>
                      </div>
                      @if ($errors->has('environment_target')) <p class="help-block" style="color:red;">{{ $errors->first('environment_target') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="well">
                        <input id="ex3" type="text" name="environment_imp" class="form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="100"/>
                        <span id="ex6CurrentSliderValLabel"><span id="label3"></span>&nbsp;<span id="ex3SliderVal">100%</span></span>
                      </div>
                      @if ($errors->has('environment_imp')) <p class="help-block" style="color:red">{{ $errors->first('environment_imp') }}</p> @endif
                    </div>

                    <br>
                  </div>

                  <div class="col-lg-5">


                    <div class="form-group">
                      <label>Desired distance for intervention (Km)</label>
                      <div class="input-group">
                        <div class="input-group-addon"></div>
                        {{ Form::text('hyperlocality_target','', array('class' => 'form-control', 'placeholder' => 'Hyperlocality', 'step' => '0.01', 'required')) }}
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Nearest postcode at centre of desired intervention required"><a href="#">Hyperlocality (?)</a></label>
                      </div>
                      @if ($errors->has('hyperlocality_target')) <p class="help-block" style="color:red;">{{ $errors->first('hyperlocality_target') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="well">
                        <input id="ex4" type="text" name="hyperlocality_imp" class="form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0"/>
                        <span id="ex6CurrentSliderValLabel"><span id="label4"></span>&nbsp;<span id="ex4SliderVal">0%</span></span>
                      </div>
                      @if ($errors->has('hyperlocality_imp')) <p class="help-block" style="color:red">{{ $errors->first('hyperlocality_imp') }}</p> @endif
                    </div>

                    <br>
                    <div class="form-group">
                      <label>Other targets set by customer with 0-100% bias of importance to each</label>
                      <div class="input-group">
                        <div class="input-group-addon"></div>
                        {{ Form::number('other','', array('class' => 'form-control', 'placeholder' => 'Other', 'step' => '0.01')) }}
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Any other information or targets relevant to Social Value contract obligations"><a href="#">Other</a></label>
                      </div>
                      @if ($errors->has('other')) <p class="help-block" style="color:red;">{{ $errors->first('other') }}</p> @endif
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="well">
                        <input id="ex5" type="text" name="other_imp" class="form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="0"/>
                        <span id="ex6CurrentSliderValLabel"><span id="label5"></span>&nbsp;<span id="ex5SliderVal">0%</span></span>
                      </div>
                      @if ($errors->has('other_imp')) <p class="help-block" style="color:red">{{ $errors->first('other_imp') }}</p> @endif
                    </div>
                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>




              <div class="row setup-content" id="step-3">
                <div class="col-xs-10">
                  <div class="col-md-12">
                    <h3> Step 3</h3>
                    @if(Auth::user()->has_role('admin'))
                    <div class="input-group">
                      <label>Organisation </label>
                      <select class ="form-control"
                      {{ Form::select('user_id', User::forSelectWMFS(), array('required')) }}
                      @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }} </p>@endif
                    </select>
                  </div>
                  @elseif(Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                  Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                  Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                  Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                  Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014'))
                  {{ Form::hidden('user_id', Auth::id(), array('class' => 'form-control', 'placeholder' => 'User ID', 'required')) }}
                  @endif
                  <div class="form-group">
                    <label>Guidelines <label data-toggle="tooltip" data-placement="left" title="Any narrative that you wish to add which is not included within within the targets."> <a href="#"> (?) </a> </label></label>
                    <div class="input-group">
                      {{ Form::textarea('guidelines','', array('class' => 'form-control', 'placeholder' => 'Guidelines')) }}
                    </div>
                  </div>
                  @if ($errors->has('guidelines')) <p class="help-block">{{ $errors->first('guidelines') }}</p> @endif
                  <br>

                  {{ Form::submit('Complete', ['class' => 'btn btn-success btn-lg']) }}

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

{{Form::close()}}

</div>

@stop
@section('scripts')
<script type="text/javascript">
$(function(){
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  });

});
</script>

<script type="text/javascript">
$("#ex1").slider();
$("#ex1").on('slide', function(slideEvt) {
  $("#ex1SliderVal").text(slideEvt.value+'%');
});

$("#ex2").slider();
$("#ex2").on('slide', function(slideEvt) {
  $("#ex2SliderVal").text(slideEvt.value+'%');
});

$("#ex3").slider();
$("#ex3").on('slide', function(slideEvt) {
  $("#ex3SliderVal").text(slideEvt.value+'%');
});

$("#ex4").slider();
$("#ex4").on('slide', function(slideEvt) {
  $("#ex4SliderVal").text(slideEvt.value+'%');
});

$("#ex5").slider();
$("#ex5").on('slide', function(slideEvt) {
  $("#ex5SliderVal").text(slideEvt.value+'%');
});
</script>
@stop
