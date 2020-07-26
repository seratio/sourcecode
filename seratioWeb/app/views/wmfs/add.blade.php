@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Add a Record
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::Add a Record
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::Add a Record
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::Add a Record
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::Add a Record
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::Add a Record
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::Add a Record
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::Add a Record
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::Add a Record
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::Add a Record
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::Add a Record
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::Add a Record
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::Add a Record
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::Add a Record
@endif
@parent
@stop

@section('content')


<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add a Record

    </h1>

    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Add a Record</li>
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
      <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">


          <div class="box-header">

          </div><!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <div class="container">
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
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                    <p>Step 4</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                    <p>Step 5</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-6" type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
                    <p>Step 6</p>
                  </div>
                </div>
              </div>
              {{ Form::open(array('route'=> 'organisation.store', 'class' => 'form')) }}
              <div class="row setup-content" id="step-1">
                <div class="col-lg-10">
                  <div class="col-md-8">
                    <h3> Sentiment Values</h3>

                    <div class="panel panel-info">
                      <p align="justify">This section requires you, under EU GECES 2014 best practice, to input current feedback data from the target audience you claim to be adding social value to.
                        The surveys conducted asks service users if they feel your work is bringing a positive change.
                        This must be monitored as <u><a href="#" data-toggle="tooltip" title="We can discuss this with you and will be resource dependant.">practically possible</a></u>, and updated regularly as it influences your score. <br>
                        We will discuss with you the various methods available; paper format (e.g. surveys), electronically (e.g. surveymonkey.com), mobile apps and social media
                        (e.g. <u><a href="#" data-toggle="tooltip" title="Sentiment analysis engines do not filter target audiences, they simply record sentiment across a digital landscape on the organisation.">sentiment analysis engines</a></u>)
                        and <u><a href="#" data-toggle="tooltip" title="We will assist with the decision of the survey format and the quantity, to gauge engagement and grain appropriate numbers for your progress."> assist with your decision</a></u>.<br>
                        We require positive, neutral and negative data from the sample to calculate the current sentiment.
                      </p>

                    </div>
                    <div class="input-group">
                      <div class="input-group-addon"></div>
                      {{ Form::text('measured_year', '', array('class' => 'form-control', 'placeholder' => 'Measured Year', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Measured Year"><a href="#">Measured Year</a></label>
                    </div>
                    @if ($errors->has('measured_year')) <p class="help-block">{{ $errors->first('measured_year') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon"></div>
                      {{ Form::text('targeted_audience', '', array('class' => 'form-control', 'placeholder' => 'Who is your target audience?', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This may be a specific demographic group e.g. pensioners, immigrants, youth, unemployed, single parents."><a href="#">Targeted Audience</a></label>
                    </div>
                    @if ($errors->has('targeted_audience')) <p class="help-block">{{ $errors->first('targeted_audience') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">#</div>
                      {{ Form::text('positive', '', array('class' => 'form-control', 'placeholder' => 'Positive', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of positive responses received."><a href="#">Positive</a></label>
                    </div>
                    @if ($errors->has('positive')) <p class="help-block">{{ $errors->first('positive') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('neutral', '', array('class' => 'form-control', 'placeholder' => 'Neutral', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of neutral responses received."><a href="#">Neutral</a></label>
                    </div>
                    @if ($errors->has('neutral')) <p class="help-block">{{ $errors->first('neutral') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('negative', '', array('class' => 'form-control', 'placeholder' => 'Negative', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of negative responses received."><a href="#">Negative</a></label>
                    </div>
                    @if ($errors->has('negative')) <p class="help-block">{{ $errors->first('negative') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('target_population', '', array('class' => 'form-control', 'placeholder' => 'Target Population', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This is the size of community that is being intervened.."><a href="#">Target Population</a></label>
                    </div>
                    @if ($errors->has('target_population'))  <p class="help-block" style="color:red">{{ $errors->first('target_population') }}</p> @endif
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      {{ Form::text('margin_errors', '', array('class' => 'form-control', 'type'=>'number', 'min' => '0', 'max'=> '100', 'placeholder' => 'Margin of errors', 'required')) }}
                      <label class="input-group-addon"><a href="#">Margin of error</a></label>
                    </div>
                    @if ($errors->has('margin_errors'))  <p class="help-block" style="color:red">{{ $errors->first('margin_errors') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">dd-mm-yyyy</span>
                      {{ Form::text('sentiment_date', '', array('class' => 'form-control datepicker', 'placeholder' => 'Sentiment Date', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="The sentiment date is they date that the survey has been completed."><a href="#">Sentiment Date</a></label>
                    </div>
                    @if ($errors->has('sentiment_date')) <p class="help-block">{{ $errors->first('sentiment_date') }}</p> @endif
                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-2">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3> Reported</h3>
                    <div class="panel panel-info">
                      <p align="justify">This is factual information which we need to calculate your social value, the data must be accurate and in no circumstances should they be falsified, in the instance that a figure is unknown, please enter 0.<br>
                        Most of the information will be contained within your annual report and accounts.  Your HR or Finance departments should be able to assist with any queries.  Please use your most recent set of audited accounts submitted in the public domain.
                      </p>
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('non_statutory_spend', '', array('class' => 'form-control', 'placeholder' => 'Non-Statutory Spend', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This is the amount the Authority has spent on community engagement projects such as Voluntary organisations and community groups funded.  Found in the annual report on community engagement spending with third sector organisations or directly sponsored projects.  If a report is not readily accessible then further investigation will be required to illicit if the authority has an annual community voluntary grant budget or has sponsored community activities in the financial year of the last set of audited account."><a href="#">Non-Statutory Spend</a></label>
                    </div>
                    @if ($errors->has('non_statutory_spend')) <p class="help-block">{{ $errors->first('non_statutory_spend') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('no_of_service_users', '', array('class' => 'form-control', 'placeholder' => 'Number of Service Users', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Number of service users is the population of the area served by the authority, these figures are usually available from Office of National Statistics (ONS) data.
                      The population of council area - this will usually be on the Authority website figures are based on Office of National Statistics (ONS).
                      "><a href="#">Number of Service Users</a></label>
                    </div>
                    @if ($errors->has('no_of_service_users')) <p class="help-block">{{ $errors->first('no_of_service_users') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('net_asset_value', '', array('class' => 'form-control', 'placeholder' => 'Net Asset Value', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="From last set of audited accounts will be in the annual accounts as Net Asset value."><a href="#">Net Asset Value</a></label>
                    </div>
                    @if ($errors->has('net_asset_value')) <p class="help-block">{{ $errors->first('net_asset_value') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('staff', '', array('class' => 'form-control', 'placeholder' => 'Number of staff', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This is the total number of staff as documented in the organisations most recent published audited accounts.  If not published in the public domain this figure will need to be acquired from the Authorities HR department."><a href="#">Number of staff</a></label>
                    </div>
                    @if ($errors->has('staff')) <p class="help-block">{{ $errors->first('staff') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">tCO2e</span>
                      {{ Form::text('carbon_reduction_t', '', array('class' => 'form-control', 'placeholder' => 'Carbon Reduction ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Carbon reduction information can be found in last year of audited accounts in tCO2e. Carbon reduction in past 12 months ascertain if the Authority has a carbon reduction policy, this is often a five year plan starting with an initial base figure and then a strategy to reduce carbon year on year by a percentage value. The figure required in tonnesCo2e for the amount of carbon reduced is for the financial year of the audited accounts."><a href="#">Carbon Reduction</a></label>
                    </div>
                    @if ($errors->has('carbon_reduction_t')) <p class="help-block">{{ $errors->first('carbon_reduction_t') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">tCO2e</span>
                      {{ Form::text('carbon_offset', '', array('class' => 'form-control', 'placeholder' => 'Carbon Offset ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="If you are unable to locate figures for this, please enter 0."><a href="#">Carbon Offset</a></label>
                    </div>
                    @if ($errors->has('carbon_offset')) <p class="help-block">{{ $errors->first('carbon_offset') }}</p> @endif
                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-3">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3> People</h3>
                    <div class="panel panel-info">
                      Number of people supported/engaged/ impacted by social projects and initiatives from non-statutory community budget/ grants you have created
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">#m</span>
                      {{ Form::text('people', '', array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Number of people supported/engaged/ impacted by social projects and initiatives.
                      It is a strong possibility that at this stage the authority may record the spend on CSR and community engagement but not the amount of people engaged. In order to show an accurate SER rating the Authority must record the amount of people engaged in CSR/community projects.
                      If figures are not available in reports from the Authority of the amount of people engaged and supported in community projects then an approach will have to be made to the relevant department to ascertain if this data has been collated.
                      "><a href="#">People</a></label>
                    </div>
                    @if ($errors->has('people')) <p class="help-block">{{ $errors->first('people') }}</p> @endif
                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-4">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3> Money Leveraged</h3>
                    <div class="panel panel-info">
                      Money leveraged is where your invested capital and resources unlocks/leverages other amount of monies from other sources such as central government or other bodies (expressed in monetary value) by others i.e. match funding. Do not include your money contribution for non-statutory grant funding as this should already be in your Non-Statutory spending expressed in Step 2.
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('money_leveraged', '', array('class' => 'form-control', 'placeholder' => 'Money Leveraged', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Investing money and resources, which leverages other amounts of monies from other organisations such as government or other bodies i.e. matched funding. This is the extra money leveraged which should be entered."><a href="#">Money Leveraged</a></label>
                    </div>
                    @if ($errors->has('money_leveraged')) <p class="help-block">{{ $errors->first('money_leveraged') }}</p> @endif
                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-5">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3>Pay and Staff – Current Year</h3>
                    <div class="panel panel-info">
                      These figures can be found in the latest audited annual accounts, they are not used to measure your social impact, but are considered as ‘below the line’ calculations that provides guidance to you.  In the case of a local authority, members will be the list of councillors and for the public sector organisations will be the councillors who sit on the authority, referred to as members in the annual accounts.
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('cu_directors_salary', '', array('class' => 'form-control', 'placeholder' => 'Directors Salary', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="For Councils local authorities this is the senior board/senior executives/director – total bill paid."><a href="#">Directors Salary</a></label>
                    </div>
                    @if ($errors->has('cu_directors_salary')) <p class="help-block">{{ $errors->first('cu_directors_salary') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('cu_members_salary', '', array('class' => 'form-control', 'placeholder' => 'Members Salary  ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="For Councils /public sector bodies this is the amount of councillors/members – total allowance paid."><a href="#">Members Salary</a></label>
                    </div>
                    @if ($errors->has('cu_members_salary')) <p class="help-block">{{ $errors->first('cu_members_salary') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('cu_staff_salary_bill', '', array('class' => 'form-control', 'placeholder' => 'Total Staff Salary Bill ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total staff salary bill."><a href="#">Total staff salary bill</a></label>
                    </div>
                    @if ($errors->has('cu_staff_salary_bill')) <p class="help-block">{{ $errors->first('cu_staff_salary_bill') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('cu_executive_board', '', array('class' => 'form-control', 'placeholder' => 'Executive Board (Total number)', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individuals on board (senior board/senior executives/directors and Councillors /Members)."><a href="#">Executive Board (Total number)</a></label>
                    </div>
                    @if ($errors->has('cu_executive_board')) <p class="help-block">{{ $errors->first('cu_executive_board') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('cu_total_counc_members', '', array('class' => 'form-control', 'placeholder' => 'Total number of councillors/members ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individual councillors and members."><a href="#">Total number of councillors/members</a></label>
                    </div>
                    @if ($errors->has('cu_total_counc_members')) <p class="help-block">{{ $errors->first('cu_total_counc_members') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('cu_total_board_senior_directors', '', array('class' => 'form-control', 'placeholder' => 'Total number of Board/Senior Executives/Directors ', 'required')) }}
                      <label class="input-group-addon">Total number of Board/Senior Executives/Directors </label>
                    </div>
                    @if ($errors->has('cu_total_board_senior_directors')) <p class="help-block">{{ $errors->first('cu_total_board_senior_directors') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('cu_total_staff', '', array('class' => 'form-control', 'placeholder' => 'Total number of staff  ', 'required')) }}
                      <label class="input-group-addon">Total number of staff</label>
                    </div>
                    @if ($errors->has('cu_total_staff')) <p class="help-block">{{ $errors->first('cu_total_staff') }}</p> @endif

                    <br>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
                </div>
              </div>
              <div class="row setup-content" id="step-6">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3> Pay and Staff - Previous Year</h3>
                    <div class="panel panel-info">
                      These figures can be found in the previous years audited annual accounts, they are not used to measure your social impact, but are considered as ‘below the line’ calculations that provides guidance to you
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('py_directors_salary', '', array('class' => 'form-control', 'placeholder' => 'Directors Salary', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total bill for all directors/senior board/senior executives; found in previous years audited accounts."><a href="#">Directors Salary</a></label>
                    </div>
                    @if ($errors->has('py_directors_salary')) <p class="help-block">{{ $errors->first('py_directors_salary') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('py_members_salary', '', array('class' => 'form-control', 'placeholder' => 'Members Salary  ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total Councillors and members allowances paid."><a href="#">Members Salary</a></label>
                    </div>
                    @if ($errors->has('py_members_salary')) <p class="help-block">{{ $errors->first('py_members_salary') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">£m</span>
                      {{ Form::text('py_staff_salary_bill', '', array('class' => 'form-control', 'placeholder' => 'Total Staff Salary Bill ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total staff salary bill; found in previous years audited accounts."><a href="#">Total staff salary bill</a></label>
                    </div>
                    @if ($errors->has('py_staff_salary_bill')) <p class="help-block">{{ $errors->first('py_staff_salary_bill') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('py_executive_board', '', array('class' => 'form-control', 'placeholder' => 'Executive Board (Total number)', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individuals on board (senior board/senior executives/directors and Councillors /Members)."><a href="#">Executive Board (Total number)</a></label>
                    </div>
                    @if ($errors->has('py_executive_board')) <p class="help-block">{{ $errors->first('py_executive_board') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('py_total_counc_members', '', array('class' => 'form-control', 'placeholder' => 'Total number of councillors/members ', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individual councillors and members."><a href="#">Total number of councillors/members</a></label>
                    </div>
                    @if ($errors->has('py_total_counc_members')) <p class="help-block">{{ $errors->first('py_total_counc_members') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('py_total_board_senior_directors', '', array('class' => 'form-control', 'placeholder' => 'Total number of Board/Senior Executives/Directors ', 'required')) }}
                      <label class="input-group-addon">Total number of Board/Senior Executives/Directors </label>
                    </div>
                    @if ($errors->has('py_total_board_senior_directors')) <p class="help-block">{{ $errors->first('py_total_board_senior_directors') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">#</span>
                      {{ Form::text('py_total_staff', '', array('class' => 'form-control', 'placeholder' => 'Total number of staff  ', 'required')) }}
                      <label class="input-group-addon">Total number of staff</label>
                    </div>
                    @if ($errors->has('py_total_staff')) <p class="help-block">{{ $errors->first('py_total_staff') }}</p> @endif
                    <br>

                    @if(Auth::user()->has_role('admin'))
                    <div class="input-group">
                      <label>Organisation</label>
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
                  {{ Form::hidden('role_id', Auth::user()->role_id, array('class' => 'form-control', 'placeholder' => 'Role ID', 'required')) }}
                  @endif
                  <br>
                  {{ Form::submit('Save and Submit', ['class' => 'btn btn-success btn-lg pull-right', 'name' => 'save_type']) }}

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
    endDate: '+0d',
    autoclose: true
  });
});
</script>

@stop
