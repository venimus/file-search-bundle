<?php

namespace Venimus\VenimusSearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Venimus\VenimusSearchBundle\Import\FinderImporter;

class IndexImportCommand extends ContainerAwareCommand
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var \Venimus\VenimusSearchBundle\Engine\Search $engine */
        $engine = $this->getContainer()->get('venimus.search.engine');

        $importer = new FinderImporter($engine);

        $importer->setRecursive($input->getOption('recursive'));

        $indexedCount = $importer->import($input->getArgument('uri'));

        $output->writeln(sprintf('Indexed <info>%s</info> files', $indexedCount));
    }

    protected function configure()
    {
        $this
            ->setName('venimus:engine:import')
            ->setDescription('Indexes all files of <uri>.')
            ->addArgument(
                'uri',
                InputArgument::REQUIRED,
                'Stream URI (i.e. directory) to engine. Finder::in() compatible.' . PHP_EOL .
                'e.g. <info>/home/data</info> or <info>ftp://some.ftp</info>' . PHP_EOL
            )
            ->addOption(
                'recursive',
                'r',
                InputOption::VALUE_NONE,
                'Scan recursively',
                null
            );
    }
}
