<?php
namespace Service;

/**
 * Handles email sending logic
 */
class EmailService {

    private string $senderEmail = "noreply@example.com";

    public function send(string $to, string $message): string {
        return "Email sent to {$to} from {$this->senderEmail}";
    }
}
