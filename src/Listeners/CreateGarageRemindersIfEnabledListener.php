<?php

use Illuminate\Contracts\Queue\ShouldQueue;
use Spork\Core\Events\FeatureCreated;
use Spork\Core\Models\FeatureList;
use Spork\Core\Spork;

class CreateGarageRemindersIfEnabledListener implements ShouldQueue
{
    public function handle(FeatureCreated $event)
    {
        $createdFeature = $event->featureList;

        if (! Spork::hasFeature('reminders')) {
            return;
        }

        if ($createdFeature->feature !== 'reminders') {
            return;
        }

        if (! $createdFeature->settings?->track_maintenance) {
            // This garage does not track maintenance reminders.
            return;
        }

        $this->trackMaintenance($createdFeature);
    }

    protected function trackMaintenance(FeatureList $createdFeature)
    {
        switch ($createdFeature->settings?->type) {
            case 'bike':
            case 'vehicle':
            case 'motorcycle':
            case 'trike':
            case 'boat':
            case 'atv':
            case 'golf_cart':
            case 'board':
            case 'rv':
            case 'trailer':
            case 'camper':
            default:
                // No code yet, still trying to figure out how I want this to work... :thinking:
                break;
        }
    }
}
