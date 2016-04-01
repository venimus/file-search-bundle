# file-search-bundle
Demo Application that implementing searchable index for files

Bundle contains Search Engine and two Index storages (Doctrine and Memory)

Search Engine is a bridge class that implements \Venimus\VenimusSearchBundle\Engine\SearchInterface
which separates the storage interface from the public one.

Default (application wide) storage could be switched in app/services.yml by setting it to the 
'venimus.search.storage' alias

```
services:
  venimus.search.storage: '@venimus.search.storage.doctrine'
```

Could be switched to '@venimus.search.storage.memory'

# Interfaces

Bundle can be extended with other implemented storages which should be reigstered as services and set to the alias.
Storages should implement \Venimus\VenimusSearchBundle\Engine\Storage\StorageInterface.

E.g. to extend with a ElasticSearch storage you need to a class ElasticSearchStorage that implements StorageInterface.

All classes depend on interfaces so each part of it could be extended in similar fashion.

Search returns instances of ResultSetInterface that also could be extended.

To be changed, an instance of ResultSetFactoryInterface should be passed to its constructor.
This factory by default is `Factory\KeyResultSet` which builds result set from the keys of the array returned
by the storage's getMatching() method.

Search exposes several methods to be used by clients:

for managing the index storage:
```
SearchEngineInterface::index(IndexableInterface) // index one Indexable
SearchEngineInterface::remove(IndexableInterface) // unindex one Indexable
SearchEngineInterface::flush() // Inform the Storage that it can flush the changes
```

for searching the indexed data
```
SearchEngineInterface::search()
```

Doctrine index has a Auto-flush feature that is controlled in app/config
from the key `venimus_venimus_search.auto_flush_every`.
To turn off the feature set it to 0 (false).

There are also some parameters which further control the current implementation of the Search engine

```
parameters:
  venimus.search.engine.class: 'Venimus\VenimusSearchBundle\Engine\Search'
  venimus.search.resultset_factory.class: 'Venimus\VenimusSearchBundle\Factory\IdentifiersResultSetFactory'
  venimus.search.storage.doctrine.entity_class: 'Venimus\VenimusSearchBundle\Entity\Index'
```

# Setup Doctrine index

To run the commands with Doctrine index the database should be prepared with `php bin/console doctrine:schema:update`.
It will create a table for the default class_class Venimus\VenimusSearchBundle\Entity\Index
with the metadata defined in the bundle's Resources\config\doctrine.

To turn off the default creation you can set the config option `doctrine.orm.auto_mapping` to false and add manual
mapping.

There is also a config option (in app/config.yml) that can control the auto-flush functionality of the Doctrine storage.

To set up which Entity is used from Doctrine storage change the parameter `venimus.search.storage.doctrine.entity_class`

The new Entity should have a Repository that implements SearchInterface 
or that simply extends \Venimus\VenimusSearchBundle\Engine\Storage\Doctrine (not recommended)

Note: All this should be made better configurable using the Bundle configuration and a CompilerPass.

You can specify different entity class by changing the parameter `venimus.search.storage.doctrine.entity_class`

Application contains a client part that includes console commands in the venimus namespace
for indexing single file or import a directory (URI) into the default storage along with a search.

There is also a command `venimus:search` which implements Search engine with Memory Storage
(which indexes and directly searches)

Note: Bundle is not shippable (needs cleanup of composer dependancies and export only the Bundle part)
It also includes only small set of unittests.

