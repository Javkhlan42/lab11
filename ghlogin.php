<?php
session_start();

$CLIENT_ID = '31df29479214fd5f592b';
$CLIENT_SECRET = 'da6d0d8f7f182721b75eec81283cacf66b75ef77';

if (isset($_GET['code'])) {
    // Retrieve the code from the URL parameters
    $sessionCode = $_GET['code'];

    // Use cURL to make a POST request to GitHub to get an access token
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://github.com/login/oauth/access_token');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
        'code' => $sessionCode,
    ]));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Check for successful response and extract the access token
    if ($httpCode === 200) {
        $jresult = json_decode($result, true);

        // Check if 'access_token' key exists in the response
        if (isset($jresult['access_token'])) {
            $accessToken = $jresult['access_token'];

            // Store the access token securely (in a session variable in this example)
            $_SESSION['access_token'] = $accessToken;

            // Fetch user's email addresses from GitHub API
            $accessToken = $_SESSION['access_token'];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.github.com/user/emails');
            $headers = [
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
                'X-GitHub-Api-Version: 2022-11-28',
                'User-Agent: mybrowser'
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);


            if ($httpCode === 200) {
                $emails_jarr = json_decode($result, true);
                $emails = array_column($emails_jarr, 'email');

                
                $allowedEmail = 'javkhlangantulga17@gmail.com'; 


                $authorized = in_array($allowedEmail, $emails);

                if ($authorized) {
                    echo "news: Apple was founded as Apple Computer Company on April 1, 1976, by Steve Wozniak, Steve Jobs, and Ronald Wayne to develop and sell Wozniak's Apple I personal computer. It was incorporated by Jobs and Wozniak as Apple Computer, Inc. in 1977. The company's second computer, the Apple II, became a best seller and one of the first mass-produced microcomputers.";
                } else {
                    echo "You are not authorized to view this content.";
                }
            } else {
                echo "Error fetching emails from GitHub API. HTTP code: $httpCode";
            }
        } else {
            echo "Access token not found in the response.";
        }
    } else {
        echo "Error getting access token from GitHub. HTTP code: $httpCode";
    }
} else {

    echo "Authentication failed. No code parameter found.";
}
?>
