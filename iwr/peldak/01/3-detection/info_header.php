<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Classic HTTP Headers Demo (for Mobile Detect)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
        }

        h1 {
            color: #333;
            margin-top: 24px;
        }

        p {
            margin: 6px 0;
        }

        hr {
            margin: 18px 0;
        }

        code {
            background: #f2f2f2;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .small {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<?php

function safe($str)
{
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/* Common headers */
var_dump($_SERVER);
$accept = $_SERVER["HTTP_ACCEPT"] ?? "";
$accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"] ?? "";
$accept_charset = $_SERVER["HTTP_ACCEPT_CHARSET"] ?? ""; // often empty in modern browsers
$user_agent = $_SERVER["HTTP_USER_AGENT"] ?? "";

/* Historical WAP headers (for educational purposes) */
$x_wap_profile = $_SERVER["HTTP_X_WAP_PROFILE"] ?? "";
$profile = $_SERVER["HTTP_PROFILE"] ?? "";

/* Output */
echo "<h1>ACCEPT</h1><p><code>" . safe($accept) . "</code></p><hr>";

echo "<h1>ACCEPT-LANGUAGE</h1><p><code>" . safe($accept_language) . "</code></p><hr>";

echo "<h1>ACCEPT-CHARSET (historical)</h1>";
if ($accept_charset !== "") {
    echo "<p><code>" . safe($accept_charset) . "</code></p>";
} else {
    echo "<p class='small'>(not provided by modern browsers)</p>";
}
echo "<hr>";

echo "<h1>USER AGENT</h1>";
echo "<p><code>" . safe($user_agent) . "</code></p>";
echo "<p class='small'>Tip: You can modify this using your User-Agent Switcher extension to simulate different devices.</p><hr>";

echo "<h1>WAP / UAProf (historical example)</h1>";
echo "<p class='small'>These headers were used by old WAP mobile phones. Modern browsers no longer send them.</p>";

echo "<p><strong>X-WAP-Profile:</strong> ";
if ($x_wap_profile !== "") {
    echo '<code><a href="' . safe($x_wap_profile) . '" target="_blank">' . safe($x_wap_profile) . '</a></code>';
} else {
    echo "<code>(not provided)</code>";
}
echo "</p>";

echo "<p><strong>Profile:</strong> ";
if ($profile !== "") {
    echo '<code><a href="' . safe($profile) . '" target="_blank">' . safe($profile) . '</a></code>';
} else {
    echo "<code>(not provided)</code>";
}
echo "</p>";

// https://whichbrowser.net/data/profiles/index.html

?>
</body>
</html>