<?php
header("HTTP/1.1 404 Not Found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f6fa;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #2f3640;
            text-align: center;
        }

        .container {
            max-width: 480px;
            padding: 20px;
        }

        .error-code {
            font-size: 96px;
            font-weight: 700;
            color: #4a90e2;
            line-height: 1;
            margin-bottom: 10px;
        }

        .message {
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .details {
            font-size: 15px;
            color: #555;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn:hover {
            background: #357ab7;
        }

        .icon {
            width: 140px;
            opacity: 0.7;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="https://cdn-icons-png.flaticon.com/512/565/565535.png" class="icon" alt="404 icon">

    <div class="error-code">404</div>
    <div class="message">Oops! This page doesn’t exist.</div>
    <div class="details">The resource you are looking for might have been moved, deleted, or never existed.</div>

    <a href="/iws_2025/06/API/" class="btn">Back to Home</a>
</div>

</body>
</html>