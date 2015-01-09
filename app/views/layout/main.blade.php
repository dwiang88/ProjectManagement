<!DOCTYPE html>
<html>
    <head>
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ Config::get('app.myapp_name') }}</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>  
        {{ HTML::style('assets/css/style.css') }}     
        {{ HTML::style('assets/css/datepicker3.css') }}
        {{ HTML::style('assets/dataTable/dataTables.bootstrap.css') }}
        {{ HTML::script('assets/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        {{ HTML::script('assets/js/bootstrap-filestyle.min.js') }}
        {{ HTML::script('assets/js/bootstrap-datepicker.js') }}       
        {{ HTML::script('assets/dataTable/jquery.dataTables.min.js') }}  
        {{ HTML::script('assets/dataTable/dataTables.bootstrap.js') }}  
       
<script type="text/javascript">

$(function() {

    $('#gtable').dataTable();
});

</script>
        
    </head>
    

    <body>
    	<div class="container-fluid">
	    	   	<div class="row-fluid">       	  
				        @include('layout.navigation')
				        @if(Session::has('global'))
				        <div>{{ Session::get('global')}}</div>
				        @endif
				        <div class="col-md-12">				        
				        @yield('content')
				        </div>				   
		        </div>  
		              
  		 </div>
  		 
  	 <div id="footer"></div>
  		 
    </body>


</html>