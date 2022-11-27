<?php

namespace Command;

use GuzzleHttp\ClientInterface;
use Scooter\Entities\Status;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FakeMobileUsers extends Command
{
    private const USER_REST_TIME_IN_SECONDS_BETWEEN_TRIPS = 5;
    private const SCOOTER_POSITION_UPDATE_IN_SECONDS = 3;

    private ClientInterface $client;

    public function __construct(string $name = null, ClientInterface $client)
    {
        parent::__construct($name);
        $this->client = $client;

        $this->addOption(name: 'user-id', mode: InputOption::VALUE_OPTIONAL);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $mobileUserId = $input->getOption('user-id') ?: 1;
        $mobileUser   = [
            'lat' => 48.14512148225868,
            'lon' => 11.481291644976924
        ];

        while (true) {
            $response = $this->client->request(
                'GET',
                sprintf(
                    'http://localhost:8080/api/scooters/nearby?latitude=%s&longitude=%s',
                    $mobileUser['lat'],
                    $mobileUser['lon']
                ),
                [
                    'auth' => [
                        'mobile',
                        'oZq!63ydPHB0'
                    ]
                ]
            );

            $scooters = json_decode($response->getBody()->getContents(), true);

            if (!($scooters['result'] ?? [])) {
                $output->writeln('<error>No scooter nearby, sorry.</error>');
                return 0;
            }

            /**
             * Whenever user finds a scooter, get close to it and
             * then normally scans to start the ride. Then a new even
             * to update the history of the scooter will be triggered
             */

            $randomScooterId = array_rand($scooters['result'] ?? []);

            if (!isset($scooters['result'][$randomScooterId])) {
                $output->writeln('<error>No scooter nearby, sorry.</error>');
                return 0;
            }

            $chosenScooter = $scooters['result'][$randomScooterId];

            $this->updateScooterHistory(
                $chosenScooter['latitude'],
                $chosenScooter['longitude'],
                $mobileUserId,
                $chosenScooter['scooter_id'],
                Status::OCCUPIED,
            );

            $output->writeln(
                sprintf(
                    '<info>User %d has taken the scooter %d at %s, %s.</info>',
                    $mobileUserId,
                    $chosenScooter['scooter_id'],
                    $chosenScooter['latitude'],
                    $chosenScooter['longitude'],
                )
            );

            $newLatitude = $chosenScooter['latitude'];

            for ($i = 0; $i < 3; $i++) {
                sleep(self::SCOOTER_POSITION_UPDATE_IN_SECONDS);

                $newLatitude = $this->moveScooter($newLatitude);

                $this->updateScooterHistory(
                    $newLatitude,
                    $chosenScooter['longitude'],
                    $mobileUserId,
                    $chosenScooter['scooter_id'],
                    Status::OCCUPIED,
                );

                $output->writeln(
                    sprintf(
                        '<info>User %d is updating scooter %d location at %s, %s.</info>',
                        $mobileUserId,
                        $chosenScooter['scooter_id'],
                        $newLatitude,
                        $chosenScooter['longitude'],
                    )
                );

                $mobileUser['lat'] = $newLatitude;
            }

            $this->updateScooterHistory(
                $newLatitude,
                $chosenScooter['longitude'],
                $mobileUserId,
                $chosenScooter['scooter_id'],
                Status::FREE,
            );

            $output->writeln(
                sprintf(
                    '<info>User %d finished his trip with scooter %d at %s, %s. Resting a bit now...</info>',
                    $mobileUserId,
                    $chosenScooter['scooter_id'],
                    $newLatitude,
                    $chosenScooter['longitude'],
                )
            );

            sleep(self::USER_REST_TIME_IN_SECONDS_BETWEEN_TRIPS);

            $output->writeln(sprintf('<info>User %d is ready for another trip!</info>', $mobileUserId));
        }
    }

    private function updateScooterHistory(
        float $scooterLatitude,
        float $scooterLongitude,
        int $mobileUserId,
        int $scooterId,
        Status $status,
    ): void {
        $this->client->request(
            'POST',
            sprintf('http://localhost:8080/api/scooter/%d/history', $scooterId),
            [
                'auth' => [
                    'mobile',
                    'oZq!63ydPHB0'
                ],
                'json' => [
                    'latitude' => $scooterLatitude,
                    'longitude' => $scooterLongitude,
                    'userId' => $mobileUserId,
                    'status' => $status->value,
                    'scooterId' => $scooterId,
                ]
            ]
        );
    }

    private function moveScooter(float $currentLatitude): float
    {
        $earth = 6378.137; //radius of the earth in kilometer
        $pi = pi();
        $oneMeterInDegree = (1 / ((2 * $pi / 360) * $earth)) / 1000;  //1 meter in degree

        $directions      = ['forward', 'backward'];
        $movingDirection = array_rand($directions);

        $meters = 3;

        if ($directions[$movingDirection] === 'forward') {
            $newLatitude = $currentLatitude + ($meters * $oneMeterInDegree);
            return $newLatitude;
        }

        $newLatitude = $currentLatitude - ($meters * $oneMeterInDegree);

        return $newLatitude;
    }
}
