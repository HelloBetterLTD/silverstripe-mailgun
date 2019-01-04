<?php
namespace SilverStripers\silverstripemailgun\Models;
use SilverStripe\Control\Email\SwiftMailer;

/**
 * Created by PhpStorm.
 * User: mpowerPC
 * Date: 1/4/2019
 * Time: 10:52 AM
 */

class SilverStripersMailer extends SwiftMailer
{
    protected $mailgunClient;

    public function __construct()
    {
        $config = $this->config();
        $transport = \Swift_SmtpTransport::newInstance('smtp.mailgun.org', 25)
            ->setUsername($config->SMTPusername)
            ->setPassword($config->SMTPpassword);
        $client = \Swift_Mailer::newInstance($transport);
        $this->setMailGunClient($client);
    }

    //@from array of email address with show nAME
    //@$to array of email addresses
    //@$subject string
    //@$content text
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

    protected function sendMessage($message)
    {
        return $this->mailgunClient->send($message);
    }

    public function  setMailGunClient($client)
    {
        $this->mailgunClient = $client;
        return $this;
    }

    public function getMailgunClient()
    {
        return $this->mailgunClient;
    }

}