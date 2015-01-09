@extends('layout.main')
@section('content')

<div class="col-md-12">
		<h4 class="page_title">{{ $page_title }}</h4>
		<hr>
</div>
<div class="col-md-9 colborder">

@if(count($records) > 0)
	
<div>Title</div>	
<div class="panel-heading">
	<h4>{{ $records[0]->issue_title}}</h4>	
	<hr>
</div>

<div>Description</div>
<div class="list-content">
	{{ makeClickableLinks($records[0]->issue_description) }}

</div>

@else
	<div style="padding:20px;">No Records Found</div>
	
 @endif


</div>

<!--  Right Column -->

<div class="col-md-3">

<table class="table table-condensed table-hover">
   <tr>
      <td>Post Date</td>
      <td>: {{  date("d-m-Y",strtotime($records[0]->postDate)) }}</td>
   </tr>
   <tr>
      <td>Priority</td>
      <td>: {{ $records[0]->priority }}</td>
   </tr>
   <tr>
      <td>Status</td>
      <td>: {{ $records[0]->status }}</td>
   </tr>
   <tr>
      <td>Assigned By</td>
      <td>: {{ $records[0]->AssignedBy }}</td>
   </tr>
   <tr>
      <td>Assigned To</td>
      <td>: {{ $records[0]->AssignedTo }}</td>
   </tr>
</table>

<?php 
$show = "";

if(($records[0]->assigned_by == Auth::user()->id) && ($records[0]->assigned_to != Auth::user()->id))
{
	if($records[0]->status_id == 7)
	{
		$get_status = 8;
	}
	else 
	{
		$get_status = 7;
	}
	 $show = "yes";
}
else
{
	$get_status = $records[0]->status_id + 1 ;
	$get_status = ($get_status == 9) ? 2: $get_status;
}

if(($records[0]->assigned_by == Auth::user()->id) && ($records[0]->assigned_to == Auth::user()->id))
{
	$show = "yes";
}	
if(($records[0]->assigned_to == Auth::user()->id) && ($records[0]->assigned_by != Auth::user()->id) && ($get_status != 7) )
{
	$show = "yes";
}

if($show == "yes")
{	
?>
<div>
<form class="form-horizontal" role="form" action="{{ URL::route('change-issue-status')}}" method="post" enctype="multipart/form-data" autocomplete="off">

<input type="hidden" name="issue_id" value="<?php echo $records[0]->issue_id; ?>" />
<input type="hidden" name="status_id" value="<?php echo $get_status; ?>" />
<input type="submit" class="btn btn-primary btn-md btn-block" value="Mark as <?php echo $status[$get_status]; ?>"/>
 {{Form::token()}}
</form>
</div>
<?php }?>
<?php if( $records[0]->assigned_by == Auth::user()->id ) {?>
<br>
<br>
<a href="{{ URL::to('/') }}/issue/edit/{{ $records[0]->issue_id }}">Edit</a>
<br>
<br>
<a href="{{ URL::to('/') }}/issue/remove/{{ $records[0]->issue_id }}">Delete</a>
<?php } ?>
</div>
<!-- End of Right Column -->

@stop
<?php 

function makeClickableLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}
?>