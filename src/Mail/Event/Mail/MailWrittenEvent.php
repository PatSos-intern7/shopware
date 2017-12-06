<?php declare(strict_types=1);

namespace Shopware\Mail\Event\Mail;

use Shopware\Api\Write\WrittenEvent;
use Shopware\Mail\Definition\MailDefinition;

class MailWrittenEvent extends WrittenEvent
{
    const NAME = 'mail.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return MailDefinition::class;
    }
}