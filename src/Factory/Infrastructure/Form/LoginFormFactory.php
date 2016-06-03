<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Form;

use Ajasta\Infrastructure\FormData\LoginFormData;
use DASPRiD\Formidable\Form;
use DASPRiD\Formidable\Mapping\FieldMappingFactory;
use DASPRiD\Formidable\Mapping\ObjectMapping;
use Interop\Container\ContainerInterface;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Form(new ObjectMapping([
            'username' => FieldMappingFactory::text(1),
            'password' => FieldMappingFactory::text(1),
            'stayLoggedIn' => FieldMappingFactory::boolean(),
        ], LoginFormData::class));
    }
}
