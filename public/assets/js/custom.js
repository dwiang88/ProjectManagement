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
                url: "<?php echo base_url(); ?>issue/issue_list",

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
	

       
      	

