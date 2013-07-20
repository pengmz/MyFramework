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
   <h1>User List <small></small></h1>
</div>
<div class="h10"></div>
  
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th width="32">ID</th>
      <th>Username</th>
      <th>Email</th>
      <th width="200">Operations</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user){ ?>	
    <tr>
      <td><?php echo $user->id; ?></td>
      <td><?php echo $user->username; ?></td>
      <td><?php echo $user->email; ?></td>
      <td>
      <a class="btn btn-primary" href="?c=user&d=edit&id=<?php echo $user->id; ?>">Edit</a>
      <a class="btn btn-primary" href="javascript:delete_user(<?php echo $user->id; ?>);">Delete</a>
      </td>
    </tr>
    <?php } ?>	
  </tbody>
</table>
<div class="h10"></div> 
	      
<script type="text/javascript">
	function delete_user(user_id) {
        if(confirm("确定要删除这个用户?")){
	        window.location.href = "?c=user&d=delete&id="+user_id;;
	    }			
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
