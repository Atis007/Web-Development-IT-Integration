<?php
// Callback function to modify the output buffer
function replaceTextInBuffer($buffer)
{
    // Replace all occurrences of 'world' with 'PHP'
    return str_replace('world', 'PHP', $buffer);
}

// Start output buffering with a callback
ob_start('replaceTextInBuffer');
//ob_start();

// Output some content
echo "Hello, world! Welcome to the world of programming.";

//$output = ob_get_contents();
//
//var_dump($output);

// Flush the output buffer and apply the callback
ob_end_flush();