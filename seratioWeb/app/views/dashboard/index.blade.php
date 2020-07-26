@extends('layout.dashboard_default')
@section('title')
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Pilot Dashboard
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Dashboard</li>
      </ol>
   </section>
   </br>
   <!-- Left col -->
   <section class="content">
      <div class="row">
         <section class="col-lg-12 connectedSortable">
            <!-- Map box -->
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-bars"></i>
                  <h3 class="box-title">
                     Projects
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 120px;">
                     <table class="table table-bordered">
                        <tr>
                           <th>Organisation</th>
                           <td> West Midlands Fire Service</td>
                        </tr>
                        <tr>
                           <th style="width: 40px">Address</th>
                           <td> 99 Vauxhall Road, Birmingham, B7 4HW </td>
                        </tr>
                        <tr>
                           <th>Tender</th>
                           <td> Learning Tender</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <!-- Map box -->
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">
                     Dates
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 500px;">
                     <table class="table table-bordered">
                        <tr>
                           <th>HoA Agreed</th>
                           <td> 18 Dec 2014</td>
                        </tr>
                        <tr>
                           <th>HoA Signed</th>
                           <td> 2 Feb 2015</td>
                        </tr>
                        <tr>
                           <th>Kick Off Meeting</th>
                           <td> Vacated by Client</td>
                        </tr>
                        <tr>
                           <th>Tender Identified</th>
                           <td> 25 Feb2015</td>
                        </tr>
                        <tr>
                           <th>Tender Published</th>
                           <td> 11 March 2015</td>
                        </tr>
                        <tr>
                           <th>Interim Report</th>
                           <td> 8 April 2015</td>
                        </tr>
                        <tr>
                           <th>Tender Closes</th>
                           <td> 9 April 2015</td>
                        </tr>
                        <tr>
                           <th>Bidders Benchmark Report</th>
                           <td> 15 April 2015</td>
                        </tr>
                        <tr>
                           <th>Bidders .v. KPI's Report</th>
                           <td> 20 April 2015</td>
                        </tr>
                        <tr>
                           <th>Tender Assesment meeting #1</th>
                           <td> 21 April 2015</td>
                        </tr>
                        <tr>
                           <th>Tender Assesment meeting #2</th>
                           <td> 22 April 2015</td>
                        </tr>
                        <tr>
                           <th>Contract Awarded</th>
                           <td> 13 May 2015</td>
                        </tr>
                        <tr>
                           <th>Contractor Start</th>
                           <td> September 2015</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <!-- Map box -->
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">
                     Compliance
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  {{ HTML::image('assets/img/compl.png') }}
                  <div id="content" style="width: 100%; height: 1450px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Assessment</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                        </tr>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tr>
                        <tr>
                           <td> Environment</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Cash</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> People</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Tax Avoidance</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Pay Disparity</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Personal Value</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Transparency in Supply Chain</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Sentiment/Feedback</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Hyperlocality</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Forward Forecasting</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Time Dependant Monitoring</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Financial Value</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Benchmarking</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Compliance</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                        </tr>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tr>
                        <tr>
                           <td> Social Value Act</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Modern Slavery Act</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> ISO 26000</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> GRI-4</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> IIRC</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Benefit Coro</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> WEF</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> EU 500+CSR</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> GECES</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> SI 20%</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Litigation Liability</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Compliance</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                        </tr>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tr>
                        <tr>
                           <td> Monthly Reporting</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td> Independent Arbitration</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Dashboard Provision</td>
                           <td> </td>
                           <td bgcolor="green"> </td>
                        </tr>
                        <tr>
                           <td>Capacity Development (online) - MOOC</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Capacity Development (face2face) - Conferences</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Capacity Development (written) - Journal</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Engagement - Collaborative Mapping (GIS)</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                        <tr>
                           <td> Solutions - Participatory Planning (Acupuncture)</td>
                           <td> </td>
                           <td bgcolor="red"> </td>
                        </tr>
                        <tr>
                           <td> Ideation</td>
                           <td> </td>
                           <td bgcolor="yellow"> </td>
                        </tr>
                     </table>
                  </div>
                  <!-- /.box-body-->
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button id="test" class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-signal"></i>
                  <h3 class="box-title">
                     Progress
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <table class="table table-bordered">
                     <tr>
                        <th bgcolor="green" style="color:white;font-weight:bold">Progress</th>
                     </tr>
                  </table>
                  <div id="chart_div"></div>
                  <div id="content" style="width: 100%; height: 200px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Overview of Project Status</th>
                        </tr>
                        <tr>
                           <th> 92% Completed </th>
                        </tr>
                        <tr>
                           <th> 8% Outstanding</th>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button onclick="var ifr=document.getElementsByName('map')[0]; ifr.src=ifr.src;" class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa  fa-map-marker"></i>
                  <h3 class="box-title">
                     Collaborative Mapping
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <iframe name="map" src="https://www.google.com/maps/d/u/0/embed?mid=zMxTY8WYoRAQ.k-90z9BEJ2rM&ll=52.4840604,-1.8777567&z=9" width="1020" height="600"></iframe>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">
                     Hyperlocality
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 3300px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Headquarters with 4 mile radius against ARM Q4 data</th>
                        </tr>
                        <tr>
                           <td>{{ HTML::image('assets/img/HQ.png' ,'', array('width' => '1200', 'height' =>'400')) }} </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">West midland Fire stations with 4 mile radius</th>
                        </tr>
                        <tr>
                           <td>{{ HTML::image('assets/img/FS1.png','', array('width' => '1200', 'height' =>'400')) }} </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">West midland Fire stations against ARM Q4 data</th>
                        </tr>
                        <tr>
                           <td>{{ HTML::image('assets/img/FS2.png','', array('width' => '1200', 'height' =>'400')) }} </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Project outcomes with 4 mile radius</th>
                        </tr>
                        <tr>
                           <td> {{ HTML::image('assets/img/PO1.png','', array('width' => '1200', 'height' =>'400'))}}</td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Project outcomes against ARM Q4 data.</th>
                        </tr>
                        <tr>
                           <td> {{ HTML::image('assets/img/PO2.png','', array('width' => '1200', 'height' =>'400')) }}</td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Third Sector Partners with 4 mile radius</th>
                        </tr>
                        <tr>
                           <td>{{ HTML::image('assets/img/TP1.png','', array('width' => '1200', 'height' =>'400')) }} </td>
                        </tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Third Sector Partners against ARM Q4 data</th>
                        </tr>
                        <tr>
                           <td> {{ HTML::image('assets/img/TP2.png','', array('width' => '1200', 'height' =>'400')) }}</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-dashboard"></i>
                  <h3 class="box-title">
                     Social Earnings Analysis
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 600px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold"></th>
                           <th bgcolor="green" style="color:white;font-weight:bold"></th>
                           <th bgcolor="green" style="color:white;font-weight:bold">2014</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Seratio</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">2018</th>
                        </tr>
                        <tr>
                           <td>SER </td>
                           <td>Ratio </td>
                           <td> 1.33</td>
                           <td>2.32</td>
                           <td>3.58 </td>
                        </tr>
                        <tr>
                           <td>SI by calculation </td>
                           <td> £m</td>
                           <td>16.88 </td>
                           <td>29.4</td>
                           <td> 38.62</td>
                        </tr>
                        <tr>
                           <td>Added Social Value </td>
                           <td> £m</td>
                           <td>4.18</td>
                           <td>16.7</td>
                           <td> 27.62</td>
                        </tr>
                        <tr>
                           <td>Increase in Market Cap/NAV </td>
                           <td> %</td>
                           <td>0.33</td>
                           <td>1.31</td>
                           <td> 2.18</td>
                        </tr>
                        <tr>
                           <td>Environment </td>
                           <td> %</td>
                           <td>0</td>
                           <td>0</td>
                           <td>0</td>
                        </tr>
                        <tr>
                           <td>People </td>
                           <td> %</td>
                           <td>18</td>
                           <td>53</td>
                           <td>70</td>
                        </tr>
                        <tr>
                           <td>Cash </td>
                           <td> %</td>
                           <td>82</td>
                           <td>47</td>
                           <td>30</td>
                        </tr>
                        <tr>
                           <td colspan="5" style="color:red;font-weight:bold">INCLUDING TAX AVOIDANCE & PAY DISPARITY</td>
                        </tr>
                        <tr>
                           <td>Tax Avoidance </td>
                           <td> £m</td>
                           <td>0</td>
                           <td>0</td>
                           <td>0</td>
                        </tr>
                        <tr>
                           <td>Pay Disparity</td>
                           <td> £m</td>
                           <td>-0.537</td>
                           <td>0.537</td>
                           <td>0.3692</td>
                        </tr>
                        <tr>
                           <td>SER POST TAX/PAY (ptp)</td>
                           <td> </td>
                           <td></td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>SER post tax/pay(ptp)</td>
                           <td>Ratio </td>
                           <td>1.372</td>
                           <td>2.36</td>
                           <td>3.61</td>
                        </tr>
                        <tr>
                           <td>SI by calculation ptp-UK£m</td>
                           <td>£m </td>
                           <td>17.41</td>
                           <td>29.93</td>
                           <td>38.99</td>
                        </tr>
                        <tr>
                           <td>Added Social Value ptp UK£m</td>
                           <td>£m </td>
                           <td>4.72</td>
                           <td>17.24</td>
                           <td>28.19</td>
                        </tr>
                        <tr>
                           <td>Increase in Market Cap/NAV ptp</td>
                           <td>%</td>
                           <td>0.37</td>
                           <td>1.35</td>
                           <td>2.207</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button id="piechart" class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">
                     Pie Chart
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="piechart_3d" style="width: 90%; height: 500px;"></div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-th-list"></i>
                  <h3 class="box-title">
                     Learning Tender
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 1700px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Assessment</th>
                        <tr>
                           <td>{{ HTML::image('assets/img/NEW.png','', array('width' => '1200', 'height' =>'900')) }} </td>
                        </tr>
                        <tr>
                           <th></th>
                        <tr>
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">Advisory</th>
                        <tr>
                           <td>
                              <p>
                              <h4> FEEDBACK TO BIDDERS </h4>
                              Tender A:        Took very much a bid compliancy approach</br>
                              Tender B:        Offered free consultancy days without providing a value</br>
                              Tender C:        Very poor articulation of their bid which spoilt a good proposal</br>
                              Tender D:        Good articulation of their own Social Value but not part o client KPI</br>
                              Tender E:        Impressive to have provided so many options of varying social value</br>
                              <h4> ASSESSMENT PROCESS </h4>
                              Three channels to deliver social value </br>
                              (i)     Enhancing SV of WMFS    </br>
                              (ii)    Direct intervention into WFMS regions </br>
                              (iii)   Partnership arrangement with 3rd sector NGO's   </br>
                              Due to the restricted time between bids and assessment, we focussed on (i) </br>
                              <h4> WMFS KPI's </h4>
                              Free training places </br>
                              20% social impact       </br>
                              </br>
                              No priority was placed on these 2 KPI's. Tender F provided several choices to deliver social value.  </br>
                              We prioritised free training, but undertook the calculations on the other options.    </br>
                              For scoring purposes we only gave the free training option but happy to provide scoring for other options</br>
                              <h4> REMINDER</h4>
                              Please ensure the winning bidder understand their commitments in terms of 2% fee, plus
                              continous monitoring of their social value through the lifetime of the contract
                              Penalties for delivering their SV obligations should be clearly spelled out
                              </br>
                              <h4> FULL REPORT</h4>
                              We are still in the process of undertaking full assessment of present and future WMFS social value
                              This report is due to be ready for a 20 May launch - we are awaiting for data from WMFS
                              </p>
                           </td>
                     </table>
                     </p>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-file-text"></i>
                  <h3 class="box-title">
                     Budget
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="content" style="width: 100%; height: 850px;">
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">WMFS Budgets - Non Statutory Spend</th>
                           <th bgcolor="green" style="color:white;font-weight:bold"> Budget</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Deficit</th>
                        </tr>
                        <th colspan="3" style="color:black;font-weight:bold">Non-Satutory Costs 2013-14</th>
                        <tr>
                        </tr>
                        <tr>
                           <td>Community Safety UK£m </td>
                           <td> 12.694</td>
                           <td> </td>
                        </tr>
                        <tr>
                           <td>Money leveraged for Community Fire Safety Engagement UK£m </td>
                           <td> 1.143</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Community Activity - # engagement </td>
                           <td> 259,753</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Service Users (m) </td>
                           <td> 2.70</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Procurement Budget UK£m </td>
                           <td> 10.8</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Social Value 20% of Procurement Budget </td>
                           <td> 0.00</td>
                           <td></td>
                        </tr>
                        </tr>
                        <th colspan="3" style="color:black;font-weight:bold">Non-Satutory Costs 2017-18</th>
                        <tr>
                        </tr>
                        <tr>
                           <td>Community Safety UK£m </td>
                           <td> 10.8</td>
                           <td style="color:red;">1.894 </td>
                        </tr>
                        <tr>
                           <td>Money leveraged for Community Fire Safety Engagement  </td>
                           <td> 0.97</td>
                           <td style="color:red;">0.173</td>
                        </tr>
                        <tr>
                           <th colspan="2" style="color:red;font-weight:bold;">Subtotal loss of budget</th>
                           <td style="color:red;font-weight:bold;">2.067</td>
                        </tr>
                        <tr>
                           <td>Community Activity - # engagement </td>
                           <td> 285,727</td>
                           <td>25,974</td>
                        </tr>
                        <tr>
                           <td>Service Users (m) </td>
                           <td> 2.89</td>
                           <td>0.19</td>
                        </tr>
                        <tr>
                           <td>Procurement Budget UK£m </td>
                           <td> 10.4</td>
                           <td>0.40</td>
                        </tr>
                        <tr>
                           <td style="color:green;font-weight:bold;">Social Value 20% of Procurement Budget </td>
                           <td style="color:green;font-weight:bold;"> 2.08</td>
                           <td style="color:green;font-weight:bold">0</td>
                        </tr>
                     </table>
                     </br>
                     <table class="table table-bordered">
                        <tr>
                           <th bgcolor="green" style="color:white;font-weight:bold">WMFS Total Budgets</th>
                           <th bgcolor="green" style="color:white;font-weight:bold"> Budget</th>
                           <th bgcolor="green" style="color:white;font-weight:bold">Deficit</th>
                        </tr>
                        <tr>
                           <td>Annual budget 2013-14 UK£m</td>
                           <td> 118.76</td>
                           <td> </td>
                        </tr>
                        <tr>
                           <td>Annual budget 2017-18 UK£m</td>
                           <td> 90</td>
                           <td style="color:red;font-weight:bold">28.76</td>
                        </tr>
                        <tr>
                           <td>Social Value Created UK£m </td>
                           <td> 28.19</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Commercial Activities UK£m </td>
                           <td> 0.6</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td style="font-weight:bold">New Activities </td>
                           <td style="color:green;font-weight:bold"> 28.79</td>
                           <td style="color:green;font-weight:bold">0</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
               <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                     <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa  fa-check"></i>
                  <h3 class="box-title">
                     Benchmark
                  </h3>
               </div>
               <div class="box-body" style="display:none">
                  <div id="chart_div_ben" style="width: 300px; height: 300px;"></div>
               </div>
               <!-- /.box-body-->
            </div>
         </section>
         <!-- /.Left col -->
      </div>
   </section>
   <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- add new calendar event modal -->
