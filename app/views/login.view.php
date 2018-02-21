<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>

  <link href="/public/css/normalize.css" rel="stylesheet">
  <link href="/public/css/style.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style="background-color: #f4efef">
  <main id='login' style="background: none">
  <!-- Start Login -->

  <section class="login">
  	<h1>Login</h1>

    <!-- Start Form Login -->
  	<form method="POST" action="/login" id="formlogin">

      <div>
      <input type="text" name="username" placeholder="Le nom">
      </div>

      <div>    		
      <input type="password" name="password" placeholder="Mot de pass">
      </div>
      
      <div>
      <input type="submit" name="login" value="Se connecter">
      </div>
      <div id="result">
      
      </div>  
  	</form>
    <!-- End Form Login -->

  </section>
  <!-- End Login -->
 </main>

 <script src="public/js/jquery-3.2.1.min.js"></script>
 <script src="public/js/script.js"></script>
</body>
</html>