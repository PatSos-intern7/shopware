<?php
namespace VirtuaLowStockMail;

use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin;
use Shopware\Models\Mail\Mail;


class VirtuaLowStockMail extends Plugin
{
    public const MAIL_TEMPLATE_NAME = 'Low Stock Email Template';

    public function install(InstallContext $context)
    {
        if($this->checkMail()) {
            $this->installMailTemplate();
        }
        parent::install($context);
    }

    public function installMailTemplate(): void
    {
        $entityManager = Shopware()->Models();

        $mail = new Mail();

        $mail->setName(self::MAIL_TEMPLATE_NAME);
        $mail->setMailtype(Mail::MAILTYPE_USER);

        $mail->setSubject($this->getSubject());
        $mail->setContent($this->getContent());
        $mail->setContentHtml($this->getContentHtml());

        $entityManager->transactional(static function ($em) use ($mail) {
            /** @var ModelManager $em */
            $em->persist($mail);
        });

    }

    private function getSubject(): string
    {
        return 'Default Subject';
    }

    private function getContent(): string
    {

        return <<<'EOD'
{include file="string:{config name=emailheaderplain}"}

{* Content *}

{include file="string:{config name=emailfooterplain}"}
EOD;
    }

    private function getContentHtml(): string
    {
        return <<<'EOD'
{include file="string:{config name=emailheaderhtml}"}

{* TTTT Content *}


{include file="string:{config name=emailfooterhtml}"}
EOD;
    }

    public function checkMail()
    {
        $em = Shopware()->Models();
        $repository = $em->getRepository(Mail::class);
        if(empty($repository->findBy(['name'=>self::MAIL_TEMPLATE_NAME]))){
            return true;
        }
        return false;
    }
}
