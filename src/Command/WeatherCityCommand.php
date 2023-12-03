<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Displays forecasts for city in country',
)]
class WeatherCityCommand extends Command
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil $weatherUtil,
        string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country_code', InputArgument::REQUIRED, 'Country code [eg. PL]')
            ->addArgument('city_name', InputArgument::REQUIRED, 'City name [eg. Szczecin]')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('country_code');
        $cityName = $input->getArgument('city_name');

        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $cityName,
        ]);

        $forecasts = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Location: %s', $location->getCity()));
        foreach ($forecasts as $forecast) {
            $io->writeln(sprintf("\t%s: %s°C, %s km/h %s, opady: %s ml, %s",
                $forecast->getTime()->format('Y-m-d'),
                $forecast->getTemperature(),
                $forecast->getWindspeed(),
                $forecast->getWinddirection(),
                $forecast->getRain(),
                $forecast->getDescription()
            ));
        }

        return Command::SUCCESS;
    }
}
