<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <style type="text/css">
        	body{ text-align:center}
        	#div{	
        		margin:0 auto;
        	 	width:400px;
        	 	height:100px;
       		}
        </style>
        <div id="div">
        		<form class="form form-horizontal" method="post">
        			<div class="row cl">
        					<input id="name" name="" type="text" placeholder="账户" class="input-text size-L">
        			</div>
        			<div class="row cl">
        					<input id="password" name="" type="password" placeholder="密码" class="input-text size-L">
        			</div>
        			<div class="row cl">
        					<input name="" id="login" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
        					<input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        			</div>
        		</form>
        </div>
        <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>

    	<script type="text/javascript">
	        $("#login").click(function(){
			  	var name=$("#name").val()
			  	var password=$("#password").val()
			    $.ajax({
			    	url:'<?php echo url("login/index")?>',
			    	data:{
			    		name:name,
			    		password:password
			    	},
			    	dataType:'json',
			    	success:function(res){
			    		if (res.status=='error') {
			    			alert(res.data)
			    			var name=$("#name").val("")
			    			var password=$("#password").val("")
			    		}
			    		if (res.status=='ok') {
			    			window.location.href = "<?php echo url('login/show')?>";
			    		}
			 			
			    	}
			    })
			  });
    </script>