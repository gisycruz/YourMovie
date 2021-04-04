<?php

namespace Models;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Model\Ticket as Ticket;


require './Vendor/PHPMailer/Exception.php';
require './Vendor/PHPMailer/PHPMailer.php';
require './Vendor/PHPMailer/SMTP.php';

class Mail
{

    public function sendMail($email,$ticketList)
    {

        $mail = new PHPMailer(true);

        try {
                //Server settings
            // $mail->SMTPDebug =0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                            // Enable SMTP authentication
                $mail->Username   = EMAIL;                     // SMTP username
                $mail->Password   = EMAILPASS ;                               // SMTP password
                $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = "587";                                    // TCP port to connect to
                $mail->CharSet = "UTF-8";
            
                //Recipients
                $mail->setFrom(EMAIL,'Your Movie');
                $mail->addAddress($email);                                     // Name is optional

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $i=1;
                $body = 'The purchase has been satisfactory the ticket/s are data: ';

                foreach ($ticketList as $ticket) { 
                    $countrtiket = $ticket->getShopping()->getCountrtiket();
                    $brinlogic = explode('/', $ticket->getQr());
                    $adreslogic = $brinlogic[6] . '/'. $brinlogic[7];
                    $totaladres = "C:/wamp64/www/YourMovie/img/Qr/" . $adreslogic;
                   
                    if($i == 1)
                    {
                        $body .= $ticket->getShopping()->getDateShopping();
                    }
                    $mail->AddAttachment($totaladres);  

                    $message =   "<br><br>Number Qr: " . $ticket->getNumberTicket() . "<br>Movie: " . $ticket->getShopping()->getScreening()->getMovie()->getTitle()  .
                                "<br>Data Screening: " . $ticket->getShopping()->getScreening()->getDate_screening()  ."<br>Hour movie : ". $ticket->getShopping()->getScreening()->getHour_screening().  "<br>Cinema: " . $ticket->getShopping()->getScreening()->getRoom()->getCinema()->getName() .
                                "<br>Address: ". $ticket->getShopping()->getScreening()->getRoom()->getCinema()->getAddress() .
                                "<br>Room: " . $ticket->getShopping()->getScreening()->getRoom()->getName() . $i++;

                                
                    
                }

                $mail->Body  = $body;
                
                $mail->Subject = 'Your Movie, you have successfully bought '. $countrtiket;


                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();


            } catch (Exception $ex) {

                echo  $ex->getMessage();
            }

    }
}