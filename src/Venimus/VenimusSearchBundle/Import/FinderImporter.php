<?php

namespace Venimus\VenimusSearchBundle\Import;

use Symfony\Component\Finder\Finder;
use Venimus\VenimusSearchBundle\Engine\SearchEngineInterface;
use Venimus\VenimusSearchBundle\Factory\IndexableFactoryInterface;
use Venimus\VenimusSearchBundle\Model\FileIndexable;

/**
 * Class FinderImporter
 * Imports a stream (using Symfony Finder) to the provided $engine instance of SearchEngineInterface
 * uses provided $factory to construct instances of IndexableInterface required by the SearchEngineInterface
 *
 * @package Venimus\VenimusSearchBundle\Command
 */
class FinderImporter
{
    /**
     * @var SearchEngineInterface
     */
    private $engine;

    /**
     * Indicates if crawling is recursive
     * @var bool
     */
    private $recursive = false;

    /**
     * FinderImporter constructor.
     * @param SearchEngineInterface $engine
     */
    public function __construct(SearchEngineInterface $engine)
    {

        $this->engine = $engine;
    }

    /**
     * Crawls the streamUri using Symfony Finder component, index each file and returns the total count
     * @param $streamUri
     * @return int $indexed
     */
    public function import($streamUri)
    {
        $finder = new Finder();
        $finder->files()->in((string)$streamUri);

        if (!$this->getRecursive()) {
            $finder->depth('==0');
        }

        $countIndexed = 0;

        foreach ($finder as $file) {
            /* @var \SplFileInfo $file */
            $indexable = new FileIndexable($file->getRealPath());
            $this->engine->index($indexable);
            $countIndexed++;
        };

        $this->engine->flush();

        return $countIndexed;
    }

    /**
     * @return bool
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * Indicates that crawler should be recursive or not
     * @param bool $recursive
     */
    public function setRecursive($recursive)
    {
        $this->recursive = (bool)$recursive;
    }
}
