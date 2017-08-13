<?php
if(!session_id()) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Zarf | Online Events</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-image:url('base.jpg'); background-size:cover; width: 100%; height: 100%;background-position: center;">

<?php
	

	# Start the session 
	
	if(isset($_SESSION["user_id"])){
		?>
		<script> location.href = '../feed.php';
              </script>
			  <?php 
	}
	# Autoload the required files
	require_once __DIR__ . '/vendor/autoload.php';

	# Set the default parameters
	$fb = new Facebook\Facebook([
	  'app_id' => '1646987182277289',
	  'app_secret' => 'ba4fdc482255aa509faf2f0e5eb9ee0b',
	  'default_graph_version' => 'v2.5',
	]);
	$redirect = 'http://zarf.co.in/online/fblogin/index.php';


	# Create the login helper object
	$helper = $fb->getRedirectLoginHelper();
	$_SESSION['FBRLH_state']=$_GET['state'];

	# Get the access token and catch the exceptions if any
	try {
	  $accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	# If the 
	if (isset($accessToken)) {
	  	// Logged in!
	 	// Now you can redirect to another page and use the
  		// access token from $_SESSION['facebook_access_token'] 
  		// But we shall we the same page

		// Sets the default fallback access token so 
		// we don't have to pass it to each request
		$fb->setDefaultAccessToken($accessToken);

		try {
		  $response = $fb->get('/me?fields=email,name');
		  $userNode = $response->getGraphUser();
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}


		// Print the user Details
		
		

		$image = 'https://graph.facebook.com/'.$userNode->getId().'/picture?width=200';
		
		
		
 $_SESSION["name"] =$userNode->getName();
                $_SESSION["user_id"] = $userNode->getId();
                $_SESSION["email"] = $userNode->getProperty('email');
                $_SESSION["dp"] = $image;
				?>
				<script> location.href = '../feed.php';
              </script>
			  <?php

		
		
		
	}else{
		$permissions  = ['email'];
		$loginUrl = $helper->getLoginUrl($redirect,$permissions);
		?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<div class="container-fluid">
		<!--<div class="alert alert-danger alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Alert!</strong> Kindly do not open this website on <strong>Facebook's App Default Browser</strong>. Follow the website in <strong>Google Chrome!</strong>
  </div>-->
		<div class="row">
		<div class ="col-md-2"></div> 
		<div class ="col-md-8"> 
		<a href="<?php echo $loginUrl;?>" ><button class="btn btn-danger btn-block">Log in with Facebook</button></a>
		
		</div>
		<div class ="col-md-2"></div> 
		</div>
		</div>
		<?php
		
	}
?>
</body>
</html>