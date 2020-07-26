@extends('layout.dashboard_default')

@section('title')
Seratio::WMFS::General Info
@stop

@section('content')


<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>

      Supplier - General Info

    </h1>
    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">General Info</li>
    </ol>
  </section>

  <p class="description">
    @if (Session::has('message'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong> {{ Session::get('message') }}</strong>
    </div>
    @endif
  </p>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <!-- left column -->
      <div class="col-md-10 col-md-offset-1">

        <!-- general form elements -->
        <div class="box box-primary">


          <div class="box-header">

          </div><!-- /.box-header -->
          <!-- form start -->


          @if($supplier)
          {{ Form::open(array('route' => array('suppliers.update', $supplier->id), 'method' => 'PUT', 'class' => 'form')) }}
          {{ Form::hidden('user_id', Auth::id()) }}
          {{ Form::hidden('supplier_id', $supplier->id)}}

          <div class="box-body">
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <strong> Please fill in the sections below and press submit once completed</strong>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Supplier Name</label>
                  {{ Form::text('supplier_name', $supplier->supplier_name, array('class' => 'form-control', 'placeholder' => 'Supplier Name', 'required')) }}
                  @if ($errors->has('supplier_name')) <p class="help-block">{{ $errors->first('supplier_name') }}</p> @endif
                </div>
                <div class="form-group">
                  <label>Address of Supplier</label>
                  {{ Form::text('number_street', $supplier->number_street, array('class' => 'form-control', 'placeholder' => 'Address of Supplier', 'required')) }}
                  @if ($errors->has('number_street')) <p class="help-block">{{ $errors->first('number_street') }}</p> @endif
                </div>
                <div class="form-group">
                  <label>City</label>
                  {{ Form::text('city', $supplier->city, array('class' => 'form-control', 'placeholder' => 'City', 'required')) }}
                  @if ($errors->has('city')) <p class="help-block">{{ $errors->first('city') }}</p> @endif
                </div>
                <div class="form-group">
                  <label>County</label>
                  {{ Form::text('county', $supplier->county, array('class' => 'form-control', 'placeholder' => 'County', 'required')) }}
                  @if ($errors->has('county')) <p class="help-block">{{ $errors->first('county') }}</p> @endif
                </div>
                <div class="form-group">
                  <label>Post Code</label>
                  {{ Form::text('post_code', $supplier->post_code, array('class' => 'form-control', 'placeholder' => 'Post Code', 'required')) }}
                  @if ($errors->has('post_code')) <p class="help-block">{{ $errors->first('post_code') }}</p> @endif
                </div>
              </div>

              <div class="col-lg-6">

                <div class="form-group">
                  <label>Country</label>
                  <select class ="form-control"
                  {{ Form::select('country', $con, $supplier->country,  array('class' => 'form-control', 'required')) }}
                  @if ($errors->has('country')) <p class="help-block">{{ $errors->first('country') }}</p> @endif
                </select>
              </div>
              <div class="form-group">
                <label>Name of Supplier Contact</label>
                {{ Form::text('supplier_contact', Auth::user()->firstname.''.Auth::user()->lastname, array('class' => 'form-control', 'placeholder' => 'Name of Supplier Contact', 'required', 'disabled')) }}
                @if ($errors->has('supplier_contact')) <p class="help-block">{{ $errors->first('supplier_contact') }}</p> @endif
              </div>
              <div class="form-group">
                <label>E-Mail</label>
                {{ Form::text('supplier_email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required', 'disabled')) }}
                @if ($errors->has('supplier_email')) <p class="help-block">{{ $errors->first('supplier_email') }}</p> @endif
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                {{ Form::text('supplier_phone', Auth::user()->phone_number, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required', 'disabled')) }}
                @if ($errors->has('supplier_phone')) <p class="help-block">{{ $errors->first('supplier_phone') }}</p> @endif
              </div>
              <div class="form-group">
                <label>Authorised Individual</label>
                {{ Form::text('supplier_authorised_individuals', $supplier->supplier_authorised_individuals, array('class' => 'form-control', 'placeholder' => 'Authorised Individual', 'required')) }}
                @if ($errors->has('supplier_authorised_individuals')) <p class="help-block">{{ $errors->first('supplier_authorised_individuals') }}</p> @endif
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

      </div><!-- /.box-body -->
      {{ Form::close() }}

      @else

      {{ Form::open(array('route'=> 'suppliers.store', 'class' => 'form')) }}
      {{ Form::hidden('user_id', Auth::id()) }}

      <div class="box-body">

        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Supplier Name</label>
              {{ Form::text('supplier_name', '', array('class' => 'form-control', 'placeholder' => 'Supplier Name', 'required')) }}
              @if ($errors->has('supplier_name')) <p class="help-block">{{ $errors->first('supplier_name') }}</p> @endif
            </div>
            <div class="form-group">
              <label>Address of Supplier</label>
              {{ Form::text('number_street', '', array('class' => 'form-control', 'placeholder' => 'Address of Supplier', 'required')) }}
              @if ($errors->has('number_street')) <p class="help-block">{{ $errors->first('number_street') }}</p> @endif
            </div>
            <div class="form-group">
              <label>City</label>
              {{ Form::text('city', '', array('class' => 'form-control', 'placeholder' => 'City', 'required')) }}
              @if ($errors->has('city')) <p class="help-block">{{ $errors->first('city') }}</p> @endif
            </div>
            <div class="form-group">
              <label>County</label>
              {{ Form::text('county', '', array('class' => 'form-control', 'placeholder' => 'County', 'required')) }}
              @if ($errors->has('county')) <p class="help-block">{{ $errors->first('county') }}</p> @endif
            </div>
            <div class="form-group">
              <label>Post Code</label>
              {{ Form::text('post_code', '', array('class' => 'form-control', 'placeholder' => 'Post Code', 'required')) }}
              @if ($errors->has('post_code')) <p class="help-block">{{ $errors->first('post_code') }}</p> @endif
            </div>
          </div>

          <div class="col-lg-6">

            <div class="form-group">
              <label>Country</label>
              <select class ="form-control"
              {{ Form::select('country', $con, '',  array('class' => 'form-control', 'required')) }}
              @if ($errors->has('country')) <p class="help-block">{{ $errors->first('country') }}</p> @endif
            </select>
          </div>
          <div class="form-group">
            <label>Name of Supplier Contact</label>
            {{ Form::text('supplier_contact', Auth::user()->firstname.''.Auth::user()->lastname, array('class' => 'form-control', 'placeholder' => 'Name of Supplier Contact', 'required', 'disabled')) }}
            @if ($errors->has('supplier_contact')) <p class="help-block">{{ $errors->first('supplier_contact') }}</p> @endif
          </div>
          <div class="form-group">
            <label>E-Mail</label>
            {{ Form::text('supplier_email', Auth::user()->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required', 'disabled')) }}
            @if ($errors->has('supplier_email')) <p class="help-block">{{ $errors->first('supplier_email') }}</p> @endif
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            {{ Form::text('supplier_phone', Auth::user()->phone_number, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required', 'disabled')) }}
            @if ($errors->has('supplier_phone')) <p class="help-block">{{ $errors->first('supplier_phone') }}</p> @endif
          </div>
          <div class="form-group">
            <label>Authorised Individual</label>
            {{ Form::text('supplier_authorised_individuals', '', array('class' => 'form-control', 'placeholder' => 'Authorised Individual', 'required')) }}
            @if ($errors->has('supplier_authorised_individuals')) <p class="help-block">{{ $errors->first('supplier_authorised_individuals') }}</p> @endif
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

  </div><!-- /.box-body -->
  {{ Form::close() }}


  @endif

</div>
</section><!-- /.right-side -->
</div><!--/.col (right) -->

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
