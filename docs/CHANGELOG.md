# Changelog

## 16.10.2026 - Version 1.0

### Neu
- Die Instanz prüft jetzt die eingetragene IP-Adresse und zeigt bei einer ungültigen Adresse einen Fehlerstatus.
- Die Variablen verwenden jetzt die nativen Darstellungen von IP-Symcon 9 (Schalter, Schieberegler, Farbe) statt der alten Profile.
- Achtung: Bestehende Instanzen werden beim nächsten Übernehmen einmalig auf die neuen Darstellungen umgestellt. Eigene Anpassungen daran danach bleiben erhalten.
- Die Bibliothek heißt jetzt "Govee Local", die Module heißen "GoveeLocalDevice" und "GoveeLocalDiscovery".
- Achtung: Bestehende Instanzen bleiben erhalten und funktionieren unverändert. Die Funktionen behalten ihr Präfix `GOVEE_`.

### Fixes
- Befehle an die Geräte und deren Antworten werden mit dem UDP-Socket von IP-Symcon 9 korrekt ausgetauscht.
- Ungültige oder unvollständige Antworten der Geräte führen nicht mehr zu Fehlermeldungen.
- Helligkeit und Farbtemperatur werden auf die vom Gerät unterstützten Bereiche (1–100 %, 2000–9000 K) begrenzt.
- In der Geräte-Suche wurde die doppelte Spalte "Bluetooth Software Version" entfernt.
- Achtung: Das Modul benötigt jetzt IP-Symcon 9.0.
