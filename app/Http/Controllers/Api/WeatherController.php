<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Weather;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $city_name = $request->input('city');
        if (is_null($city_name)) {
            return response()->json(['error' => "Invalid request"], 400);
        }

        $weather = Weather::where('city', $city_name)->get();
        if ($weather->isEmpty()) {
            return Weather::getWeatherFromAPI($city_name);
        }

        $weather = $weather->first();
        $response = [
            'temperature' => $weather->temperature,
            'humidity' => $weather->humidity,
            'description' => $weather->description,
        ];
        return response()->json($response);
    }
}
