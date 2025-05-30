import requests
import joblib
import numpy as np
import mysql.connector
from datetime import date, timedelta

# --- Configura città e API ---
citta = "Vicenza"
api_key = "b625a7c2e2bc4f208f555826252105"
url = f"http://api.weatherapi.com/v1/current.json?key={api_key}&q={citta}&aqi=yes"

# --- Recupera dati meteo ---
res = requests.get(url)
data = res.json()

# Estrai dati
temp = data['current']['temp_c']
umidita = data['current']['humidity']
pm25 = data['current']['air_quality'].get('pm2_5', 10)
pm10 = data['current']['air_quality'].get('pm10', 15)
temp_min = temp - 3
temp_max = temp + 3

# --- Previsione AI ---
model = joblib.load("modello_previsione_temperatura.pkl")
X = np.array([[temp_min, temp_max, temp, umidita, pm25, pm10]])
prevista = round(float(model.predict(X)[0]), 2)

# --- Inserimento nel DB ---
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="iot_ambiente"
)
cursor = conn.cursor()

query = """
INSERT INTO previsioni (citta, data_previsione, temperatura_prevista, temperatura_attuale, umidita, pm25, pm10)
VALUES (%s, %s, %s, %s, %s, %s, %s)
"""
cursor.execute(query, (citta, date.today() + timedelta(days=1), prevista, temp, umidita, pm25, pm10))
conn.commit()
cursor.close()
conn.close()

print(f"✅ Previsione salvata: {prevista}°C per {citta}")
