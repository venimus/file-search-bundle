<?php

namespace Venimus\VenimusSearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Venimus\VenimusSearchBundle\Engine\Search;
use Venimus\VenimusSearchBundle\Engine\Storage\Memory;
use Venimus\VenimusSearchBundle\Factory\FileIndexableFactory;
use Venimus\VenimusSearchBundle\Factory\IdentifiersResultSetFactory;
use Venimus\VenimusSearchBundle\Import\FinderImporter;
use Venimus\VenimusSearchBundle\Query\PlainTextQuery;

/**
 * Class SearchCommand
 * Demonstrates simple search engine implementation using Memory Storage
 * Constructs Search Engine indexes the URI path, performs search by content and dump filenames found
 *
 * @package Venimus\VenimusSearchBundle\Command
 */
class SearchCommand extends ContainerAwareCommand
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $storage = new Memory();
        $resultSetFactory = new IdentifiersResultSetFactory();
        $engine = new Search($storage, $resultSetFactory);
        $importer = new FinderImporter($engine);

        $importer->setRecursive($input->getOption('recursive'));

        $indexedCount = $importer->import($input->getArgument('uri'));

        $query = new PlainTextQuery($input->getArgument('text'));

        $results = $engine->search($query);

        $output->writeln(sprintf('Indexed <info>%s</info> files', $indexedCount));

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
            ->setName('venimus:search')
            ->setDescription('Indexes <uri> and dumps the filenames containing <string>. Uses a MemorySearchEngine.')
            ->addArgument(
                'uri',
                InputArgument::REQUIRED,
                'Stream URI (i.e. directory) to engine. Finder::in() compatible.' . PHP_EOL .
                'e.g. <info>/home/data</info> or <info>ftp://some.ftp</info>' . PHP_EOL
            )
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
