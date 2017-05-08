<?php
namespace Phinx\Migration;

use Phinx\Config\ConfigInterface;
use Phinx\Db\Adapter\AdapterFactory;

class Schema{

    protected static $_config;

    protected static $_adapters = [];

    public static function setConfig(ConfigInterface $config){
        self::$_config = $config;
    }

    public static function getConfig(){
        return self::$_config;
    }

    public static function connection($conn){
        if(!isset(self::$_adapters[$conn])) {
            $dbConfig = self::$_config->getEnvironment($conn);
            if ($dbConfig) {
                $adapter = AdapterFactory::instance()
                    ->getAdapter($dbConfig['adapter'], $dbConfig);
                self::$_adapters[$conn] = $adapter;
                return $adapter;
            }
            return null;
        }
        return self::$_adapters[$conn];
    }
}