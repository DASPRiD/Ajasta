<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\Project;

use Ajasta\Domain\Project\ProjectId;
use Ajasta\Infrastructure\Doctrine\Type\AbstractIdType;

class ProjectIdType extends AbstractIdType
{
    /**
     * {@inheritdoc}
     */
    protected function getIdClassName() : string
    {
        return ProjectId::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta.Project.ProjectId';
    }
}
