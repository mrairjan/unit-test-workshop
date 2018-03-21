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

namespace Logger;

interface LoggerInterface
{
    public function log(string $message);
}