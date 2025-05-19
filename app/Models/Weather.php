<?php

namespace App\Models;

use http\Env\Request;
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
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $data = json_decode($response, true)['current'];
        $data['city'] = json_decode($response, true)['location']['name'];

        if ($data['city'] !== $city_name) {
            return response()->json(['error' => 'City not found'], 404);
        }

        $data = [
            'city' => $data['city'],
            'temperature' => (int)$data['temp_c'],
            'humidity' => $data['humidity'],
            'description' => $data['condition']['text'],
        ];

        Weather::create($data);
        return response()->json(['message' => 'created']);
    }
}
