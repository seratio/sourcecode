@extends('layout.dashboard_default')
@section('title')
SE Ratio::Modern Slavery::View All Users
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
               <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Title</th>
                           <th>First Name</th>
                           <th>Last Name</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Sub Role</th>
                           <th>Customer Number</th>
                           <th>Modern Slavery</th>
                           <th>Sentiment</th>
                           <th>Customer Type</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $user)
                        <tr>
                           @if($user->title == 0)
                           <td> N/A </td>
                           @else
                           <td> {{array_get(User::$TITLES, $user->title, 'unknown')}} </td>
                           @endif
                           <td>{{ $user->firstname ? $user->firstname :'N/A' }} </td>
                           <td>{{ $user->lastname ? $user->lastname : 'N/A'  }}</td>
                           <td>{{ $user->email ? $user->email : 'N/A' }}</td>
                           <td>{{ array_get(User::$ROLES, $user->role_id, 'unknown')}} </td>
                           <td>{{ array_get(User::$SUBROLES, $user->subrole_id, 'unknown')}}</td>
                           <td>{{ $user->mscustomer ? $user->mscustomer->customer_number : 'N/A' }}</td>
                           <td> {{ $user->mscustomer ? $user->mscustomer->modern_slavery : 'N/A' }}</td>
                           <td> {{ $user->mscustomer ? $user->mscustomer->sentiment : 'N/A' }}</td>
                           <td> {{ $user->mscustomer ? $user->mscustomer->customer_type : 'Unknown' }}
                           @if(Auth::user()->has_role('admin') && ($user->mscustomer))
                           <td>
                              <a href= "{{URL::route('modernslavery.show',['$id'=>$user->mscustomer->id])}}" class="btn btn-success btn-xs" title="View Customer">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              <a href= "#" class="btn btn-info btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$user->mscustomer->id}}">
                              <span class="glyphicon glyphicon-plus"></span></a>
                              <div class="modal fade" id="myModal{{$user->mscustomer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                       </div>
                                       <div class="modal-body">
                                          {{ Form::open(array('route' => array('modernslavery.result', $user->mscustomer->id), 'method' => 'POST')) }}
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">Modern Slavery</span>
                                             {{ Form::number('modern_slavery', $user->mscustomer->modern_slavery, array('step' => 'any', 'class' => 'form-control', 'aria-describedby' => 'basic-addon1')) }}
                                             @if ($errors->has('modern_slavery'))
                                             <p class="help-block">{{ $errors->first('modern_slavery') }}</p>
                                             @endif
                                          </div>
                                          </br></br>
                                          <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon2">Sentiment</span>
                                             {{ Form::number('sentiment',$user->mscustomer->sentiment, array('step' => 'any', 'class' => 'form-control', 'aria-describedby' => 'basic-addon2')) }}
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
                           @endif
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
