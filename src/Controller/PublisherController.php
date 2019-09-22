<?php
namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Publisher;
use App\Service\CreateAd;
use App\Utils\jsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PublisherController extends AbstractController
{
    use jsonResponseTrait;

    /**
     * @Route("/publisher/{id}", name="show_publisher", methods={"GET"})
     */
    public function show(int $id)
    {
        try {
            $publisher = $this->getDoctrine()
                ->getRepository(Publisher::class)
                ->find($id);

            if (!$publisher) {
                throw $this->createNotFoundException(
                    'No Publisher found for id ' . $id
                );
            }

            return $this->jsonOk($publisher, Response::HTTP_OK);

        } catch (NotFoundHttpException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}