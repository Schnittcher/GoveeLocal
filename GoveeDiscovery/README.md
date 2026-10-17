# GoveeDiscovery
Diese Instanz sucht Govee-Geräte im lokalen Netzwerk per UDP-Multicast und legt sie als GoveeDevice-Instanz an. Beim Öffnen der Konfiguration wird die Suche gestartet. Gefunden werden nur Geräte, die in der Govee Home App eingerichtet, mit dem WLAN verbunden und bei denen in den Geräteeinstellungen die LAN-Steuerung aktiviert ist. Nicht jedes Govee-Modell unterstützt die LAN-Steuerung.

## Inhaltsverzeichnis
- [GoveeDiscovery](#goveediscovery)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [1. Konfiguration](#1-konfiguration)
  - [2. Variablen](#2-variablen)
  - [3. Funktionen](#3-funktionen)
  - [4. Spenden](#4-spenden)
  - [5. Lizenz](#5-lizenz)

## 1. Konfiguration

Feld | Beschreibung
------------ | ----------------
Geräteliste | Gefundene Geräte mit IP-Adresse, MAC, SKU sowie Bluetooth- und WLAN-Versionen. Über "Erstellen" wird die Geräteinstanz samt UDP-Socket angelegt.

## 2. Variablen
Diese Instanz legt keine Variablen an.

## 3. Funktionen

`void GOVEE_scanDevices(integer $InstanzID);`
Sendet die Suchanfrage an die Govee-Geräte. Wird beim Öffnen der Konfiguration automatisch aufgerufen.

## 4. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:

[![PayPal](https://img.shields.io/badge/PayPal-Spenden-00457C?logo=paypal&logoColor=white&style=for-the-badge)](https://www.paypal.com/donate?hosted_button_id=EK4JRP87XLSHW) [![Amazon Wunschzettel](https://img.shields.io/badge/Amazon-Wunschzettel-FF9900?logo=amazon&logoColor=white&style=for-the-badge)](https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share)

## 5. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
