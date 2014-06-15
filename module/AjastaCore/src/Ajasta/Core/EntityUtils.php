<?php
namespace Ajasta\Core;

use RuntimeException;

abstract class EntityUtils
{
    /**
     * @param string $allowedCaller
     */
    public static function restrictCaller($allowedCaller)
    {
        $backtrace = debug_backtrace(
            DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT,
            3
        );

        if (!$backtrace[2]['object'] instanceof $allowedCaller) {
            throw new RuntimeException(sprintf(
                '%s::%s may only be called by %s',
                $backtrace[1]['class'],
                $backtrace[1]['function'],
                $allowedCaller
            ));
        }
    }
}
