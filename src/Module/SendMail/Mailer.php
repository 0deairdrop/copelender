<?php
namespace Src\Module\SendMail;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    protected $mail;
    protected $recipientEmail;
    protected $recipientName;
    protected $subject;
    protected $htmlBody;
    protected $altBody;
    protected $cc = [];
    protected $bcc = [];
    protected $attachment = false;
    protected $attachmentPath = '';

    public function __construct()
    {
        // Initialize PHPMailer
        $this->mail = new PHPMailer(true);  // Exceptions will not be caught here, handled externally

        // Server settings (example for Gmail SMTP)
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp-relay.brevo.com';  // Set SMTP server (e.g., Gmail)
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = '7c1259001@smtp-brevo.com';  // Your Gmail address
        $this->mail->Password   = 'IMFgfPOSnCzRqEvV';         // Your Gmail password (use App Password if 2FA enabled)
        $this->mail->SMTPSecure = 'tls';                   // Encryption (use 'ssl' if needed)
        $this->mail->Port       = 587;                     // Port for TLS (465 for SSL)
    }

    public function invokeProcessSendMail($arParam=[])
    {
        $this->recipientEmail = $arParam['recipientEmail'] ?? '';
        $this->recipientName  = $arParam['recipientName'] ?? 'Recipient';  // Fallback if name not provided
        $this->subject        = $arParam['subject'] ?? '';
        $this->htmlBody       = $arParam['body'] ?? '';
        $this->altBody        = $arParam['altBody'] ?? '';
        $this->cc             = $arParam['cc'] ?? [];
        $this->bcc            = $arParam['bcc'] ?? [];
        $this->attachment     = $arParam['attachment'] ?? false;
        $this->attachmentPath = $arParam['attachmentPath'] ?? '';

        // Validate the recipient email
        if (filter_var($this->recipientEmail, FILTER_VALIDATE_EMAIL)) 
        {
            if ($this->attachment === false) 
            {
                return $this->sendMail();
            } 
            else 
            {
                return $this->sendMailWithAttachment();
            }
        } 
        else 
        {
            return ['status' => false, 'message' => 'Invalid recipient email address'];
        }
    }

    private function sendMail()
    {
        $this->addRecipients();
        return $this->prepareEmailContentAndSend();
    }

    // Method to send an email with an attachment and optional CC/BCC
    private function sendMailWithAttachment()
    {
        $this->addRecipients();
        
        // Add attachment
        if (file_exists($this->attachmentPath)) 
        {
            $this->mail->addAttachment($this->attachmentPath);  // Add attachment if file exists
        }

        return $this->prepareEmailContentAndSend();
    }

    private function addRecipients()
    {
        // Set the sender details
        $this->mail->setFrom('gossipears@gmail.com', APP_NAME);  // Set sender address and name

        // Add recipient
        $this->mail->addAddress($this->recipientEmail, $this->recipientName);  // Add recipient with name

        // Add CC (if provided)
        if (!empty($this->cc)) 
        {
            foreach ($this->cc as $ccEmail => $ccName) 
            {
                $this->mail->addCC($ccEmail, $ccName);
            }
        }

        // Add BCC (if provided)
        if (!empty($this->bcc)) 
        {
            foreach ($this->bcc as $bccEmail => $bccName) 
            {
                $this->mail->addBCC($bccEmail, $bccName);
            }
        }
    }

    // Method to prepare email content and send
    private function prepareEmailContentAndSend()
    {
        // Email content
        $this->mail->isHTML(true);           // Set email format to HTML
        $this->mail->Subject = $this->subject;  
        $this->mail->Body    = $this->htmlBody;  
        $this->mail->AltBody = $this->altBody;  
        // Send email and check result
        if ($this->mail->send()) 
        {
            return ['status' => true, 'message' => 'Email sent successfully'];
        } 
        else 
        {
            // Return PHPMailer's built-in error message
            return ['status' => false, 'message' => 'Email could not be sent. Mailer Error: ' . $this->mail->ErrorInfo];
        }
    }
}
