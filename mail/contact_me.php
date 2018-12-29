<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||   
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "Nenhum argumento fornecido!";
   return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
if(!empty($_POST['phone'])){
   $phone = strip_tags(htmlspecialchars($_POST['phone']));
}else{
   $phone="*Não informado";
}
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'contato@aportar.me'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Contato via site de:  $name";
$email_subject = '=?UTF-8?B?'.base64_encode($email_subject).'?=';
$email_body = "Mensagem de contato do https://aportar.me recebida.\n\n"."Detalhes:\n\nNome: $name\n\nE-mail: $email_address\n\nTelefone: $phone\n\nMensagem:\n$message";
$headers = "From: contato@aportar.me\n";
$headers .= "Reply-To: $email_address";   

echo mail($to,$email_subject,$email_body,$headers);
return true;
?>