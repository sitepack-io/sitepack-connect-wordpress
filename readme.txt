=== SitePack Connect ===
Contributors: sitepack
Tags: connect, woocommerce, cyclesoftware, wilmar, sitepack
Requires at least: 5.0
Tested up to: 6.2.1
Stable tag: 1.1.0
License: GPLv2 or later

De SitePack Connect plugin is ontworpen om je WordPress website te integreren met het kassasysteem, waardoor je de producten kunt synchroniseren en bestellingen kunt terugplaatsen naar het kassasysteem. Deze plugin werkt met kassasystemen zoals CycleSoftware en Wilmar.

== Description ==

### SitePack Connect: dé #1 integratie partner

De SitePack Connect plugin is ontworpen om je WordPress website te integreren met je kassasysteem, waardoor je de producten kunt synchroniseren en bestellingen kunt terugplaatsen naar het kassasysteem. Deze plugin werkt met de bekende kassasystemen zoals CycleSoftware en Wilmar.

Met de SitePack Connect plugin kan je de producten synchroniseren tussen je WordPress-website en het kassasysteem. Producten worden automatisch meerder keren per dag bijgewerkt wanneer je wijzigingen aanbrengt in je gekozen kassapakket.

De belangrijkste functies zijn:

* Categorie indeling aanpassen
* Meerdere updates per dag
* Bijna live voorraad informatie (maximaal 15 minuten oud)
* Productafbeeldingen uitsluiten
* Geen zware processen op je WordPress website
* Premium ondersteuning via onze helpdesk
* Vaste lage maandprijs, zonder verplichte opstartkosten

#### Categorie indeling aanpassen

In SitePack Connect is het mogelijk om de standaard DST categoriestructuur te overschrijven. Dit is handig als je bepaalde categorieën hebt die niet geschikt zijn voor de webshop. Stel dit eenmalig in bij SitePack Connect in het Categorie overzicht. Wij passen daarna automatisch alle producten aan.

#### Live voorraadinformatie

De voorraadinformatie van een product wordt bij iedere synchronisatie bijgewerkt in de WordPress admin. Als een bezoeker de productpagina bekijkt, zorgt de plugin ervoor dat we ook de live voorraadinformatie ophalen uit het gebruikte kassasysteem. Deze informatie wordt voor maximaal 15 minuten onthouden.

#### Productafbeeldingen uitsluiten

Het is ook mogelijk om productafbeeldingen uit te sluiten. Login bij SitePack Connect en zoek het product op. Klik daarna op Afbeeldingen bij het product en sluit de afbeeldignen uit die niet op de webshop mogen verschijnen. De wijzigingen worden dan zo snel mogelijk doorgevoerd op de webwinkel.

#### CycleSoftware webshop koppeling

Deze plugin werkt optimaal als [CycleSoftware webshop koppeling](https://sitepack.nl/integraties/cyclesoftware). De producten en categorieën worden meerdere keren per dag uitgelezen en aangepast in de WooCommerce webwinkel.

Het is wel verplicht om bij CycleSoftware een webwinkel module aan te schaffen. Deze heeft SitePack Connect nodig om alle functionaliteiten te kunnen gebruiken.

#### Wilmar webshop koppeling

Deze [Wilmar webshop koppeling](https://sitepack.nl/integraties/wilmar) sluit ook naadloos aan bij het Wilmar kassapakket. De categorieën en producten worden meerdere keren per dag uitgelezen en bijgewerkt in de WooCommerce webwinkel.

Het is wel verplicht om bij Wilmar een webwinkel module aan te schaffen. Deze heeft SitePack Connect nodig om alle functionaliteiten te kunnen gebruiken.

### Premium ondersteuning

Voor onze klanten zijn we altijd bereid om een stapje extra te zetten. Gaat er iets niet goed met een product? Laat het ons weten via onze helpdesk en we helpen je graag verder.

### Meer informatie

Wil je graag nog meer informatie over de mogelijkheden van SitePack Connect? Wellicht kan een van deze bronnen je verder helpen:

* De officiële [SitePack](https://sitepack.nl) website
* Het [SitePack helpcentrum](https://help.sitepack.nl)
* Inloggen op de [SitePack admin](https://admin.sitepack.nl)

== Installation ==

Upload de plugin-bestanden naar de /wp-content/plugins/ map.
Activeer de plugin via het 'Plugins' menu in WordPress.
Configureer de plugin-instellingen via het 'SitePack Connect Kassasysteem Integratie'-menu in WordPress.

== Configuration ==

Ga naar het 'SitePack'-menu in WordPress.
Genereer de API sleutel en secret (geheim)
Open SitePack Connect en maak een nieuwe worklfow aan met bovenstaande API gegevens
Configureer de synchronisatie-instellingen voor producten en bestellingen.
De producten en categorieen worden binnen korte tijd automatisch aangemaakt.

== Frequently Asked Questions ==

= Welke kassasystemen worden ondersteund door deze plugin? =

Deze plugin werkt met kassasystemen zoals CycleSoftware en Wilmar.

= Moet ik een SitePack Connect-account hebben om deze plugin te gebruiken? =

Ja, je hebt een SitePack Connect-account nodig om deze plugin te gebruiken.

= Hoe kan ik mijn SitePack Connect API-sleutel vinden? =

Je kan de SitePack Connect API-sleutel vinden in de WordPress omgeving door op de linkerkant op het SitePack menuitem te klikken. Daar staat de API sleutel en geheim die nodig is in Connect.

= Kan ik mijn producten handmatig synchroniseren? =

Nee, wij updaten de producten meerdere malen per dag vanuit SitePack Connect. Het is vaak niet nodig om dit nog handmatig uit te voeren.

= Hoe vaak worden producten automatisch bijgewerkt? =

Producten worden regelmatig bijgewerkt, de interval hangt af van het gekozen [SitePack Connect abbonnement](https://sitepack.nl/producten-importeren).

= Ik heb een andere vraag, die hier niet bijstaat =

Wellicht kan onze [online helpdesk](https://help.sitepack.nl) je verder helpen. Anders staat onze helpdesk ook voor je klaar om je vraag te beantwoorden.

== Developers ==

If you want to contribute, please take a look at our [Github Repository](https://github.com/sitepack-io/sitepack-connect-wordpress).

== Changelog ==

= 1.1.0 =

Release date: 2023-04-05

#### Enhancements

* You can use the spGetProductStockInformation(int $productId) method to get the live stock information of a product and their related stock locations if the subscription is sufficient
* Disable ajax stock information in the product page by using the filter "sitepack_fetch_live_stock" with value "false"

#### Bugfixes

* Stock implementation call bugfix in REST API

= 1.0.2 =

Release date: 2023-03-30

#### Enhancements

* PHP Shorthand tag replaced with default opening tag

= 1.0.1 =

Release date: 2023-03-29

#### Bugfixes

* Translations textdomain updated to correct namespace (sitepack-connect)
* Stable tag updated to 1.0.1
* Added extra escaping and sanitizing optimized before displaying content to the user interface
* Index files added in all plugin directories to prevent directory listings
* Fixed settings link from the plugins section

= 1.0.0 =

Release date: 2023-03-05

#### Enhancements

* Initial release of this WordPress plugin for SitePack