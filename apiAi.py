import requests

def get_weather(lat, lon):
    url = f'https://api.open-meteo.com/v1/forecast?latitude={lat}&longitude={lon}&hourly=temperature_2m,precipitation,windspeed_10m&current_weather=true'
    response = requests.get(url)
    if response.status_code == 200:
        data = response.json()
        current = data.get('current_weather', {})
        return {
            'temperatura': current.get('temperature'),
            'precipitazioni': current.get('precipitation', 0),  # potrebbe non esserci
            'velocita_vento': current.get('windspeed')
        }
    else:
        return None

def get_air_quality(city):
    url = f'https://api.openaq.org/v2/latest?city={city}&limit=1&country=IT'
    response = requests.get(url)
    if response.status_code == 200:
        data = response.json()
        if data['results']:
            measurements = data['results'][0]['measurements']
            # Prendiamo PM2.5 e PM10 se disponibili
            pm25 = next((m['value'] for m in measurements if m['parameter'] == 'pm25'), None)
            pm10 = next((m['value'] for m in measurements if m['parameter'] == 'pm10'), None)
            no2 = next((m['value'] for m in measurements if m['parameter'] == 'no2'), None)
            return {'pm25': pm25, 'pm10': pm10, 'no2': no2}
    return None

if __name__ == '__main__':
    # Coordinate Milano
    lat_milano = 45.4642
    lon_milano = 9.1900
    city = 'Milano'

    meteo = get_weather(lat_milano, lon_milano)
    aria = get_air_quality(city)

    print("Dati Meteo attuali a Milano:")
    print(meteo)

    print("\nDati Qualità aria a Milano:")
    print(aria)
