<?php

require_once("PHPMailer_5.2.2/class.phpmailer.php");

class Mailer {
	public $from;
	public $to;
	public $cc;
	public $bcc;
	public $subject;
	public $message;
	public $mail;
	
	private $CI;
	
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->mail = new PHPMailer(true);
		
		$this->mail->IsSMTP();
		$this->mail->SMTPAuth   = true;
		$this->mail->CharSet    = config_item('charset');
        $this->mail->SMTPSecure = config_item('smtp_crypto');
        $this->mail->Host       = config_item('smtp_host');
        $this->mail->Port       = config_item('smtp_port');
        $this->mail->Username   = config_item('smtp_user');
        $this->mail->Password   = config_item('smtp_pass');
        
        $from = config_item('mailfrom');
        
        $this->mail->SetFrom($from[1], $from[0]);
        $this->mail->AddReplyTo($from[1], $from[0]);
	}
	
	public function send(){
	    
	    $body = $this->message;
	    
	    $this->mail->AltBody = strip_tags($this->message);
	    $this->mail->MsgHTML($body);
	    $this->mail->Subject = $this->subject;
	    
	    $this->mail->AddAddress($this->to);
	    
	    if ( ! $this->mail->Send())
	    {
	       error_log($this->mail->ErrorInfo);
	       return false;
	    }
	    return true;
	}
}

?>