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
         View Data
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
         <div id="light">
            @if(@socialvalue && !@retCurrent)
            <span class="active" id="red"></span>
            @else
            <span id="red"></span>
            @endif
            <span id="orange"></span>
            @if(@retCurrent)
            <span class="active" id="green"></span>
            @else
            <span id="green"></span>
            @endif
         </div>
         <div class="container">
            <div class="well col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Sentiment Values</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos cyruxx">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Sentiment Values</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>Sentiment Date:</td>
                                          <td>{{ $socialvalue->sentiment_date }}</td>
                                       </tr>
                                       <tr>
                                          <td>Positive(#):</td>
                                          <td>{{ $socialvalue->positive }}</td>
                                       </tr>
                                       <tr>
                                          <td>Neutral(#):</td>
                                          <td>{{ $socialvalue->neutral }}</td>
                                       </tr>
                                       <tr>
                                          <td>Negative(#):</td>
                                          <td>{{ $socialvalue->negative }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Reported</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user2">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user2">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Reported</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>CSR(£m):</td>
                                          <td>{{ $socialvalue->csr }}</td>
                                       </tr>
                                       <tr>
                                          <td>Deg of Separation(#):</td>
                                          <td>{{ $socialvalue->deg_of_separation }}</td>
                                       </tr>
                                       <tr>
                                          <td>Shares(#m):</td>
                                          <td>{{ $socialvalue->shares }}</td>
                                       </tr>
                                       <tr>
                                          <td>Capitilization/NAV(£m):</td>
                                          <td>{{ $socialvalue->capititilization_NAV }}</td>
                                       </tr>
                                       <tr>
                                          <td>Staff(#):</td>
                                          <td>{{ $socialvalue->staff }}</td>
                                       </tr>
                                       <tr>
                                          <td>Carbon Reduction t(tCO2e):</td>
                                          <td>{{ $socialvalue->carbon_reduction_t }}</td>
                                       </tr>
                                       <tr>
                                          <td>Carbon Offset(tCO2e):</td>
                                          <td>{{ $socialvalue->carbon_offset }}</td>
                                       </tr>
                                       <tr>
                                          <td>Value tCO2e Non Traded(£):</td>
                                          <td>{{ $socialvalue->value_tCO2e_non_traded }}</td>
                                       </tr>
                                       <tr>
                                          <td>Value tCO2 Traded(£):</td>
                                          <td>{{ $socialvalue->value_tCO2e_traded }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>People</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user3">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user3">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">People</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>People(#m):</td>
                                          <td>{{ $socialvalue->people }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Money Leveraged</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user4">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user4">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Money Leveraged</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>Money Leveraged(£m):</td>
                                          <td>{{ $socialvalue->money_leveraged }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Inlcuding Tax Avoidance & Pay Disparity - Current Year</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user5">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user5">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Inlcuding Tax Avoidance & Pay Disparity - Current Year</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>Current Year Directory Salary Executive(£m):</td>
                                          <td>{{ $socialvalue->current_year_directors_salary_executive }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Directory Salary Non-Executive(£m):</td>
                                          <td>{{ $socialvalue->current_year_directors_salary_non_executive }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Staff Salary(£m):</td>
                                          <td>{{ $socialvalue->current_year_staff_salary }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Staff Salary Without Directors(£m):</td>
                                          <td>{{ $socialvalue->current_year_staff_salary_without_directors }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Tax Charged(£m):</td>
                                          <td>{{ $socialvalue->current_year_tax_charged }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Total Share Holder Pay Divident Cash(£m):</td>
                                          <td>{{ $socialvalue->current_year_total_share_holder_pay_dividend_cash }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Executive Board(#):</td>
                                          <td>{{ $socialvalue->current_year_executive_board }} </td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Non-Executive Board(#):</td>
                                          <td>{{ $socialvalue->current_year_non_executive_board }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Board Total(£m):</td>
                                          <td>{{ $socialvalue->current_year_board_total }}</td>
                                       </tr>
                                       <tr>
                                          <td>Current Year Number of Staffs(£m):</td>
                                          <td>{{ $socialvalue->current_year_number_of_staffs }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Inlcuding Tax Avoidance & Pay Disparity - Previous Year</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user6">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user6">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Inlcuding Tax Avoidance & Pay Disparity - Previous Year</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>Previous Year Directory Salary Executive(£m):</td>
                                          <td>{{ $socialvalue->prior_year_directors_salary_executive }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Directory Salary Non-Executive(£m):</td>
                                          <td>{{ $socialvalue->prior_year_directors_salary_non_executive }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Staff Salary(£m):</td>
                                          <td>{{ $socialvalue->prior_year_staff_salary }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Staff Salary Without Directors(£m):</td>
                                          <td>{{ $socialvalue->prior_year_staff_salary_without_directors }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Tax Charged(£m):</td>
                                          <td>{{ $socialvalue->prior_year_tax_charged }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Total Share Holder Pay Divident Cash(£m):</td>
                                          <td>{{ $socialvalue->prior_year_total_share_holder_pay_dividend_cash }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Executive Board(#):</td>
                                          <td>{{ $socialvalue->prior_year_executive_board }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Non-Executive Board(#):</td>
                                          <td>{{ $socialvalue->prior_year_non_executive_board }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Board Total(£m):</td>
                                          <td>{{ $socialvalue->prior_year_board_total }}</td>
                                       </tr>
                                       <tr>
                                          <td>Previous Year Number of Staffs(£m):</td>
                                          <td>{{ $socialvalue->prior_year_number_of_staffs }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @if(@$retCurrent)
               <div class="row user-row">
                  <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                     <img class="img-circle"
                        src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                        alt="User Pic">
                  </div>
                  <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                     <strong>Result</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user7">
                     <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
               </div>
               <div class="row user-infos user7">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                     <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3 class="panel-title">Result</h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                    alt="User Pic">
                              </div>
                              <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                 <img class="img-circle"
                                    src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                    alt="User Pic">
                              </div>
                              <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                 <table class="table table-user-information">
                                    <tbody>
                                       <tr>
                                          <td>SER(Ratio):</td>
                                          <td>{{ $retCurrent['ser'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>Social Impact(£m):</td>
                                          <td>{{ $retCurrent['social_impact'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>Social Impact as a Percentage of Capitilisation(%):</td>
                                          <td>{{ $retCurrent['social_impact_asap_cap'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>Added Value(£m):</td>
                                          <td>{{ $retCurrent['added_value'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>Environment(%):</td>
                                          <td>{{ $retCurrent['environment'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>People(%):</td>
                                          <td>{{ $retCurrent['people'] }}</td>
                                       </tr>
                                       <tr>
                                          <td>Cash(%):</td>
                                          <td>{{ $retCurrent['cash'] }}</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @else
               <a href= "{{URL::route('socialvalue.edit',['$id'=>$socialvalue->id])}}" class="btn btn-success btn-lg" title="edit">Edit</a>
               <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-lg" href="{{ route('socialvalue.destroy', ['id' => $socialvalue->id]) }}" title="Delete">Delete</a>
               @endif
            </div>
         </div>
      </div>
   </section>
</div>
@stop
@section('scripts')
<script type="text/javascript">
   $('#light').load(function() {
       // Caching
       var self = $('.active');

       // Check if another element exists after the currently active one otherwise
       // find the parent and start again
   });
</script>
@stop
