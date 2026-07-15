<?php declare(strict_types=1);
function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$assetV = trim((string)@file_get_contents(__DIR__ . '/data/asset-version.txt')) ?: '10';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ochrana osobných údajov a cookies – Sunset v Raji</title>
<meta name="description" content="Podmienky ochrany osobných údajov a používania súborov cookies na webe sunsetvraji.sk.">
<meta name="robots" content="noindex, follow">
<link rel="canonical" href="https://sunsetvraji.sk/ochrana-osobnych-udajov.php">
<link rel="icon" href="/favicon.ico" sizes="48x48">
<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-180.png">
<link rel="stylesheet" href="assets/css/style.css?v=<?= h($assetV) ?>">
<style>
.legal{max-width:820px;margin:0 auto;padding:120px 20px 72px}
.legal h1{font-size:clamp(1.6rem,5vw,2.2rem);margin-bottom:1.2rem}
.legal h2{font-size:1.2rem;margin:2rem 0 .6rem}
.legal p, .legal li{font-size:.96rem}
.legal ul{padding-left:1.3rem;margin:.5rem 0 1rem}
.legal table{width:100%;border-collapse:collapse;margin:.8rem 0 1.2rem;font-size:.9rem}
.legal th,.legal td{border:1px solid var(--cream-dark);padding:8px 10px;text-align:left;vertical-align:top}
.legal th{background:var(--cream)}
.legal .back{display:inline-block;margin-bottom:1.4rem;font-weight:600}
@media(max-width:640px){.legal table,.legal thead,.legal tbody,.legal th,.legal td,.legal tr{display:block}.legal th{display:none}.legal td{border:0;border-bottom:1px solid var(--cream-dark);padding:6px 0}.legal tr{margin-bottom:12px;border:1px solid var(--cream-dark);border-radius:8px;padding:8px 12px}}
</style>
</head>
<body>
<header class="nav solid" id="nav">
  <div class="nav-inner">
    <a class="nav-brand" href="/" aria-label="Sunset v Raji – domov">
      <img src="assets/img/logo-white.png" alt="Sunset v Raji" width="86" height="60">
    </a>
    <nav class="nav-links nav-simple" aria-label="Hlavná navigácia">
      <a href="/#den">Program</a>
      <a href="/#lineup">Lineup</a>
      <a href="/#galeria">Galéria</a>
      <a href="/#informacie">Info</a>
      <a href="/#kontakt">Kontakt</a>
    </nav>
  </div>
</header>

<main class="legal">
<a class="back" href="/">← Späť na hlavnú stránku</a>
<h1>Podmienky ochrany osobných údajov – sunsetvraji.sk</h1>

<p>Tieto podmienky ochrany súkromia vysvetľujú, akým spôsobom spracúvame pri organizovaní podujatia Sunset v Raji a prevádzke webu sunsetvraji.sk osobné údaje v rámci spoločnosti <strong>Martin Babčan</strong>, so sídlom: <strong>Ottlýkovská 396/36, 013 14 Kamenná Poruba</strong>, IČO: <strong>52611281</strong>, registrácia: Okresný úrad Žilina, č. živnostenského registra 580-66268 (ďalej len „<strong>prevádzkovateľ</strong>“ alebo „<strong>my</strong>“). Pre zodpovedanie akýchkoľvek otázok týkajúcich sa ochrany osobných údajov alebo prijatia a vybavenia žiadostí dotknutých osôb nás neváhajte kontaktovať.</p>

<p><strong>Kontaktné údaje:</strong><br>
E-mail: <strong>objednavky@techessence.sk</strong><br>
Telefónne číslo: <strong>0949 819 436</strong><br>
Korešpondenčná adresa: <strong>Ottlýkovská 396/36, 013 14 Kamenná Poruba</strong></p>

