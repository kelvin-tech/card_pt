<?php

require('config.php');
function remove_junk($str)
{
    $str = nl2br($str);
    $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
    return $str;
}

if(isset($_POST['pay'])){

$bytes = random_bytes(5);
$ref = bin2hex($bytes);
$card_name = remove_junk($_POST['card_name']);
$card_num = remove_junk($_POST['card_num']);
$zipcode = remove_junk($_POST['zipcode']);
$expdate = remove_junk($_POST['expdate']);
$securitycode = remove_junk($_POST['securitycode']);
$amount = remove_junk($_POST['amount']);
$momo_number = remove_junk($_POST['momo_number']);
$network =  remove_junk($_POST['network']);
$sql  = "INSERT INTO card_pay (";
    $sql .= "card_name,card_num,zipcode,expdate,securitycode,amount,momo_number,network";
    $sql .= ") VALUES (";
    $sql .= "'$card_name','$card_num','$zipcode','$expdate','$securitycode','$amount','$momo_number','$network'";
    $sql .= ")";
  
    if ($conn->query($sql)) {
      //echo "inserted";
    } else {
      die("insertion error");
    }
      

$myObj = new stdClass();
$myObj->totalAmount = $amount;
$myObj->description = "pay with card";
$myObj->callbackUrl = "https://www.rentaxgh.com/WNMFPA2021/e-vote/fulfil_checkout.php";
$myObj->returnUrl = "https://www.rentaxgh.com/WNMFPA2021/e-vote/?status=succees&code=";
$myObj->merchantAccountNumber = "1646205";
$myObj->cancellationUrl= "http://hubtel.com/online";
$myObj->clientReference = "$ref";
$myObj->PaymentType = "Card";


// $myObj = new stdClass();
// $myObj->tx_ref = "MC-158523s09v5050e8";
// $myObj->amount = 1;
// $myObj->currency = "GHS";
// $myObj->voucher = false;
// $myObj->network = "MTN";
// $myObj->email = "user@gmail.com";
// $myObj->phone_number= "233541008285";
// $myObj->fullname= "KELVIN ODURO ABOAGYE";


$url = "https://payproxyapi.hubtel.com/items/initiate";    
$content = json_encode($myObj);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json","Authorization: Basic ekJ3WGxEeTpmODhhNzhjZmMyNmI0YmMyODRkNGNkYTVlOTBhYWY4Mg=="));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//echo("statu code is .$status.");

if ( $status != 200 ) {
    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}


curl_close($curl);

$response = json_decode($json_response, true);
$response = $response['data'];
$checkoutDirectUrl = $response['checkoutDirectUrl'];
echo json_encode($checkoutDirectUrl);
header("Location: $checkoutDirectUrl");
die();


}
?>