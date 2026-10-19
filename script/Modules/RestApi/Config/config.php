<?php

$addOnOf = 'Mart';

return [
    'name' => 'RestApi',
    'verification_required' => true,
    'item_id' => 61504968,
    'parent_id' => 55116396,
    'parent_min_version' => '1.2.1',
    'script_name' => $addOnOf . '-restapi-module',
    'parent_product_name' => $addOnOf,
    'setting' => \Modules\RestApi\Entities\RestApiGlobalSetting::class,
];
