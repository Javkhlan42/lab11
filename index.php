<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub API Authorization</title>
</head>

<body>
    <p>
        Well, hello there!
    </p>
    <p>
        <?php
        $client_id = '';
        ?>
        We're going to now talk to the GitHub API. Ready?
        <a href="https://github.com/login/oauth/authorize?scope=user:email&client_id=<?php echo $client_id; ?>">Click here</a> to begin!
    </p>
    <p>
        If that link doesn't work, remember to provide your own <a href="/apps/building-oauth-apps/authorizing-oauth-apps/">Client ID</a>!
    </p>
</body>

</html>