<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\InputFilter\User;

use Assert\Assertion;
use Zend\Filter\FilterInterface;
use Zend\Validator\ValidatorInterface;

abstract class AbstractInputFilter
{
    /**
     * @var array
     */
    private $inputs = [];

    final protected function addInput(string $name, bool $required, array $filters, array $validators)
    {
        $this->inputs[$name] = [
            'required' => $required,
            'filters' => $filters,
            'validators' => $validators,
        ];
    }

    final public function filter(array $data) : InputFilterResult
    {
        $filteredValues = [];

        foreach ($this->inputs as $name => $input) {
            if (!array_key_exists($name, $data)) {
                if ($input['required']) {
                    // Missing value
                    continue;
                }

                $value = '';
            } else {
                $value = $data[$name];
            }

            foreach ($input['filters'] as $filter) {
                /* @var $filter FilterInterface */
                Assertion::isInstanceOf($filter, FilterInterface::class);
                $value = $filter->filter($value);
            }

            foreach ($input['validators'] as $validator) {
                /* @var $validator ValidatorInterface */
                Assertion::isInstanceOf($filter, ValidatorInterface::class);

                if (!$validator->isValid($value)) {
                    // General error
                    continue;
                }
            }
        }
    }
}
