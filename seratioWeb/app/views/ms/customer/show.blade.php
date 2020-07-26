@extends('layout.dashboard_default')
@section('title')
SE Ratio::Modern Slavery::Customer Info
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View Customer Data / {{$customer->customer_name}}
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Info</li>
      </ol>
   </section>
   </br>
   <section class="content">
      <div class="row">
         <div class="col-lg-9">
            @if (Session::has('message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
               <strong> {{ Session::get('message') }}</strong>
            </div>
            @endif
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Customer Info</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class="row">
                        <div class="well col-lg-10 col-md-offset-1" style="">
                           <div class="row user-row">
                              <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                                 <i class="fa fa-info-circle"  style="color:green; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Basic Info</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos cyruxx">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-success">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Basic Info</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td><b>Customer Name:</b></td>
                                                      <td >{{$customer->customer_name ? $customer->customer_name : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Address:</b></td>
                                                      <td>{{$customer->number_street ? $customer->number_street : ''}},<br>{{$customer->city ? $customer->city : ''}},<br>{{$customer->county ? $customer->county : ''}},<br>{{$customer->post_code ? $customer->post_code : ''}} @if($customer->country) ,<br>{{  array_get(Country::countries(), $customer->country, 'Unknown') }} @endif</td>
                                                   <tr>
                                                      <td><b>Primary Contact:</b></td>
                                                      <td >{{$customer->primary_contact ? $customer->primary_contact : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>E-Mail:</b></td>
                                                      <td >{{$customer->email ? $customer->email : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Phone Number:</b></td>
                                                      <td >{{$customer->number ? $customer->number : 'Unknown'}}</td>
                                                   </tr>
                                                   @if($customer->sector)
                                                   <tr>
                                                      <td><b>Sector:</b></td>
                                                      <td>{{ array_get(MSlavery::sectors(), $customer->sector, 'Unknown') }}</td>
                                                   </tr>
                                                   @endif
                                                   @if($customer->main_industry)
                                                   <tr>
                                                      <td><b>Main Industry:</b></td>
                                                      <td>{{ array_get(MSlavery::industries(), $customer->main_industry, 'Unknown') }}</td>
                                                   </tr>
                                                   @endif
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
                                 <i class="fa fa-money"  style="color:maroon; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Pay</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user2">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos user2">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-danger">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Pay</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td><b>Currency:</b></td>
                                                      <td>{{$customer->currency ? $customer->currency : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Total Revenue:</b></td>
                                                      <td>{{$customer->total_revenue ? $customer->total_revenue : 'Unknown'}}</td>
                                                   <tr>
                                                      <td><b>Total Wages:</b></td>
                                                      <td>{{$customer->total_wages ? $customer->total_wages : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Number of Employees:</b></td>
                                                      <td>{{$customer->no_of_employees ? $customer->no_of_employees : 'Unknown'}}</td>
                                                   </tr>
                                                   @if($customer->document1)
                                                   <tr>
                                                      <td><b>Documents:</b></td>
                                                      <td> <a href="{{URL::asset($customer->document1)}}" target="_blank"><i class="fa fa-download">
                                                         Click here to download the file</i></a>
                                                      </td>
                                                   </tr>
                                                   @endif
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
                                 <i class="fa fa-line-chart"  style="color:orange; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Sentiment</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user3">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos user3">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-warning">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Sentiment</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td >Have you conducted your own employer anti-slavery sentiment survey?</td>
                                                      @if($customer->sentiment_q1 == '1')
                                                      <td> Yes </td>
                                                      @elseif($customer->sentiment_q1 == '2')
                                                      <td> No </td>
                                                      @else
                                                      <td> N/A </td>
                                                      @endif
                                                   </tr>
                                                   @if($customer->sentiment_q1 == '1')
                                                   <tr>
                                                      <td >Would you like to use Seratio's purpose built Anti-Slavery sentiment survey?</td>
                                                      @if($customer->sentiment_q1_sub == '3')
                                                      <td> Yes </td>
                                                      @elseif($customer->sentiment_q1_sub == '4')
                                                      <td> No </td>
                                                      @else
                                                      <td> N/A </td>
                                                      @endif
                                                   </tr>
                                                   <tr>
                                                      <td>What % of your employees would recommend your company to a friend to work for?</td>
                                                      <td>{{ $customer->sentiment_q2 ? $customer->sentiment_q2 : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td >What % of employees completed your survey?</td>
                                                      <td >{{ $customer->sentiment_q3 ? $customer->sentiment_q3 : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>When was this survey conducted? Month/Year</td>
                                                      <td>{{ $customer->sentiment_q4 ? $customer->sentiment_q4 : 'Unknown'}}</td>
                                                   </tr>
                                                   @endif
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
                                 <i class="fa fa-book"  style="color:red; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Statement</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user4">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos user4">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-danger">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Statement</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td >Please outline a description of the nature of your business, the organisational structure, and the organisations supply chains ie which countries or sectors it operates in</td>
                                                      <td> {{ $customer->nature_of_your_business ? $customer->nature_of_your_business : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td >This question relates to the maintenance of anti-slavery or human trafficking policies in your supply chain and your own business. Please list and or link to established and documented policies. Do you have the following already in place or being put in place?</td>
                                                      <td> {{ $customer->policies ? $customer->policies : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td >Do you have Existing Policies for Child Labour?</td>
                                                      <td> {{ $customer->checkbox1 ? $customer->checkbox1 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td >For Bribery and Corruption</td>
                                                      <td> {{ $customer->checkbox3 ? $customer->checkbox3 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td> For Conditions of Employment</td>
                                                      <td> {{ $customer->checkbox5 ? $customer->checkbox5 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td> Do you have them for Living Wages/Minimum Wages?</td>
                                                      <td> {{ $customer->checkbox7 ? $customer->checkbox7 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For environmental issues</td>
                                                      <td> {{ $customer->checkbox9 ? $customer->checkbox9 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Prevention of hidden third party labour exploitation</td>
                                                      <td> {{ $customer->checkbox11 ? $customer->checkbox11 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Elimination of Discrimination</td>
                                                      <td> {{ $customer->checkbox13 ? $customer->checkbox13 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Whistleblowing</td>
                                                      <td> {{ $customer->checkbox15 ? $customer->checkbox15 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Equal Opportunity</td>
                                                      <td> {{ $customer->checkbox2 ? $customer->checkbox2 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Remuneration</td>
                                                      <td> {{ $customer->checkbox6 ? $customer->checkbox6 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For health and safety</td>
                                                      <td> {{ $customer->checkbox8 ? $customer->checkbox8 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Supplier Code of Conduct and Sustainability</td>
                                                      <td> {{ $customer->checkbox10 ? $customer->checkbox10 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Freedom of Association</td>
                                                      <td> {{ $customer->checkbox12 ? $customer->checkbox12 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>For Human Rights Compliance</td>
                                                      <td> {{ $customer->checkbox14 ? $customer->checkbox14 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>What % of your known suppliers do you have the above terms policies with?</td>
                                                      <td> {{ $customer->known_supp ? $customer->known_supp : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Select the due diligence processes in relation to the management and identification of slavery which you have and attach relevant documents</td>
                                                      <td> {{ $customer->checkbox16 ? $customer->checkbox16 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Please list which external auditors, internal or external third party technology providers and NGO's that you have used and the dates of their reports, if not yet reported the dates they were commissioned</td>
                                                      <td> {{ $customer->external_auditors ? $customer->external_auditors : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Have you been informed of any instances or suspicious of slavery in your supply chain?</td>
                                                      <td> {{ $customer->instances ? $customer->instances : 'N/A'}}</td>
                                                   </tr>
                                                   @if($customer->instances == 'Yes')
                                                   <tr>
                                                      <td>If Yes, please detail each instance, dates, country, sector, and the processes that you have put into place to investigate and rectify the situation. Detail how any such violation
                                                         or risk has been managed/eliminated - detail the audits ie whether they are internal or external, if external which providers you used ie technology such as Seratio, 3rd parties who provide audit, investigation or consultancy services - state when these were carried out
                                                      </td>
                                                      <td> {{ $customer->free_text ? $customer->free_text : 'N/A'}}</td>
                                                   </tr>
                                                   @endif
                                                   <tr>
                                                      <td>Please detail which types of management reports you are using to manage performance indicators to monitor and manage the risk of slavery</td>
                                                      <td> {{ $customer->checkbox17 ? $customer->checkbox17 : 'N/A'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>Please detail which internal or external technology platforms you are using and the external consultants that you use</td>
                                                      <td> {{ $customer->technology_platforms ? $customer->technology_platforms : 'N/A'}}</td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
         <div class="col-lg-3">
            <!-- Danger box -->
            <div class="box box-solid box-success">
               <div class="box-header">
                  <h3 class="box-title">Info</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class= "btn-group-vertical" style="width: 100%; height: 270px;">
                        <div class="row">
                           <div class="col-lg-10 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-red">
                                 <div class="inner">
                                    <h3>
                                       {{$customer->customer_number}}
                                    </h3>
                                    <p>
                                       Customer Number
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
               </div>
            </div>
            <!-- /.box -->
         </div>
      </div>
      @if(Auth::user()->has_role('admin'))
      <div class="row">
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Compliance</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <button type="button" align="right" style=" height: 100px;width:100%" class="btn btn-success btn-lg">
                        <b>
                           No Risk @if($customer->modern_slavery>=2) ({{$customer->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-warning" style="height: 100px;width:100%">
                        <b>
                           Potential Risk @if($customer->modern_slavery>=1 && $customer->modern_slavery<2) ({{$customer->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-danger" style="height: 100px;width:100%">
                        <b>
                           Identifiable Risk @if($customer->modern_slavery<1 && !empty($customer->modern_slavery)) ({{$customer->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-success">
               <div class="box-header">
                  <h3 class="box-title">Progress</h3>
               </div>
               <div class="box-body">
                  <table class="table table-bordered">
                  </table>
                  <div id="chart_div"></div>
               </div>
               <!-- /.box-body-->
            </div>
            <!-- /.box -->
         </div>
      </div>
      @endif
      <div class="row">
         <div class="col-xs-12">
            <!--Danger box -->
            <div class="box box-solid box-warning">
               <div class="box-header">
                  <h3 class="box-title">Related Suppliers</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class="row" style="overflow: scroll;">
                        <table id="example1" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th>Supplier Number</th>
                                 <th>Supplier Name</th>
                                 <th>Address</th>
                                 <th>E-Mail</th>
                                 <th>Sector</th>
                                 <th>Main Industry</th>
                                 <th>Currency</th>
                                 <th>Total Revenue</th>
                                 <th>Total Wages</th>
                                 <th>Number of Employees</th>
                                 <th>Annual Accounts</th>
                                 <th>Have you carried out a sentiment survey of your employees?</th>
                                 <th>What % of your employees would recommend your company to a friend to work for?</th>
                                 <th>What % of employees completed your survey?</th>
                                 <th>When was this survey conducted? Month/Year</th>
                                 <th>Have you completed this survey or provided any data before for another Customer?</th>
                                 <th>Customer Number</th>
                                 <th>Modern Slavery</th>
                                 <th>Sentiment</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($suppliers as $supplier)
                              <tr>
                                 <td>{{$supplier->supplier_number ? $supplier->supplier_number : 'Unknown'}} </td>
                                 <td>{{$supplier->supplier_name ? $supplier->supplier_name : 'Unknown'}} </td>
                                 <td>{{$supplier->number_street ? $supplier->number_street : ''}},<br>{{$supplier->city ? $supplier->city : ''}},<br>{{$supplier->county ? $supplier->county : ''}},<br>{{$supplier->post_code ? $supplier->post_code : ''}} @if($supplier->country) ,<br>{{  array_get(Country::countries(), $supplier->country, 'Unknown') }} @endif</td>
                                 <td>{{$supplier->email ? $supplier->email : 'Unknown'}} </td>
                                 <td>{{$supplier->sector ? $supplier->sector : 'Unknown'}} </td>
                                 <td>{{$supplier->main_industry ? $supplier->main_industry : 'Unknown'}} </td>
                                 <td>{{$supplier->currency ? $supplier->currency : 'Unknown'}} </td>
                                 <td>{{$supplier->total_revenue ? $supplier->total_revenue : 'Unknown'}} </td>
                                 <td>{{$supplier->total_wages ? $supplier->total_wages : 'Unknown'}} </td>
                                 <td>{{$supplier->no_of_employees ? $supplier->no_of_employees : 'Unknown'}} </td>
                                 @if($supplier->document1)
                                 <td><a href="{{URL::asset($supplier->document1)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                                 @else
                                 <td>N/A</td>
                                 @endif
                                 <td>{{$supplier->sentiment_q1 ? 'Yes' : 'No'}} </td>
                                 <td>{{$supplier->sentiment_q2 ? $supplier->sentiment_q2 : 'Unknown'}} </td>
                                 <td>{{$supplier->sentiment_q3 ? $supplier->sentiment_q3 : 'Unknown'}} </td>
                                 <td>{{$supplier->sentiment_q4 ? $supplier->sentiment_q4 : 'Unknown'}} </td>
                                 <td>{{$supplier->supplier_another_check ? $supplier->supplier_another_check : 'Unknown'}} </td>
                                 <td>{{$supplier->supplier_another ? $supplier->supplier_another : 'N/A'}} </td>
                                 <td>{{$supplier->modern_slavery ? $supplier->modern_slavery : 'N/A'}}</td>
                                 <td>{{$supplier->sentiment ? $supplier->sentiment : 'N/A'}}</td>
                                 <td>
                                    <a href= "#" class="btn btn-info btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$supplier->id}}">
                                    <span class="glyphicon glyphicon-plus"></span></a>
                                    <div class="modal fade" id="myModal{{$supplier->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                             </div>
                                             <div class="modal-body">
                                                @if (Session::has('message'))
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                   <strong> {{ Session::get('message') }}</strong>
                                                </div>
                                                @endif
                                                {{ Form::open(array('route' => array('modernslavery.suresult', $supplier->id), 'method' => 'POST')) }}
                                                <div class="input-group">
                                                   <span class="input-group-addon" id="basic-addon1">Modern Slavery</span>
                                                   {{ Form::number('modern_slavery', $supplier->modern_slavery, array('step' => 'any', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1', 'required')) }}
                                                   @if ($errors->has('modern_slavery'))
                                                   <p class="help-block">{{ $errors->first('modern_slavery') }}</p>
                                                   @endif
                                                </div>
                                                </br></br>
                                                <div class="input-group">
                                                   <span class="input-group-addon" id="basic-addon2">Sentiment</span>
                                                   {{ Form::number('sentiment',$supplier->sentiment, array('step' => 'any', 'class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'required')) }}
                                                   @if ($errors->has('sentiment'))
                                                   <p class="help-block">{{ $errors->first('sentiment') }}</p>
                                                   @endif
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
                              </tr>
                              @endforeach
                           </tbody>
                           <tfoot>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.box -->
      <div class="row">
         <div class="col-xs-12">
            <!--Danger box -->
            <div class="box box-solid box-info">
               <div class="box-header">
                  <h3 class="box-title">Sentiment Survey Results - Customer </h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class="row" style="overflow: scroll;">
                        <table id="example3" class="table table-bordered table-striped">
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
                              @foreach($customer_surveys as $survey)
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
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.box -->
      <div class="row">
         <div class="col-xs-12">
            <!--Danger box -->
            <div class="box box-solid box-danger">
               <div class="box-header">
                  <h3 class="box-title">Sentiment Survey Results - Suppliers </h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class="row" style="overflow: scroll;">
                        <table id="example2" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th>Supplier Number</th>
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
                                 <td>{{ $survey->supplier_number ? $survey->supplier_number : 'Unknown'}}</td>
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
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.box -->
   </section>
</div>
<!-- add new calendar event modal -->
@stop
@section('scripts')
<!-- page script -->
<script type="text/javascript">
   $(function() {
       $("#example1").dataTable();
       $("#example2").dataTable();
       $("#example3").dataTable();
   });
</script>
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
<script type="text/javascript">
   $(function() {
       $('#myModal{{$supplier->id}}').modal('show');
   });
</script>
@endif
<script type="text/javascript">
   google.load('visualization', '1.0', {packages: ['corechart', 'bar']});
   google.load('visualization', '1.0', {packages:['gauge']});
   google.load("visualization", "1", {packages:["corechart"]});

   google.setOnLoadCallback(drawBasic);


   function drawBasic() {

     var data = google.visualization.arrayToDataTable([
       ['Sections', '% Completion',],
       ['Basic Info', {{$basic_info}}],
       ['Pay', {{$pay}}],
       ['Sentiment', {{$sentiment}}]

       ]);

     var options = {
       chartArea: {width: '60%'},
       hAxis: {
         minValue: 0
     },
     vAxis: {

     }
   };

   var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
   chart.draw(data, options);
   }



</script>
@stop
