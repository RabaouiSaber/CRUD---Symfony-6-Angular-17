<?php

namespace App\Service;

use App\Entity\Groupe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupeService
{
    private ManagerRegistry $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function create(string $nomGroupe, string $origin, string $ville, float $anneeDebut, float $anneeSeparation, string $fondateurs, int $membres, string $courantMusical, string $presentation)
    {
        $entityManager = $this->doctrine->getManager();
    
        $groupe = new Groupe();
        $groupe->setNomGroupe($nomGroupe);
        $groupe->setOrigine($origin);
        $groupe->setVille($ville);
        $groupe->setanneeDebut($anneeDebut);
        $groupe->setanneeSeparation($anneeSeparation);
        $groupe->setFondateurs($fondateurs);
        $groupe->setMembres($membres);
        $groupe->setCourantMusical($courantMusical);
        $groupe->setpresentation($presentation);

        $entityManager->persist($groupe);
        $entityManager->flush();
        return new JsonResponse(200);
    }

    public function update(Request $request,int $id){
        $entityManager = $this->doctrine->getManager();
        $data = json_decode($request->getContent(), true);
    
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
    
        if (!$groupe) {
            return new JsonResponse('Groupe not found', 404);
        }
    
        $groupe->setNomGroupe($data['nomGroupe']);
        $groupe->setOrigine($data['origine']);
        $groupe->setVille($data['ville']);
        $groupe->setanneeDebut($data['anneeDebut']);
        $groupe->setanneeSeparation($data['anneeSeparation']);
        $groupe->setFondateurs($data['fondateurs']);
        $groupe->setMembres($data['membres']);
        $groupe->setCourantMusical($data['courantMusical']);
        $groupe->setpresentation($data['presentation']);
    
        $entityManager->flush();
    
        return new JsonResponse('Groupe updated successfully', 200);
    }
    
    
    public function delete(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);

        if (!$groupe) {
            return new JsonResponse('Groupe not found', 404);
        }

        $entityManager->remove($groupe);
        $entityManager->flush();
        
        return new JsonResponse('Groupe deleted', 200);
    }
    
    public function getAll()
    {
        $entityManager = $this->doctrine->getManager();
        $GroupeEntities = $entityManager->getRepository(Groupe::class)->findAll();
        
         $groupes = [];
 
         foreach ($GroupeEntities as $groupeEntity) {
             $groupes[] = [
                 'id' => $groupeEntity->getId(),
                 'nomGroupe' => $groupeEntity->getNomGroupe(),
                 'origine' => $groupeEntity->getOrigine(),
                 'ville' => $groupeEntity->getVille(),
                 'anneeDebut' => $groupeEntity->getanneeDebut(),
                 'anneeSeparation' => $groupeEntity->getanneeSeparation(),
                 'fondateurs' => $groupeEntity->getFondateurs(),
                 'membres' => $groupeEntity->getMembres(),
                 'courantMusical' => $groupeEntity->getCourantMusical(),
                 'presentation' => $groupeEntity->getpresentation(),
             ];
         }
 
         $jsonData = json_encode($groupes);
         
         $response = new Response($jsonData);
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
        
    }

    public function getGroupeById(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $groupe = $entityManager->getRepository(Groupe::class)->find($id);
    
        if (!$groupe) {
            return new JsonResponse('Groupe not found', 404);
        } else {
            $groupeArray = [
                'id' => $groupe->getId(),
                'nomGroupe' => $groupe->getNomGroupe(),
                'origine' => $groupe->getOrigine(),
                'ville' => $groupe->getVille(),
                'anneeDebut' => $groupe->getAnneeDebut(),
                'anneeSeparation' => $groupe->getAnneeSeparation(),
                'fondateurs' => $groupe->getFondateurs(),
                'membres' => $groupe->getMembres(),
                'courantMusical' => $groupe->getCourantMusical(),
                'presentation' => $groupe->getPresentation(),
            ];
    
            $jsonGroupe = json_encode($groupeArray);
    
            return new JsonResponse($jsonGroupe, 200, [], true);
        }
    }
}
