<?php
namespace App\Controller;

use App\Entity\Advertiser;
use App\Entity\Publisher;
use App\Service\CreateAd;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AdvertiserController extends AbstractController
{


    /**
     * @Route("/advertiser/{id}", name="show_advertiser")
     */
    public function show($id, SerializerInterface $serializer)
    {
        $advertiser = $this->getDoctrine()
            ->getRepository(Advertiser::class)
            ->find($id);

        if (!$advertiser) {
            throw $this->createNotFoundException(
                'No Advertiser found for id '.$id
            );
        }

        return $this->json($advertiser, 200, [], ['groups' => 'api_rest']);
    }
}