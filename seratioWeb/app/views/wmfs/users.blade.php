@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH
@endif
@parent
@stop

@section('content')

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View  All Users
    </h1>

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">

          </div><!-- /.box-header -->
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
                  <th>Compliance</th>
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
                  <td>{{ array_get(User::$SUBROLES, $user->subrole_id, 'unknown')}}</td>
                  <td>{{ $user->compl ? $user->compl : 'N/A'}}</td>
                  @if(Auth::user()->has_role('admin'))
                  <td>
                    <!--<a href= "{{URL::route('users.show',['$id'=>$user->id])}}" class="btn btn-success btn-xs" title="View User">
                    <span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href= "{{URL::route('users.edit',['$id'=>$user->id])}}" class="btn btn-warning btn-xs" title="Edit User">
                    <span class="glyphicon glyphicon-pencil"></span></a>
                    <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('users.destroy', ['id' => $user->id]) }}" title="Delete User">
                    <span class="glyphicon glyphicon-minus-sign"></span>
                  </a>-->
                  @if(!$user->user_defined && ($user->role_id == 6 || $user->role_id == 10 || $user->role_id == 11 || $user->role_id == 12 ||
                  $user->role_id == 13 || $user->role_id == 14 || $user->role_id == 15 || $user->role_id == 16 || $user->role_id == 17 || $user->role_id == 18 ||
                  $user->role_id == 19 || $user->role_id == 20 || $user->role_id == 21 || $user->role_id == 22))
                  {{ Form::open(array('route' => array('make.supplier', $user->id), 'method' => 'POST', 'onclick'=>'return confirm(\'Are you sure?\')')) }}
                  <button type="submit" class="btn btn-info btn-xs">Make Supplier</button>
                  {{ Form::close() }}
                  {{ Form::open(array('route' => array('make.customer', $user->id), 'method' => 'POST', 'onclick'=>'return confirm(\'Are you sure?\')')) }}
                  <button type="submit" class="btn btn-danger btn-xs">Make Customer</button>
                </a>
                {{ Form::close() }}
                @endif
                @if($user->subrole_id == 0)
                <a href= "{{URL::route('tenders.index',['id'=>$user->id])}}" class="btn btn-success btn-xs" title="View Tenders">
                  <span class="glyphicon glyphicon-list-alt"></span></a>
                  <a href= "{{URL::route('compliance.get',['$id'=>$user->id])}}" class="btn btn-primary btn-xs" title="Add compliance">
                    <span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('users.destroy', ['id' => $user->id]) }}" title="Delete User">
                      <span class="glyphicon glyphicon-minus-sign"></span>
                      @endif
                      @if($user->role_id == 23 && !$user->user_defined)
                      {{ Form::open(array('route' => array('make.bidder', $user->id), 'method' => 'POST', 'onclick'=>'return confirm(\'Are you sure?\')')) }}
                      <button type="submit" class="btn btn-info btn-xs">Make Bidder</button>
                      {{ Form::close() }}
                      @endif

                      @endif
                    </td>

                  </tr>
                  @endforeach

                </tbody>
                <tfoot>

                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>

    </section><!-- /.content -->

  </div><!-- ./wrapper -->



  @stop
  @section('scripts')

  <!-- page script -->
  <script type="text/javascript">
  $(function() {
    $("#example1").dataTable();
  });
</script>
@stop
