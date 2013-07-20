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
   			
<div class="page-header">
   	<h2><?php echo ucfirst(get_action_name())?> Form</h2>
</div>

<div class="row-fluid">
<?php 
	$c = get_controller_name();
	$d = get_action_name();
	$action = '?c=' . $c;
	if ($d == 'edit') {
		$action .= '&d=update';	
	} else {
		$action .= '&d=save';	
	}
	
	HTML::form($action, $fields);
?>	
</div>

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
