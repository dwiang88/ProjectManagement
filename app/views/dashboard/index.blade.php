@extends('layout.main')
@section('content')
<style>

table {
font-size: 13px !important;
}
</style>
<div class="col-md-12">
		<h4 class="page_title">{{ $page_title }}</h4>
		<hr>
</div>


<div class="col-md-12">
@if(Session::has('msg'))
 <div class="alert alert-{{ Session::get('type') }}" role="alert" >
    <a href="#" class="close" data-dismiss="alert">&times;</a>
	<p>{{ Session::get('msg')}}</p>
</div>	
 @endif
</div>

<!-- Left Column -->
<div class="col-md-4">

	<div class="panel panel-default">
	  <div class="panel-heading">Statistics</div>
	  <div class="panel-body">
	
			<table class="table" style="font-size: 20px !important;">
			<tr>
				<td>Total Issues</td>
				<td>{{ $total_issue }}</td>
			</tr>
			<tr>
				<td>Unresolved Issues</td>
				<td>{{ $unresolved }}</td>
			</tr>
			
			<tr>
				<td>Closed Issues</td>
				<td>{{ $closed }}</td>
			</tr>
			
			<tr>
				<td>Issues Submitted By You</td>
				<td>{{ $submitted_by_you }}</td>
			</tr>
			
			<tr>
				<td>Solved Issues By You</td>
				<td>{{ $solved_by_you }}</td>
			</tr>
			<tr>
				<td>Issues yet to be Solved By You</td>
				<td>{{ $issues_yet_to_solve_by_you }}</td>
			</tr>
			</table>
	
	</div>
	</div>
</div>
<!-- Right Column -->

 
 <div class="col-md-8">
<div class="panel panel-default">
	  <div class="panel-heading">Assigned To Me</div>
	  <div class="panel-body">
<div class="list-content">
@if(count($records) > 0)	
<table class="table table-striped table-bordered" cellspacing="0" width="100%" align="center" id="gtable">
    <thead>
        <tr>
           <th>SL#</th> 
           <th>Track</th>
           <th>Title</th>
           <th>Status</th>
           <th>Assigned By</th>
           
                  
        </tr>
    </thead>
    <tbody> 
   <?php $i = 1; ?>
    @foreach ($records as $rows)
       
        <tr>
        	<td>{{$i}}</td>
        	<td>{{ $rows['tracking_num'] }}</td>                   
            <td width="50%;"><a href="{{ URL::to('/') }}/issue/{{ $rows['issue_id'] }}">{{ $rows['issue_title'] }}</a>
            	<p><span class="post-time">Post Date {{ date("d-m-Y",strtotime($rows['postDate'])) }}</span></p>
            	</td>
            <td>{{ $rows['status'] }}</td>            
            <td>{{ $rows['AssignedBy'] }}</td>                    
        </tr>
        <?php $i++ ;?>
     @endforeach
    </tbody>
</table>

@else
	<div>No Records Found</div>
	
 @endif

</div>
</div>
</div>

</div>
 
 
 
 




@stop