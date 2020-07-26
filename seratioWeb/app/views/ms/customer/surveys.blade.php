@extends('layout.dashboard_default', ['ms' => $ms])
@section('title')
SE Ratio::Modern Slavery::All Suppliers
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Customer Survey Results / {{$ms->customer_name}}
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
               <div class="box-body table-responsive">
                  <div class="row">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>Customer Number</th>
                              <th>In which country do you work?</th>
                              <th>Do you feel positive when you are at work?</th>
                              <th>Is it safe to speak up and challenge they way things are done within your organisation?</th>
                              <th>What Impact does your work have on your health?</th>
                              <th>Would you recommend your work to a friend?</th>
                              <th>Are you forced to work beyond your agreed working hours or workload and threatend with unpleasent consequences if you do not?</th>
                              <th>Do you feel safe at your workplace?</th>
                              <th>Are you movements outside of work restricted by your employer?</th>
                              <th>Are you working voluntarily?</th>
                              <th>Does your employer deduct money from your wages for travel, for food or for rent</th>
                              <th>Do you feel exploited in your work?</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($surveys as $survey)
                           <tr>
                              <td>{{ $survey->customer_number ? $survey->customer_number : 'Unknown'}}</td>
                              <td> @if($survey->country) {{array_get(Country::countries(), $survey->country, 'Unknown') }} @else 'Unknown' @endif</td>
                              <td>{{ $survey->question_1 ? $survey->question_1 : 'Unknown' }}</td>
                              <td>{{ $survey->question_2 ? $survey->question_2 : 'Unknown' }}</td>
                              <td>{{ $survey->question_3 ? $survey->question_3 : 'Unknown' }}</td>
                              <td>{{ $survey->question_4 ? $survey->question_4 : 'Unknown' }}</td>
                              <td>{{ $survey->question_5 ? $survey->question_5 : 'Unknown' }}</td>
                              <td>{{ $survey->question_6 ? $survey->question_6 : 'Unknown' }}</td>
                              <td>{{ $survey->question_7 ? $survey->question_7 : 'Unknown' }}</td>
                              <td>{{ $survey->question_8 ? $survey->question_8 : 'Unknown' }}</td>
                              <td>{{ $survey->question_9 ? $survey->question_9 : 'Unknown' }}</td>
                              <td>{{ $survey->question_10 ? $survey->question_10 : 'Unknown' }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
