<?php
namespace Zhjar;

final class Core
{
    private static $initialized = false;
    private static $configs;

    public static function initializeApplication($config)
    {
        if (!is_array($config)) {
            throw new \Exception("Invalid application config.");
        }

        if (self::$initialized) {
            throw new \Exception("Application is already initialized.");
        }

        /*
        if (PHP_SAPI != "cli" &&
            (!isset($_SERVER["HTTP_HOST"]) || ! preg_match("#^(localhost|192\\.168\\.1\\.\\d+|(\\w+\\.)*v2014\\.dev)$#", $_SERVER["HTTP_HOST"]))
        ) {
            throw new \Exception("Access denied!");
        }

        foreach (array("shop_site_url", "cms_site_url", "microshop_site_url", "circle_site_url", "admin_site_url", "mobile_site_url", "wap_site_url", "chat_site_url", "upload_site_url", "resource_site_url") as $k) {
            if (!isset($config[$k])) {
                throw new \Exception("Invalid config, missing '" . $k . "' config.");
            }
            $v = $config[$k];
            if (!is_string($v) || ! preg_match("#^http://(localhost|192\\.168\\.1\\.\\d+|(\\w+\\.)*v2014\\.dev)#", $v)) {
                throw new \Exception("Invalid config '" . $k . "', access denied.");
            }
        }
         */

        define("InShopNC", true, true);

        define("WEB_SITE_URL", $config["web_site_url"], true);
        define("ADMIN_SITE_URL", $config["admin_site_url"], true);
        define("MOBILE_SITE_URL", $config["mobile_site_url"], true);
        define("WAP_SITE_URL", $config["wap_site_url"], true);
        define("UPLOAD_SITE_URL", $config["upload_site_url"], true);
        define("RESOURCE_SITE_URL", $config["resource_site_url"], true);

        define("NODE_SITE_URL", $config["node_site_url"], true);

        define("MD5_KEY", md5($config["md5_key"]), true);

        define("DEFAULT_PLATFORM_STORE_ID", $config["default_store_id"], true);
        define("URL_MODEL", $config["url_model"], true);
        define("SUBDOMAIN_SUFFIX", $config["subdomain_suffix"], true);

        define("DS", "/", true);
        define("StartTime", microtime(true), true);
        define("TIMESTAMP", time(), true);

        define("LANG_TYPE", $config["lang_type"], true);
        define("SESSION_EXPIRE", $config["session_expire"], true);
        define("COOKIE_PRE", $config["cookie_pre"], true);
        define("CHARSET", $config["db"]["master"]["dbcharset"], true);
        define("TABLEPRE", $config["tablepre"], true);
        define("DBDRIVER", $config["dbdriver"], true);
        define("DBPRE", $config["db"]["master"]["dbname"] . "`.`" . $config["tablepre"], true);

        spl_autoload_register(__CLASS__ . "::autoload");

        $tmpPath = BASE_CORE_PATH . "/framework/function/core.php";
        if (!file_exists($tmpPath)) {
            throw new \Exception("Cannot load core functions.");
        }
        require $tmpPath;

        // ...
        foreach ($config as $k => $v) {
            self::$configs[$k] = $v;
        }

        $setting = H("setting");
        if (!$setting || !is_array($setting)) {
            $setting = H("setting", true);
        }
        if (is_array($setting)) {
            foreach ($setting as $k => $v) {
                if (!isset(self::$configs[$k])) {
                    self::$configs[$k] = $v;
                }
            }
        }

        self::$configs["shopnc_version"] = "<span class=\"vol\"><font class=\"b\">Shop</font><font class=\"o\">NC</font></span>";

        $timeZone = self::getConfig("time_zone");
        if ($timeZone) {
            date_default_timezone_set($timeZone);
        } else {
            date_default_timezone_set("Asia/Shanghai");
        }

        if ($saveHandler = self::$configs["session_type"]) {
            ini_set("session.save_handler", $saveHandler);
        }

        if ($savePath = self::$configs["session_save_path"]) {
            ini_set("session.save_path", $savePath);
        } else {
            session_save_path(BASE_DATA_PATH . "/session");
        }

        session_start();

        Tpl::output("setting_config", self::$configs);
        \Language::read("core_lang_index");

        self::$initialized = true;
    }

    public static function runApplication()
    {
        if (!self::$initialized) {
            throw new \Exception("Application has not been initialized.");
        }

        if (!defined("BASE_PATH")) {
            throw new \Exception("Cannot find 'BASE_PATH' constant in module.");
        }

        $moduleConfigFile = BASE_PATH . "/config/config.ini.php";
        if (file_exists($moduleConfigFile)) {
            $moduleConfig = require $moduleConfigFile;
            if (is_array($moduleConfig)) {
                unset($moduleConfig["shopnc_version"]);
                self::$configs = array_replace_recursive(self::$configs, $moduleConfig);
            }
        }

        $baseControlFile = BASE_PATH . "/control/control.php";
        if (!file_exists($baseControlFile)) {
            throw new \Exception("Cannot load base control classes in module.");
        }
        require $baseControlFile;

        $act = empty($_GET["act"]) ? "index" : $_GET["act"];
        $op = empty($_GET["op"]) ? "index" : $_GET["op"];

        if (self::getConfig("enabled_subdomain") && $act == "index" && $op == "index" && subdomain() > 0) {
            $act = "show_store";
        }

        $actFile = BASE_PATH . "/control/" . $act . ".php";
        if (!file_exists($actFile)) {
            if (self::getConfig("debug")) {
                throw new \Exception("Cannot find act file.");
            }
            showMessage("Sorry, the page you are visiting is not found!", "", "html", "error");
            return;
        }

        require $actFile;
        $actClass = $act . "Control";

        if (!class_exists($actClass, false)) {
            throw new \Exception("Cannot find act class.");
        }

        $actObject = new $actClass();

        $opMethod = $op . "Op";
        if (!method_exists($actObject, $opMethod)) {
            $opMethod = "indexOp";
        }
        if (!method_exists($actObject, $opMethod)) {
            throw new \Exception("Cannot find '" . $op . "' op in '" . $act . "' act.");
        }

        $actObject->$opMethod();
    }

    public static function autoload($className)
    {
        $lc = strtolower($className);
        $len = strlen($lc);

        if ($len > 5 && substr($lc, -5) == "class") {
            $path = BASE_PATH . "/framework/libraries/" . substr($lc, 0, -5) . ".class.php";
            if (!file_exists($path)) {
                throw new \Exception("Class Error: cannot autoload class: " . $className);
            }
            require $path;
            return;
        }

        if ($len > 5 && substr($lc, 0, 5) == "cache") {
            $path = BASE_CORE_PATH . "/framework/cache/cache." . substr($lc, 5) . ".php";
            if (!file_exists($path)) {
                throw new \Exception("Class Error: cannot autoload class: " . $className);
            }
            require $path;
            return;
        }

        if ($lc == "db") {
            $path = BASE_CORE_PATH . "/framework/db/" . strtolower(DBDRIVER) . ".php";
            if (!file_exists($path)) {
                throw new \Exception("Class Error: cannot autoload class: " . $className);
            }
            require $path;
            return;
        }

        $path = BASE_CORE_PATH . "/framework/libraries/" . $lc . ".php";
        if (!file_exists($path)) {
            throw new \Exception("Class Error: cannot autoload class: " . $className);
        }
        require $path;
        return;
    }

    public static function getConfigs()
    {
        return self::$configs;
    }

    public static function getConfig($name)
    {
        if (isset(self::$configs[$name])) {
            return self::$configs[$name];
        }
    }
}
