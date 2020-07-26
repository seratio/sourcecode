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
         View All Users
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
                           <th>Position</th>
                           <th>Organisation</th>
                           <th>Phone Number</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Sub Role</th>
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
                           <td>{{ $user->position ? $user->position : 'N/A' }}</td>
                           <td>{{ $user->organisation ? $user->organisation : 'N/A' }}</td>
                           <td>{{ $user->phone_number ? $user->phone_number : 'N/A' }}</td>
                           <td>{{ $user->email ? $user->email : 'N/A' }}</td>
                           <td>{{ array_get(User::$ROLES, $user->role_id, 'unknown')}} </td>
                           @if($user->subrole_id>-1)
                           <td>{{ array_get(User::$SUBROLES, $user->subrole_id, 'unknown') }}</td>
                           @else
                           <td>N/A</td>
                           @endif
                           @if(Auth::user()->has_role('admin'))
                           <td>
                              <a href= "{{URL::route('users.show',['$id'=>$user->id])}}" class="btn btn-success btn-xs" title="View User">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
                              <a href= "{{URL::route('users.edit',['$id'=>$user->id])}}" class="btn btn-warning btn-xs" title="Edit User">
                              <span class="glyphicon glyphicon-pencil"></span></a>
                              <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('users.destroy', ['id' => $user->id]) }}" title="Delete User">
                              <span class="glyphicon glyphicon-minus-sign"></span>
                              </a>
                              @if(!$user->user_defined && $user->role_id == 6)
                              <a href= "{{URL::route('users.show',['$id'=>$user->id])}}" class="btn btn-info btn-xs" title="View User">
                              Make Supplier</a>
                              <a href= "{{URL::route('users.show',['$id'=>$user->id])}}" class="btn btn-danger btn-xs" title="View User">
                              Make Customer</a>
                              @endif
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
