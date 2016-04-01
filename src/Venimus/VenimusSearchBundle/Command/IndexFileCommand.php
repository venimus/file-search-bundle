<?php

namespace Venimus\VenimusSearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Venimus\VenimusSearchBundle\Model\FileIndexable;

class IndexFileCommand extends ContainerAwareCommand
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var \Venimus\VenimusSearchBundle\Engine\SearchEngineInterface $index */
        $engine = $this->getContainer()->get('venimus.search.engine');

        $file = new \SplFileInfo($input->getArgument('filename'));
        if (!$file->isFile() || !$file->isReadable()) {
            throw new RuntimeException(sprintf('File is unreadable <info>%s</info>', $file->getRealPath()));
        }

        $indexable = new FileIndexable($file->getRealPath());

        $engine->index($indexable);

        $engine->flush();

        $output->writeln(sprintf('Indexed <info>%s</info>', $file->getRealPath()));
    }

    protected function configure()
    {
        $this
            ->setName('venimus:engine:file')
            ->setDescription('Indexes a single <filename>')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'filename to add to the engine'
            );
    }
}
