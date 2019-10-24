<?php

namespace VirtuaLowStockMail\Services;

class Sender
{
    public function sendMail(string $templateName, string $sendTo): void
    {
        $mail = Shopware()->TemplateMail()->createMail($templateName);
        $mail->addTo($sendTo);
        $mail->send();
    }
}
