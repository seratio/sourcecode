@extends('layout.dashboard_default')
@section('title')
SE Ratio::
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View All Entries
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
               <div class="box-body table-responsive" style="overflow: scroll;">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Company</th>
                           <th>Date</th>
                           <th>Positive</th>
                           <th>Negative</th>
                           <th>Neutral</th>
                           <th>Sentiment Date</th>
                           <th>CSR</th>
                           <th>Deg of Separation</th>
                           <th>shares</th>
                           <th>Capitalisation/NAV</th>
                           <th>staff</th>
                           <th>Carbon Reduction t</th>
                           <th>Carbon Offset</th>
                           <th>Value tCO2 Non Traded</th>
                           <th>Value tCO2 traded</th>
                           <th>People</th>
                           <th>Money Leveraged</th>
                           <th>Current Year Directors Salary Executive</th>
                           <th>Current Year Directors Salary Non Executive</th>
                           <th>Current Year Staff Salary</th>
                           <th>Current Year Staff Salary Without Directors</th>
                           <th>Current Year Tax Charged</th>
                           <th>Current Year Total Share Holder Pay Divident</th>
                           <th>Current Year Executive Board</th>
                           <th>Current Year Non Executive Board</th>
                           <th>Current Year Board Total</th>
                           <th>Current Year Number of Staffs</th>
                           <th>Prior Year Directors Salary Executive</th>
                           <th>Prior Year Directors Salary Non Executive</th>
                           <th>Prior Year Staff Salary</th>
                           <th>Prior Year Staff Salary Without Directors</th>
                           <th>Prior Year Tax Charged</th>
                           <th>Prior Year Total Share Holder Pay Divident</th>
                           <th>Prior Year Executive Board</th>
                           <th>Prior Year Non Executive Board</th>
                           <th>Prior Year Board Total</th>
                           <th>Prior Year Number of Staffs</th>
                           <th>SER</th>
                           <th>Social Impact</th>
                           <th>Social Impact as a Percentage of Capitilisation </th>
                           <th>Added Value</th>
                           <th>Environment</th>
                           <th>People</th>
                           <th>Cash</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($socialvalues as $socialvalue)
                        <tr>
                           <td>{{ $socialvalue->user ? $socialvalue->user->organisation : 'Unknown' }}</td>
                           <td>{{ $socialvalue->created_at }} </td>
                           <td>{{ $socialvalue->positive }}</td>
                           <td>{{ $socialvalue->negative }}</td>
                           <td>{{ $socialvalue->neutral }}</td>
                           <td>{{ $socialvalue->sentiment_date }}</td>
                           <td>{{ $socialvalue->csr }}</td>
                           <td>{{ $socialvalue->deg_of_separation }} </td>
                           <td>{{ $socialvalue->shares }}</td>
                           <td>{{ $socialvalue->capititilization_NAV }}</td>
                           <td>{{ $socialvalue->staff }}</td>
                           <td>{{ $socialvalue->carbon_reduction_t }}</td>
                           <td>{{ $socialvalue->carbon_offset }}</td>
                           <td>{{ $socialvalue->value_tCO2e_non_traded }} </td>
                           <td>{{ $socialvalue->value_tCO2e_traded }}</td>
                           <td>{{ $socialvalue->people }}</td>
                           <td>{{ $socialvalue->money_leveraged }}</td>
                           <td>{{ $socialvalue->current_year_directors_salary_executive }}</td>
                           <td>{{ $socialvalue->current_year_directors_salary_non_executive }}</td>
                           <td>{{ $socialvalue->current_year_staff_salary }} </td>
                           <td>{{ $socialvalue->current_year_staff_salary_without_directors }}</td>
                           <td>{{ $socialvalue->current_year_tax_charged }}</td>
                           <td>{{ $socialvalue->current_year_total_share_holder_pay_dividend_cash }}</td>
                           <td>{{ $socialvalue->current_year_executive_board }}</td>
                           <td>{{ $socialvalue->current_year_non_executive_board }}</td>
                           <td>{{ $socialvalue->current_year_board_total }} </td>
                           <td>{{ $socialvalue->current_year_number_of_staffs }}</td>
                           <td>{{ $socialvalue->prior_year_directors_salary_executive }}</td>
                           <td>{{ $socialvalue->prior_year_directors_salary_non_executive }}</td>
                           <td>{{ $socialvalue->prior_year_staff_salary }} </td>
                           <td>{{ $socialvalue->prior_year_staff_salary_without_directors }}</td>
                           <td>{{ $socialvalue->prior_year_tax_charged }}</td>
                           <td>{{ $socialvalue->prior_year_total_share_holder_pay_dividend_cash }}</td>
                           <td>{{ $socialvalue->prior_year_executive_board }}</td>
                           <td>{{ $socialvalue->prior_year_non_executive_board }}</td>
                           <td>{{ $socialvalue->prior_year_board_total }} </td>
                           <td>{{ $socialvalue->prior_year_number_of_staffs }}</td>
                           <td>{{ $socialvalue->ser ? $socialvalue->ser : 'N/A' }}</td>
                           <td>{{ $socialvalue->social_impact ? $socialvalue->social_impact : 'N/A'}}</td>
                           <td>{{ $socialvalue->social_impact_asap_cap ? $socialvalue->social_impact_asap_cap : 'N/A'}}
                           <td>{{ $socialvalue->added_value ? $socialvalue->added_value : 'N/A'}}</td>
                           <td>{{ $socialvalue->environment ? $socialvalue->environment : 'N/A'}}</td>
                           <td>{{ $socialvalue->people_r ? $socialvalue->people_r : 'N/A'}}</td>
                           <td>{{ $socialvalue->cash ? $socialvalue->cash : 'N/A'}}</td>
                           <td>
                              @if(Auth::user()->has_role('admin'))
                              <a href= "#" class="btn btn-primary btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$socialvalue->id}}">
                              <span class="glyphicon glyphicon glyphicon-plus"></span></a>
                              <div class="modal fade" id="myModal{{$socialvalue->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                       </div>
                                       <div class="modal-body">
                                          {{ Form::open(array('route' => array('result.add', $socialvalue->id))) }}
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">Ratio</span>
                                             {{ Form::number('ser', $socialvalue->ser, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                                             @if ($errors->has('ser'))
                                             <p class="help-block">{{ $errors->first('ser') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">SER</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">£m</span>
                                             {{ Form::number('social_impact',$socialvalue->social_impact, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('social_impact'))
                                             <p class="help-block">{{ $errors->first('social_impact') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Social Impact</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">%</span>
                                             {{ Form::number('social_impact_asap_cap',$socialvalue->social_impact_asap_cap, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('social_impact_asap_cap'))
                                             <p class="help-block">{{ $errors->first('social_impact_asap_cap') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Social Impact as a Percentage of Capitilisation</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">£m</span>
                                             {{ Form::number('added_value',$socialvalue->added_value, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('added_value'))
                                             <p class="help-block">{{ $errors->first('added_value') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Added Value</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">%</span>
                                             {{ Form::number('environment',$socialvalue->environment, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('environment'))
                                             <p class="help-block">{{ $errors->first('environment') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Environment</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">%</span>
                                             {{ Form::number('people_r',$socialvalue->people_r, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('people_r'))
                                             <p class="help-block">{{ $errors->first('people_r') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">People</button>
                                             </span>
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">%</span>
                                             {{ Form::number('cash',$socialvalue->cash, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
                                             @if ($errors->has('cash'))
                                             <p class="help-block">{{ $errors->first('cash') }}</p>
                                             @endif
                                             <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">Cash</button>
                                             </span>
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
                              @endif
                              <a href= "#" class="btn btn-info btn-xs" title="View Stats" data-toggle="modal" data-target="#myModal1{{$socialvalue->id}}">
                              <span class="glyphicon glyphicon glyphicon-zoom-in"></span></a>
                              <div class="modal fade" id="myModal1{{$socialvalue->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">View Stats</h4>
                                       </div>
                                       <div class="modal-body">
                                          <div id="light">
                                             @if($socialvalue->ser == '0' && $socialvalue->query != '1')
                                             <span class="active" id="red"></span>
                                             <span id="orange"></span>
                                             <span id="green"></span>
                                             @elseif($socialvalue->query == '1')
                                             <span id="red"></span>
                                             <span class="active" id="orange"></span>
                                             <span id="green"></span>
                                             @elseif($socialvalue->ser != '0')
                                             <span id="red"></span>
                                             <span id="orange"></span>
                                             <span class="active" id="green"></span>
                                             @endif
                                          </div>
                                          <div class="row">
                                             <h3> Explanation of indicators</h3>
                                             <ul>
                                                <li> Red: Entry accepted and being processed </li>
                                                <li> Orange: Queries raised  </li>
                                                <li> Green: Result posted to Dashboard </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                       </div>
                                    </div>
                                    <!-- /.modal-content -->
                                 </div>
                                 <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                              <a href= "{{URL::route('socialvalue.edit',['$id'=>$socialvalue->id])}}" class="btn btn-warning btn-xs" title="Edit Entry">
                              <span class="glyphicon glyphicon glyphicon-pencil"></span></a>
                              <a href= "#" class="btn btn-success btn-xs" title="There is a query" data-toggle="modal" data-target="#myModal2{{$socialvalue->id}}">
                              <span class="glyphicon glyphicon glyphicon-info-sign"></span></a>
                              <div class="modal fade" id="myModal2{{$socialvalue->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Change status</h4>
                                       </div>
                                       <div class="modal-body">
                                          {{ Form::open(array('route' => array('query.add', $socialvalue->id))) }}
                                          <div class="input-group">
                                             <label>Query</label>
                                             <select class ="form-control"
                                             {{ Form::select('query', ['No', 'Yes'], null) }}
                                             @if ($errors->has('query'))
                                             <p class="help-block">{{ $errors->first('query') }} </p>
                                             @endif
                                             </select>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                          {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                                       </div>
                                       {{Form::close()}}
                                    </div>
                                    <!-- /.modal-content -->
                                 </div>
                                 <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                              <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('socialvalue.destroy', ['id' => $socialvalue->id]) }}" title="Delete Gateway">
                              <span class="glyphicon glyphicon-minus-sign"></span>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                     </tfoot>
                  </table>
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
   $(document).ready(function() {
   $('#example1').DataTable( {
   dom: 'C<"clear">lfrtip',

   colVis: {
    exclude: [],
    groups: [
        {
            title: "Sentiment",
            columns: [ 2, 3, 4, 5 ]
        },
        {
            title: "Reported",
            columns: [ 6, 7, 8, 9, 10, 11, 12, 13, 14 ]
        },
        {
            title: "People",
            columns: [ 15 ]
        },
        {
            title: "Money Leveraged",
            columns: [ 16 ]
        },
        {
            title: "Current Year",
            columns: [ 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
        },
        {
            title: "Previous Year",
            columns: [ 27, 28, 29, 30, 31, 32, 33, 34, 35, 36]
        },
        {
            title: "Result",
            columns: [ 37, 38, 39, 40, 41, 42, 43]
        }
    ]
   }
   } );
   } );
</script>
@stop
