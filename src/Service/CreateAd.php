<?php

namespace App\Service;

use App\AdComponents\AdComponentFactory;
use App\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateAd
{
    /**
     * @var Ad
     */
    protected $ad;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var ValidatorService $validator
     */
    private $validator;

    public function __construct(RequestStack $requestStack, LoggerInterface $logger, EntityManagerInterface $em, ValidatorService $validator)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * Json string decoded, from body content in an api request for example
     *
     * @param mixed|object $requestContent
     * @return Ad
     */
    public function invoke($requestContent) : Ad
    {
        try {
            $this->ad = new Ad();
            $this->ad->setName($requestContent->name);
            $this->ad->setStatus(Ad::STATUS_STOPPED);
            $this->ad->setAdvertiser($this->em->getReference('\App\Entity\Advertiser', $requestContent->advertiser));
            $components = $requestContent->components ?? [];

            foreach ($components as $component) {
                $adComponent = AdComponentFactory::create($component->type);

                $adComponent->setEntityFromJson($component);
                $adComponent->setAd($this->ad);

                $this->validator->validate($adComponent);

                $this->ad->addComponent($adComponent);
            }

            $this->validator->validateAd($this->ad);

            $this->em->persist($this->ad);
            $this->em->flush();

            return $this->ad;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new BadRequestHttpException(sprintf($e->getMessage()));
        }
    }

}
