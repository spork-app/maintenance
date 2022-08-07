<?php

use App\Events\FeatureCreated;
use App\Models\FeatureList;
use App\Spork;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateGarageRemindersIfEnabledListener implements ShouldQueue
{
    public function handle(FeatureCreated $event)
    {
        $createdFeature = $event->featureList;

        if (!Spork::hasFeature(FeatureList::FEATURE_REMINDERS)) {
            return;
        }

        if ($createdFeature->feature !== FeatureList::FEATURE_REMINDERS) {
            return;
        }

        if (!$createdFeature->settings?->track_maintenance) {
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