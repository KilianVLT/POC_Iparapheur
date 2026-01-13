<?php

namespace App\Tools\Worker;

final class CheckUrl
{
    public function __construct(
        public readonly string $url,
    ) {}

    public function getUrl(): string
    {
        return $this->url;
    }
}
