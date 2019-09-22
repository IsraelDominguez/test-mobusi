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
    * @Route("/publisher", name="publisher")
    */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $publisher = new Publisher();
        $publisher->setName('Antonio');
        $entityManager->persist($publisher);
        $entityManager->flush();

        return new Response('Saved new Publisher with id '.$publisher->getId());

    }

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

            return $this->jsonOk($publisher, Response::HTTP_OK, 'publisher');

        } catch (NotFoundHttpException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}