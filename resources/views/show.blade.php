<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <div>
        		<form class="form form-horizontal" method="post">
        			<div class="row cl">
        					<input id="name" name="" type="text" placeholder="账户" class="input-text size-L">
        			</div>
        			<div class="row cl">
        					<input id="password" name="" type="password" placeholder="密码" class="input-text size-L">
        			</div>
        			<div class="row cl">
        					<input name="" id="login" type="button" class="btn btn-success radius size-L" value="&nbsp;添&nbsp;&nbsp;&nbsp;&nbsp;加&nbsp;">
        			</div>
        		</form>
                <button><a  href="<?php echo url("login/tuichu")?>">退出</a></button>
                <table border="1">
                    
                </table>
                <meta name="csrf-token" content="{{ csrf_token() }}">
        </div>
        <div id="div" style="position: absolute;left: 50%; top:30%;display: none">
            <span id="up_id" hidden></span>
            用户名：<input id="up_name" type="text">
            <br><br>
            密码：<input id="up_password" type="text">
            <br><br>
            <input type="button" value="修改" onclick="up()">
        </div>
        <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#login").click(function(){
                var name=$("#name").val()
                var password=$("#password").val()
                $.ajax({
                    url:'<?php echo url("login/addaction")?>',
                    data:{
                        name:name,
                        password:password
                    },
                    dataType:'json',
                    success:function(res){
                        if (res.status=='ok') {
                            alert('添加成功')
                        }else{
                            alert('添加失败')
                        }
                      show()  
                    }
                });
            });
        });
        function show(){
        $.ajax({
            url:"<?php echo url('login/showa'); ?>",
            dataType:'json',
            success:function(res){
                console.log(res)
                var data=res.data
                var tr=''
                for (var i = 0; i < data.length; i++) {
                        
                        tr=tr+"<tr><td>"+data[i].name+"</td><td>"+data[i].password+"</td><td onclick='dele("+data[i].id+")'>删除</td><td onclick='update(\""+data[i].id+"\",\""+data[i].name+"\",\""+data[i].password+"\")'>修改</td></tr>"
                    }
                    $("table").html(tr);
            }
        })
    }
    show()

        function dele(id){
            $.ajax({
                url:"<?php echo url('login/delete');?>",
                data:{
                    id:id
                },
                dataType:'json',
                success:function(res){
                    if (res.status=='ok') {
                        alert("删除成功")
                    }
                    show()
                }
            })
        }
        function update(id,name,password){
            $("#up_id").html(id)
            $("#up_name").val(name)
            $("#up_password").val(password)
            document.getElementById("div").style.display="block";
        }

        function up(){
            var up_id=$("#up_id").html()
            var up_name=$("#up_name").val()
            var up_password=$("#up_password").val()
            $.ajax({
                url:"<?php echo url('login/update');?>",
                data:{
                    id:up_id,
                    name:up_name,
                    password:up_password
                },
                dataType:'json',
                success:function(res){
                    if (res.status=='ok') {
                        show();
                    document.getElementById("div").style.display="none";
                    }else{
                        $("#up_name").val("");
                        $("#up_password").val("");
                        alert('修改失败');
                    }
                }
            })
        }


    </script>