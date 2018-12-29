<?php
declare(strict_types=1);

namespace corbomite\cli\models;

class CliArgumentsModel
{
    private $rawArguments = [];
    private $parsedArguments = [];
    private $parsedArgumentsByIndex = [];

    public function __construct(
        array $rawArguments = []
    ) {
        $this->setRawArguments($rawArguments);
    }

    public function setRawArguments(array $rawArguments): self
    {
        $this->rawArguments = $rawArguments = array_values($rawArguments);

        $index = 0;

        foreach ($rawArguments as $rawArgument) {
            $check = explode('--', $rawArgument);

            if (\count($check) >= 2) {
                unset($check[0]);
                $rawArgument = $check[1];
            }

            $rawArgument = explode('=', $rawArgument);

            $this->parsedArguments[$rawArgument[0]] = $rawArgument[1] ??
                $rawArgument[0];

            $this->parsedArgumentsByIndex[$index] =
                $this->parsedArguments[$rawArgument[0]];

            $index++;
        }

        return $this;
    }

    public function getRawArguments(): array
    {
        return $this->rawArguments;
    }

    public function getParsedArguments(): array
    {
        return $this->parsedArguments;
    }

    public function getArgument(string $key, ?string $fallback = null): ?string
    {
        return $this->parsedArguments[$key] ?? $fallback;
    }

    public function getArgumentByIndex(int $index, ?string $fallback = null): ?string
    {
        return $this->parsedArgumentsByIndex[$index] ?? $fallback;
    }
}