@stop
@section('scripts')
<script type="text/javascript">
   $(document).ready(function() {
       $("#test").click(function() {
           drawBasic();
       });

   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
       $("#piechart").click(function() {
           drawPie();
       });

   });
</script>
<!--<script type="text/javascript">
   $(document).ready(function() {
     $("#piechart").click(function() {
         var chart;
         var legend;

         var chartData = [
             {
                 "label": "Environmental",
                 "value": '0'
             },
             {
                 "label": "People",
                 "value": '53'
             },
             {
                 "label": "Cash",
                 "value": '47'
             }


         ];

         AmCharts.ready(function () {
             // PIE CHART
             pieChart = new AmCharts.AmPieChart();
             pieChart.dataProvider = chartData;
             pieChart.titleField = "label";
             pieChart.valueField = "value";
             pieChart.outlineColor = "#FFFFFF";
             pieChart.fontSize = 14;
             pieChart.fontFamily = 'Georgia';
             pieChart.outlineAlpha = 0.8;
             pieChart.outlineThickness = 1;
             pieChart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]%</b></span>";
             pieChart.colors = ["#FFCB05", "#252525", "#888888"];

             // LEGEND
             pieLegend = new AmCharts.AmLegend();
             pieLegend.align = "center";
             pieLegend.position = "bottom";
             pieLegend.equalWidths = false;
             pieLegend.autoMargins = false;
             pieLegend.labelText = "[[title]]";
             pieLegend.valueText = "[[value]]%";
             pieLegend.valueAlign = "left";
             pieLegend.markerType = "square";
             pieLegend.switchable = false;
             pieChart.addLegend(pieLegend);

             pieChart.labelRadius = 30;
             pieChart.labelText = "";

             // this makes the chart 3D
             pieChart.depth3D = 15;
             pieChart.angle = 30;

             // WRITE
             pieChart.write("chartdiv");
         });
   });
   });


   </script>-->
