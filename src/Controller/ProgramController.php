<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class ProgramController extends AbstractController
{
    /**
     * @Route("/programs", name="program_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        return $this->render('program/index.html.twig',
            ['programs' => $programs]
        );
    }
    /**
     * @Route("/show/{id}", name="program_show")
     */
    public function show(Program $program): Response
    {
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findAll();

        if (!$seasons) {
            throw $this->createNotFoundException(
                'No season with id : '.$program.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }
    /**
     * @Route("/programs/{programId}/seasons/{seasonId}", name="program_season_show")
     */
    public function seasonShow(int $programId, int $seasonId): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id'=>$seasonId]);
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id'=>$programId]);
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season'=>$season]);

        return $this->render('program/season_show.html.twig',
        [
            'program'=>$program,
            'season'=>$season,
            'episodes'=>$episodes
        ]);
    }

}