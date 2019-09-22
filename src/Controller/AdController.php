<?php
namespace App\Controller;

use App\Entity\Ad;
use App\Exceptions\InvalidStatusException;
use App\Service\CreateAd;
use App\Service\PublishAd;
use App\Utils\jsonResponseTrait;
use Psr\Log\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\Bundle\TestBundle\TestServiceContainer\PublicService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdController extends AbstractController
{
    use jsonResponseTrait;

    /**
     * @Route("/ad/{id}", name="show_ad", methods={"GET"})
     */
    public function show(int $id)
    {
        try {
            $ad = $this->getDoctrine()
                ->getRepository(Ad::class)
                ->find($id);

            if (!$ad) {
                throw $this->createNotFoundException(
                    'No Ad found for id ' . $id
                );
            }

            return $this->jsonOk($ad, Response::HTTP_OK, 'ad');

        } catch (NotFoundHttpException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
    * @Route("/ad", name="ad", methods={"POST"})
    */
    public function create(CreateAd $createAdService, RequestStack $requestStack)
    {
        try {
            $requestContent = json_decode($requestStack->getCurrentRequest()->getContent());

            $ad = $createAdService->invoke($requestContent);

            return $this->jsonOk($ad, Response::HTTP_CREATED, 'ad');

        } catch (InvalidArgumentException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/ad/publish/{id}", name="publish_ad", methods={"PATCH"})
     */
    public function publish($id, PublishAd $publishAd, RequestStack $requestStack)
    {
        try {
            $ad = $this->getDoctrine()
                ->getRepository(Ad::class)
                ->find($id);

            if (!$ad) {
                throw $this->createNotFoundException(
                    'No Ad found for id ' . $id
                );
            }

            if ($ad->getStatus() != Ad::STATUS_STOPPED)
                return $this->jsonError('To publish an Ad, must be ' . Ad::STATUS_STOPPED, Response::HTTP_PRECONDITION_FAILED);

            $publishers = json_decode($requestStack->getCurrentRequest()->getContent());

            $publishAd->invoke($ad, $publishers);

            return $this->jsonOk($ad, Response::HTTP_OK, 'ad');

        } catch (InvalidStatusException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        } catch (NotFoundHttpException $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}