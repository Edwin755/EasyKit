<?php
/**
 * Email for the framework
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */
    
namespace Core;

use Exception;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Class Email
 *
 * @package Core
 */
class Email
{
    
        
    /**
     * Data for Email
     *
     * @var string $to
     * @var array $from [email => name]
     */  
    private $to, $from, $subject, $content_text, $content_html, $attachment;

    /**
     * Construct
     *
     * @param $to
     * @param array $from
     * @param $subject
     * @param $content_html
     * @param null $content_txt
     * @param null $attachment
     */
    function __construct($to, array $from, $subject, $content_html, $content_txt = null, $attachment = null)
    {
        $this->to = $to;        
        $this->from = $from;        
        $this->subject = $subject;        
        $this->content_html = $content_html;        
        $this->content_txt = $content_txt;        
        $this->attachment = $attachment;        
    }

    /**
     * Send
     *
     * @return bool
     * @throws Exception
     */
    function send()
    {
        $app = Dispatcher::getAppFile();
        $transport = Swift_SmtpTransport::newInstance($app['mail_smtp'], $app['mail_port'])
            ->setUsername($app['mail_username'])
            ->setPassword($app['mail_password']);
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance();
    	$message
            ->setSubject($this->subject)
            ->setFrom($this->from)
            ->setBody($this->content_html)
            ->addPart($this->content_html, 'text/html');

    	$message->setTo([$this->to]);

        if (!is_null($this->attachment) && !empty($this->attachment)) {
            foreach($this->attachment as $attachment){
        		$message->attach(Swift_Attachment::fromPath($attachment));
            }
    	}

    	$headers = $message->getHeaders();

        if ($mailer->send($message)) {
            return true;
        } else {
            return false;
        }
    }
}
