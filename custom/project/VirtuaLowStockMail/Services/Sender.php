<?php

namespace VirtuaLowStockMail\Services;

class Sender
{
    public function sendMail(string $templateName, string $sendTo, string $contentHtml): void
    {
        $mail = Shopware()->TemplateMail()->createMail($templateName);
        $mail->addTo($sendTo);
        $mail->setBodyHtml($contentHtml);
        $mail->send();
    }
}
