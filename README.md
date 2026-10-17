[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Version](https://img.shields.io/badge/Symcon%20Version-9.0%20%3E-blue.svg)
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![Check Style](https://github.com/Schnittcher/Govee/actions/workflows/style.yml/badge.svg)](https://github.com/Schnittcher/Govee/actions/workflows/style.yml)
[![Tests](https://github.com/Schnittcher/Govee/actions/workflows/tests.yml/badge.svg)](https://github.com/Schnittcher/Govee/actions/workflows/tests.yml)

# Govee
Mit diesem Modul lassen sich Govee-Geräte lokal über UDP in IP-Symcon integrieren.

## Inhaltsverzeichnis
- [Govee](#govee)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [1. Voraussetzungen](#1-voraussetzungen)
  - [2. Funktionsumfang](#2-funktionsumfang)
  - [3. Enthaltene Module](#3-enthaltene-module)
  - [4. Installation](#4-installation)
  - [5. Konfiguration in IP-Symcon](#5-konfiguration-in-ip-symcon)
  - [6. Spenden](#6-spenden)
  - [7. Lizenz](#7-lizenz)

## 1. Voraussetzungen

* mindestens IPS Version 9.0
* Govee-Geräte, die die LAN-Steuerung unterstützen. Das Gerät muss in der Govee Home App eingerichtet und mit dem WLAN verbunden sein, in den Geräteeinstellungen muss die LAN-Steuerung eingeschaltet werden.
* Werden VLANs genutzt, muss für die Suche Multicast aktiv sein.

## 2. Funktionsumfang
* Geräte im Netzwerk suchen und anlegen
* Geräte schalten und Status abgleichen (Ein/Aus, Helligkeit, Farbe, Farbtemperatur)

Die einzelnen Funktionen stehen bei den Instanzen unter "Enthaltene Module" und in der README des jeweiligen Moduls.

## 3. Enthaltene Module

* [GoveeDevice](GoveeDevice/README.md)
  * Bildet ein Govee-Gerät ab und schaltet es lokal über UDP.
* [GoveeDiscovery](GoveeDiscovery/README.md)
  * Sucht Govee-Geräte im Netzwerk und legt sie als GoveeDevice an.

## 4. Installation
Die Installation erfolgt über den IP-Symcon Module Store.

## 5. Konfiguration in IP-Symcon
Die Geräte werden über die Instanz GoveeDiscovery gefunden und angelegt. Die Konfiguration übernimmt dabei die Discovery-Instanz.

## 6. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:

[![PayPal](https://img.shields.io/badge/PayPal-Spenden-00457C?logo=paypal&logoColor=white&style=for-the-badge)](https://www.paypal.com/donate?hosted_button_id=EK4JRP87XLSHW) [![Amazon Wunschzettel](https://img.shields.io/badge/Amazon-Wunschzettel-FF9900?logo=amazon&logoColor=white&style=for-the-badge)](https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share)

## 7. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
