@extends('layout.dashboard_default', ['ms' => $ms])
@section('title')
SE Ratio::Modern Slavery::Customer Info
@stop
@section('css')
<!--<style type='text/css'>
   .box{
    padding: 20px;
    display: none;
    margin-top: 20px;
    border: 1px solid #000;
   }
   .red{ background: #ff0000; }
   .green{ background: #00ff00; }
   .blue{ background: #0000ff; }
   </style>-->
<style type="text/css">
   div.parent > div {
   display: none;
   }
</style>
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         @if($basic)
         Customer - Basic Details
         @elseif($pay)
         Customer - Pay Details
         @elseif($sentiment)
         Customer - Sentiment Details
         @elseif($statement)
         Customer - Statement
         @endif
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Info</li>
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
         <div class="col-md-10 col-md-offset-1">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               @if($customer)
               @if($basic)
               {{ Form::open(array('route' => array('modernslavery.update', $customer->id), 'method' => 'PUT', 'class' => 'form')) }}
               {{ Form::hidden('user_id', Auth::id()) }}
               {{ Form:: hidden('type', 'basic') }}
               <div class="box-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>Customer Name</label>
                           {{ Form::text('customer_name', $customer->customer_name, array('class' => 'form-control', 'placeholder' => 'Customer Name', 'required')) }}
                           @if ($errors->has('customer_name'))
                           <p class="help-block">{{ $errors->first('customer_name') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Address</label>
                           {{ Form::text('number_street', $customer->number_street, array('class' => 'form-control', 'placeholder' => 'Address', 'required')) }}
                           @if ($errors->has('number_street'))
                           <p class="help-block">{{ $errors->first('number_street') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>County</label>
                           {{ Form::text('county', $customer->county, array('class' => 'form-control', 'placeholder' => 'County', 'required')) }}
                           @if ($errors->has('county'))
                           <p class="help-block">{{ $errors->first('county') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Country</label>
                           <select class ="form-control"
                           {{ Form::select('country', $con, $customer->country,  array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('country'))
                           <p class="help-block">{{ $errors->first('country') }}</p>
                           @endif
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Email</label>
                           {{ Form::email('email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'disabled')) }}
                           @if ($errors->has('email'))
                           <p class="help-block">{{ $errors->first('email') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sector</label>
                           <select class ="form-control"
                           {{ Form::select('sector', $sectors, $customer->sector,  array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('sector'))
                           <p class="help-block">{{ $errors->first('sector') }}</p>
                           @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>Customer Number</label>
                           {{ Form::text('customer_number', $customer->customer_number, array('class' => 'form-control', 'disabled')) }}
                           @if ($errors->has('customer_number'))
                           <p class="help-block">{{ $errors->first('customer_number') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>City</label>
                           {{ Form::text('city', $customer->city, array('class' => 'form-control', 'placeholder' => 'City', 'required')) }}
                           @if ($errors->has('city'))
                           <p class="help-block">{{ $errors->first('city') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Post Code</label>
                           {{ Form::text('post_code', $customer->post_code, array('class' => 'form-control', 'placeholder' => 'Post Code', 'required')) }}
                           @if ($errors->has('post_code'))
                           <p class="help-block">{{ $errors->first('post_code') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Primary Contact</label>
                           {{ Form::text('primary_contact', $customer->primary_contact, array('class' => 'form-control', 'placeholder' => 'Primary Contact', 'required')) }}
                           @if ($errors->has('primary_contact'))
                           <p class="help-block">{{ $errors->first('primary_contact') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Phone Number</label>
                           {{ Form::text('number', $customer->number, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required')) }}
                           @if ($errors->has('number'))
                           <p class="help-block">{{ $errors->first('number') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Industry</label>
                           <select class ="form-control"
                           {{ Form::select('main_industry', $industries, $customer->main_industry, array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('main_industry'))
                           <p class="help-block">{{ $errors->first('main_industry') }}</p>
                           @endif
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12 col-md-offset-4">
                     {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                     {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                  </div>
               </div>
               <br>
            </div>
            <!-- /.box-body -->
            {{ Form::close() }}
            @elseif($pay)
            {{ Form::open(array('route' => array('modernslavery.update', $customer->id), 'method' => 'PUT', 'class' => 'form', 'files' => true)) }}
            {{ Form::hidden('user_id', Auth::id()) }}
            {{ Form:: hidden('type', 'pay') }}
            <div class="box-body">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label>Currency</label>
                        <select class ="form-control"
                        {{ Form::select('currency', $currencies, $customer->currency, array('class' => 'form-control', 'placeholder' => 'Currency', 'required')) }}
                        @if ($errors->has('currency'))
                        <p class="help-block">{{ $errors->first('currency') }}</p>
                        @endif
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Total Payroll/wages in million’s'</label>
                        {{ Form::text('total_wages', $customer->total_wages, array('class' => 'form-control', 'placeholder' => 'Total Payroll/wages in million’s', 'required')) }}
                        @if ($errors->has('total_wages'))
                        <p class="help-block">{{ $errors->first('total_wages') }}</p>
                        @endif
                     </div>
                     @if($customer->customer_type == 'Enterprise')
                     <div class="form-group">
                        <label>Number Part time employees</label>
                        {{ Form::text('no_of_pt_employees', $customer->no_of_pt_employees, array('class' => 'form-control', 'placeholder' => 'Number Part time employees', 'required')) }}
                        @if ($errors->has('no_of_pt_employees'))
                        <p class="help-block">{{ $errors->first('no_of_pt_employees') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Total part time wages annually</label>
                        {{ Form::text('total_pt_wages', $customer->total_pt_wages, array('class' => 'form-control', 'placeholder' => 'Total part time wages annually', 'required')) }}
                        @if ($errors->has('total_pt_wages'))
                        <p class="help-block">{{ $errors->first('total_pt_wages') }}</p>
                        @endif
                     </div>
                     @endif
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label>Total Revenue in Miliion's</label>
                        {{ Form::text('total_revenue', $customer->total_revenue, array('class' => 'form-control', 'placeholder' => 'Total Revenue in million’s', 'required')) }}
                        @if ($errors->has('total_revenue'))
                        <p class="help-block">{{ $errors->first('total_revenue') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Number of employees<label data-toggle="tooltip" data-placement="left" title="By providing more detailed information on the number and wages of part time and full time employees we are able to provide more accurate measurements.."> <a href="#"> (?) </a> </label></label>
                        {{ Form::text('no_of_employees', $customer->no_of_employees, array('class' => 'form-control', 'placeholder' => 'Number of employees', 'required')) }}
                        @if ($errors->has('no_of_employees'))
                        <p class="help-block">{{ $errors->first('no_of_employees') }}</p>
                        @endif
                     </div>
                     @if($customer->customer_type == 'Enterprise')
                     <div class="form-group">
                        <label>Total part time hours annually</label>
                        {{ Form::text('total_pt_hours', $customer->total_pt_hours, array('class' => 'form-control', 'placeholder' => 'Total part time hours annually', 'required')) }}
                        @if ($errors->has('total_pt_hours'))
                        <p class="help-block">{{ $errors->first('total_pt_hours') }}</p>
                        @endif
                     </div>
                     @endif
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label>Please upload last financial year’s audited accounts[File Types: pdf, doc, xls]</label>
                        {{ Form::file('document1') }}
                        @if ($errors->has('document1'))
                        <p class="help-block">{{ $errors->first('document1') }}</p>
                        @endif
                     </div>
                  </div>
                  @if($customer->document1)
                  <div class="col-lg-3">
                     <div class="form-group">
                        <a href="{{URL::asset($customer->document1)}}" target="_blank"><i class="fa fa-download">
                        Click here to download the existing file</i></a>
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12 col-md-offset-5">
               {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
               {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
            </div>
         </div>
         <br>
      </div>
      <!-- /.box-body -->
      {{ Form::close() }}
      @elseif($statement)
      {{ Form::open(array('route' => array('modernslavery.update', $customer->id), 'method' => 'PUT', 'class' => 'form')) }}
      {{ Form::hidden('user_id', Auth::id()) }}
      {{ Form:: hidden('type', 'statement') }}
      <div class="box-body">
         <div class="row">
            <div class="col-lg-12">
               <div class="row">
                  <div class="col-lg-10">
                     <div class="form-group">
                        <label>Please outline a description of the nature of your business, the organisational structure, and the organisations supply chains ie which countries or sectors it operates in.</label>
                        {{ Form::textarea('nature_of_your_business', $customer->nature_of_your_business, ['class' => 'form-control', 'required']) }}
                        @if ($errors->has('nature_of_your_business'))
                        <p class="help-block">{{ $errors->first('nature_of_your_business') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>This question relates to the maintenance of anti-slavery or human trafficking policies in your supply chain and your own business. Please list and or link to established and documented policies. Do you have the following already in place or being put in place?</label>
                        {{ Form::textarea('policies', $customer->policies, ['class' => 'form-control', 'required']) }}
                        @if ($errors->has('policies'))
                        <p class="help-block">{{ $errors->first('policies') }}</p>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        {{--*/ $checked1 = explode(', ', $customer->checkbox1) /*--}}
                        <label>Do you have Existing Policies for Child Labour*</label><br>
                        @if(in_array('Contractual terms', $checked1))
                        {{ Form::checkbox('checkbox1[]', 'Contractual terms', true  )  }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox1[]', 'Contractual terms' )  }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked1))
                        {{ Form::checkbox('checkbox1[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox1[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('Being developed', $checked1))
                        {{ Form::checkbox('checkbox1[]', 'Being developed', true) }} Being developed <br>
                        @else
                        {{ Form::checkbox('checkbox1[]', 'Being developed') }} Being developed <br>
                        @endif
                        @if(in_array('No', $checked1))
                        {{ Form::checkbox('checkbox1[]', 'No', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox1[]', 'No') }} No <br>
                        @endif
                        @if ($errors->has('checkbox1'))
                        <p class="help-block">{{ $errors->first('checkbox1') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked3 = explode(', ', $customer->checkbox3) /*--}}
                        <label>For Bribery and Corruption*</label><br>
                        @if(in_array('Contractual terms', $checked3))
                        {{ Form::checkbox('checkbox3[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox3[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked3))
                        {{ Form::checkbox('checkbox3[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox3[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked3))
                        {{ Form::checkbox('checkbox3[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox3[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('No', $checked3))
                        {{ Form::checkbox('checkbox3[]', 'No', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox3[]', 'No') }} No <br>
                        @endif
                        @if ($errors->has('checkbox3'))
                        <p class="help-block">{{ $errors->first('checkbox3') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked5 = explode(', ', $customer->checkbox5) /*--}}
                        <label>For Conditions of Employment*</label><br>
                        @if(in_array('Contractual terms', $checked5))
                        {{ Form::checkbox('checkbox5[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox5[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked5))
                        {{ Form::checkbox('checkbox5[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox5[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked5))
                        {{ Form::checkbox('checkbox5[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox5[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('No', $checked5))
                        {{ Form::checkbox('checkbox5[]', 'No', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox5[]', 'No') }} No <br>
                        @endif
                        @if ($errors->has('checkbox5'))
                        <p class="help-block">{{ $errors->first('checkbox5') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked7 = explode(', ', $customer->checkbox7) /*--}}
                        <label>Do you have them for Living Wages/Minimum Wages*</label><br>
                        @if(in_array('Contractual terms', $checked7))
                        {{ Form::checkbox('checkbox7[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox7[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked7))
                        {{ Form::checkbox('checkbox7[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox7[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked7))
                        {{ Form::checkbox('checkbox7[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox7[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked7))
                        {{ Form::checkbox('checkbox7[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox7[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox7'))
                        <p class="help-block">{{ $errors->first('checkbox7') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked9 = explode(', ', $customer->checkbox9) /*--}}
                        <label>For environmental issues*</label><br>
                        @if(in_array('Contractual terms', $checked9))
                        {{ Form::checkbox('checkbox9[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox9[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked9))
                        {{ Form::checkbox('checkbox9[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox9[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked9))
                        {{ Form::checkbox('checkbox9[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox9[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked9))
                        {{ Form::checkbox('checkbox9[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox9[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox9'))
                        <p class="help-block">{{ $errors->first('checkbox9') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked11 = explode(', ', $customer->checkbox11) /*--}}
                        <label>For Prevention of hidden third party labour exploitation*</label><br>
                        @if(in_array('Contractual terms', $checked11))
                        {{ Form::checkbox('checkbox11[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox11[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked11))
                        {{ Form::checkbox('checkbox11[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox11[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked11))
                        {{ Form::checkbox('checkbox11[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox11[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked11))
                        {{ Form::checkbox('checkbox11[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox11[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox11'))
                        <p class="help-block">{{ $errors->first('checkbox11') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked13 = explode(', ', $customer->checkbox13) /*--}}
                        <label>Elimination of Discrimination*</label><br>
                        @if(in_array('Contractual terms', $checked13))
                        {{ Form::checkbox('checkbox13[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox13[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked13))
                        {{ Form::checkbox('checkbox13[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox13[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked13))
                        {{ Form::checkbox('checkbox13[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox13[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked13))
                        {{ Form::checkbox('checkbox13[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox13[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox13'))
                        <p class="help-block">{{ $errors->first('checkbox13') }}</p>
                        @endif
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        {{--*/ $checked2 = explode(', ', $customer->checkbox2) /*--}}
                        <label>For Equal Opportunity*</label><br>
                        @if(in_array('Contractual terms', $checked2))
                        {{ Form::checkbox('checkbox2[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox2[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked2))
                        {{ Form::checkbox('checkbox2[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox2[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked2))
                        {{ Form::checkbox('checkbox2[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox2[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('No', $checked2))
                        {{ Form::checkbox('checkbox2[]', 'No', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox2[]', 'No') }} No <br>
                        @endif
                        @if ($errors->has('checkbox2'))
                        <p class="help-block">{{ $errors->first('checkbox2') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked6 = explode(', ', $customer->checkbox6) /*--}}
                        <label>For Remuneration*</label><br>
                        @if(in_array('Contractual terms', $checked6))
                        {{ Form::checkbox('checkbox6[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox6[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked6))
                        {{ Form::checkbox('checkbox6[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox6[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked6))
                        {{ Form::checkbox('checkbox6[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox6[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked6))
                        {{ Form::checkbox('checkbox6[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox6[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox6'))
                        <p class="help-block">{{ $errors->first('checkbox6') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked8 = explode(', ', $customer->checkbox8) /*--}}
                        <label>For health and safety*</label><br>
                        @if(in_array('Contractual terms', $checked8))
                        {{ Form::checkbox('checkbox8[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox8[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked8))
                        {{ Form::checkbox('checkbox8[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox8[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked8))
                        {{ Form::checkbox('checkbox8[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox8[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked8))
                        {{ Form::checkbox('checkbox8[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox8[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox8'))
                        <p class="help-block">{{ $errors->first('checkbox8') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked10 = explode(', ', $customer->checkbox10) /*--}}
                        <label>For Supplier Code of Conduct and Sustainability*</label><br>
                        @if(in_array('Contractual terms', $checked10))
                        {{ Form::checkbox('checkbox10[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox10[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked10))
                        {{ Form::checkbox('checkbox10[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox10[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked10))
                        {{ Form::checkbox('checkbox10[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox10[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked10))
                        {{ Form::checkbox('checkbox10[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox10[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox10'))
                        <p class="help-block">{{ $errors->first('checkbox10') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked12 = explode(', ', $customer->checkbox12) /*--}}
                        <label>For Freedom of Association*</label><br>
                        @if(in_array('Contractual terms', $checked12))
                        {{ Form::checkbox('checkbox12[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox12[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked12))
                        {{ Form::checkbox('checkbox12[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox12[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked12))
                        {{ Form::checkbox('checkbox12[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox12[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked12))
                        {{ Form::checkbox('checkbox12[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox12[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox12'))
                        <p class="help-block">{{ $errors->first('checkbox12') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked14 = explode(', ', $customer->checkbox14) /*--}}
                        <label>For Human Rights Compliance*</label><br>
                        @if(in_array('Contractual terms', $checked14))
                        {{ Form::checkbox('checkbox14[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox14[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked14))
                        {{ Form::checkbox('checkbox14[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox14[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked14))
                        {{ Form::checkbox('checkbox14[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox14[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked14))
                        {{ Form::checkbox('checkbox14[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox14[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox14'))
                        <p class="help-block">{{ $errors->first('checkbox14') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked15 = explode(', ', $customer->checkbox15) /*--}}
                        <label>For Whistleblowing*</label><br>
                        @if(in_array('Contractual terms', $checked15))
                        {{ Form::checkbox('checkbox15[]', 'Contractual terms', true) }} Contractual terms <br>
                        @else
                        {{ Form::checkbox('checkbox15[]', 'Contractual terms') }} Contractual terms <br>
                        @endif
                        @if(in_array('Policies', $checked15))
                        {{ Form::checkbox('checkbox15[]', 'Policies', true) }} Policies  <br>
                        @else
                        {{ Form::checkbox('checkbox15[]', 'Policies') }} Policies  <br>
                        @endif
                        @if(in_array('In development', $checked15))
                        {{ Form::checkbox('checkbox15[]', 'In development', true) }} In development <br>
                        @else
                        {{ Form::checkbox('checkbox15[]', 'In development') }} In development <br>
                        @endif
                        @if(in_array('None', $checked15))
                        {{ Form::checkbox('checkbox15[]', 'None', true) }} No <br>
                        @else
                        {{ Form::checkbox('checkbox15[]', 'None') }} No <br>
                        @endif
                        @if ($errors->has('checkbox15'))
                        <p class="help-block">{{ $errors->first('checkbox15') }}</p>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-10">
                     <div class="form-group">
                        <label>What % of your known suppliers do you have the above terms policies with?</label>
                        {{ Form::select('known_supp',$known, $customer->known_supp,  array('class' => 'form-control', 'required')) }}
                        @if ($errors->has('known_supp'))
                        <p class="help-block">{{ $errors->first('known_supp') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked16 = explode(', ', $customer->checkbox16) /*--}}
                        <label>Select the due diligence processes in relation to the management and identification of slavery which you have and attach relevant documents*</label><br>
                        @if(in_array('Supplier Certification', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Supplier Certification', true) }} Supplier Certification <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Supplier Certification') }} Supplier Certification <br>
                        @endif
                        @if(in_array('Internal Supplier Audits', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Internal Supplier Audits', true) }} Internal Supplier Audits  <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Internal Supplier Audits') }} Internal Supplier Audits  <br>
                        @endif
                        @if(in_array('External Supplier Audits', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'External Supplier Audits', true) }} External Supplier Audits <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'External Supplier Audits') }} External Supplier Audits <br>
                        @endif
                        @if(in_array('Customer Contractual Rights to Audit', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Customer Contractual Rights to Audit', true) }} Customer Contractual Rights to Audit <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Customer Contractual Rights to Audit') }} Customer Contractual Rights to Audit <br>
                        @endif
                        @if(in_array('Contractual Termination terms for violation of slavery protocols', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Contractual Termination terms for violation of slavery protocols', true) }} Contractual Termination terms for violation of slavery protocols <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Contractual Termination terms for violation of slavery protocols') }} Contractual Termination terms for violation of slavery protocols <br>
                        @endif
                        @if(in_array('Training to your own employees', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Training to your own employees', true) }} Training to your own employees <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Training to your own employees') }} Training to your own employees <br>
                        @endif
                        @if(in_array('Training for suppliers', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Training for suppliers', true) }} Training for suppliers <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Training for suppliers') }} Training for suppliers <br>
                        @endif
                        @if(in_array('Internal Compliance Officers', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Internal Compliance Officers', true) }} Internal Compliance Officers <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Internal Compliance Officers') }} Internal Compliance Officers <br>
                        @endif
                        @if(in_array('Disciplinary Procedures', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Disciplinary Procedures', true) }} Disciplinary Procedures <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Disciplinary Procedures') }} Disciplinary Procedures <br>
                        @endif
                        @if(in_array('Whistleblowing', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Whistleblowing', true) }} Whistleblowing <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Whistleblowing') }} Whistleblowing <br>
                        @endif
                        @if(in_array('Management Information Protocols', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Management Information Protocols', true) }} Management Information Protocols <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Management Information Protocols') }} Management Information Protocols <br>
                        @endif
                        @if(in_array('Reporting', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Reporting', true) }} Reporting <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Reporting') }} Reporting <br>
                        @endif
                        @if(in_array('Other', $checked16))
                        {{ Form::checkbox('checkbox16[]', 'Other', true) }} Other <br>
                        @else
                        {{ Form::checkbox('checkbox16[]', 'Other') }} Other <br>
                        @endif
                        @if ($errors->has('checkbox16'))
                        <p class="help-block">{{ $errors->first('checkbox16') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Please list which external auditors, internal or external third party technology providers and NGO's that you have used and the dates of their reports, if not yet reported the dates they were commissioned</label>
                        {{ Form::textarea('external_auditors', $customer->external_auditors, ['class' => 'form-control', 'required']) }}
                        @if ($errors->has('external_auditors'))
                        <p class="help-block">{{ $errors->first('external_auditors') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Have you been informed of any instances or suspicious of slavery in your supply chain?</label>
                        {{ Form::select('instances',['NULL' =>'--Please Select--', 'Yes'=>'Yes', 'No'=>'No'], $customer->instances,  array('class' => 'form-control', 'required', 'id' => 'instances')) }}
                        @if ($errors->has('instances'))
                        <p class="help-block">{{ $errors->first('instances') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>If Yes, please detail each instance, dates, country, sector, and the processes that you have put into place to investigate and rectify the situation. Detail how any such violation
                        or risk has been managed/eliminated - detail the audits ie whether they are internal or external, if external which providers you used ie technology such as Seratio, 3rd parties who provide audit, investigation or consultancy services - state when these were carried out</label>
                        {{ Form::textarea('free_text', $customer->free_text, ['class' => 'form-control', 'id' =>'free_text']) }}
                        @if ($errors->has('free_text'))
                        <p class="help-block">{{ $errors->first('free_text') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        {{--*/ $checked17 = explode(', ', $customer->checkbox17) /*--}}
                        <label>Please detail which types of management reports you are using to manage performance indicators to monitor and manage the risk of slavery.*</label><br>
                        @if(in_array('Internal Management Reports', $checked17))
                        {{ Form::checkbox('checkbox17[]', 'Internal Management Reports', true) }} Internal Management Reports <br>
                        @else
                        {{ Form::checkbox('checkbox17[]', 'Internal Management Reports') }} Internal Management Reports <br>
                        @endif
                        @if(in_array('Internal Technology', $checked17))
                        {{ Form::checkbox('checkbox17[]', 'Internal Technology', true) }} Internal Technology  <br>
                        @else
                        {{ Form::checkbox('checkbox17[]', 'Internal Technology') }} Internal Technology  <br>
                        @endif
                        @if(in_array('External Technology', $checked17))
                        {{ Form::checkbox('checkbox17[]', 'External Technology', true) }} External Technology <br>
                        @else
                        {{ Form::checkbox('checkbox17[]', 'External Technology') }} External Technology <br>
                        @endif
                        @if(in_array('External Consultants', $checked17))
                        {{ Form::checkbox('checkbox17[]', 'External Consultants', true) }} External Consultants <br>
                        @else
                        {{ Form::checkbox('checkbox17[]', 'External Consultants') }} External Consultants <br>
                        @endif
                        @if ($errors->has('checkbox17'))
                        <p class="help-block">{{ $errors->first('checkbox17') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Please detail which internal or external technology platforms you are using and the external consultants that you use</label>
                        {{ Form::textarea('technology_platforms', $customer->technology_platforms, ['class' => 'form-control', 'required']) }}
                        @if ($errors->has('technology_platforms'))
                        <p class="help-block">{{ $errors->first('technology_platforms') }}</p>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12 col-md-offset-5">
               {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
               {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
            </div>
         </div>
         <br>
      </div>
      <!-- /.box-body -->
      {{ Form::close() }}
      @elseif($sentiment)
      {{ Form::open(array('route' => array('modernslavery.update', $customer->id), 'method' => 'PUT', 'class' => 'form')) }}
      {{ Form::hidden('user_id', Auth::id()) }}
      {{ Form:: hidden('type', 'sentiment') }}
      <div class="box-body">
         <div class="row">
            <div class="col-lg-10">
               <br>
               <div class="form-group">
                  <font size="4">
                     Have you conducted your own employer anti-slavery sentiment survey<label data-toggle="tooltip" data-placement="left" title="For more accurate and detailed information please ask your employees to complete our own online sentiment survey at (url) and provide them your customer number"> <a href="#"> (?) </a> </label>
                     {{ Form::select('sentiment_q1', [ ''=>'-- Please Select --', '1' => 'Yes', '2' => 'No'], $customer->sentiment_q1, array('required', 'id' =>'show_divs')) }}
                     @if ($errors->has('sentiment_q1'))
                     <p class="help-block">{{ $errors->first('sentiment_q1') }}</p>
                     @endif
                  </font>
               </div>
               <div class="parent">
                  <div id="show1" class="child">
                     <font size="4">Would you like to use Seratio's purpose built Anti-Slavery sentiment survey?
                     {{ Form::select('sentiment_q1_sub', [ ''=>'-- Please Select --', '3' => 'Yes', '4' => 'No'], $customer->sentiment_q1_sub, array('id' =>'show_divs_sub')) }}
                     </font>
                     <div id="show3">
                        <br><br>
                        <div class="row">
                           <div class="col-md-12 col-md-offset-1">
                              <div class="panel panel-warning">
                                 <div class="panel-heading">
                                    <h1 class="panel-title">Info</h1>
                                 </div>
                                 <p align="justify" style="font-size:5;">
                                    Once you click the submit button you will be directed to our online survey and please send this link https://www.seratio.com/customer_survey/{{{$customer->customer_number}}} to all of your employees to complete
                                    <br>
                                 </p>
                                 <br>
                                 <br>
                              </div>
                              {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg', 'onclick' => "window.open('https://www.seratio.com/customer_survey/$customer->customer_number/')" ]) }}
                              {{Form::close()}}
                           </div>
                        </div>
                     </div>
                     <div id="show4">
                        <br>
                        <div class="form-group">
                           <label for="sentiment_q2">What % of your employees would recommend your company to a friend to work for?</label>
                           {{ Form::text('sentiment_q2', $customer->sentiment_q2, array('class' => 'form-control', 'placeholder' => 'What % of your employees would recommend your company to a friend to work for?')) }}
                           @if ($errors->has('sentiment_q2'))
                           <p class="help-block">{{ $errors->first('sentiment_q2') }}</p>
                           @endif
                        </div>
                        <br>
                        <div class="form-group">
                           <label for="sentiment_q3_4">What % of employees completed your survey?</label>
                           {{ Form::text('sentiment_q3', $customer->sentiment_q3, array('class' => 'form-control', 'placeholder' => 'What % of employees completed your survey?')) }}
                           @if ($errors->has('sentiment_q3'))
                           <p class="help-block">{{ $errors->first('sentiment_q3') }}</p>
                           @endif
                        </div>
                        <br>
                        <div class="form-group">
                           <label for="sentiment_q4_4">When was this survey conducted? Month/Year</label>
                           {{ Form::text('sentiment_q4', $customer->sentiment_q4, array('class' => 'form-control', 'placeholder' => 'When was this survey conducted? Month/Year')) }}
                           @if ($errors->has('sentiment_q4'))
                           <p class="help-block">{{ $errors->first('sentiment_q4') }}</p>
                           @endif
                        </div>
                        <br>
                        <div class="col-lg-6 col-md-offset-1">
                           {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg pull-right']) }}
                           {{Form::close()}}
                        </div>
                        <!-- /.box -->
                     </div>
                  </div>
                  <div id="show2">
                     <br><br>
                     <div class="row">
                        <div class="col-md-12 col-md-offset-1">
                           <div class="panel panel-warning">
                              <div class="panel-heading">
                                 <h1 class="panel-title">Info</h1>
                              </div>
                              <p align="justify" style="font-size:5;">
                                 Once you click the submit button you will be directed to our online survey and please send this link https://www.seratio.com/customer_survey/{{{$customer->customer_number}}} to all of your employees to complete
                                 <br>
                              </p>
                              <br>
                              <br>
                           </div>
                           {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg', 'onclick' => "window.open('https://www.seratio.com/customer_survey/$customer->customer_number/')"]) }}
                           {{Form::close()}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.box-body -->
      {{Form::close()}}
      <br>
      <br>
      @endif
      @endif
   </section>
</div>
@stop
@section('scripts')
<script type="text/javascript">
   $('#show_divs').change(function() {
     var showDiv = $(this).val();
     $('div.parent > div').hide();
     $('div.child > div').hide();
     $('#show' + showDiv).show();
   }).trigger('change');
   $('#show_divs_sub').change(function() {
     var showDiv_sub = $(this).val();
     $('div.child > div').hide();
     $('#show' + showDiv_sub).show();
   }).trigger('change');

</script>
<script type="text/javascript">
   $(function() {
     var instanceSelect = function(){
         if ($(this).val() == 'Yes') {
            $('#free_text').parents('.form-group').show();
        } else {
            $('#free_text').parents('.form-group').hide();
        }
     }
     $('#instances').change(instanceSelect);

     instanceSelect.apply($('#instances'), []);
   });
</script>
@stop
