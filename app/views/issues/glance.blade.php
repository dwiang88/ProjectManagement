@extends('layout.main')
@section('content')

<div class="col-md-12">
		<h4 class="page_title">{{ $page_title }}</h4>
		<hr>
</div>

<div class="col-md-12">

<div class="list-content">
@if(count($records) > 0)		
	 @foreach ($records as $rows)    
       <div><a href="{{ URL::to('/') }}/issue/{{ $rows['issue_id'] }}">{{ $rows['issue_title'] }}</a> 
       <?php if($rows['status_id'] == 7) {?>
       <span class="post-time">Closed</span>
       <?php }?>
       </div>       
     @endforeach
@else
	<div>No Records Found</div>	
 @endif
</div>
</div>
@stop