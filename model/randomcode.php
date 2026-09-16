<?php
// Function to generate a random token of given length
function generateToken($length = 18) {
    // Allowed characters: uppercase, lowercase, digits
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $token = '';
    $maxIndex = strlen($characters) - 1;

    // Generate token
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $maxIndex)];
    }

    return $token;
}

// Example usage
// echo "Random Token: " . generateToken(10);
?>
