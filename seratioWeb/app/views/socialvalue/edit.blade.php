@extends('layout.dashboard_default')
@section('title')
SE Ratio::Socialvalue
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit a Record
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
            {{ Form::open(array('route' => array('socialvalue.update', $socialvalue->id), 'method' => 'PUT')) }}
            <div class="row setup-content" id="step-1">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Sentiment Values</h3>
                     <div class="input-group">
                        <div class="input-group-addon">#</div>
                        {{ Form::number('positive', $socialvalue->positive, array('class' => 'form-control', 'placeholder' => 'Positive', 'required')) }}
                        @if ($errors->has('positive'))
                        <p class="help-block">{{ $errors->first('positive') }}</p>
                        @endif
                        <label class="input-group-addon">Positive</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('neutral', $socialvalue->neutral, array('class' => 'form-control', 'placeholder' => 'Neutral', 'required')) }}
                        @if ($errors->has('neutral'))
                        <p class="help-block">{{ $errors->first('neutral') }}</p>
                        @endif
                        <label class="input-group-addon">Neutral</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('negative', $socialvalue->negative, array('class' => 'form-control', 'placeholder' => 'Negative', 'required')) }}
                        @if ($errors->has('negative'))
                        <p class="help-block">{{ $errors->first('negative') }}</p>
                        @endif
                        <label class="input-group-addon">Negative</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">yyyy-mm-dd</span>
                        {{ Form::text('sentiment_date', $socialvalue->sentiment_date, array('class' => 'form-control datepicker', 'placeholder' => 'Sentiment Date', 'required')) }}
                        @if ($errors->has('sentiment_date'))
                        <p class="help-block">{{ $errors->first('sentiment_date') }}</p>
                        @endif
                        <label class="input-group-addon">Sentiment Date</label>
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
                        {{ Form::number('csr', $socialvalue->csr , array('class' => 'form-control', 'placeholder' => 'CSR', 'required')) }}
                        @if ($errors->has('csr'))
                        <p class="help-block">{{ $errors->first('csr') }}</p>
                        @endif
                        <label class="input-group-addon">CSR</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('deg_of_separation', $socialvalue->deg_of_separation, array('class' => 'form-control', 'placeholder' => 'Deg of Separation', 'required')) }}
                        @if ($errors->has('deg_of_separation'))
                        <p class="help-block">{{ $errors->first('deg_of_separation') }}</p>
                        @endif
                        <label class="input-group-addon">Deg of Sepration</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#m</span>
                        {{ Form::number('shares', $socialvalue->shares, array('class' => 'form-control', 'placeholder' => 'Shares', 'required')) }}
                        @if ($errors->has('shares'))
                        <p class="help-block">{{ $errors->first('shares') }}</p>
                        @endif
                        <label class="input-group-addon">Shares</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('capititilization_NAV', $socialvalue->capititilization_NAV, array('class' => 'form-control', 'placeholder' => 'Capititilization/NAV', 'required')) }}
                        @if ($errors->has('capititilization_NAV'))
                        <p class="help-block">{{ $errors->first('capititilization_NAV') }}</p>
                        @endif
                        <label class="input-group-addon">Capititilization/NAV</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('staff', $socialvalue->staff, array('class' => 'form-control', 'placeholder' => 'Staff', 'required')) }}
                        @if ($errors->has('staff'))
                        <p class="help-block">{{ $errors->first('staff') }}</p>
                        @endif
                        <label class="input-group-addon">Staff</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">tCO2e</span>
                        {{ Form::number('carbon_reduction_t', $socialvalue->carbon_reduction_t, array('class' => 'form-control', 'placeholder' => 'Carbon Reduction t ', 'required')) }}
                        @if ($errors->has('carbon_reduction_t'))
                        <p class="help-block">{{ $errors->first('carbon_reduction_t') }}</p>
                        @endif
                        <label class="input-group-addon">Carbon Reduction t</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">tCO2e</span>
                        {{ Form::number('carbon_offset', $socialvalue->carbon_offset, array('class' => 'form-control', 'placeholder' => 'Carbon Offset ', 'required')) }}
                        @if ($errors->has('carbon_offset'))
                        <p class="help-block">{{ $errors->first('carbon_offset') }}</p>
                        @endif
                        <label class="input-group-addon">Carbon Offset</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£</span>
                        {{ Form::number('value_tCO2e_non_traded', $socialvalue->value_tCO2e_non_traded, array('class' => 'form-control', 'placeholder' => 'Value tCO2 Non Traded', 'required')) }}
                        @if ($errors->has('value_tCO2e_non_traded'))
                        <p class="help-block">{{ $errors->first('value_tCO2e_non_traded') }}</p>
                        @endif
                        <label class="input-group-addon">Value tCO2 Non Traded</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£</span>
                        {{ Form::number('value_tCO2e_traded', $socialvalue->value_tCO2e_traded, array('class' => 'form-control', 'placeholder' => 'Value tCO2 Traded', 'required')) }}
                        @if ($errors->has('value_tCO2e_traded'))
                        <p class="help-block">{{ $errors->first('value_tCO2e_traded') }}</p>
                        @endif
                        <label class="input-group-addon">Value tCO2 Traded</label>
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
                        <span class="input-group-addon">#m</span>
                        {{ Form::number('people', $socialvalue->people, array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
                        @if ($errors->has('people'))
                        <p class="help-block">{{ $errors->first('people') }}</p>
                        @endif
                        <label class="input-group-addon">People</label>
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
                        {{ Form::number('money_leveraged', $socialvalue->money_leveraged, array('class' => 'form-control', 'placeholder' => 'Money Leveraged', 'required')) }}
                        @if ($errors->has('money_leveraged'))
                        <p class="help-block">{{ $errors->first('money_leveraged') }}</p>
                        @endif
                        <label class="input-group-addon">Money Leveraged</label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-5">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Inlcuding Tax Avoidance & Pay Disparity - Current Year</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_directors_salary_executive', $socialvalue->current_year_directors_salary_executive, array('class' => 'form-control', 'placeholder' => 'Directory Salary(Executive)', 'required')) }}
                        @if ($errors->has('current_year_directors_salary_executive'))
                        <p class="help-block">{{ $errors->first('current_year_directors_salary_executive') }}</p>
                        @endif
                        <label class="input-group-addon">Directory Salary(Executive)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_directors_salary_non_executive', $socialvalue->current_year_directors_salary_non_executive, array('class' => 'form-control', 'placeholder' => 'Directory Salary(Non-Executive)', 'required')) }}
                        @if ($errors->has('current_year_directors_salary_non_executive'))
                        <p class="help-block">{{ $errors->first('current_year_directors_salary_non_executive') }}</p>
                        @endif
                        <label class="input-group-addon">Directory Salary(Non-Executive)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_staff_salary', $socialvalue->current_year_staff_salary, array('class' => 'form-control', 'placeholder' => 'Staff Salary', 'required')) }}
                        @if ($errors->has('current_year_staff_salary'))
                        <p class="help-block">{{ $errors->first('current_year_staff_salary') }}</p>
                        @endif
                        <label class="input-group-addon">Staff Salary</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_staff_salary_without_directors', $socialvalue->current_year_staff_salary_without_directors, array('class' => 'form-control', 'placeholder' => 'Staff Salary (without directors)', 'required')) }}
                        @if ($errors->has('current_year_staff_salary_without_directors'))
                        <p class="help-block">{{ $errors->first('current_year_staff_salary_without_directors') }}</p>
                        @endif
                        <label class="input-group-addon">Staff Salary (without directors)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_tax_charged', $socialvalue->current_year_tax_charged, array('class' => 'form-control', 'placeholder' => 'Tax Charge', 'required')) }}
                        @if ($errors->has('current_year_tax_charged'))
                        <p class="help-block">{{ $errors->first('current_year_tax_charged') }}</p>
                        @endif
                        <label class="input-group-addon">Tax Charge</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_total_share_holder_pay_dividend_cash', $socialvalue->current_year_total_share_holder_pay_dividend_cash, array('class' => 'form-control', 'placeholder' => 'Total Shareholder Pay (Divident)', 'required')) }}
                        @if ($errors->has('current_year_total_share_holder_pay_dividend_cash'))
                        <p class="help-block">{{ $errors->first('current_year_total_share_holder_pay_dividend_cash') }}</p>
                        @endif
                        <label class="input-group-addon">Total Shareholder Pay (Divident)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('current_year_executive_board', $socialvalue->current_year_executive_board, array('class' => 'form-control', 'placeholder' => 'Executive Board', 'required')) }}
                        @if ($errors->has('current_year_executive_board'))
                        <p class="help-block">{{ $errors->first('current_year_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon">Executive Board</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_non_executive_board', $socialvalue->current_year_non_executive_board, array('class' => 'form-control', 'placeholder' => 'Non-Executive Board', 'required')) }}
                        @if ($errors->has('current_year_non_executive_board'))
                        <p class="help-block">{{ $errors->first('current_year_non_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon">Non-Executive Board</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_board_total', $socialvalue->current_year_board_total, array('class' => 'form-control', 'placeholder' => 'Board Total', 'required')) }}
                        @if ($errors->has('current_year_board_total'))
                        <p class="help-block">{{ $errors->first('current_year_board_total') }}</p>
                        @endif
                        <label class="input-group-addon">Board Total</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('current_year_number_of_staffs', $socialvalue->current_year_number_of_staffs, array('class' => 'form-control', 'placeholder' => 'Number of Staff', 'required')) }}
                        @if ($errors->has('current_year_number_of_staffs'))
                        <p class="help-block">{{ $errors->first('current_year_number_of_staffs') }}</p>
                        @endif
                        <label class="input-group-addon">Number of Staff</label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-6">
               <div class="col-xs-10">
                  <div class="col-md-8">
                     <h3> Inlcuding Tax Avoidance & Pay Disparity - Previous Year</h3>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_directors_salary_executive', $socialvalue->prior_year_directors_salary_executive, array('class' => 'form-control', 'placeholder' => 'Directory Salary(Executive)', 'required')) }}
                        @if ($errors->has('prior_year_directors_salary_executive'))
                        <p class="help-block">{{ $errors->first('prior_year_directors_salary_executive') }}</p>
                        @endif
                        <label class="input-group-addon">Directory Salary(Executive)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_directors_salary_non_executive', $socialvalue->prior_year_directors_salary_non_executive, array('class' => 'form-control', 'placeholder' => 'Directory Salary(Non-Executive)', 'required')) }}
                        @if ($errors->has('prior_year_directors_salary_non_executive'))
                        <p class="help-block">{{ $errors->first('prior_year_directors_salary_non_executive') }}</p>
                        @endif
                        <label class="input-group-addon">Directory Salary(Non-Executive)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_staff_salary', $socialvalue->prior_year_staff_salary, array('class' => 'form-control', 'placeholder' => 'Staff Salary', 'required')) }}
                        @if ($errors->has('prior_year_staff_salary'))
                        <p class="help-block">{{ $errors->first('prior_year_staff_salary') }}</p>
                        @endif
                        <label class="input-group-addon">Staff Salary</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_staff_salary_without_directors', $socialvalue->prior_year_staff_salary_without_directors, array('class' => 'form-control', 'placeholder' => 'Staff Salary (without directors)', 'required')) }}
                        @if ($errors->has('prior_year_staff_salary_without_directors'))
                        <p class="help-block">{{ $errors->first('prior_year_staff_salary_without_directors') }}</p>
                        @endif
                        <label class="input-group-addon">Staff Salary (without directors)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_tax_charged', $socialvalue->prior_year_tax_charged, array('class' => 'form-control', 'placeholder' => 'Tax Charge', 'required')) }}
                        @if ($errors->has('prior_year_tax_charged'))
                        <p class="help-block">{{ $errors->first('prior_year_tax_charged') }}</p>
                        @endif
                        <label class="input-group-addon">Tax Charge</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">£m</span>
                        {{ Form::number('prior_year_total_share_holder_pay_dividend_cash', $socialvalue->prior_year_total_share_holder_pay_dividend_cash, array('class' => 'form-control', 'placeholder' => 'Total Shareholder Pay (Divident)', 'required')) }}
                        @if ($errors->has('prior_year_total_share_holder_pay_dividend_cash'))
                        <p class="help-block">{{ $errors->first('prior_year_total_share_holder_pay_dividend_cash') }}</p>
                        @endif
                        <label class="input-group-addon">Total Shareholder Pay (Divident)</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('prior_year_executive_board', $socialvalue->prior_year_executive_board, array('class' => 'form-control', 'placeholder' => 'Executive Board', 'required')) }}
                        @if ($errors->has('prior_year_executive_board'))
                        <p class="help-block">{{ $errors->first('prior_year_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon">Executive Board</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('prior_year_non_executive_board', $socialvalue->prior_year_non_executive_board, array('class' => 'form-control', 'placeholder' => 'Non-Executive Board', 'required')) }}
                        @if ($errors->has('prior_year_non_executive_board'))
                        <p class="help-block">{{ $errors->first('prior_year_non_executive_board') }}</p>
                        @endif
                        <label class="input-group-addon">Non-Executive Board</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('prior_year_board_total', $socialvalue->prior_year_board_total, array('class' => 'form-control', 'placeholder' => 'Board Total', 'required')) }}
                        @if ($errors->has('prior_year_board_total'))
                        <p class="help-block">{{ $errors->first('prior_year_board_total') }}</p>
                        @endif
                        <label class="input-group-addon">Board Total</label>
                     </div>
                     <br>
                     <div class="input-group">
                        <span class="input-group-addon">#</span>
                        {{ Form::number('prior_year_number_of_staffs', $socialvalue->prior_year_number_of_staffs, array('class' => 'form-control', 'placeholder' => 'Number of Staff', 'required')) }}
                        @if ($errors->has('prior_year_number_of_staffs'))
                        <p class="help-block">{{ $errors->first('prior_year_number_of_staffs') }}</p>
                        @endif
                        <label class="input-group-addon">Number of Staff</label>
                     </div>
                     <br>
                     <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
               </div>
            </div>
            <div class="row setup-content" id="step-7">
               <div class="col-xs-10">
                  <div class="col-md-12">
                     <h3> Step 7</h3>
                     @if(Auth::user()->has_role('admin'))
                     <div class="input-group">
                        <label>Organisation</label>
                        <select class ="form-control"
                        {{ Form::select('user_id', User::forselect(),$socialvalue->user_id, array('required')) }}
                        @if ($errors->has('title'))
                        <p class="help-block">{{ $errors->first('title') }} </p>
                        @endif
                        </select>
                     </div>
                     @elseif(Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third'))
                     {{ Form::hidden('user_id', Auth::id(), array('class' => 'form-control', 'placeholder' => 'User ID', 'required')) }}
                     @endif
                     <br>
                     {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg pull-right']) }}
                  </div>
               </div>
            </div>
            {{ Form::close() }}
         </div>
      </div>
   </section>
   <!-- /.right-side -->
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
