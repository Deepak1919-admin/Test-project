<?php
    session_start();
    ob_start();
    include('commonclass.php');
    include('hybridauth/config.php');
    include('hybridauth/hybridauth/Hybrid/Auth.php');
    if (isset($_GET['provider'])) {
        $provider = $_GET['provider'];
        try {
            $hybridauth = new Hybrid_Auth($config);
            $authProvider = $hybridauth->authenticate($provider);
            $insert_array = array();
            $user_profile = $authProvider->getUserProfile();
            if ($user_profile && isset($user_profile->identifier)) {
                $insert_array['first_name'] = $user_profile->firstName;
                $insert_array['profile_pic'] = $user_profile->photoURL;
                $insert_array['email'] = $user_profile->email;
                $insert_array['status'] = 1;
                $password   =   $objUsers->randomPassword();
                $insert_array['password'] = $password;
		//$insert_array['hybridauth_provider_name']=$user_profile->profileURL;
                $user_exist = $objUsers->checkUser($user_profile->email);

                if ($user_exist == 0) {
                    $objUsers->setArrData($insert_array);
                    $ress=$objUsers->insert(); 
$abc= mysql_insert_id();

$details=$objUsers->GetRowContent($abc);

 $_SESSION['dream']['user_id']       = $details["id"];
$_SESSION['dream']['username']      = $details["username"];
$_SESSION['dream']['name']      = $details["first_name"];
$_SESSION['dream']['email']      = $details["email"];
$_SESSION['dream']['type']	= 'user';
                    if ($insert == "done") {
						$headers = "From: info@dreamuniform.com\r\n";
						$headers .= "Content-type: text/html\r\n";
						$to = $user_profile->email;
						$subject = "Login details from DreamUniform";
						$message = "User Name : " . $user_profile->email ;
						$message.= "/n password : " . $password ;
						
						mail($to, $subject, $message, $headers);
					}
                } else {
                    $_SESSION['dream']['user_id']       = $user_exist["id"];
                    $_SESSION['dream']['username']      = $user_exist["username"];
$_SESSION['dream']['name']      = $user_exist["first_name"];
$_SESSION['dream']['email']      = $user_exist["email"];
					$_SESSION['dream']['type']	= 'user';
                }
                header('location:index.php'); 
            }
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 0 : echo "Unspecified error.";
                    break;
                case 1 : echo "Hybridauth configuration error.";
                    break;
                case 2 : echo "Provider not properly configured.";
                    break;
                case 3 : echo "Unknown or disabled provider.";
                    break;
                case 4 : echo "Missing provider application credentials.";
                    break;
                case 5 : echo "Authentication failed. "
                    . "The user has canceled the authentication or the provider refused the connection.";
                    break;
                case 6 : echo "User profile request failed. Most likely the user is not connected "
                    . "to the provider and he should to authenticate again.";
                    $twitter->logout();
                    break;
                case 7 : echo "User not connected to the provider.";
                    $twitter->logout();
                    break;
                case 8 : echo "Provider does not support this feature.";
                    break;
            }
            // well, basically your should not display this to the end user, just give him a hint and move on..
            echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
            echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
?>