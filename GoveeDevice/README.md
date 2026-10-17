# GoveeDevice
Diese Instanz bildet ein Govee-Gerät in IP-Symcon ab. Sie schaltet das Gerät lokal über UDP und gleicht den Status regelmäßig ab. Angelegt wird sie normalerweise über die Instanz GoveeDiscovery. Voraussetzung ist, dass das Gerät in der Govee Home App eingerichtet, mit dem WLAN verbunden und in den Geräteeinstellungen die LAN-Steuerung aktiviert ist.

## Inhaltsverzeichnis
- [GoveeDevice](#goveedevice)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [1. Konfiguration](#1-konfiguration)
  - [2. Variablen](#2-variablen)
  - [3. Funktionen](#3-funktionen)
  - [4. Spenden](#4-spenden)
  - [5. Lizenz](#5-lizenz)

## 1. Konfiguration

Feld | Beschreibung
------------ | ----------------
IP-Adresse | IP-Adresse des Geräts. Muss eine gültige IP-Adresse sein, sonst bleibt die Instanz im Fehlerstatus.
Aktiv | Schaltet die Instanz und die Statusabfrage ein oder aus.
Aktualisierungsintervall | Intervall in Sekunden, in dem der Status des Geräts abgefragt wird (Standard 10, mindestens 1).

## 2. Variablen

Variable | Ident | Typ | Beschreibung
------------ | ------------ | ------------ | ----------------
Status | `State` | Ja/Nein | Gerät ein- oder ausschalten, steuerbar.
Helligkeit | `Brightness` | Ganzzahl (%) | Helligkeit 1–100, steuerbar.
Farbe | `Color` | Ganzzahl (Hex-Farbe) | Farbe des Geräts, steuerbar.
Farbtemperatur | `ColorTemperature` | Ganzzahl (K) | Farbtemperatur von 2000 bis 9000 K, steuerbar.

Alle Variablen verwenden die nativen Darstellungen von IP-Symcon (Schalter, Schieberegler, Farbe).

## 3. Funktionen

`void GOVEE_UpdateState(integer $InstanzID);`
Fragt den aktuellen Status beim Gerät ab. Wird automatisch im eingestellten Intervall aufgerufen.

`void RequestAction(integer $VariablenID, mixed $Wert);`
Löst die Aktion einer Variable aus.

Beispiel:
`RequestAction(12345, true); //Einschalten`
`RequestAction(56789, 50); //Helligkeit auf 50 %`
`RequestAction(76543, 2700); //Farbtemperatur auf 2700 K`
`RequestAction(14725, 0xff0000); //Farbe Rot`

## 4. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:

[![PayPal](https://img.shields.io/badge/PayPal-Spenden-00457C?logo=paypal&logoColor=white&style=for-the-badge)](https://www.paypal.com/donate?hosted_button_id=EK4JRP87XLSHW) [![Amazon Wunschzettel](https://img.shields.io/badge/Amazon-Wunschzettel-FF9900?logo=amazon&logoColor=white&style=for-the-badge)](https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share)

## 5. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
