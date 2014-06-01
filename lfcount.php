<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>РИО диспетчер</title>
	<link type="text/css" rel="stylesheet" href="templates/bootstrap/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="templates/bootstrap/css/bootstrap-responsive.min.css">
	<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
	<style>
      body{padding-top: 60px;}
	  .inp4{display:block;width:80%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
	  .inp1{display:block;width:20%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
	#box, #mlist {
	display:none;
	position:absolute;
	width:300px;
	z-index:99;
	left: auto;
	top: auto;
	background-color: #EEF2F6;
	border-radius: 10px;
	padding-bottom: 5px;
}
.itm{
	height:25px;
	cursor:pointer;
	padding-left: 3px;	
	padding-top: 2px;
	font-size:12px;
	margin-top: 2px;
}
.itm:hover{
	background-color: #6D8EB2;
	color:#fff;
}
 
    </style>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Рио</a>
        </div>
      </div>
    </div>
<!-- Сетка -->
<div class="container-fluid fill">   
          <?
		  $page = file_get_contents('http://212.224.113.37/count_list.php?id='.$_GET['a']);
		  print($page);
		  ?>
<!-- Сетка -->
</div>
<script type="text/javascript" src="templates/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>