<?php
/**
 * @copyright C UAB "NFQ Solutions" 2018
 *
 * This Software is the property of "Net Frequency"
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB "NFQ Solutions":
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */
declare(strict_types=1);

namespace Logger;

class EchoLogger implements LoggerInterface
{
    public function log(string $message)
    {
        echo $message;
    }
}