# Changelog

## 22.10.2026 - Version 2.0.1

### Fixes
- Die Instanzen lassen sich in IP-Symcon 9 wieder anlegen (Fehler "RequireParent is not available anymore").
- Die Geräte-Suche und alle Geräteinstanzen nutzen jetzt gemeinsam einen UDP-Socket, damit sich die Antworten der Geräte auf Port 4002 nicht stören.

## 17.10.2026 - Version 2.0

### Neu
- Die Instanz prüft jetzt die eingetragene IP-Adresse und zeigt bei einer ungültigen Adresse einen Fehlerstatus.
- Die Variablen verwenden jetzt die nativen Darstellungen von IP-Symcon 9 (Schalter, Schieberegler, Farbe) statt der alten Profile.
- Achtung: Bestehende Instanzen werden beim nächsten Übernehmen einmalig auf die neuen Darstellungen umgestellt. Eigene Anpassungen daran danach bleiben erhalten.
- Die Bibliothek heißt jetzt "Govee Local", die Module heißen "GoveeLocalDevice" und "GoveeLocalDiscovery".
- Achtung: Bestehende Instanzen bleiben erhalten und funktionieren unverändert. Die Funktionen behalten ihr Präfix `GOVEE_`.
- Achtung: Das Modul benötigt jetzt IP-Symcon 9.0.

### Fixes
- Befehle an die Geräte und deren Antworten werden mit dem UDP-Socket von IP-Symcon 9 korrekt ausgetauscht.
- Ungültige oder unvollständige Antworten der Geräte führen nicht mehr zu Fehlermeldungen.
- Helligkeit und Farbtemperatur werden auf die vom Gerät unterstützten Bereiche (1–100 %, 2000–9000 K) begrenzt.
- In der Geräte-Suche wurde die doppelte Spalte "Bluetooth Software Version" entfernt.

## 08.03.2024 - Version 1.0

### Neu
- Erste Version.
