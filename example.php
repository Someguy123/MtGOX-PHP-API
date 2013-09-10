<?php
/*
 * This is an example file provided with the
 * unofficial MtGox PHP Class found on GitHub
 * which was created by Someguy123
 *
 * https://github.com/Someguy123/MtGOX-PHP-API
 *
 * This file connects to MtGox using the API
 * credentials supplied, and then outputs the
 * current BTCUSD ticker
 */
include("Gox.class.php");
// Change these values to the ones obtained from http://mtgox.com/security
$gox = new Gox("YourAPIKey", "YourAPISecret");
$ticker = $gox->ticker(); // No parameters defaults to BTCUSD
if($ticker['result'] == "success") {
    echo "The current average price for BTC in USD is ".$ticker['data']['avg']['value']."\r\n";
} else {
    echo "An error occurred obtaining the ticker";
}
?>
