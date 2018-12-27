<?php
//Import the PHPMailer class into the global namespace
require __DIR__.'/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Dotenv\Dotenv;

class Main {

  public function __construct() {
    $this->NAME = $_POST['name'];
    $this->EMAIL = $_POST['email'];
    $this->MSG = $_POST['message'];
    $this->PHONE = $_POST['phone'];
    $this->URL = $_SERVER["HTTP_HOST"];
    $this->SUBJECT = 'Contato';

    $this->dotenv = new Dotenv();
    $this->dotenv->load(__DIR__.'/.env');
    
    $this->smtp = getenv('HOST');
    $this->userName = getenv('USER_NAME');
    $this->pass = getenv('PASSWORD');
    $this->from = getenv('FROM');
    $this->fromName = getenv('FROM_NAME');

    echo '<script>alert("entrou")</script>';

    $this->sendMail();
  }

  private function sendMail() {
    $mail = new PHPMailer();

    // Define que a mensagem será SMTP
    $mail->IsSMTP();

    // Host do servidor SMTP externo, como o SendGrid.
    $mail->Host = $this->smtp;

    // Autenticação | True
    $mail->SMTPAuth = true;

    // Usuário do servidor SMTP
    $mail->Username = $this->userName; 

    // Senha da caixa postal utilizada
    $mail->Password = $this->pass;

    $mail->From = $this->from;
    $mail->FromName = $this->fromName;
    $mail->AddAddress($this->EMAIL, $this->NAME);

    // Define que o e-mail será enviado como HTML | True
    $mail->IsHTML(true);

    // Charset da mensagem (opcional)
    $mail->CharSet = 'UTF-8';

    // Assunto da mensagem
    $mail->Subject = $this->SUBJECT;

    // Conteúdo no corpo da mensagem
    $message = 
    '<div class="email">
        <div><b>Nome: </b>' . $this->NAME . '.</div>
        <div><b>E-mail: </b>' . $this->EMAIL . '.</div>
        <div><b>Telefone: </b>' . $this->PHONE . '.</div>
        <div><b>Mensagem: </b><p>' . $this->MSG . '.</p></div>
     </div>';

     $mail->Body = $message;

    //Envio da Mensagem
    $enviado = $mail->Send();

    $mail->ClearAllRecipients();

    if ($enviado) {
      http_response_code(200);
      $obj = [
        'code' => 200,
        'status' => 'Success',
        'message' => 'E-mail enviado com sucesso!'
      ];
      
      echo '<script>console.log('.$obj.')</script>';
      return;
    } else {
      $masgError = $mail->ErrorInfo;
      http_response_code(500);
      $obj = [
        'code' => 500,
        'status' => 'Intrenal Server',
        'message' => 'Não foi possível enviar o e-mail.',
        'detail:'=> $masgError
      ];
      
      echo '<script>console.log('.$obj.')</script>';
      return;
    }
  }

}
$main = new Main;