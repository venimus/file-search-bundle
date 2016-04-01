<?php

namespace Venimus\VenimusSearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Venimus\VenimusSearchBundle\Query\PlainTextQuery;

class IndexSearchCommand extends ContainerAwareCommand
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var \Venimus\VenimusSearchBundle\Engine\Search $engine */
        $engine = $this->getContainer()->get('venimus.search.engine');

        $query = new PlainTextQuery($input->getArgument('text'));

        $results = $engine->search($query);

        if ($input->getOption('count')) {
            $output->writeln($results->count(), OutputInterface::VERBOSITY_QUIET);

            return;
        }

        $output->writeln(sprintf('Found <info>%s</info> results', $results->count()));
        $output->writeln($results->getIterator(), OutputInterface::VERBOSITY_QUIET);
    }

    protected function configure()
    {
        $this
            ->setName('venimus:engine:search')
            ->setDescription('Search engine for files containing <string>')
            ->addArgument(
                'text',
                InputArgument::REQUIRED,
                'Search string'
            )
            ->addOption(
                'recursive',
                'r',
                InputOption::VALUE_NONE,
                'Scan recursively',
                null
            )
            ->addOption(
                'count',
                'c',
                InputOption::VALUE_NONE,
                'Show count of results instead of filenames',
                null
            );
    }
}
