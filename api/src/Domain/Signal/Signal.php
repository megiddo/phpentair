<?php

declare(strict_types=1);

namespace App\Domain\Signal;

use JsonSerializable;
use DateTime;

class Signal implements JsonSerializable
{
    private int $id;
    private DateTime $ts;
    private string $signal;
    private string $parsed;
    private string $error;

    public function __construct(int $id, DateTime $ts, string $signal) {
        $this->id = $id;
        $this->ts = $ts;
        $this->signal = $signal;
        $this->error = "";
    }

    public function parsed($json) {
        $this->parsed = $json;
    }

    public function error($error) {
        $this->error = $error;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTs(): Date {
        return $this->ts;
    }

    public function getSignal(): string {
        return $this->signal;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ts' => $this->ts,
            'signal' => $this->signal,
            'parsed' => $this->parsed,
            'error' => $this->error
        ];
    }

}