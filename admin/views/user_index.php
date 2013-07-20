  
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
      <td>${user->id}</td>
      <td>${user->username}</td>
      <td>${user->email}</td>
      <td>
      <a class="btn btn-primary" href="?c=user&d=edit&id=${user->id}">Edit</a>
      <a class="btn btn-primary" href="javascript:delete_user(${user->id});">Delete</a>
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

