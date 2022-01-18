<?php

namespace HummNGIN\Core\Headers;

use DateTimeImmutable;
use DateTimeZone;

class ResponseHeader extends Header
{
    public function __construct(array $headers = [])
    {
        parent::__construct($headers);

        if (!isset($this->headers['cache-control'])) {
            $this->set('Cache-Control', '');
        }

        if (!isset($this->headers['date'])) {
            $this->initDate();
        }

        if (!isset($this->headers['expires'])) {
            $this->setExpires();
        }
    }

    private function initDate(): void
    {
        $this->set('Date', gmdate('D, d M Y H:i:s') . ' GMT');
    }

    public function setExpires($date = null)
    {
        if ($date == null) {
            $this->set('Expires', -1);
        } else {
            $date = DateTimeImmutable::createFromMutable($date);
            $date = $date->setTimezone(new DateTimeZone('UTC'));
            $this->set('Expires', $date->format('D, d M Y H:i:s') . ' GMT');
        }
    }
}