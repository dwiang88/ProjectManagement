@extends('layout.main')
@section('content')
<div class="col-md-12">
		<h4 class="page_title">{{ $page_title }}</h4>
		<hr>
</div>
<div class="col-md-12">
@if(Session::has('msg'))
 <div class="alert alert-success" role="alert" >
    <a href="#" class="close" data-dismiss="alert">&times;</a>
	<p>{{ Session::get('msg')}}</p>
</div>	
 @endif
</div>


<div class="col-md-8">
<div class="panel panel-default">
<div class="panel-heading">Add New Issue</div>
<div style="padding: 40px;">


@if($errors->has())    
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger" role="alert" >
      	<a href="#" class="close" data-dismiss="alert">&times;</a>
      	{{ $error }}
      </div>
  @endforeach
 @endif


<form class="form-horizontal" role="form" action="{{URL::route('update-issue-post') }}" method="post" enctype="multipart/form-data" autocomplete="off">
   
  <div class="form-group">
    <label for="questionTitle">Title</label>    
    <input type="text" name="title" class="form-control" id="question_title" placeholder="Title"  value="{{ (Input::old('title')) ? Input::old('title') : $records[0]->issue_title }}" >
  </div>
  
<div class="row">
  <div class="form-group col-xs-4">
    <label for="">Project</label>    
    {{ Form::select('project', $project , (Input::old('project')) ? Input::old('project') : $records[0]->project_id , array('id' => 'project', 'class' => 'form-control',  )) }}
  </div>
  
  <div class="form-group col-xs-8" style="margin-left: 2%;">
    <label for="">Parent Issue</label>    
    {{ Form::select('parent_issue', $parent_issue ,(Input::old('parent_issue')) ? Input::old('parent_issue') : $records[0]->parent_issue , array('id' => 'parent_issue', 'class' => 'form-control',  )) }}
  </div>
</div>
  
<div class="row">
  
  <div class="form-group col-xs-6">
    <label for="">Assign To</label>    
    {{ Form::select('assigned_to', $users , (Input::old('assigned_to')) ? Input::old('assigned_to') : $records[0]->assigned_to , array('id' => 'assigned_to', 'class' => 'form-control',  )) }}
  </div>
  
  <div class="form-group col-xs-6" style="margin-left: 2%;">
    <label for="">Priority</label>    
    {{ Form::select('priority', $priority ,(Input::old('priority')) ? Input::old('priority') : $records[0]->priority_id , array('id' => 'priority', 'class' => 'form-control',  )) }}
  </div>    
</div>
  
  <div class="form-group">
    <label for="exampleInputPassword1">Desctiption</label>
    <textarea name="description" class="form-control" rows="8">{{ (Input::old('description')) ? ' value="' .e(Input::old('description')) . ' "' :  $records[0]->issue_description   }}</textarea>
  </div>
  
  <input type="hidden" name="issue_id" value="{{$records[0]->issue_id}}">
	
  <button type="submit" class="btn btn-default pull-right">Submit</button>
   {{Form::token()}}
</form>
<!-- Button trigger modal -->

</div>
</div>
</div>

<script type="text/javascript">

$(function() {
	
	// Function
	$('#project').change(function() {

        var project_id = $(this).val();
        if (project_id == "") 
        {
            $("#parent_issue").html("<option value=''>Select</option>");
        } 
        else 
        {
            //Do stuff
            $.ajax({

                type: "POST",
                url: "<?php echo URL::to('/') ?>/issue/list",
                data: {
                    project_id: project_id
                },
                success: function(server_response) 
                {
                    $("#parent_issue").html(server_response);
                    
                }

            }); //$.ajax ends here

        } //if else		
        return false
    }); 							
	// Function Ends	
	
	
	
}); 				    

</script>
@stop

