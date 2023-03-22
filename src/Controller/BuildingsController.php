<?php

namespace App\Controller;

use App\Entity\Pieces;
use App\Entity\Buildings;
use App\Entity\Organisations;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BuildingsController extends AbstractController
{
    /**
     * Get all the buildings et pass them in JSON
     * In case of error return a JSON
     */
    #[Route('/buildings', name: 'building_showBuildings')]
    public function showBuildings(ManagerRegistry $doctrine): Response
    {
        $buildings = $doctrine->getRepository(Buildings::class)->findAll();

        if (!$buildings) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'There is no buildings!'
            ], Response::HTTP_NOT_FOUND);
        }

        $data = [];
        foreach ($buildings as $building) {
            $data[] = [
                ['status' => '200'],
                'id' => $building->getId(),
                'name' => $building->getName(),
                'zipcode' => $building->getZipcode(),
            ];
        }
        return new JsonResponse($data);
    }

    /**
     * Get the building choose && add the room avalaibable for this building
     * with the number of people inside to JSON
     * In case of error return also a JSON
     */
    #[Route('/building/{id}/rooms', name: 'building_roomInBulding')]
    public function infoBuilding(ManagerRegistry $doctrine, int $id) : Response
    {
        $pieces = $doctrine->getRepository(Pieces::class)->findBy(['b_id' => $id]);
        
        if (!$pieces) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'Cant find the room for this id!'
            ], Response::HTTP_NOT_FOUND);
        }
        $building = $doctrine->getRepository(Buildings::class)->find($id);

        if (!$building) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings for this id!'
            ], Response::HTTP_NOT_FOUND);
        }

        $buildingData = [
            ['status' => '200'],
            'id' => $building->getId(),
            'name' => $building->getName(),
            'zipcode' => $building->getZipcode(),
            'o_id' => $building->getOId(),
            'rooms' => []
        ];
        foreach ($pieces as $piece) {
            $buildingData['rooms'][] = [
                'id' => $piece->getId(),
                'name' => $piece->getName(),
                'personnes_presentes' => $piece->getPeople()
            ];
        }
        return new JsonResponse($buildingData);
    }

    /**
     * Display the Building who belong to a particular organisation
     */
    #[Route('/organisation/{idOrganisation}/buildings', name: 'building_buildingsFromOrganisation')]
    public function showBuildingsFromOrganisation(int $idOrganisation) : Response {
        return $this->render('buildings/buildingsOrganisation.html.twig', ['id' => $idOrganisation]);
    }

    /**
     * Get the data & transform then into JSON
     * Display the Building who belong to a particular organisation
     */
    #[Route('/organisation/{idOrganisation}/buildingsJSON', name: 'building_buildingsFromOrganisationJSON')]
    public function setBuildingsFromOrganisationJSON(ManagerRegistry $entity, int $idOrganisation) : Response {
        $organisationBuildings = $entity->getRepository(Buildings::class)->findBy(['o_id' => $idOrganisation]);

        if (!$organisationBuildings) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings find!'
            ], Response::HTTP_NOT_FOUND);
        }
        $organisationName = $entity->getRepository(Organisations::class)->find($idOrganisation);
        
        if (!$organisationName) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings find!'
            ], Response::HTTP_NOT_FOUND);
        }
        foreach ($organisationBuildings as $data) {
            $array[] = [
                ['status' => '200'],
                'id' => $data->getId(),
                'name' => $data->getName(),
                'zipcode' => $data->getZipcode(),
                'o_id' => $idOrganisation,
                'nameOrganisation' => $organisationName->getName(),
                'rooms' => []
            ];
        }
        return new JsonResponse($array);
    }
}
