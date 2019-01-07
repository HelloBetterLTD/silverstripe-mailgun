<?php
namespace SilverStripers\silverstripemailgun\Models;
use SilverStripe\Control\Email\SwiftMailer as MainSwiftMailer;
/**
 * Created by PhpStorm.
 * User: mpowerPC
 * Date: 1/4/2019
 * Time: 10:52 AM
 */

class SilverStripersMailer extends MainSwiftMailer
{
    protected $mailgunClient;

    public function __construct()
    {
        $config = $this->config();
        // create the Transport
        $transport = \Swift_SmtpTransport::newInstance('smtp.mailgun.org', 25)
            ->setUsername($config->SMTPusername)
            ->setPassword($config->SMTPpassword);
        // create the Mailer using your created Transport
        $client = \Swift_Mailer::newInstance($transport);
        $this->setMailGunClient($client);
    }

    //@$to array of email addresses of reciever
    //@from array of email address with show nAME of sender
    //@$subject string ,subject of email
    //@$content text , plain content of email
    //@$attachments array of file links, this could be set of urls or file paths on the disk
    public function sendPlain($to = [], $from = [], $subject = '', $content = '', $attachments = [])
    {

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($content);
        if(count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $message->attach(\Swift_Attachment::fromPath($attachment));
            }
        }

        return $this->sendMessage($message);
    }

    //@$to array of email addresses of reciever
    //@from array of email address with show nAME of sender
    //@$subject string ,subject of email
    //@$plainContent text , plain content of email
    //@$htmlContent text , HTML Text content of email
    //@$attachments array of file links, this could be set of urls or file paths on the disk
    public function sendHTML($to, $from, $subject, $htmlContent, $plainContent = '', $attachments = [])
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($plainContent)
            ->addPart($htmlContent, 'text/html');
        if(count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $message->attach(\Swift_Attachment::fromPath($attachment));
            }
        }
        return $this->sendMessage($message);
    }

    //send the email
    //returns boolean
    protected function sendMessage($message)
    {
        return $this->mailgunClient->send($message);
    }

    //set the mailgunClient
    //returns this
    public function  setMailGunClient($client)
    {
        $this->mailgunClient = $client;
        return $this;
    }

    //get the mailgunClient
    //returns Swift_Mailer object
    public function getMailgunClient()
    {
        return $this->mailgunClient;
    }

}