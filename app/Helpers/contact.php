<?php

use App\Models\ContactGeneral;

function getStep(ContactGeneral $contactGeneral = null): float
{
    if($contactGeneral == null) {
        return 1;
    }

    if($contactGeneral->company == null && $contactGeneral->type == 'company') {
        return 2;
    }

    if($contactGeneral->person == null && $contactGeneral->type == 'person') {
        return 2.5;
    }

    if($contactGeneral->detail == null) {
        return 3;
    }

    return 4;
}
