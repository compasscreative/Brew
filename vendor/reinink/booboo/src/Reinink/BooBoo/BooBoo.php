<?php

namespace Reinink\BooBoo;

use \ErrorException;
use Psr\Log\LoggerInterface;

class BooBoo
{
    private static $instance;
    public $callback;
    public $logger;

    private function __construct()
    {
    }

    public static function setup($callback = false, LoggerInterface $logger = null)
    {
        // Create instance
        self::$instance = new BooBoo();
        self::$instance->callback = $callback;
        self::$instance->logger = $logger;

        // Set handlers
        set_exception_handler(array(self::$instance, 'exception'));
        set_error_handler(array(self::$instance, 'native'));
        register_shutdown_function(array(self::$instance, 'shutdown'));

        // Report all errors
        error_reporting(-1);
    }

    public function exception($exception)
    {
        ob_get_level() and ob_end_clean();

        if (!is_null($this->logger)) {
            $this->logger->critical(
                $exception->getMessage(),
                array(
                    'Message' => $exception->getMessage(),
                    'File' => $exception->getFile(),
                    'Line' => $exception->getLine()
                )
            );
        }

        if (is_callable($this->callback)) {
            call_user_func_array($this->callback, array($exception));
        }
    }

    public function native($code, $error, $file, $line)
    {
        $this->exception(new ErrorException($error, $code, 0, $file, $line));
    }

    public function shutdown()
    {
        if ($error = error_get_last()) {
            extract($error, EXTR_SKIP);

            $this->exception(new ErrorException($message, $type, 0, $file, $line));
        }
    }
}
