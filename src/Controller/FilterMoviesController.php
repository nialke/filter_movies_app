<?php

namespace App\Controller;

use App\Service\FilterMoviesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'filter_movies_')]
class FilterMoviesController extends AbstractController
{

    public function __construct(private readonly FilterMoviesService $filterMoviesService)
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return new Response();
    }

    #[Route('/random', name: 'random', methods: 'GET')]
    public function random(): Response
    {
        return new Response(implode('</br>', $this->filterMoviesService->getRandomMovieTitles()));
    }

    #[Route('/firstChar', name: 'first_char', methods: 'GET')]
    public function firstChar(): Response
    {
        return new Response(
            implode('</br>', $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount())
        );
    }

    #[Route('/minimumWord', name: 'minimum_word', methods: 'GET')]
    public function minimumWord(): Response
    {
        return new Response(
            implode('</br>', $this->filterMoviesService->getMoviesWithMinimumWordCount())
        );
    }

}