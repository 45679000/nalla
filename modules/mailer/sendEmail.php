<?php
require 'phpmailer/PHPMailerAutoload.php';

class Mailer{
    private $conn;
    private $body;
    private $emailAddress;
    private $subject;

    public function __construct($body, $emailAddress, $subject){
        $this->body = $body;
        $this->emailAddress = $emailAddress;
        $this->subject = $subject;

    }
    public function sendEmail($recepient){
        //create an instance of PHPMailer
        //create an instance of PHPMailer

        // echo $this->body;
        // echo $this->emailAddress;
        // echo $this->subject;

        $mail = new PHPMailer();

        //set a host
        $mail->Host = "mail.chamusupplies.com";
    
        //enable SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
    
        //set authentication to true
        $mail->SMTPAuth = true;
    
        //set login details for Gmail account
        $mail->Username = "info@chamusupplies.com";
        $mail->Password = "Chamu@2022";
    
        //set type of protection
        $mail->SMTPSecure = "tls"; //or we can use TLS
    
        //set a port
        $mail->Port = 587; //or 587 if TLS
    
        //set subject
        $mail->Subject = $this->subject;
    
    
        //set HTML to true
        $mail->isHTML(true);
    
        //set body
        $mail->Body = $this->emailTemplate($this->body);
    
        
    
        //set who is sending an email
        $mail->setFrom('amin@shiloahmega.com', 'CHAMU TIFMS');
    
        //set where we are sending email (recipients)
        $mail->addAddress($recepient, "Recepient Name");
    
        //send an email
        if($mail->send()){
            return 1;
        }
        else{
           return 0;
        }
    
    }
    public function emailTemplate($body){
       $temp1 =  '

       <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
       <html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
       <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
         <title>Demystifying Email Design</title>
         <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       
         <style type="text/css">
           a[x-apple-data-detectors] {color: inherit !important;}
         </style>
       
       </head>
       <body style="margin: 0; padding: 0;">
         <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
           <tr>
             <td style="padding: 20px 0 30px 0;">
       
       <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
         <tr>
           <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0;">
             <img src="https://www.chamusupplies.com/wp-content/uploads/2020/04/chamulogo.png" alt="Verify" width="300" height="230" style="display: block;" />
           </td>
         </tr>
         <tr>
           <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
               <tr>
                 <td>
                   <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                     <tr>
                       <td width="260" valign="top">
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                           <tr>
                             <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 25px 0 0 0;">
                               <p style="margin: ;">'.$body.'</p>
                             </td>
                           </tr>
                         </table>
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
             </table>
           </td>
         </tr>
       </table>
       
             </td>
           </tr>
         </table>
       </body>
       </html>
       
       ';
       return $temp1;
    }
}        
?>
