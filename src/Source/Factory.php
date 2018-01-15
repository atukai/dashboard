<?php

namespace Gridly\Source;

class Factory
{
    /**
     * @param array $config
     * @return Source
     * @throws Exception
     */
    public static function create(array $config): Source
    {
        if (!isset($config['type'])) {
            throw Exception::sourceClassNotProvided();
        }
        
        switch ($config['type']) {
            case Pdo::class:
                $source = new Pdo(
                    new \PDO(
                        $config['dsn'],
                        $config['username'],
                        $config['password']
                    ),
                    $config['table']
                );
                break;
            default:
                throw Exception::unsupportedSourceClass($config['type']);
        }
        
        return $source;
    }
}
