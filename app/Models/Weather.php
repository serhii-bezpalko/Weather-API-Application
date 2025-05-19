<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

/**
 * @mixin Builder
 */
class Weather extends Model
{
    protected $fillable = ['city', 'temperature', 'humidity', 'description'];

    public static function getWeatherFromAPI(string $city_name): JsonResponse
    {
        $apikey = env('WEATHER_API_KEY');
        $response = Http::get("http://api.weatherapi.com/v1/current.json?key={$apikey}&q={$city_name}&aqi=no")->json();
        if (key_exists('error', $response)) {
            if ($response['error']['message'] === 'No matching location found.') {
                return response()->json(['error' => 'City not found'], 404);
            }
            return response()->json(['error' => 'Invalid request'], 400);
        }

        if ($response['location']['name'] !== $city_name) {
            return response()->json(['error' => 'City not found'], 404);
        }

        $data = [
            'city' => $response['location']['name'],
            'temperature' => (int)$response['current']['temp_c'],
            'humidity' => $response['current']['humidity'],
            'description' => $response['current']['condition']['text'],
        ];

        Weather::create($data);
        unset($data['city']);
        return response()->json($data);
    }
}
