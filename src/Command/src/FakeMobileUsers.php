<?php

namespace Command;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeMobileUsers extends Command
{
    private ClientInterface $client;

    public function __construct(string $name = null, ClientInterface $client)
    {
        parent::__construct($name);
        $this->client = $client;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hey! Works');

        return 0;
    }
}