

<?php
/*
|--------------------------------------------------------------------------

|
*/
define( 'DB_HOST', '185.224.138.91' );          // Set database host
define( 'DB_USER', 'u191736858_card_payments');             // Set database user
define( 'DB_PASS', 'dsQUI()*hjhasjW12%6N&');             // Set database password
define( 'DB_NAME', 'u191736858_card_payments' );      


// define( 'DB_HOST', 'localhost' );          // Set database host
// define( 'DB_USER', 'root' );             // Set database user
// define( 'DB_PASS', '' );             // Set database password
// define( 'DB_NAME', 'card_payments' );   

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>

