<?php

use App\Events\FeatureCreated;
use App\Models\FeatureList;
use App\Spork;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePropertyRemindersIfEnabledListener implements ShouldQueue
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
            // This property does not track maintenance reminders.
            return;
        }
        
        $this->trackMaintenance($createdFeature);
    }

    protected function trackMaintenance(FeatureList $createdFeature)
    {
        // Is it conditional to whether or not it's a primary residence? 
        //
        // How does one draw up a maintenance schedule for a property?
        // - lawn work/gardening/Weeding? (maybe use rain info, drought info, etc to predict how long the weeds might be?)
        // - roof work
        // - plumbing?/electrical?/lights? (Maybe there's a schedule for this kinda stuff if your house is a certain age?)
        // - filters (air/water/water heater)
        // - power washing/cleaning off mildue
        // - retaring driveway?
        // - Snow plowing? (maybe tie into weather to help predict when to plow/shovel?)
    }
}