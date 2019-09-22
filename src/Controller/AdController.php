<?php
namespace App\Controller;

use App\Entity\Ad;
use App\Service\CreateAd;
use Psr\Log\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdController extends AbstractController
{

    /**
     * @Route("/ad/{id}", name="show_ad", methods={"GET"})
     */
    public function show($id)
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
            return $this->json($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
    * @Route("/ad", name="ad", methods={"GET","POST"})
    */
    public function create(CreateAd $createAdService, RequestStack $requestStack)
    {
        try {
            $requestContent = json_decode($requestStack->getCurrentRequest()->getContent());

            $ad = $createAdService->invoke($requestContent);

            return $this->json($ad, Response::HTTP_CREATED, [], ['groups' => 'api_rest']);

        } catch (InvalidArgumentException $e) {
            return $this->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}