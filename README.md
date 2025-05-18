
# Weather API Application

Weather API application that allows users to subscribe to weather updates for a choosen city. You can use any free Weather API (e.g [WeatherAPI.com](https://www.weatherapi.com/my))

## Api Reference
Implement the next endpoints:

- `GET /api/weather?city={city}` - Get current weather for a given city with `Temperature`, `Humidity` and `Weather description`
- `POST /api/subscribe` - Subscribe a given `email` to weather updates for a given `city` with a given frequency (`daily` or `hourly`)
- `GET /api/confirm/{token}` - Confirm email subscription (send a link to this endpoint on the confirmation email)
- `GET /api/unsubscribe/{token}` - Unsubscribe from weather updates (send a link to this endpoint in each weather update)
