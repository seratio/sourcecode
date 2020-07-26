@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Microsite::AddResult
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Result
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <!--<li><a href="#">Social Value</a></li>
            <li class="active">Social Value</li>-->
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
                  <div class="stepwizard-step">
                     <a href="#step-7" type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
                     <p>Step 7</p>
                  </div>
               </div>
            </div>
            {{ Form::open(array('route' => array('microsite.updateresult', $microsite->id), 'method' => 'POST', 'class'=>'form')) }}
            {{ Form::hidden('user_id', $microsite->user_id) }}
            {{ Form::hidden('microsite_id', $microsite->id)}}
            <div class="row setup-content" id="step-1">
               <div class="col-lg-10">
                  <div class="col-md-8">
                     <h3> Sentiment Values</h3>
                     <div class="input-group">
                        <div class="input-group-addon"></div>
                        {{ Form::text('targeted_audience', $microvalue->targeted_audience, array('class' => 'form-control', 'placeholder' => 'Who is your target audience?', 'required')) }}
                        @if ($errors->has('targeted_audience'))
                        <p class="help-block">{{ $errors->first('targeted_audience') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This may be a specific demographic group e.g. pensioners, immigrants, youth, unemployed, single parents."><a href="#">Targeted Audience</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <div class="input-group-addon">#</div>
                        {{ Form::text('positive', $microvalue->positive, array('class' => 'form-control', 'placeholder' => 'Positive', 'required')) }}
                        @if ($errors->has('positive'))
                        <p class="help-block">{{ $errors->first('positive') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of positive response received."><a href="#">Postive</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::text('neutral', $microvalue->neutral, array('class' => 'form-control', 'placeholder' => 'Neutral', 'required')) }}
                        @if ($errors->has('neutral'))
                        <p class="help-block">{{ $errors->first('neutral') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of neutral response received."><a href="#">Neutral</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::text('negative', $microvalue->negative, array('class' => 'form-control', 'placeholder' => 'Negative', 'required')) }}
                        @if ($errors->has('negative'))
                        <p class="help-block">{{ $errors->first('negative') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Please enter number of negative response received."><a href="#">Negative</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">dd-mm-yyyy</span>
                        {{ Form::text('sentiment_date', $microvalue->sentiment_date, array('class' => 'form-control datepicker', 'placeholder' => 'Sentiment Date', 'required')) }}
                        @if ($errors->has('sentiment_date'))
                        <p class="help-block">{{ $errors->first('sentiment_date') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="The sentiment date is they date that the survey has been completed."><a href="#">Sentiment Date</a></label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-2">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Reported</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('non_statutory_spend', $microvalue->non_statutory_spend, array('class' => 'form-control', 'placeholder' => 'Non-Statutory Spend', 'required')) }}
                        @if ($errors->has('non_statutory_spend'))
                        <p class="help-block">{{ $errors->first('non_statutory_spend') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This is the amount the Authority has spent on community engagement projects such as Voluntary organisations and community groups funded.  Found in the annual report on community engagement spending with third sector organisations or directly sponsored projects.  If a report is not readily accessible then further investigation will be required to illicit if the authority has an annual community voluntary grant budget or has sponsored community activities in the financial year of the last set of audited account."><a href="#">Non-Statutory Spend</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::text('no_of_service_users', $microvalue->no_of_service_users , array('class' => 'form-control', 'placeholder' => 'Number of Service Users', 'required')) }}
                        @if ($errors->has('no_of_service_users'))
                        <p class="help-block">{{ $errors->first('no_of_service_users') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Number of service users is the population of the area served by the authority, these figures are usually available from Office of national Statistics (ONS) data.
                           The population of council area - this will usually be on the Authority website figures are based on National office of statistics (NOS) figures.
                           "><a href="#">Number of Service Users</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('net_asset_value', $microvalue->net_asset_value, array('class' => 'form-control', 'placeholder' => 'Net Asset Value', 'required')) }}
                        @if ($errors->has('net_asset_value'))
                        <p class="help-block">{{ $errors->first('net_asset_value') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="From last set of audited accounts will be in the annual accounts as Net Asset value."><a href="#">Net Asset Value</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::text('staff', $microvalue->staff, array('class' => 'form-control', 'placeholder' => 'Number of staff', 'required')) }}
                        @if ($errors->has('staff'))
                        <p class="help-block">{{ $errors->first('staff') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="This is the total number of staff as documented in the organisations most recent published audited accounts.  If not published in the public domain this figure will need to be acquired from the Authorities HR department."><a href="#">Number of staff</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">tCO2e</span>
                        {{ Form::text('carbon_reduction_t', $microvalue->carbon_reduction_t, array('class' => 'form-control', 'placeholder' => 'Carbon Reduction ', 'required')) }}
                        @if ($errors->has('carbon_reduction_t'))
                        <p class="help-block">{{ $errors->first('carbon_reduction_t') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Carbon reduction information can be found in last year of audited accounts in tCO2e. Carbon reduction in past 12 months ascertain if the Authority has a carbon reduction policy, this is often a five year plan starting with an initial base figure and then a strategy to reduce carbon year on year by a percentage value. The figure required in tonnesCo2e for the amount of carbon reduced is for the financial year of the audited accounts."><a href="#">Carbon Reduction</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">tCO2e</span>
                        {{ Form::text('carbon_offset', $microvalue->carbon_offset, array('class' => 'form-control', 'placeholder' => 'Carbon Offset ', 'required')) }}
                        @if ($errors->has('carbon_offset'))
                        <p class="help-block">{{ $errors->first('carbon_offset') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="If you are unable to locate figures for this, please enter 0."><a href="#">Carbon Offset</a></label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-3">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> People</h3>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::text('people', $microvalue->people, array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
                        @if ($errors->has('people'))
                        <p class="help-block">{{ $errors->first('people') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Number of people supported/engaged/ impacted by social projects and initiatives.
                           It is a strong possibility that at this stage the authority may record the spend on CSR and community engagement but not the amount of people engaged in order to show an accurate SER rating the Authority must record the amount of people engaged in CSR/community projects.
                           If figures are not available in reports from the Authority of the amount of people engaged and supported in community projects then an approach will have to be made to the relevant department to ascertain if this data has been collated.
                           "><a href="#">People</a></label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-4">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Money Leveraged</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('money_leveraged', $microvalue->money_leveraged, array('class' => 'form-control', 'placeholder' => 'Money Leveraged', 'required')) }}
                        @if ($errors->has('money_leveraged'))
                        <p class="help-block">{{ $errors->first('money_leveraged') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Investing money and resources, which leverages other amounts of monies from other organisations such as government or other bodies i.e. matched funding. This is the extra money leveraged through which should be entered."><a href="#">Money Leveraged</a></label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-5">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3>Pay and Staff – Current Year</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_directors_salary', $microvalue->cu_directors_salary, array('class' => 'form-control', 'placeholder' => 'Directors Salary', 'required')) }}
                        @if ($errors->has('cu_directors_salary'))
                        <p class="help-block">{{ $errors->first('cu_directors_salary') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="For Councils local authorities this is the senior board/senior executives/director – total bill paid."><a href="#">Directors Salary</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_members_salary', $microvalue->cu_members_salary, array('class' => 'form-control', 'placeholder' => 'Members Salary  ', 'required')) }}
                        @if ($errors->has('cu_members_salary'))
                        <p class="help-block">{{ $errors->first('cu_members_salary') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="For Councils /public sector bodies this is the amount of councillors/members – total allowance paid."><a href="#">Members Salary</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_staff_salary_bill', $microvalue->cu_staff_salary_bill, array('class' => 'form-control', 'placeholder' => 'Total Staff Salary Bill ', 'required')) }}
                        @if ($errors->has('cu_staff_salary_bill'))
                        <p class="help-block">{{ $errors->first('cu_staff_salary_bill') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total staff salary bill."><a href="#">Total staff salary bill</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_executive_board', $microvalue->cu_executive_board, array('class' => 'form-control', 'placeholder' => 'Executive Board (Total number)', 'required')) }}
                        @if ($errors->has('cu_executive_board'))
                        <p class="help-block">{{ $errors->first('cu_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individuals on board (senior board/senior executives/directors and Councillors /Members)."><a href="#">Executive Board (Total number)</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_total_counc_members', $microvalue->cu_total_counc_members, array('class' => 'form-control', 'placeholder' => 'Total number of councillors/members ', 'required')) }}
                        @if ($errors->has('cu_total_counc_members'))
                        <p class="help-block">{{ $errors->first('cu_total_counc_members') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individual councillors and members."><a href="#">Total number of councillors/members</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_total_board_senior_directors', $microvalue->cu_total_board_senior_directors, array('class' => 'form-control', 'placeholder' => 'Total number of Board/Senior Executives/Directors ', 'required')) }}
                        @if ($errors->has('cu_total_board_senior_directors'))
                        <p class="help-block">{{ $errors->first('cu_total_board_senior_directors') }}</p>
                        @endif
                        <label class="input-group-addon">Total number of Board/Senior Executives/Directors </label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('cu_total_staff', $microvalue->cu_total_staff, array('class' => 'form-control', 'placeholder' => 'Total number of staff  ', 'required')) }}
                        @if ($errors->has('cu_total_staff'))
                        <p class="help-block">{{ $errors->first('cu_total_staff') }}</p>
                        @endif
                        <label class="input-group-addon">Total number of staff</label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-6">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Pay and Staff - Previous Year</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_directors_salary', $microvalue->py_directors_salary, array('class' => 'form-control', 'placeholder' => 'Directors Salary', 'required')) }}
                        @if ($errors->has('py_directors_salary'))
                        <p class="help-block">{{ $errors->first('py_directors_salary') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total bill for all directors/senior board/senior executives; found in previous years audited accounts."><a href="#">Directors Salary</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_members_salary', $microvalue->py_members_salary, array('class' => 'form-control', 'placeholder' => 'Members Salary  ', 'required')) }}
                        @if ($errors->has('py_members_salary'))
                        <p class="help-block">{{ $errors->first('py_members_salary') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total Councillors and members allowances paid."><a href="#">Members Salary</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_staff_salary_bill', $microvalue->py_staff_salary_bill, array('class' => 'form-control', 'placeholder' => 'Total Staff Salary Bill ', 'required')) }}
                        @if ($errors->has('py_staff_salary_bill'))
                        <p class="help-block">{{ $errors->first('py_staff_salary_bill') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total staff salary bill; found in previous years audited accounts."><a href="#">Total staff salary bill</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_executive_board', $microvalue->py_executive_board, array('class' => 'form-control', 'placeholder' => 'Executive Board (Total number)', 'required')) }}
                        @if ($errors->has('py_executive_board'))
                        <p class="help-block">{{ $errors->first('py_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individuals on board (senior board/senior executives/directors and Councillors /Members)."><a href="#">Executive Board (Total number)</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_total_counc_members', $microvalue->py_total_counc_members, array('class' => 'form-control', 'placeholder' => 'Total number of councillors/members ', 'required')) }}
                        @if ($errors->has('py_total_counc_members'))
                        <p class="help-block">{{ $errors->first('py_total_counc_members') }}</p>
                        @endif
                        <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of individual councillors and members."><a href="#">Total number of councillors/members</a></label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_total_board_senior_directors', $microvalue->py_total_board_senior_directors, array('class' => 'form-control', 'placeholder' => 'Total number of Board/Senior Executives/Directors ', 'required')) }}
                        @if ($errors->has('py_total_board_senior_directors'))
                        <p class="help-block">{{ $errors->first('py_total_board_senior_directors') }}</p>
                        @endif
                        <label class="input-group-addon">Total number of Board/Senior Executives/Directors </label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::text('py_total_staff', $microvalue->py_total_staff, array('class' => 'form-control', 'placeholder' => 'Total number of staff  ', 'required')) }}
                        @if ($errors->has('py_total_staff'))
                        <p class="help-block">{{ $errors->first('py_total_staff') }}</p>
                        @endif
                        <label class="input-group-addon">Total number of staff</label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-7">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Results</h3>
                     <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Ratio</span>
                        {{ Form::text('ser', $microvalue->ser, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                        @if ($errors->has('ser'))
                        <p class="help-block">{{ $errors->first('ser') }}</p>
                        @endif
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">SER</button>
                        </span>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">£m</span>
                        {{ Form::text('social_impact',$microvalue->social_impact, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                        @if ($errors->has('social_impact'))
                        <p class="help-block">{{ $errors->first('social_impact') }}</p>
                        @endif
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Social Impact</button>
                        </span>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">%</span>
                        {{ Form::text('social_impact_asap_cap',$microvalue->social_impact_asap_cap, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                        @if ($errors->has('social_impact_asap_cap'))
                        <p class="help-block">{{ $errors->first('social_impact_asap_cap') }}</p>
                        @endif
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Social Impact as a Percentage of Capitilisation</button>
                        </span>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">£m</span>
                        {{ Form::text('added_value',$microvalue->added_value, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                        @if ($errors->has('added_value'))
                        <p class="help-block">{{ $errors->first('added_value') }}</p>
                        @endif
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Added Value</button>
                        </span>
                     </div>
                     <br>
                     {{ Form::submit('Save', ['class' => 'btn btn-success btn-lg pull-right']) }}
                  </div>
                  <!-- /.box-body -->
               </div>
               <!-- /.box -->
            </div>
         </div>
         {{Form::close()}}
      </div>
   </section>
</div>
@stop
@section('scripts')
<script type="text/javascript">
   $(function(){
     $('.datepicker').datepicker({
       format: 'yyyy-mm-dd',
       endDate: '+0d',
       autoclose: true
     });
   });
</script>
@stop
