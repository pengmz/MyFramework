<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
		include_theme_css('/css/bootstrap.min.css');
		include_theme_css('/css/bootstrap-responsive.min.css');
		include_theme_css('/style.css');
	?>
    <!--[if lt IE 9]>
      <?php include_theme_script('/js/html5shiv.js'); ?>
    <![endif]-->	
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Admin</a>
		  <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>          
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> Username
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="?d=logout">Sign Out</a></li>
            </ul>
          </div>          
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
        	<div class="h10"></div>
			<?php $this->import('nav');?>		    
        </div>
        <div class="span9" style="min-height:456px">
			<div class="h10"></div>
			<?php $this->import('message');?>	
   			<?php 
	$c = $param['c'];
	$d = $param['d'];
	$action = '?c=' . $c;
	if ($d == 'edit') {
		$action .= '&d=update';	
	} else {
		$action .= '&d=save';	
	}
			
?>	
<div class="page-header">
   	<h2>User Form</h2>
</div>

<div class="row-fluid">	  	

   <form id="form1" name="form1" method="post" action="<?php echo $action; ?>" onsubmit="return validateData()">
   		<input type="hidden" id="id" name="id" value="<?php echo $param['id']; ?>" />
   		
   		<label for="username">Username<span style="color:red">*</span></label>
   		<input id="username" name="username" value="<?php echo $param['username']; ?>" type="text" style="width:50%"/>
   		&nbsp;<span id="username_is_required" class="text-error hide">please enter username.</span><br/>
   		<div class="h10"></div>
   		
   		<label for="password">Password</label>
   		<input id="password" name="password" value="<?php echo $param['password']; ?>" type="password" style="width:50%"/><br/>
   		<div class="h10"></div>
   		
   		<label for="email">Email</label>
   		<input id="email" name="email" value="<?php echo $param['email']; ?>" type="text" style="width:50%"/><br/>
   		<div class="h10"></div>
   		<div class="h10"></div>
   		
		<button class="btn btn-danger btn-large" id="saveForm" type="submit" style="width:200px">
			保存
		</button>	    		
    </form>
    <div class="h10"></div>

</div>

<script type="text/javascript">
	$("#username").focus();
	
	function validateData(){
	    $(".text-error").hide();
	    if (!jQuery.trim($("#username").val())){
	        $("#username_is_required").show();
	        $("#username").focus();
	        return false;
	    }
	    return true;
	}
</script>	

	   		<div class="h10"></div>      
        </div>
    </div>
    <hr/>

    <footer>
    	<p class="pull-right">&copy; Company 2013 &nbsp;&nbsp;&nbsp;</p>
    </footer>
        
	<?php 
		include_theme_script('/js/jquery.min.js');
		include_theme_script('/js/bootstrap.min.js');
	?>

  </body>
</html>
