@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::View All Bids
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
         @if(Auth::user()->has_role('admin'))
         {{ $microsite->customer_name ? $microsite->customer_name : 'Unknown'}}/View all Bids
         @else
         View all Bids
         @endif
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">View all Bids</li>
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
         <!-- Main content -->
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <div class="box-body table-responsive" style="overflow: scroll;">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Bid Name</th>
                           <th>Bid Date</th>
                           <th>Tender</th>
                           <th>Price(£)</th>
                           <th>Added Social Value(£)</th>
                           <th>People(£)</th>
                           <th>Cash(£)</th>
                           <th>Environment(£)</th>
                           <th>Annual Price(£)</th>
                           <th>Social Value(%)</th>
                           <th>Total(%)</th>
                           @if(Auth::user()->has_role('admin'))
                           <th>Actions</th>
                           @endif
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($bids as $bid)
                        <tr>
                           <td>{{ $bid->bid_name ? $bid->bid_name : 'N/A'}}</td>
                           <td>{{ $bid->bid_date ? $bid->bid_date : 'N/A' }} </td>
                           <td>{{ $bid->tender_number ? 'Tender'.''.$bid->tender_number : 'N/A' }}</td>
                           <td>{{ $bid->price ? $bid->price : 'N/A' }}</td>
                           <td>{{ $bid->added_social_value ? $bid->added_social_value : 'N/A'}}</td>
                           <td>{{ $bid->people ? $bid->people : 'N/A' }}</td>
                           <td>{{ $bid->cash ? $bid->cash : 'N/A'  }}</td>
                           <td>{{ $bid->environment ? $bid->environment : 'N/A' }}</td>
                           <td>{{ $bid->annual_price ? $bid->annual_price : 'N/A' }} </td>
                           <td>{{ $bid->social_value ? $bid->social_value : 'N/A' }}</td>
                           <td>{{ $bid->total ? $bid->total : 'N/A' }}</td>
                           @if(Auth::user()->has_role('admin'))
                           <td>
                              <a href= "#" class="btn btn-primary btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$bid->id}}">
                              <span class="glyphicon glyphicon glyphicon-plus"></span></a>
                              <div class="modal fade" id="myModal{{$bid->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                       </div>
                                       <div class="modal-body">
                                          {{ Form::open(array('route' => array('microbids.result', $bid->id))) }}
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">(£)</span>
                                             {{ Form::text('annual_price', $bid->annual_price, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                                             @if ($errors->has('annual_price'))
                                             <p class="help-block">{{ $errors->first('annual_price') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Annual Price</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">(%)</span>
                                             {{ Form::text('social_value', $bid->social_value, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                                             @if ($errors->has('social_value'))
                                             <p class="help-block">{{ $errors->first('social_value') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Social Value</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">(£)</span>
                                             {{ Form::text('total', $bid->total, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                                             @if ($errors->has('total'))
                                             <p class="help-block">{{ $errors->first('total') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Total</button>
                                             </span>
                                          </div>
                                          </br></br>
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
                           </td>
                           @endif
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <br>
            </div>
            <!-- /.box-body -->
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
     $("#example1").dataTable();
   });
</script>
@stop
