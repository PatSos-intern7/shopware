<?php

namespace VirtuaPocztaPolskaDispatch\Services;

use Shopware\Components\Model\ModelManager;
use Shopware\Models\Country\Country;
use Shopware\Models\Dispatch\Dispatch;
use Shopware\Models\Dispatch\ShippingCost;
use Shopware\Models\Payment\Payment;

class DispatchCreator
{
    /**
     * @var ModelManager
     */
    private $em;
    /**
     * @var array
     */
    private $euCountriesIsoCodes;

    public function __construct(ModelManager $em)
    {
        $this->em = $em;

        $this->euCountriesIsoCodes = [
            'AT', 'BE', 'HR', 'BG', 'CY',
            'CZ', 'DK', 'EE', 'FI', 'FR',
            'DE', 'GR', 'HU', 'IE', 'IT',
            'LV', 'LT', 'LU', 'MT', 'NL',
            'PL', 'PT', 'RO', 'SK', 'SI',
            'ES', 'SE', 'GB'
        ];
    }

    public function createDeliveryMethod()
    {
        if($this->dispatchCheck()){
            $newDispatchMethod = $this->getPocztaPoskaDispatch();
            $this->em->persist($newDispatchMethod);
            $this->em->flush();
        }
        return 0;
    }

    private function getPocztaPoskaDispatch()
    {

        $post = new Dispatch();
        return $post->setName('Poczta Polska')
            ->setDescription('Poczta Polska Decs')
            ->setPosition(1)
            ->setActive(true)
            ->setPayments($this->getPayments())
            ->setType(0)
            ->setSurchargeCalculation(0)
            ->setCalculation(0)
            ->setCostsMatrix($this->getShippingPrices())
            ->setBindWeekdayFrom(1)
            ->setBindWeekdayTo(5)
            ->setCountries($this->getEuCountries())

            ->setComment('Poczta Polska commnet')// not null
            ->setTaxCalculation(1)// not null
            ->setBindLastStock(1)

            ->setShippingFree(100);
    }

    private function dispatchCheck(): bool
    {
        $dispatchRepo = $this->em->getRepository(Dispatch::class);
        return  empty($dispatchRepo->findBy(['name'=>'Poczta Polska'])) ?  true : false ;
    }

    private function getEuCountries()
    {
        $countries = $this->em->getRepository(Country::class);

        return  $countries->findBy(['iso'=>$this->euCountriesIsoCodes]);
    }

    private function getPayments()
    {
        return $this->em->getRepository(Payment::class)->findAll();
    }

    private function getShippingPrices()
    {
        $threshold1 = new ShippingCost();
        $threshold1->setValue(5)->setFrom(0)->setFactor(0);
        $threshold2 = new ShippingCost();
        $threshold2->setValue(10)->setFrom(11)->setFactor(0);

        return [
            $threshold1,
            $threshold2
        ];
    }
}
