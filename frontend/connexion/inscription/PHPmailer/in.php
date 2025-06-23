<?php
 require 'class.phpmailer.php';

 $mail = new PHPMailer;

 $mail->isSMTP();                                      // Set mailer to use SMTP
 $mail->Host = 'smtp.gmail.com';  // Specify main and backup server
 $mail->SMTPAuth = true;                               // Enable SMTP authentication
 $mail->Username = 'hajar.couzirochdy@gmail.com';                            // SMTP username
 $mail->Password = 'couzirochdy';                           // SMTP password
 $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

 $mail->From = 'hajar.couzirochdy@gmail.com';
 $mail->FromName = 'Mailer';
 $mail->addAddress('hajar.couzirochdy@gmail.com', 'sos');  // Add a recipient
 $mail->addAddress('hajar.couzirochdy@gmail.com');               // Name is optional
 $mail->addReplyTo('hajar.couzirochdy@gmail.com', 'Information');
 $mail->addCC('hajar.couzi2806@gmail.com');
 $mail->addBCC('hajar.couzi2806@gmail.com');

 $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
 $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
 $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
 $mail->isHTML(true);                                  // Set email format to HTML

 $mail->Subject = 'Here is the subject';
 $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 if(!$mail->send()) {
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo;
  exit;
 }

 echo 'Message has been sent';