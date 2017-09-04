<html>

<head>
<title>Benvenuti in IoT Inc.</title>
<meta charset ="UTF-8">
<meta name="viewport" content="width-device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome.css"/>
<form action = "log.php" method = "post">


</head>

<body>

	<div class="container">
	<img src="images/user-icon.png"/>
		<form>
			<div class="form-input">
				<input type="text" class="tbox" name="username" value="Username" 
                                 onfocus="this.value='';" required />
			</div>
			<div class="form-input">
				<input type="password" class="tbox" name="pass" value="Password" 
                                onfocus="this.value='';" required />
			</div>
		<input type="submit" name="submit" value="LOGIN" class="btn-login">
		
		</form><br /><br />
		
	</div>
	


</body>


</html>