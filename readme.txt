=== VGW ===
Contributors: otterstedt
Donate link: http://maheo.eu/vgw
Tags: VG-Wort, VGW, Zählpixel
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

VGW is a wordpress plugin to add a VG-Wort-Zählpixels to posts/pages

== Description ==

VGW is a wordpress plugin to add a VG-Wort-Zählpixels to posts/pages

Because VG-Wort-Zählpixels are only used on German webpages, I'm going to
describe this plugin in German ;-)

Ok, dieses Plugin macht folgendes:

* Wenn im Custom Field "vgwpixel" des Artikels (der Seite) ein
  VG-Wort-Zählpixel angegeben wurde, dann wird dieses Zählpixel im Artikel
  (der Seite) ausgegeben.

* In die Sidebar kann optional eine Costum Metabox eingefügt werden. 
  Wenn dieses zusätzliche Eingabefeld aktiviert ist, _muss_ das Zählpixel
  dort eingetragen werden. (Ansonsten gibt man es unten in der Maske bei
  den Custom Fields ein)

* Bei der Eingabe eines neuen Artikels (einer neuen Seite) wird die Anzahl
  Zeichen im Editor unterhalb des Eingabefeldes ausgegeben.

* In der Posts/Pages-Übersicht wird eine neue Spalte eingefügt. In dieser
  Spalte wird die Anzahl Zeichen des Artikels (der Seite) angezeigt. Außerdem
  wird dort angegeben, ob der betreffende Artikel (die Seite) bereits ein
  VG-Wort-Zählpixel besitzt. Artikel/Seiten mit mehr als 1800 Zeichen, die
  noch kein VG-Wort Zählpixel enthalten werden hervorgehoben.

Weitere Anmerkungen:

* Da Angabe im der Custom Metabox überschreibt die Angabe unten bei den Custom
  Fields. Wenn die Metabox aktiviert ist, _muss_ die Angabe also dort
  vorgenommen werden.


* Update der Anzeige im Editor erfolgt immer erst nach "Save Draft", "Publish"
  oder "Update"

* Leerzeichen werden mitgezählt, Zeilenumbrüche zählen als zwei Zeichen
  (Line Feed / Carriage Return)

* Satzzeichen werden mitgezählt

* Werden Umlaute HTML-encodet (&auml; etc.) dann wird mehr als ein Zeichen
  gezählt (Wordpress wandelt diese Zeichen aber zurück in UTF-Umlaute, die
  dann natürlich einfach gezählt werden. 

* Das vgwpixel-Feld wird weitgehend unverändert im Artikel ausgegeben. Diese
  Funktion darf deshalb aus Sicherheitsgründen nur von vertrauenswürdigen
  Autoren verwendet werden.

Kritik und Anregungen sind herzlich willkommen!
* h.otterstedt@gmail.com
* http://maheo.eu/vgw

== Installation ==

* Entpacke das Archiv ins Wordpress Plugin Verzeichnis (wp-content/plugins/)
* Aktiviere das Plugin im Wordpress Backend.
* Füge VG-Wort-Zählpixel als Custom Field "vgwpixel" in deine Artikel ein
  (den ganzen Link, den Du von der VG-Wort bekommen hast)
* Wenn Du möchtest kannst Du die Pixel stylen. Sie sind mit dem Div "vgwpixel"
  umgeben.

== Frequently Asked Questions ==

Siehe http://maheo.eu/vgw für Diskussionen zu diesem Plugin

== Screenshots ==

1. Zusätzliche Spalte in "Manage Posts"
2. Custom Meta Box

== Changelog ==

= 1.0.4 =
* Costum MetaBox konfigurierbar über die Variable $vgw_want_custommetabox

= 1.0.2 =
* Versuch das Update-Problem zu lösen: "Plugin Version" -> "Version" in
  readme.txt

= 1.0.0 =
* Änderungen an der readme.txt (neue Versionsnummer, neuer Stable Tag, README -> readme.txt)

== Upgrade Notice ==

= 1.0.4 =
* Konfiguriere $vgw_want_custommetabox um die Custom Metabox zu zeigen (true) oder
nicht zu zeigen (false). Default: true

= 1.0.2 =
* minor changes

= 1.0.0 =
* minor changes



