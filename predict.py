import sys
import joblib
import numpy as np
import json

# Carica il modello
model = joblib.load("modello_previsione_temperatura.pkl")

# Legge argomenti da terminale o PHP
# Attesi: min_temp max_temp avg_temp umidita pm25 pm10
if len(sys.argv) != 7:
    print(json.dumps({"errore": "Parametri insufficienti"}))
    sys.exit(1)

try:
    valori = [float(arg) for arg in sys.argv[1:]]
except ValueError:
    print(json.dumps({"errore": "Valori non numerici"}))
    sys.exit(1)

# Previsione
input_data = np.array(valori).reshape(1, -1)
prediction = model.predict(input_data)

# Output JSON
print(json.dumps({"temperatura_prevista": round(prediction[0], 2)}))

