<?php

namespace App\Controller;

use App\Repository\VinylMixRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinylController extends AbstractController
{

    public function __construct(
        private bool $isDebug,
    )
    {
    }


    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Obaro', 'artist' => 'Dir En Grey'],
            ['song' => 'Ginger', 'artist' => 'Trace'],
        ];

        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, string $slug = null): Response
    {
        $genre = $slug ? str_replace('-', ' ', $slug) : null;

        $mixes = $mixRepository->findAllOrderedByVotes($slug);


        return $this->render('vinyl/browse.html.twig', [
                'genre' => $genre,
                'mixes' => $mixes,
            ]);
    }
}