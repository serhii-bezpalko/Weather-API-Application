
# Weather API Application

Weather API application that allows users to subscribe to weather updates for a choosen city. You can use any free Weather API (e.g [WeatherAPI.com](https://www.weatherapi.com/my))

## Installing / Getting started
1. Clone the repo
```shell
git clone https://github.com/serhii-bezpalko/Weather-API-Application.git
cd Weather-API-Application
```
2. Create `.env`
```shell
cp .env.example .env
```
Update .env with your API key from WeatherAPI.com and correct database credentials:
```shell
WEATHER_API_KEY=your_api_key_here
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=weather_api_application
DB_USERNAME=laravel
DB_PASSWORD=secret
```
3. Start the containers
```shell
docker compose up --build -d
```
4. Run migrations
Once containers are up:
```shell
docker exec -it php-fpm php artisan migrate
```
5. Email Configuration
To test confirmation/unsubscribe emails configure SMTP credentials in .env.
## Api Reference
Implement the next endpoints:

- `GET /api/weather?city={city}` - Get current weather for a given city with `Temperature`, `Humidity` and `Weather description`
- `POST /api/subscribe` - Subscribe a given `email` to weather updates for a given `city` with a given frequency (`daily` or `hourly`)
- `GET /api/confirm/{token}` - Confirm email subscription (send a link to this endpoint on the confirmation email)
- `GET /api/unsubscribe/{token}` - Unsubscribe from weather updates (send a link to this endpoint in each weather update)
