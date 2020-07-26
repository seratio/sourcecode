@extends('layout.dashboard_default')
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
         View All Suppliers
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
                  <table id="example1" class="table table-bordered">
                     <thead>
                        <tr>
                           <th>Supplier Name</th>
                           <th>Supplier Number</th>
                           <th>Address</th>
                           <th>E-Mail</th>
                           <th>Sector</th>
                           <th>Industry</th>
                           <th>Modern Slavery</th>
                           <th>Sentiment</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($suppliers as $supplier)
                        @if($supplier->modern_slavery>=2)
                        <tr class="gradeA success">
                           @elseif ($supplier->modern_slavery>=1 && $supplier->modern_slavery<2)
                        <tr class="gradeA warning">
                           @elseif ($supplier->modern_slavery<1 && !empty($supplier->modern_slavery))
                        <tr class="gradeA danger">
                           @else
                        <tr class="gradeA">
                           @endif
                           <td>{{ $supplier->supplier_name ? $supplier->supplier_name :'N/A' }} </td>
                           <td>{{ $supplier->supplier_number ? $supplier->supplier_number :'N/A' }} </td>
                           <td>{{ ($supplier->number_street && $supplier->city && $supplier->county && $supplier->post_code && $supplier->country) ?
                              $supplier->number_street.'<br>'.$supplier->city.'<br>'.$supplier->county.'<br>'.$supplier->post_code.'<br>'.array_get(Country::countries(), $supplier->country, 'Unknown') :'N/A' }}
                           </td>
                           <td>{{ $supplier->email ? $supplier->email :'N/A' }} </td>
                           <td>{{ $supplier->sector ? $supplier->sector :'N/A' }} </td>
                           <td>{{ array_get(MSlavery::industries(), $supplier->main_industry, 'Unknown')}} </td>
                           <td class="color-green">{{ $supplier->modern_slavery ? $supplier->modern_slavery : 'N/A'}}</td>
                           <td>{{ $supplier->sentiment ? $supplier->sentiment : 'N/A' }}</td>
                           <td>
                              <a href= "{{URL::route('mssupplier.show',['$id'=>$supplier->id])}}" class="btn btn-success btn-xs" title="View User">
                              <span class="glyphicon glyphicon-eye-open"></span></a>
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
