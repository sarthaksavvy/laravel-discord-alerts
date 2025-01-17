<?php

namespace Spatie\DiscordAlerts;

class DiscordAlert
{
    protected string $webhookUrlName = 'default';

    public function to(string $webhookUrlName): self
    {
        $this->webhookUrlName = $webhookUrlName;

        return $this;
    }

    public function message(string $text): void
    {
        $webhookUrl = Config::getWebhookUrl($this->webhookUrlName);

        $text = $this->parseNewline($text);

        $jobArguments = [
            'text' => $text,
            'webhookUrl' => $webhookUrl,
        ];

        $job = Config::getJob($jobArguments);

        dispatch($job);
    }

    private function parseNewline(string $text): string
    {
        return str_replace('\n', PHP_EOL, $text);
    }
}
