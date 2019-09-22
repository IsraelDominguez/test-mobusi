<?php

namespace App\Service;

use App\AdComponents\AdComponentFactory;
use App\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAd
{
    /**
     * @var Ad
     */
    protected $ad;

    private $logger;
    private $request;

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    public function __construct(RequestStack $requestStack, LoggerInterface $logger, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->request = json_decode($requestStack->getCurrentRequest()->getContent());
        $this->logger = $logger;
        $this->em = $em;
        $this->validator = $validator;
    }

    public function invoke() : Ad
    {
        try {
            // TODO: catch BadRequest Exception
            $this->ad = new Ad();
            $this->ad->setName($this->request->name);
            $this->ad->setStatus(Ad::STATUS_STOPPED);
            $this->ad->setAdvertiser($this->em->getReference('\App\Entity\Advertiser', $this->request->advertiser));
            $components = $this->request->components ?? null;

            if ($components == null)
                throw new InvalidArgumentException('Ads Component is mandatory');

            foreach ($components as $component) {
                $adComponent = AdComponentFactory::create($component->type);

                $adComponent->setEntityFromJson($component);
                $adComponent->setAd($this->ad);

                $errors = $this->validator->validate($adComponent);
                if (count($errors) > 0)
                    throw new InvalidArgumentException((string)$errors);

                $this->ad->addComponent($adComponent);
            }
            $this->em->persist($this->ad);
            $this->em->flush();

            return $this->ad;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new BadRequestHttpException(sprintf($e->getMessage()));
        }
    }

}
