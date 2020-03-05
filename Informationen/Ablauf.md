# :hourglass_flowing_sand: Ablauf der LAP

In diesem Dokument werde ich auflisten wie die LAP abgelaufen ist.

(Mit den Zeiten bin ich mir nicht mehr zu 100% sicher)
- 08:00 - 10:00 : Durchlesen der Aufgabenstellung, einrichten des PCs, Aufsetzen der Datenbank, Erstellung des Datenbankdiagramms und des Zeitplans
- 10:00 - 12:00 : Arbeiten am ersten Teil der Aufgabenstellung
- 13:00 - 14:30 : Fertigstellen des ersten teils der Aufgabenstellung
- 14:30 - 15:30 : Arbeiten und fertigstellen des zweiten Teils und Fachgespräche

## Beginn

Als aller erstes wird man in den Prüfungsraum gebeten und es wird einem der Arbeitsplatz für den restlichen Tag zugewiesen. In meinem Fall waren die Rechner leider nicht mehr ganz das neueste Modell da es schon von außen sichtbar war das dieser PC, zu großer Wahrscheinlichkeit, nicht mehr "State of the Art" ist. Nachdem jeder den Ihm zugewiesenen Platz eingenommen hat, wird einem der generelle Zeitplan vorgetragen, welcher in der Einleitung bereits aufgeschlüsselt wurde. Nach der Einteilung der Prüfung wurden uns die Arbeitsaufträge und eine Box ausgehändigt. In dieser Box befanden sich diverse Kabel und Peripherie mit welcher wir den PC zum Laufen bringen mussten. Das sollte aber für niemanden ein Problem darstellen der schon einmal einen Stromstecker in ein Netzteil und die Steckdose gesteckt hat, da es nichts anderes ist als das. Auch der Anschluss einer USB Tastatur und Maus sollte für jeden der einen zweistelligen IQ besitzt keine besondere Herausforderung darstellen. Das letzte was zum "Technischen" Teil der LAP gehört anschließen-genesen des Netzwerkkabels was, wenn man den Prüfern nicht zuhört, tatsächlich nicht so einfach werden kann da nicht jede Netzwerdose auch eine Verbindung zum Internet zulässt. Nachdem alles geschafft ist, kann man sich endlich, in Windows 7, anmelden und wird von einem nicht zurückgesetzten Desktop begrüßt. Auf diesem Desktop finden sich alle Programme die Vorangegangene Prüflinge hinterlassen haben. Ich habe, in zwei Unterordnern, sogar eine fast fertige Prüfungsarbeit gefunden. Als ich mich nun vom Schock erholt hatte, begann ich sofort mit dem Import der VM in VirtualBox, zum Glück wie sich im Nachhinein rausstellte. Als ich mit dem Import der headless GNU/Linux CentOS 2 VM begann konnte ich fast nichts am PC machen da er mit dem Import für 15 Minuten voll ausgelastet war. Die Zeit konnte ich aber schon gut Nutzen die generelle Aufgabenstellung zu lesen und mit dem Datenbank Diagramm zu beginnen.(Aufgabenstellung und Datenbankdiagramm in diesem Repository enthalten)

Nachdem die VM importiert war und das Datenbankdiagramm fast fertig konnte ich mit dem Erstellen einer sogenannten "Dokumentation des Fortschritts" beginnen welche vom Prüfling verlangt die Netzwerkeinstellungen der VM mit dem GNU/Linux Kommand (ifconfig) zu dokumentieren. Auch muss das erfolgreiche verbinden zum Apache Webserver mit der Apache Default Page in der Doku inkludiert sein. Danach beginnt man, zumindest zum teil, mit dem Programmieren da in der Doku sowohl die PHP Info Page (<?php phpinfo() ?>) als auch ein Hello World Programm (<?php echo 'Hello World!'; ?>) verlangt werden.

