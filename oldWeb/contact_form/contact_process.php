<?php

include dirname(dirname(__FILE__)).'/mail.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
include 'email_validation.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);


$error = '';

// Check name

if(!$name)
{
$error .= 'Молимо да унесете Ваше име.<br />';
}

// Check email

if(!$email)
{
$error .= 'Молимо да унесете Вашу електронску адресу<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Морате унети валидну електронску адресу<br />';
}

// Check message (length)

if(!$message || strlen($message) < 10)
{
$error .= "Молимо да унесете поруку. Порука мора имати најмање 10 карактера.<br />";
}


if(!$error)
{
$mail = mail(CONTACT_FORM, $subject, $message,
     "From: ".$name." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());


if($mail)
{
echo 'Порука је успешно послата';
}

}
else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
?>