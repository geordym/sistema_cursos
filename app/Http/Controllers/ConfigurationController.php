<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    //


    public function putConfiguration($key, $value)
    {
        $configuration = Configuration::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        return $configuration;
    }

    public function getConfiguration($key)
    {
        $configuration = Configuration::where('key', $key)->first();
        return $configuration ? $configuration->value : null;
    }


}
