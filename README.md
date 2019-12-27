# gsales_cron
Automatsiertes erstellen und Versenden von Rechnungen per Gsales 2 API.

## Vorrausetzung
- \> PHP 5.4
- Berechtigung, um ein Cronjob zu erstellen
- Gsales User mit API berechtigung
- Kunden haben die Option "Rechnung/Mahnung automatisch spoolen" aktiviert

## Installation
Git Repository klonen oder downloaden und die gsales_cron.php ausführbar machen. (0755)
gsales_cron.php bearbeiten und `<API-Keys>` und `<Gsales-Domain>` durch eigene Werte ersetzen.
## Cron
Cron am besten per /etc/crontab ausführen lassen. Dazu bearbeiten wir die crontab
```
nano /etc/crontab
```
oder
```
crontab -e
```
Beispiel für die Ausführung jeden Tag um 0 Uhr:
```
0 0 * * * /usr/bin/php /path/to/gsales_cron.php
```
Beispiel für die Ausführung jede Stunde:
```
0 * * * * /usr/bin/php /path/to/gsales_cron.php
```

### Mehr Scripte/Unterstüzung
- :orange_book: [Profoxi Blog](https://wiki.profoxi.de/)