<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
//    comment to end of file
    //#[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    #[Route('/weather/{city}-{country}', name: 'app_weather')]
    public function city(Location $location, ForecastRepository $repository): Response
    {
        $forecasts = $repository->findByLocation($location);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}