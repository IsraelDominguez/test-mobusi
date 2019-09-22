<?php
namespace App\Controller;

use App\Entity\Ad;
use App\Service\CreateAd;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AdController extends AbstractController
{

    /**
     * @Route("/ad/{id}", name="show_ad", methods={"GET"})
     */
    public function show($id, SerializerInterface $serializer)
    {
        try {

            $ad = $this->getDoctrine()
                ->getRepository(Ad::class)
                ->find($id);

            if (!$ad) {
                throw $this->createNotFoundException(
                    'No Publisher found for id ' . $id
                );
            }

            return $this->json($ad, 200, [], ['groups' => 'api_rest']);
        } catch (NotFoundHttpException $e) {
            return $this->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }

    }

    /**
    * @Route("/ad", name="ad", methods={"GET","POST"})
    */
    public function create(CreateAd $createAdService)
    {
        try {

            $ad = $createAdService->invoke();

            return $this->json($ad, 200, [], ['groups' => 'api_rest']);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }

    }
}