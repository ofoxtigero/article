<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
    var myTable;
    var opType='add';
    var currentRow;
    var currentNav;
    function  deleteRow(mid)
    {

    	if(!confirm("确定删除此项菜单吗？"))
		 {
		    return;
		 }
        var queryUrl = 'menu/menu.handle.php?opType=delete'+'&&rnd=+Math.random()';
         opType='delete';

          $.ajax({
            url:queryUrl,
            type:'GET', //GET
            async:true,    //或false,是否异步
            data:{'menuId':mid},
            timeout:5000,    //超时时间
            beforeSend:function(xhr){
                // console.log(xhr)
                // console.log('发送前')
            },
            success:function(data,textStatus,jqXHR){
              myTable.ajax.reload();
            },
            error:function(xhr,textStatus){
               
            },
            complete:function(){
                // console.log('结束')
            }
        });

    }
    function  editRow(mid)
    {
        opType='edit';
        currentRow = mid;
 
        $('#menuName').val(mid.name);
        $('#menuUrl').val(mid.url);
        $('#menuParentId').val(mid.parentId);

        $('#myModal').modal();
    }
    function  showRow(mid)
    {
         opType='show';
        // var ss =  eval(mid);
        $('#menuName').val(mid.name);
         $('#menuUrl').val(mid.url);
        $('#menuParentId').val(mid.parentId);

        $('#myModal').modal();
    }
    var getString =function (obj){
        var str = '{';
        for (var key in obj)
        {
            str=str+key+':'+'\''+obj[key]+'\''+',';
        }
        str =str.substring(0,str.length-1);
        str = str+'}';
        return str;
    }
    $(function(){

         loadLeftMenu();
         var queryUrl = 'menu/menu.handle.php?opType=show'+'&&rnd=+Math.random()';
         myTable = $('#tbMenu').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":queryUrl,
            "columns": [
            {"data": "id",render:function(data, type, full, meta){
                    return '<input type="checkbox" name="'+full.id+'"/>';
         }},
            { "data": "id" },
            { "data": "name",render:function(data, type, full, meta){
                return "<span style='color:red'>"+data+"</span>";

            }},
            { "data": "url" },
            { "data": "parentId" },
            {"data": "id",render:function(data, type, full, meta){
                    var id = full.id;
                var arr=getString(full);
                //'",name:"'+full.name+'",url:"'+full.url+'",parentId:"'+full.parentId+'}';
                    return '<button class="btn btn-success" onclick="showRow('+arr+')"><i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</button><button class="btn btn-info" onclick="editRow('+arr+')"><i class="glyphicon glyphicon-edit icon-white"></i>编辑</button><button class="btn btn-danger" onclick="deleteRow('+id+')"><i class="glyphicon glyphicon-trash icon-white"></i>删除</button>';
         }}],
         columnDefs:[{"targets":4,visible:true}]
        });

         $('#btnSaveMenu').click(function(){
            handleMenuItem();
         });
    });

    function handleMenuItem()
    {
        if(opType=='add')
        {
            addMenuItem();
        }
        if(opType=='edit')
        {
            editMenuItem();
        }
        loadLeftMenu();
    }
    function editMenuItem()
    {

     var  currentRow1={};
     currentRow1.name=$('#menuName').val();
     currentRow1.url=$('#menuUrl').val();
     currentRow1.parentId=$('#menuParentId').val();
         $.ajax({
            url:'menu/menu.handle.php?opType=edit',
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{'menuId':currentRow.id,'menuName':currentRow1.name,'menuUrl':currentRow1.url,'menuParentId':currentRow1.parentId},
            timeout:5000,    //超时时间
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            beforeSend:function(xhr){
 
            },
            success:function(data,textStatus,jqXHR){
                
              alert('成功'+data+'个菜单项');
              myTable.ajax.reload();
            },
            error:function(xhr,textStatus){
                console.log('错误');
            },
            complete:function(){
                // console.log('结束')
            }
        });

    }

    function addMenuItem()
    {

        var menuName,menuUrl,menuParentId;
         menuName = $('#menuName').val();
         menuUrl = $('#menuUrl').val();
         menuParentId = $('#menuParentId').val();
          $.ajax({
            url:'menu/menu.handle.php?opType=add',
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{'menuName':menuName,'menuUrl':menuUrl,'menuParentId':menuParentId},
            timeout:5000,    //超时时间
            dataType:'json',
            beforeSend:function(xhr){
 
            },
            success:function(data,textStatus,jqXHR){
              //alert('成功插入'+data+'个菜单项');
              myTable.ajax.reload();
            },
            error:function(xhr,textStatus){
                console.log('错误');'/'
            },
            complete:function(){
                // console.log('结束')
            }
        });
    }

    function loadLeftMenu()
    {

        
        $.ajax({
            url:'menu/getLeftMenu.php',
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{},
            timeout:5000,    //超时时间
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            beforeSend:function(xhr){
              
            },
            success:function(data,textStatus,jqXHR){
                $('#ulLeftMenu').html('');
                $('#ulLeftMenu').append('<li class="list-group-item">Main</li>');
                $.each(data,function(i,item){
                        //alert(item[1]+':'+);

                    if(item[3]>0){
                        var param="'"+item[1]+"','"+item[2]+"'";
                      var temp='<li><a class="list-group-item" href="'+item[2]+'" onclick=addNav('+param+')><i class="glyphicon glyphicon-home"></i><span>'+item[1]+'</span></a>';
                      $('#ulLeftMenu').append(temp);
                    }
                });
            },
            error:function(xhr,textStatus){
                console.log('错误');
            },
            complete:function(){
                // console.log('结束')
            }
        });
    }

    function loadNav()
    {
        var temp='<li><a href="index.php">主页</a></li>';
    }
    function addNav(name,url)
    {

        var temp='<li><a href="'+url+'">'+name+'</a></li>'
        $('#ulNav').append(temp);
    }



     
 </script>
	 
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
	    <div class="navbar-header">
	        <a class="navbar-brand" href="#">经济数据</a>
		</div>
    	<div>
	        <ul class="nav navbar-nav">
	            <li class="active"><a href="#">iOS</a></li>
	            <li><a href="#">SVN</a></li>
	            <li class="dropdown"><a href="#">java</a>
	            </li>
        	</ul>
    	</div>
    </div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-xs-2">
			 <ul class="list-group" id="ulLeftMenu">
			 
			 </ul>
		</div>
		<div class="col-xs-8">
			<!--nav begin-->
			<div class="container">
				<div class="row">
					<ul class="breadcrumb">
					    <li><a href="#">Home</a></li>
					    <li><a href="#">2013</a></li>
					    <li class="active">十一月</li>
					</ul>
				</div>
				<div class="row">
					<div class="panel panel-default">
					    <div class="panel-body">
					      <button class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-edit icon-white"></i>添加菜单</button>
					    </div>
					</div>
				</div><!--end of class='row'-->
				<div class="row">
					<div id="main">
						 <table id="tbMenu" class="display" cellspacing="0" width="100%">
			                <thead>
			                    <tr>
			                        <th><input type="checkbox" name="allCheck" id="allCheck"></th>
			                        <th>id</th>
			                        <th>name</th>
			                        <th>url</th>
			                        <th>parentId</th>
			                        <th>操作</th>
			                    </tr>
			                </thead>
			                <tfoot>
			                    <tr>
			                    <th><input type="checkbox" name="allCheck" id="allCheck"></th>
			                        <th>id</th>
			                        <th>name</th>
			                        <th>url</th>
			                        <th>parentId</th>
			                        <th>操作</th>
			                    </tr>
			                </tfoot>
			             </table>
					</div><!--id=main-->
				</div>
			</div>
		</div>
	</div>
</div>
<!--modal start-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                   <table>
                     <tr>
                         <td>
                         <label class="control-label" for="inputSuccess4">菜单名称</label>
                         </td>
                         <td> 
                         <div class="form-group has-success has-feedback">
                       
                        <input type="text" name="menuName" class="form-control" id="menuName" style="width:400px"/>
                     
                    </div></td>
                     </tr>
                     <tr>
                          <td> <label class="control-label" for="inputSuccess4">菜单地址</label></td>
                         <td>    <div class="form-group has-success has-feedback">
                       
                        <input type="text" class="form-control" name="menuUrl" id="menuUrl">
                       
                    </div></td>
                     </tr>
                       <tr>
                          <td> <label class="control-label" for="inputSuccess4">父菜单</label></td>
                         <td>    <div class="form-group has-success has-feedback">
                       
                        <input type="text" style="width:400px" class="form-control" name="menuParentId" id="menuParentId">
                       
                    </div></td>
                     </tr>
                              
                 </table>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal" id="btnSaveMenu">Save changes</a>
                </div>
            </div>
        </div>
    </div><!--modal end-->
</body>

</html>