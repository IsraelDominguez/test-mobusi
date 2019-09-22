<?php

namespace App\Service;

use App\Entity\Ad;
use App\Exceptions\InvalidStatusException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PublishAd
{
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

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, ValidatorService $validator)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * Json string decoded, from body content in an api request for example
     *
     * @param Ad $ad
     * @param $requestContent mixed|Object lists of ids of Publishers
     * @return Ad
     * @throws InvalidStatusException
     */
    public function invoke(Ad $ad, $publishers) : Ad
    {
        try {
            $this->validator->checkAdCanBePublished($ad);

            $publishers = $publishers->publishers ?? [];
            foreach ($publishers as $publisher) {
                $ad->addPublisher($this->em->getReference('\App\Entity\Publisher', $publisher->id));
            }
            //TODO: is necessary a PublishedAt Field
            $ad->setUpdatedAt(new \DateTime("now"));
            $ad->setStatus(Ad::STATUS_PUBLISHED);

            $this->em->persist($ad);
            $this->em->flush();

            return $ad;
        } catch (InvalidStatusException $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new BadRequestHttpException(sprintf($e->getMessage()));
        }
    }
}
