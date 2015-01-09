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

<div class="list-content">
@if(count($records) > 0)	
<table class="table table-striped table-bordered" cellspacing="0" width="100%" align="center" id="gtable">
    <thead>
        <tr>
           <th>SL#</th> 
           <th>Track</th>
           <th>Title</th>
           <th>Status</th>
           <th>Priority</th>
           <th>Assigned To</th>
           <th>Assigned By</th>
                  
        </tr>
    </thead>
    <tbody> 
   
    @foreach ($records as $rows)    
        <tr>
        	<td>{{ $rows['serial'] }}</td>
        	<td>{{ $rows['tracking_num'] }}</td>                   
            <td width="50%;"><a href="{{ URL::to('/') }}/issue/{{ $rows['issue_id'] }}">{{ $rows['issue_title'] }}</a>
            	<p><span class="post-time">Post Date {{ date("d-m-Y",strtotime($rows['postDate'])) }}</span></p>
            	</td>
            <td>{{ $rows['status'] }}</td>	
            <td>{{ $rows['priority'] }}</td>            
            <td>{{ $rows['AssignedTo'] }}</td>  
            <td>{{ $rows['AssignedBy'] }}</td>
                  
        </tr>
     @endforeach
    </tbody>
</table>

@else
	<div>No Records Found</div>
	
 @endif

</div>


</div>

@stop