<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\LocationRepository;
use App\Repository\ForecastRepository;

class WeatherUtil
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly ForecastRepository $forecastRepository,
    )
    {
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        $forecasts = $this->forecastRepository->findByLocation($location);
        return $forecasts;
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if ($location === null) {
            // Obsłuż brak znalezionej lokalizacji, np. rzuć wyjątek lub zwróć pustą tablicę prognoz.
            throw new \Exception('Location not found for country and city.');
        }

        $forecasts = $this->getWeatherForLocation($location);

        return $forecasts;
    }
}