<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = '6LcnjYEpAAAAAO_BQcf3TVWyFzPFlVHvoUw1LlGU';
    $captchaResponse = $_POST['g-recaptcha-response'];

    // Verify the reCAPTCHA response
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $captchaResponse
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response);

    if ($result->success) {
        // The reCAPTCHA was successfully completed
        header("Location: login.php");
        exit();
    } else {
        // The reCAPTCHA failed
        echo "reCAPTCHA verification failed. Please try again.";
        echo "<br/><a href='captcha.php'>Go back</a>";
    }
} else {
    // If the form was not submitted, redirect back to the recaptcha page
    header("Location: captcha.php");
    exit();
}
?>
