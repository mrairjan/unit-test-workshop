<?php
declare(strict_types=1);

use Logger\LoggerInterface;

class StringCalculator
{
    /**
     * @var \Logger\LoggerInterface
     */
    private $logger;

    /**
     * StringCalculator constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function add(string $numbers)
    {
        $this->logger->log($numbers);

        $delimiters = ['\n', ','];

        if ($this->isDelimiterSpecified($numbers)) {
            list($delimiter, $numbers) = $this->parseDelimiter($numbers);
            $delimiters[] = $delimiter;
        }

        $numbersList = $this->convertToNumbersList($numbers, $delimiters);
        $this->assertThatNumbersArePositive($numbersList);

        $result = array_sum($numbersList);

        $this->logger->log((string)$result);
        return $result;
    }

    private function isDelimiterSpecified(string $numbers)
    {
        return preg_match('/^\/\//', $numbers);
    }

    /**
     * @param string $numbers
     * @return array
     */
    private function parseDelimiter(string $numbers): array
    {
        preg_match('/^\/\/(.)\n+(.+)/', stripcslashes($numbers), $matches);
        array_shift($matches);
        return $matches;
    }


    /**
     * @param string $numbers
     * @param array $delimiters
     * @return array
     */
    private function convertToNumbersList(string $numbers, array $delimiters): array
    {
        $singleDelimiter = reset($delimiters);

        $numbers = str_replace($delimiters, $singleDelimiter, $numbers);

        $numbersList = explode($singleDelimiter, $numbers);

        return array_map(function (string $number) {
            return (int) $number;
        }, $numbersList);
    }

    /**
     * @param int[] $numbersList
     */
    private function assertThatNumbersArePositive(array $numbersList)
    {
        if ($this->hasNegativeNumbers($numbersList)) {
            throw new \RuntimeException('Negative numbers');
        }
    }

    /**
     * @param int[] $numbersList
     * @return bool
     */
    private function hasNegativeNumbers(array $numbersList): bool
    {
        return (bool) array_filter($numbersList, function (string $number) { return ($number < 0); });
    }
}
