<?php

namespace Kaliop\eZMigrationBundle\Core\ReferenceResolver;

use \eZ\Publish\API\Repository\Repository;

/**
 * Handle references to content remote Id's.
 */
class ContentResolver extends AbstractResolver
{
    /**
     * Constant defining the prefix for all reference identifier strings in definitions
     */
    protected $referencePrefixes = array('content_remote_id::'/*, 'content_id::'*/);

    protected $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param $stringIdentifier format: content_remote_id::<remote_id>
     * @return string Content id
     * @throws \Exception
     */
    public function getReferenceValue($stringIdentifier)
    {
        $ref = $this->getReferenceIdentifierByPrefix($stringIdentifier);
        switch($ref['prefix']) {
            case 'content_remote_id:':
                return $this->repository->getContentService()->loadContentByRemoteId($ref['identifier'])->id;
            //case 'content_id::':
            //    return $this->repository->getLocationService()->loadContent($ref['identifier']);
        }
    }
}
