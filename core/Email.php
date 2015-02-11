<?php
    
    namespace Core;
    
    use \Swift_Message;
    use \Swift_Attachment;
    use \Swift_SmtpTransport;
    use \Swift_Mailer;
    
    
class Email
{
    
        
    /**
     * Data for Email
     *
     * @var string $to
     * @var array $from [email => name]
     */  
    private $to, $from, $subject, $content_text, $content_html, $attachment;
    
    function __construct($to, array $from, $subject, $content_html, $content_txt = null, $attachment = null)
    {
        $this->to = $to;        
        $this->from = $from;        
        $this->subject = $subject;        
        $this->content_html = $content_html;        
        $this->content_txt = $content_txt;        
        $this->attachment = $attachment;        
    }
            
    function send()
    {
    	$message = Swift_Message::newInstance();
    
    	//Objet
    	$message->setSubject($this->subject);
    
        
    	$message->setFrom($this->from);
    
    
    	//Contenu
    	$message->setBody($this->content_html);
    
        $message->setContentType("text/html");

    
    	//Destinataire
    	$message->setTo([$this->to]);
    	
        if (!is_null($this->attachment) && !empty($this->attachment)) {
    
            foreach( $this->attachment as $attachment){
        		$message->attach(Swift_Attachment::fromPath($attachment));
            }
        
    	}
    	
        $transport = Swift_SmtpTransport::newInstance('smtp.easykit.ovh', 587)
		->setUsername('hello@easykit.ovh')
		->setPassword('0h86c7qg');

    	$headers = $message->getHeaders();
    	$mailer = Swift_Mailer::newInstance($transport);
    
    	if ($mailer->send($message)) {
            return true;	
        } else {
            throw new Exception('Couldn\'t send the message');
        }
    }
}	