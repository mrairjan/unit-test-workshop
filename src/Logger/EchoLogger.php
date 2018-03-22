<?php
declare(strict_types=1);

namespace Logger;

class EchoLogger implements LoggerInterface
{
    public function log(string $message)
    {
        echo $message;
    }
}
