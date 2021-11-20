<?php
 $connect = mysqli_connect("localhost","manladtr_user","Seven-ones1","manladtr_manlad");
    // $connect=mysqli_connect(DB_host,DB_user,DB_pass,DB_database);
 if(!$connect){
        echo "Check your connection, there seems to be a breech";
        die("ERROR: Could not connect ".mysqli_connect_error);
    }

$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer ****************************",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}
$email = $_GET['e'];
$amount = $_GET['a'];
$name = $GET['n'];
if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
   $adminquery1 = "INSERT INTO payment (name, email, amount, date) VALUES
	  ('$name', '$email', '$amount', '$date')";
 if (mysqli_query($connect, $adminquery1))
{
        echo "<script>alert('Payment Successful. Your receipt has been sent your email')</script>";
echo "<script>window.open('https://manladtravels.com.ng','_self')</script>";
        
}
		else {
			echo "<script>alert('Could not make Payment')</script>";
		}
}
