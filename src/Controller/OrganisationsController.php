<?php

namespace App\Controller;

use App\Entity\Organisations;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganisationsController extends AbstractController
{
    /**
     * Display all Organisations
     * Return JSON if error
     */
    #[Route('/organisations', name: 'app_organisations')]
    public function showAllOrganisations(ManagerRegistry $register): Response
    {
        $organisations = $register->getRepository(Organisations::class)->findAll();

        if (!$organisations) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings find!'
            ], Response::HTTP_NOT_FOUND);
         }
        return $this->render('organisations/organisations.html.twig', [
            'organisations' => $this->organisationDataToJson($organisations),
        ]);
    }

    /**
     * Convert the data to JSON
     */
    protected function organisationDataToJson(array $organisations)
    {
        $result = [];

        foreach ($organisations as $value) {
            $result[] = [
                'id' => $value->getId(),
                'name' => $value->getName(),
            ];
        }
        return $result;
    }
}
