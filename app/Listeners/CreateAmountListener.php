<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Service\GeneralService;


class CreateAmountListener
{

    public function __construct(readonly private GeneralService $generalService)
    {}

    public function handle(PostCreatedEvent $event): void
    {
        $this->generalService->addAmount($event->post?->id);
    }
}
