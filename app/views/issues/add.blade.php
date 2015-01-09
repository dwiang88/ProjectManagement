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


<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
   
  <div class="form-group">
    <label for="questionTitle">Title</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="Issue Title" {{ (Input::old('title')) ? ' value="' .e(Input::old('title')) . ' "' : ''  }} >
  </div>
  
<div class="row">
  <div class="form-group col-xs-4">
    <label for="">Project</label>    
    {{ Form::select('project', $project , Input::old('project'), array('id' => 'project', 'class' => 'form-control',  )) }}
  </div>
  
  <div class="form-group col-xs-8" style="margin-left: 2%;">
  <?php  $parent_issue = array(''  => 'Select',); ?> 
    <label for="">Parent Issue</label>    
    {{ Form::select('parent_issue', $parent_issue , Input::old('parent_issue'), array('id' => 'parent_issue', 'class' => 'form-control',  )) }}
  </div>
</div>
  
<div class="row">
  
  <div class="form-group col-xs-6">
    <label for="">Assign To</label>    
    {{ Form::select('assigned_to', $users , Input::old('assigned_to'), array('id' => 'assigned_to', 'class' => 'form-control',  )) }}
  </div>
  
  <div class="form-group col-xs-6" style="margin-left: 2%;">
    <label for="">Priority</label>    
    {{ Form::select('priority', $priority , Input::old('priority'), array('id' => 'priority', 'class' => 'form-control',  )) }}
  </div>    
</div>
  
  <div class="form-group">
    <label for="exampleInputPassword1">Desctiption</label>
    <textarea name="description" class="form-control" rows="8">{{ (Input::old('description')) ? ' value="' .e(Input::old('description')) . ' "' : ''  }}</textarea>
  </div>
  
	
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
                url: "<?php echo URL::to('/') ?>/issue/dropdown",
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

