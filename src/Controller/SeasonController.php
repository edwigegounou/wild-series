<?php


namespace App\Controller;


use App\Entity\Season;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    /**
     * @Route ("/seasons", name="season_index")
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('season/index.html.twig',
        ['seasons' => $seasonRepository->findAll()]
        );
    }

    /**
     * @Route ("/seasons", name="season_show")
     */
    public function show(int $id): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);
    }
}