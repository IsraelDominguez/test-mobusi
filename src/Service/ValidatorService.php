<?php

namespace App\Service;

use App\AdComponents\AdComponentInterface;
use App\Entity\Ad;
use App\Exceptions\InvalidStatusException;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(AdComponentInterface $component) {
        $this->checkErrors($this->validator->validate($component));
    }

    public function validateAd(Ad $ad) {
        if (count($ad->getComponents()) == 0)
            throw new InvalidArgumentException('Ads Component is mandatory');

        $this->checkErrors($this->validator->validate($ad));
    }

    public function checkAdCanBePublished(Ad $ad) {
        if ($ad->getStatus() != Ad::STATUS_STOPPED)
            throw new InvalidStatusException('Ad must be stopped to Publish');
    }

    private function checkErrors($errors) {
        if (count($errors) > 0)
            throw new InvalidArgumentException((string)$errors);
    }

}