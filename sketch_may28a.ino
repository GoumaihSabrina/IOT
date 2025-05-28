#include "Adafruit_CCS811.h"

Adafruit_CCS811 ccs;

void setup() {
  Serial.begin(9600);
  Serial.println("CCS811 test");

  if (!ccs.begin()) {
    Serial.println("Errore inizializzazione CCS811!");
    while (1);
  }

  // Aspetta che il sensore sia pronto
  while (!ccs.available());
}

void loop() {
  if (ccs.available()) {
    if (!ccs.readData()) {
      Serial.print("CO2: ");
      Serial.print(ccs.geteCO2());
      Serial.print(" ppm, TVOC: ");
      Serial.print(ccs.getTVOC());
      Serial.println(" ppb");
    } else {
      Serial.println("Errore lettura CCS811");
    }
  }
  delay(2000);
}