<p>Tieto podmienky ochrany súkromia slúžia primárne na splnenie informačných povinností podľa čl. 13 a 14 GDPR voči dotknutým osobám, o ktorých spracúvame osobné údaje. Pri spracúvaní osobných údajov sa riadime primárne všeobecným nariadením EÚ o ochrane osobných údajov („<strong>GDPR</strong>“), ktoré upravuje aj Vaše práva ako dotknutej osoby, tými ustanoveniami zákona č. 18/2018 Z. z. o ochrane osobných údajov („<strong>Zákon o ochrane osobných údajov</strong>“), ktoré sa na nás vzťahujú, ako aj ďalšími právnymi predpismi. V prípade, ak by ste nerozumeli úplne akejkoľvek informácii uvedenej v týchto podmienkach, neváhajte nás kontaktovať.</p>

<h2>Prečo spracúvame osobné údaje?</h2>
<p>Spracúvanie osobných údajov je z našej strany nevyhnutné najmä preto, aby sme mohli:</p>
<ul>
<li>organizovať naše podujatia a poskytovať naše služby a za týmto účelom spracúvať osobné údaje našich návštevníkov, zákazníkov, dodávateľov, obchodných partnerov a ďalších osôb;</li>
<li>plniť rôzne zákonné a zmluvné povinnosti; a</li>
<li>chrániť naše oprávnené záujmy.</li>
</ul>

<h2>Na aké účely a na základe akých právnych základov spracúvame osobné údaje?</h2>
<table>
<thead><tr><th>Účel spracúvania osobných údajov</th><th>Právny základ</th></tr></thead>
<tbody>
<tr><td>Vyhotovovanie a uverejňovanie fotografií a videí z podujatia Sunset v Raji</td><td>Súhlas</td></tr>
<tr><td>Preukazovanie, uplatňovanie alebo obhajovanie právnych nárokov (právna agenda)</td><td>Oprávnený záujem</td></tr>
<tr><td>Agenda práv dotknutých osôb</td><td>Plnenie zákonných povinností</td></tr>
<tr><td>Plnenie zmluvných vzťahov s obchodnými a inými partnermi</td><td>Plnenie zmluvy</td></tr>
<tr><td>Prevádzkovanie profilov na sociálnych sieťach</td><td>Oprávnený záujem</td></tr>
<tr><td>Marketingové a PR účely (vrátane merania návštevnosti webu a účinnosti reklamy)</td><td>Súhlas a/alebo oprávnený záujem</td></tr>
<tr><td>Účtovné a daňové účely</td><td>Plnenie zákonných povinností</td></tr>
<tr><td>Archívne účely a správa registratúry</td><td>Čl. 89 GDPR</td></tr>
<tr><td>Štatistické účely</td><td>Čl. 89 GDPR</td></tr>
</tbody>
</table>

<h2>Aké sú oprávnené záujmy, ktoré pri spracúvaní osobných údajov sledujeme?</h2>
<p>Pri nasledujúcich účeloch sa spoliehame na právny základ oprávneného záujmu podľa čl. 6 ods. 1 písm. f) GDPR:</p>
<ul>
<li><strong>Právna agenda</strong> – v ojedinelých prípadoch musíme preukazovať, uplatňovať alebo obhajovať naše právne nároky súdnou alebo mimosúdnou cestou alebo musíme oznámiť určité skutočnosti orgánom verejnej moci, čo považujeme za náš oprávnený záujem.</li>
<li><strong>Prevádzkovanie a správa profilov na sociálnych sieťach</strong> – ak prevádzkujeme vlastné profily na sociálnych sieťach (Facebook, Instagram, YouTube a pod.), spoliehame sa pritom na náš oprávnený záujem, ktorým je zvyšovanie povedomia o našich podujatiach v online prostredí.</li>
<li><strong>Marketingové a PR účely</strong> – ak organizujeme rôzne eventy a akcie, na ktoré pozývame našich obchodných partnerov, spoliehame sa pritom na náš oprávnený záujem, ktorým sú účely priameho marketingu. V zmysle recitálu 47 GDPR: <em>„Spracúvanie osobných údajov na účely priameho marketingu možno považovať za oprávnený záujem.“</em></li>
</ul>

