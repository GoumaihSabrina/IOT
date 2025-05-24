import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_absolute_error
import joblib

# Carica i dati preparati
df = pd.read_csv("prepared_dataset.csv")

# Colonne di input
features = [
    'min_temperature_2m',
    'max_temperature_2m',
    'avg_temperature_2m',
    'avg_relative_humidity_2m',
    'avg_pm2_5',
    'avg_pm10'
]

X = df[features]
y = df['target']

# Divisione in train e test (80% / 20%)
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, shuffle=False)

# Inizializzazione e training del modello
model = RandomForestRegressor(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Valutazione
y_pred = model.predict(X_test)
mae = mean_absolute_error(y_test, y_pred)
print(f"MAE (Errore Assoluto Medio): {mae:.2f}°C")

# Salva il modello
joblib.dump(model, "modello_previsione_temperatura.pkl")
print("Modello salvato in: modello_previsione_temperatura.pkl")
