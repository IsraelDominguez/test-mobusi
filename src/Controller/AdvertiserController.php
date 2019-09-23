<?php
namespace App\Controller;

use App\Entity\Advertiser;
use App\Entity\Publisher;
use App\Service\CreateAd;
use App\Utils\jsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AdvertiserController extends AbstractController
{

    use jsonResponseTrait;

    /**
     * @Route("/advertiser/{id}", name="show_advertisher", methods={"GET"})
     */
    public function show(int $id)
    {
        try {
            $entity = $this->getDoctrine()
                ->getRepository(Advertiser::class)
                ->find($id);

            if (!$entity) {
                throw $this->createNotFoundException(
                    'No Advertiser found for id ' . $id
                );
            }

            return $this->jsonOk($entity, Response::HTTP_OK);

        } catch (NotFoundHttpException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}