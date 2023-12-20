<?php

namespace App\Controller;
use App\Entity\Groupe;
use App\Service\GroupeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class GroupeController extends AbstractController
{
    private GroupeService $groupeService;
    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }


    #[Route('/groupes/all', name: 'groupe_all', methods: ["GET","OPTIONS"])]
    public function getAll()
    {
       $groupes= $this->groupeService->getAll();
       return $groupes;
    }


    #[Route('/groupes/getOne/{id}', name: 'groupe_getOne', methods: ["GET","OPTIONS"])]
    public function getBandById($id)
    {
        $groupe= $this->groupeService->getGroupeById($id);
        return $groupe;
    }


    #[Route('/groupes/update/{id}', name: 'groupe_update', methods: ["POST","OPTIONS"])]
    public function update(Request $request,$id)
    {
        $groupes = $this->groupeService->update( $request,$id);
        return $groupes;
    }


    #[Route('/groupes/delete/{id}', name: 'groupe_delete', methods: ["OPTIONS","DELETE"])]
    public function delete(int $id)
    {
        $deleted = $this->groupeService->delete($id);

        if (!$deleted) {
            return new JsonResponse('Groupe not found', 404);
        }

        return new JsonResponse('Groupe deleted successfully', 200);
    }
}
