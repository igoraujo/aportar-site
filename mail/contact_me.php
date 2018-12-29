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
$email_body = "<div>Mensagem de contato do https://aportar.me recebida.</div>"."<div><br><b>Detalhes:</b></div><div><b>Nome:&nbsp;&nbsp;</b>".$name."</div><div><b>E-mail:&nbsp;&nbsp;</b>".$email_address."</div><div><b>Telefone:&nbsp;&nbsp;</b>".$phone."</div><div><b>Mensagem:</b></div><div><code>".$message."</code></div>";
$headers = "From: contato@aportar.me\n";
$headers .= "Reply-To: $email_address\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

echo mail($to,$email_subject,$email_body,$headers);
return true;
?>