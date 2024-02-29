<?php

declare(strict_types=1);

namespace App\Domain\Signal;

use JsonSerializable;

class Signal implements JsonSerializable
{
    private int $id;

    private Date $ts;

    private string $message;

    public function __construct(int $id, Date $ts, string $message) {
        $this->id = $id;
        $this->ts = $ts;
        $this->message = $message;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTs(): Date {
        return $this->ts;
    }

    public function getMessage(): string {
        return $this->message;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ts' => $this->ts,
            'message' => $this->message,
        ];
    }

}