<h2>Komu poskytujeme Vaše osobné údaje?</h2>
<p>Zachovávanie mlčanlivosti o osobných údajoch berieme veľmi vážne, a preto sme prijali interné politiky, vďaka ktorým sú Vaše osobné údaje zdieľané len s oprávnenými osobami alebo preverenými tretími stranami. Osobné údaje poskytujeme len v nevyhnutnej miere nasledovným kategóriám príjemcov: našim prevereným a riadne právne zaviazaným sprostredkovateľom; našim profesionálnym poradcom (napr. advokátom, audítorom); mzdovým a účtovným spoločnostiam; poskytovateľom softvérového vybavenia a cloudových služieb; poskytovateľom technickej (IT) a organizačnej (eventové agentúry) podpory; a zamestnancom vyššie uvedených osôb. Ak sme požiadaní orgánom verejnej moci o sprístupnenie Vašich osobných údajov, skúmame legislatívou stanovené podmienky na ich sprístupnenie a bez preverenia, či sú splnené podmienky, Vaše osobné údaje neposkytujeme.</p>

<h2>Do ktorých krajín prenášame Vaše osobné údaje?</h2>
<p>Štandardne obmedzujeme akékoľvek cezhraničné prenosy osobných údajov do tretích krajín mimo Európskeho hospodárskeho priestoru (EÚ, Island, Nórsko a Lichtenštajnsko). Pri použití nástrojov tretích strán (napr. Meta Pixel, Google Analytics) môže dochádzať k prenosu údajov v súlade s podmienkami týchto poskytovateľov.</p>

<h2>Ako dlho uchovávame Vaše osobné údaje?</h2>
<p>Osobné údaje uchovávame najviac dovtedy, kým je to potrebné na účely, na ktoré sa osobné údaje spracúvajú. Fotografie a videá z našich akcií uchovávame po dobu uvedenú v oznámení alebo súhlase s vyhotovovaním fotografií alebo videí nachádzajúcom sa na mieste konania akcie, typicky 5 rokov. Údaje spracúvané na účtovné a daňové účely uchovávame 10 rokov. Ak spracúvame Vaše osobné údaje na základe súhlasu, po jeho odvolaní sme povinní osobné údaje ďalej nespracúvať na daný účel.</p>

<h2>Aké práva máte ako dotknutá osoba?</h2>
<p><strong>Ak o Vás spracúvame osobné údaje na základe Vášho súhlasu so spracúvaním osobných údajov, máte právo kedykoľvek svoj súhlas odvolať. Jeho odvolanie však nemá vplyv na zákonnosť spracúvania osobných údajov pred jeho odvolaním. Máte právo kedykoľvek účinne namietať proti spracúvaniu osobných údajov na účely priameho marketingu vrátane profilovania. Právo namietať máte aj voči spracúvaniu Vašich osobných údajov na základe oprávnených záujmov, ktoré sledujeme.</strong></p>
<p>Ako dotknutá osoba máte najmä:</p>
<ul>
<li>právo požiadať o prístup k osobným údajom podľa článku 15 GDPR;</li>
<li>právo na opravu a doplnenie osobných údajov podľa článku 16 GDPR;</li>
<li>právo na vymazanie Vašich osobných údajov podľa článku 17 GDPR;</li>
<li>právo na obmedzenie spracúvania osobných údajov podľa článku 18 GDPR;</li>
<li>právo na prenosnosť údajov podľa článku 20 GDPR.</li>
</ul>
<p>Takisto máte <strong>právo kedykoľvek podať sťažnosť Úradu na ochranu osobných údajov Slovenskej republiky</strong> alebo obrátiť sa so žalobou na príslušný súd. V každom prípade odporúčame akékoľvek spory, otázky alebo námietky riešiť primárne komunikáciou s nami.</p>

