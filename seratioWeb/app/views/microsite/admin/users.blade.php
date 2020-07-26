@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Microsite::View All Users
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View  All Customers
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
               <div class="box-body table-responsive" style="overflow:scroll;">
                  <table id="example1" class="table table-bordered table-striped" >
                     <thead>
                        <tr>
                           <th>Title</th>
                           <th>First Name</th>
                           <th>Last Name</th>
                           <th>Email</th>
                           <th>Customer Name</th>
                           <th>Type</th>
                           <th>Address</th>
                           <th>primary_contact</th>
                           <th>Number</th>
                           <th>Accounts</th>
                           <th>Free Text</th>
                           <th>20% Social Value creation in your PQQ?</th>
                           <th>Social Value goals? </th>
                           <th>Social Value Policy?</th>
                           <th>Have you built these into your contracts?</th>
                           <th>Seratio as your Social Value measurement tool?</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($data as $user)
                        <tr>
                           @if($user->title == 0)
                           <td> N/A </td>
                           @else
                           <td> {{array_get(User::$TITLES, $user->title, 'unknown')}} </td>
                           @endif
                           <td>{{ $user->firstname ? $user->firstname :'N/A' }} </td>
                           <td>{{ $user->lastname ? $user->lastname : 'N/A'  }}</td>
                           <td>{{ $user->email ? $user->email : 'N/A' }}</td>
                           <td>{{ $user->microsite ? $user->microsite->customer_name : 'Unknown' }}</td>
                           <td>{{ $user->microsite ? $user->microsite->customer_type : 'Unknown' }}</td>
                           <td>{{$user->microsite ? $user->microsite->number_street : ''}}
                              <br>{{$user->microsite ? $user->microsite->city : ''}}
                              <br>{{$user->microsite ? $user->microsite->county : ''}}
                              <br>{{$user->microsite ? $user->microsite->post_code : ''}}
                              <br>{{$user->microsite ? $user->microsite->country: '' }}
                           </td>
                           <td>{{ $user->microsite ? $user->microsite->primary_contact : 'Unknown'}}</td>
                           <td>{{ $user->microsite ? $user->microsite->number : 'Unknown'}}</td>
                           @if($user->microsite->checkbox == 1)
                           <td><a href="{{URL::asset($user->microsite->audited_accounts)}}" target="_blank"><i class="fa fa-download">
                              Download</i></a>
                           </td>
                           @elseif($user->microsite->checkbox == 2)
                           <td>{{ $user->microsite->published_accounts }}</td>
                           @else
                           <td>N/A</td>
                           @endif
                           <td>{{ $user->microsite->free_text ? $user->microsite->free_text : 'N/A'}}</td>
                           <td>{{ $user->microsite->question1 ? 'Yes' : 'No'}}</td>
                           <td>{{ $user->microsite->question2 ? 'Yes' : 'No'}}</td>
                           <td>{{ $user->microsite->question3 ? 'Yes' : 'No'}}</td>
                           <td>{{ $user->microsite->question4 ? 'Yes' : 'No'}}</td>
                           <td>{{ $user->microsite->question5 ? 'Yes' : 'No'}}</td>
                           <td>
                              <a href= "{{URL::route('microsite.addresult',['$id'=>$user->microsite->id])}}" class="btn btn-success btn-xs" title="Add Result">
                              <span class="glyphicon glyphicon-plus"></span></a>
                              @if(Auth::user()->has_role('admin'))
                              <a href= "{{URL::route('microbids.bids',['$id'=>$user->microsite->id])}}" class="btn btn-success btn-xs" title="View Bids">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              @endif
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
   $(function() {
     $("#example1").dataTable();
   });
</script>
@stop
