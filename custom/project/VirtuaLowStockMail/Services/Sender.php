<?php

namespace VirtuaLowStockMail\Services;

class Sender
{
    public function sendMail(string $templateName): void
    {
        $mail = Shopware()->TemplateMail()->createMail($templateName);
        $mail->addTo('mail@gmail.com');
        $mail->send();
    }
}
