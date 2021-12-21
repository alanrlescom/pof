<?php

require './libraries/stripe/init.php';

\Stripe\Stripe::setApiKey('sk_test_51K74NuJ4An9dIGcQc8XRJlapH9BnkoioCfODMFAIsnFR7BTSh5WwmFfmVC320ZwyLnwGSEClUYLv4Hos56Yr04bD00gdpGaWFs');

function calculateOrderAmount(array $items): int {
    return 1400;
}

header('Content-Type: application/json');

try {

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => floatval($_POST["amount"]) * 100,
        'currency' => 'mxn',
        'automatic_payment_methods' => [
            'enabled' => false,
        ],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>