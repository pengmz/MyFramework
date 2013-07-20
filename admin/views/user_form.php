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

   <form id="form1" name="form1" method="post" action="${action}" onsubmit="return validateData()">
   		<input type="hidden" id="id" name="id" value="${param['id']}" />
   		
   		<label for="username">Username<span style="color:red">*</span></label>
   		<input id="username" name="username" value="${param['username']}" type="text" style="width:50%"/>
   		&nbsp;<span id="username_is_required" class="text-error hide">please enter username.</span><br/>
   		<div class="h10"></div>
   		
   		<label for="password">Password</label>
   		<input id="password" name="password" value="${param['password']}" type="password" style="width:50%"/><br/>
   		<div class="h10"></div>
   		
   		<label for="email">Email</label>
   		<input id="email" name="email" value="${param['email']}" type="text" style="width:50%"/><br/>
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
