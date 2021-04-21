<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$subscriber_email = $_POST['email'];

//Validate first
if(empty($subscriber_email))
{
    echo "email is mandatory!";
    exit;
}

if(IsInjected($subscriber_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'openneuropet';//<== update the email address
$email_subject = "New subscriber";
$email_body = "You have a new subscriber $subscriber_email.";

$to = "wamcyril@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $subscriber_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
