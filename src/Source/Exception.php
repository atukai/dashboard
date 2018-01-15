<?php

namespace Gridly\Source;

class Exception extends \Gridly\Exception
{
    /**
     * @return Exception
     */
    public static function sourceClassNotProvided(): Exception
    {
        return new self(sprintf('Source class was not provided.'));
    }
    
    /**
     * @param string $className
     * @return Exception
     */
    public static function unsupportedSourceClass(string $className): Exception
    {
        return new self(sprintf('Unknown source class "%s".', $className));
    }
}
