@if(Auth::check())
   <div class="navbar navbar-default" role="navigation">
      <div class="container-fluid">            
         
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header" style="margin-left: 1%;">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
             <a class="navbar-brand" href="{{ URL::route('home')}}">Morich</a>
         </div>
         <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
            <li class="menu-item menu-head"><a href="{{ URL::route('home')}}">Dashboard</a></li>          
                          
               
               <!-- Issues  -->
               <li class="menu-item dropdown">
               
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Project Issues <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                       <li class="menu-item "><a href="{{ URL::route('Add-new-issue')}}">Create New Issue</a></li>
                 	   <li class="menu-item "><a href="{{ URL::route('All-issues')}}">Issue List</a></li> 
                 	   <li class="menu-item "><a href="{{ URL::route('Individual-issues')}}">Issue By Me</a></li>                
                  </ul>
               </li>
               <!-- End of Issues  -->
            
           
                <li class="menu-item menu-head"><a href="{{ URL::route('account-sign-out')}}">Sign Out</a></li>
            </ul>

			<div class="pull-right">Hi , {{ Auth::user()->username}}</div>
         </div>
         
         
      </div>
   </div>
 @endif
