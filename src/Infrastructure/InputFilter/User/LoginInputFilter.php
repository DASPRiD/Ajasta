<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\InputFilter\User;

use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;

class LoginInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
        ], 'username');

        $this->add([
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
        ], 'password');
    }
}
