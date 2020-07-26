@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::Customer Info
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
         Customer-Basic Details
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
               {{ Form::open(array('route' => array('microsite.update', $customer->id), 'method' => 'PUT', 'class' => 'form', 'files'=>true)) }}
               {{ Form::hidden('user_id', Auth::id()) }}
               <div class="box-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>Customer Name</label>
                           {{ Form::text('customer_name', $customer->customer_name, array('class' => 'form-control', 'placeholder' => 'Customer Name', 'required')) }}
                           @if ($errors->has('customer_name'))
                           <p class="help-block" style="color:red;">{{ $errors->first('customer_name') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Address</label>
                           {{ Form::text('number_street', $customer->number_street, array('class' => 'form-control', 'placeholder' => 'Address', 'required')) }}
                           @if ($errors->has('number_street'))
                           <p class="help-block" style="color:red;">{{ $errors->first('number_street') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>County</label>
                           {{ Form::text('county', $customer->county, array('class' => 'form-control', 'placeholder' => 'County', 'required')) }}
                           @if ($errors->has('county'))
                           <p class="help-block" style="color:red;">{{ $errors->first('county') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Country</label>
                           <select class ="form-control"
                           {{ Form::select('country', $con, $customer->country,  array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('country'))
                           <p class="help-block" style="color:red;">{{ $errors->first('country') }}</p>
                           @endif
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Email</label>
                           {{ Form::email('email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'disabled')) }}
                           @if ($errors->has('email'))
                           <p class="help-block" style="color:red;">{{ $errors->first('email') }}</p>
                           @endif
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>City</label>
                           {{ Form::text('city', $customer->city, array('class' => 'form-control', 'placeholder' => 'City', 'required')) }}
                           @if ($errors->has('city'))
                           <p class="help-block" style="color:red;">{{ $errors->first('city') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Post Code</label>
                           {{ Form::text('post_code', $customer->post_code, array('class' => 'form-control', 'placeholder' => 'Post Code', 'required')) }}
                           @if ($errors->has('post_code'))
                           <p class="help-block" style="color:red;">{{ $errors->first('post_code') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Primary Contact</label>
                           {{ Form::text('primary_contact', $customer->primary_contact, array('class' => 'form-control', 'placeholder' => 'Primary Contact', 'required')) }}
                           @if ($errors->has('primary_contact'))
                           <p class="help-block" style="color:red;">{{ $errors->first('primary_contact') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Phone Number</label>
                           {{ Form::text('number', $customer->number, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required')) }}
                           @if ($errors->has('number'))
                           <p class="help-block" style="color:red;">{{ $errors->first('number') }}</p>
                           @endif
                        </div>
                     </div>
                     <hr>
                     <div class="col-lg-10">
                        <div class="form-group">
                           <font size="4">
                              Financial Documents
                              {{ Form::select('checkbox', [ ''=>'-- Please Select --', '1' => 'Attach Your Last Financial Years Audited Accounts ', '2' => 'Link to your Published Accounts'], $customer->checkbox, array('required', 'id' =>'show_divs')) }}
                              @if ($errors->has('checkbox'))
                              <p class="help-block" style="color:red;">{{ $errors->first('checkbox') }}</p>
                              @endif
                           </font>
                        </div>
                        <div id="div1">
                           <div class="form-group">
                              <label>Please upload last financial year’s audited accounts[File Types: pdf, doc, xls]</label>
                              {{ Form::file('audited_accounts') }}
                              @if ($errors->has('audited_accounts'))
                              <p class="help-block" style="color:red;">{{ $errors->first('audited_accounts') }}</p>
                              @endif
                           </div>
                           @if($customer->audited_accounts)
                           <div class="col-lg-4">
                              <div class="form-group">
                                 <a href="{{URL::asset($customer->audited_accounts)}}" target="_blank"><i class="fa fa-download">
                                 Click here to download the existing file</i></a>
                              </div>
                           </div>
                           @endif
                        </div>
                        <div id="div2">
                           <div class="form-group">
                              <label>Link to your published accounts</label>
                              {{ Form::text('published_accounts', $customer->published_accounts, array('class' => 'form-control', 'placeholder' => 'Link to your Published Accounts', 'id' => 'published_accounts')) }}
                              @if ($errors->has('published_accounts'))
                              <p class="help-block" style="color:red;">{{ $errors->first('published_accounts') }}</p>
                              @endif
                           </div>
                           <div class="form-group">
                              <label>Free Text</label>
                              {{ Form::textarea('free_text', $customer->free_text, array('class' => 'form-control', 'id' => 'free_text')) }}
                              @if ($errors->has('free_text'))
                              <p class="help-block" style="color:red;">{{ $errors->first('free_text') }}</p>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="form-group">
                     <div class="col-xs-12">
                        <label>
                        {{ Form::checkbox('question1', 1, $customer->question1, ['class' => 'field']) }} Have you asked for up to 20% Social Value creation in your PQQ?
                        </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <label>
                        {{ Form::checkbox('question2', 1, $customer->question2, ['class' => 'field']) }} Do you have agreed Social Value goals?
                        </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <label>
                        {{ Form::checkbox('question3', 1, $customer->question3, ['class' => 'field']) }}  Do you have a Social Value Policy?
                        </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <label>
                        {{ Form::checkbox('question4', 1, $customer->question4, ['class' => 'field']) }}  Have you built these into your contracts?
                        </label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <label>
                        {{ Form::checkbox('question5', 1, $customer->question5, ['class' => 'field']) }}  Have you documented in your ITT that you will use Seratio as your Social Value measurement tool and that bidders will be assessed accordingly?
                        </label>
                     </div>
                  </div>
                  <br><br>
                  <div class="col-xs-12">
                     {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                     {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                  </div>
               </div>
               <br>
            </div>
            <!-- /.box-body -->
            {{ Form::close() }}
            @endif
         </div>
      </div>
      <!--/.col (right) -->
   </section>
   <!-- /.right-side -->
</div>
@stop
@section('scripts')
<script type="text/javascript">
   $(function() {
       $('#div1').hide();
             $('#div2').hide();
       $('#show_divs').change(function(){
           if($('#show_divs').val() == '1') {
               $('#div1').show();
               $('#div2').hide();
           } else if($('#show_divs').val() == '2') {
               $('#div2').show();
               $('#div1').hide();
           } else {
             $('#div1').hide();
             $('#div2').hide();
           }
       }).trigger('change');
   });
</script>
@stop