<h2>Dochádza k automatizovanému individuálnemu rozhodovaniu?</h2>
<p>Nie, aktuálne nevykonávame také spracovateľské operácie, na základe ktorých by dochádzalo k prijímaniu rozhodnutia s právnym účinkom alebo iným podstatným vplyvom na Vašu osobu, ktoré by boli založené výlučne len na plne automatizovanom spracúvaní Vašich osobných údajov v zmysle čl. 22 GDPR.</p>

<h2>Externé webstránky</h2>
<p>Naša webstránka môže obsahovať prepojenia (linky) na iné webstránky a/alebo služby iných poskytovateľov (napr. Google Maps, Facebook). Nie sme zodpovední za obsah a spravovanie webstránok či služieb iných poskytovateľov, na ktoré odkazujeme. Tieto podmienky ochrany súkromia sa nevzťahujú na spracúvanie osobných údajov v rámci Vášho pohybu na iných webstránkach.</p>

<h2>Cookies</h2>
<p>Cookies sú malé textové súbory, ktoré zlepšujú používanie webstránky napr. tým, že umožňujú rozpoznať predchádzajúcich návštevníkov, zapamätať voľbu návštevníka alebo merať návštevnosť webstránky. Naša webová stránka používa súbory cookies najmä na účely merania návštevnosti a účinnosti reklamy (Meta Pixel, Google Analytics). Tieto sa načítajú <strong>až po udelení Vášho súhlasu</strong> v cookie lište. Svoju voľbu môžete kedykoľvek zmeniť vymazaním uložených údajov stránky vo Vašom prehliadači. Ak spracúvame Vaše údaje na základe Vášho súhlasu, je možné tento súhlas kedykoľvek odvolať.</p>
<p>Súbory cookies môžete kontrolovať alebo zmazať podľa uváženia – podrobnosti nájdete na stránke aboutcookies.org. Návody na vymazanie cookies v jednotlivých prehliadačoch:</p>
<ul>
<li>Safari™: support.apple.com/guide/safari/manage-cookies-and-website-data-sfri11471/mac</li>
<li>Opera™: opera.com/help/tutorials/security/privacy/</li>
<li>Mozilla Firefox™: support.mozilla.com/sk/kb/odstranenie-cookies</li>
<li>Google Chrome™: support.google.com/chrome/answer/95647?hl=sk</li>
</ul>

<h2>Sociálne siete</h2>
<p>Odporúčame Vám oboznámiť sa s podmienkami ochrany súkromia poskytovateľov platforiem sociálnych médií, cez ktoré spolu komunikujeme. Máme iba typické administrátorské oprávnenia pri spracúvaní Vašich osobných údajov cez naše profily. Predpokladáme, že používaním sociálnych sietí rozumiete, že Vaše osobné údaje sú primárne spracúvané poskytovateľmi platforiem sociálnych sietí (Facebook, Instagram, YouTube a pod.) a že nad týmto spracúvaním nemáme žiadnu kontrolu a nezodpovedáme zaň.</p>

<h2>Zmena podmienok ochrany súkromia</h2>
<p>Ochrana osobných údajov pre nás nie je jednorazovou záležitosťou. Informácie, ktoré sme Vám povinní vzhľadom na naše spracúvanie osobných údajov poskytnúť, sa môžu meniť alebo prestať byť aktuálne. Z tohto dôvodu si vyhradzujeme možnosť kedykoľvek tieto podmienky upraviť a zmeniť v akomkoľvek rozsahu. V prípade, že zmeníme tieto podmienky podstatným spôsobom, túto zmenu Vám dáme do pozornosti napr. všeobecným oznámením na tejto webstránke.</p>

<p><strong>Martin Babčan</strong> (sunsetvraji.sk)<br>V Kamennej Porube</p>
</main>

<footer class="footer">
  <div class="wrap footer-inner">
    <p>© <?= date('Y') ?> Sunset v Raji</p>
    <p class="footer-social"><a href="/">Domov</a><a href="obchodne-podmienky.php">Obchodné podmienky</a></p>
  </div>
</footer>
</body>
</html>
