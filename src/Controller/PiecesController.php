<?php

namespace App\Controller;

use App\Entity\Pieces;
use App\Entity\Buildings;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PiecesController extends AbstractController
{
    /**
     * Transform data to JSON data
     */
    protected function piecesJson(array $pieces, object $building)
    {
        $array = [];

        foreach ($pieces as $data) {
            $array[] = [
                ['sucess' => 200],
                'id' => $data->getId(),
                'name' => $data->getName(),
                'people' => $data->getPeople(),
                'b_id' => $data->getBId(),
                'nameBuilding' => $building->getName()
            ];
        }
        return new JsonResponse($array);
    }

    /**
     * Display the room inside the building in JSON format
    */
    #[Route('/organisation/{id}/building/{idBuilding}/piecesJSON', name: 'piece_showPieceInBuildingJSON')]
    public function getPiecesInBuilding(ManagerRegistry $entity, int $idBuilding)
    {
        $pieces = $entity->getRepository(Pieces::class)->findBy(['b_id' => $idBuilding]);

        if (!$pieces) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings find!'
            ], Response::HTTP_NOT_FOUND);
        }
        $buildingName = $entity->getRepository(Buildings::class)->find($idBuilding);

        if (!$buildingName) {
            return new JsonResponse([
                'status' => "400",
                'error' => 'No Buildings find!'
            ], Response::HTTP_NOT_FOUND);
        }
        return $this->piecesJson($pieces, $buildingName);
    }

    /**
     * Display the rooms inside one of the building
     */
    #[Route('organisation/{id}/building/{idBuilding}/pieces', name: 'piece_showPieceInBuilding')]
    public function showPiecesFromBuilding(): Response
    {
        return $this->render('pieces/pieces.html.twig');
    }
}
