<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Service\GroupeService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class XlsController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private GroupeService $groupeService;
    public function __construct(ManagerRegistry $doctrine,GroupeService $groupeService)
    {
        $this->doctrine = $doctrine;
        $this->groupeService = $groupeService;
    }
     
    #[Route("/upload", name:"xlsx", methods: ["POST","OPTIONS"])]
    public function upload(Request $request): Response
    {
        $file = $request->files->get('file');
        $fileFolder = $this->getParameter('kernel.project_dir') . '/public/uploads/'; 
        $filePathName = md5(uniqid()) . '.' . $file->getClientOriginalExtension(); 
        
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            return $this->json('file not registered', 400); 
        }
       
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); 
        $spreadsheet->getActiveSheet()->removeRow(1); 
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); 
        
        foreach ($sheetData as $Row) 
        { 
                $nomGroupe = $Row['A'];  
                $origine = $Row['B']; 
                $ville= $Row['C'];     
                $anneeDebut =(float) $Row['D'];
                $anneeSeparation = (float) $Row['E'];
                $fondateurs = $Row['F'];
                $membres = (int) $Row['G'];
                $courantMusical = $Row['H'];
                $presentation = $Row['I'];
                $this->groupeService->create(strval($nomGroupe),strval($origine),strval($ville),$anneeDebut,$anneeSeparation,strval($fondateurs),$membres,strval($courantMusical),strval($presentation));
        }
        return $this->json('Groupe enregistré', 200); 
}
}
