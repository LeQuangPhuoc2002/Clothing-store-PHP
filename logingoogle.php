<?php
include('includes/Database.php');

require 'google-api/vendor/autoload.php';

// Creating new Google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('146210714064-4qib02l3dbkqogsebt2819526soe2be6.apps.googleusercontent.com');
// Enter your Client Secret
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('http://localhost:8085/chapter1/quangphuoc/logingoogle.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);

        // Getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Print the information without storing in the database
        echo "Google ID: " . $google_account_info->id . "<br>";
        echo "Full Name: " . $google_account_info->name . "<br>";
        echo "Name: " . $google_account_info->givenName . "<br>"; // Adding the 'Name' field
        echo "Email: " . $google_account_info->email . "<br>";
        $userId = Database::getUserId($google_account_info->email);

        // If the user doesn't exist, insert into the database
        if ($userId == -1) {
            Database::insertUserWithCart($google_account_info->givenName, $google_account_info->email, $google_account_info->name, $google_account_info->id, $google_account_info->name);
            $userId = Database::getUserId($google_account_info->email); // Retrieve the newly inserted user ID
        }
      // After verifying the user's credentials and before redirecting
        $passwords = Database::generateMD5($google_account_info->name);
        $query = Database::query("SELECT * FROM users WHERE (email = '$google_account_info->email' OR username = '$google_account_info->givenName') AND password = '$passwords'");
        $user = $query->fetch_array();
        $_SESSION['user'] = $user;
        $_SESSION['name'] = $user['name']; // Make sure 'name' is a valid key in your user data
        $_SESSION['id'] = $user['user_id']; // Add this line to store user id in session
        header("location: index.php?id=" . $user['user_id']);
        exit();
      

    } else {
        header('Location: login.php');
        exit;
    }
} else {
    // Google Login Url
    $googleLoginUrl = $client->createAuthUrl();
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Login - LaravelTuts</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class='_container'>
        <h2 class='heading'>Login</h2>
    </div>
    <div class='_container btn'>
        <a type='button' class='login-with-google-btn' href='$googleLoginUrl'>
            Sign in with Google
        </a>
    </div>
</body>
</html>";
}
?>