@stop
@section('charts')
<script type="text/javascript">
   google.load('visualization', '1.0', {packages: ['corechart', 'bar']});
   google.load('visualization', '1.0', {packages:['gauge']});
   google.load("visualization", "1", {packages:["corechart"]});

   google.setOnLoadCallback(drawBasic);
   google.setOnLoadCallback(drawChart);
   google.setOnLoadCallback(drawPie);

   function drawBasic() {

         var data = google.visualization.arrayToDataTable([
           ['Sections', '% Completion',],
           ['Identification and Authority', 100],
           ['Schedule', 100],
           ['Authority', 100],
           ['Client Citizen Map', 100],
           ['Private Sector Bidders', 100],
            ['Engagement', 100],
            ['Third Sector Partners', 100],
            ['Reporting', 0],

         ]);

         var options = {
           chartArea: {width: '70%'},
           hAxis: {
             minValue: 0
           },
           vAxis: {

           }
         };

         var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
         chart.draw(data, options);
       }

   function drawChart() {

           var data = google.visualization.arrayToDataTable([
             ['Label', 'Value'],
             ['Ser', 51.64],
             ['% capitalization', 73.77],

           ]);

           var options = {
             width: 800, height: 300,
             minorTicks: 5
           };

           var chart = new google.visualization.Gauge(document.getElementById('chart_div_ben'));

           chart.draw(data, options);

           setInterval(function() {

             chart.draw(data, options);
           }, 13000);
           setInterval(function() {

             chart.draw(data, options);
           }, 5000);

         }
   function drawPie() {
           var data = google.visualization.arrayToDataTable([
             ['Label', 'Value'],
             ['Environmental',     0],
             ['People',      53],
             ['Cash',  47]
           ]);

           var options = {
             is3D: true,
             sliceVisibilityThreshold:0,

              legend: {
           position: 'labeled',
           labeledValueText: 'both',

       }
           };

           var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
           chart.draw(data, options);
         }
</script>
@stop
