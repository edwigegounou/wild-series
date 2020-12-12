<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }
    /**
     * @Route("/programs/{program_id}/seasons/{season_id}", name="program_season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     */
    public function seasonShow(Program $program, Season $season): Response
    {
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
    /**
     * @Route("/programs/{program_id}/seasons/{season_id}/episodes/{episode_id}", name="program_episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     * @ParamConverter ("episode", class="App\Entity\Episode", options={"mapping": {"episode_id": "id"}})
     */

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render ('program/episode_show.html.twig',
        [
            'program'=>$program,
            'season'=>$season,
            'episode'=>$episode
        ]);
    }
}