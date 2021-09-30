<?php

require_once ('./lib/src/PHPMailer.php');
require_once ('./lib/src/SMTP.php');
require_once ('./lib/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{

    public static function sendMail($host, $userName, $password, $myEmail, $sendTo, $titleEmail, $emailBody, $emailAltBody)
    {
        /*NÃO ALTERAR*/

        //Função de enviar emails
        
        //Enviará um email de acordo com os parâmetros especificados

        //$host: Host de sua hospedagem 
        
        //$userName: Endereço de email que vai enviar

        //$password: Senha do email que vai enviar

        //$sendTo: Endereço do email que vai receber

        //$titleEmail: Título do email
        
        //$emailBody: Corpo do Email em HTML

        //$emailAltBody: Caso não suporte HTML, conteúdo do email sem código HTML

        


        $mail = new PHPMailer(true);

        try
        {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $userName;
            $mail->Password = $password;
            $mail->Port = /* PORTA DE ENVIO DE EMAIL */;

            $mail->setFrom($myEmail);
            $mail->addAddress($sendTo);
            
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $titleEmail;
            $mail->Body = $emailBody;
            $mail->AltBody = $emailAltBody;
            
            if($mail->send()) {
		       General::alert('sucess','Verifique sua caixa de email');
        	} else {
        		General::alert('error','Erro ao enviar');
        	}
            
        }
        catch(Exception $e)
        {
            General::alert('error','Erro ao enviar');
        }
    }

    //===================================
}

?>
