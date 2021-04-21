<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$contact_email = $_POST['email'];
$contact_name  = $_POST['name'];
$contact_phone = $_POST['phone'];
$contact_subject = $_POST['subject']
$contact_message = $_POST['message'];

//Validate first
if(empty($contact_email) || empty($message))
{
    echo "meassage and email is mandatory!";
    exit;
}

if(IsInjected($contact_email) || IsInjected($subject))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'openneuropet';//<== update the email address
$email_subject = $contact_subject;
$email_body = "You have a new message from $contact_name ($_POST['phone']):\n".
              " $contact_message.";

$to = "wamcyril@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $contact_email \r\n";
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
