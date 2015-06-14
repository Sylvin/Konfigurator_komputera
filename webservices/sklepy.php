<!DOCTYPE html>
<head>
<input type="button" name="konfigurator" value="Powrot do konfiguratora" onclick="location.href='/konfigurator'"><br />
<script src="sorttable.js"></script>
<style>
table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
    content: " \25B4\25BE" 
}
</style>
</head>
<body>
<?php
	error_reporting(0); //wyłącza raportowanie błędów
	require('simple_html_dom.php'); //parser html
	$url = "http://".$_SERVER['HTTP_HOST']."/app/konfigurator.xml";
	$xml = simplexml_load_file($url); //retrieve URL and parse XML content
	foreach ($xml->children() as $child) {	//pobranie kolejnych elementów z xmla
		$nodes[] = $child;
	}
	$cpu = $nodes[0];
	$gpu = $nodes[1];
	
	$tabcpu = explode(" ", $cpu);	//rozbicie elementu z xmla na pojedyncze wyrazy
	foreach($tabcpu as $k => $v) {
		if(preg_match("/(\d)/", $v))	//jeżeli wyraz zawiera liczbę potraktuj to jako zapytanie do wyszukiwarki
			$zapytanie_cpu = $v;
	}	
	$zapytanie_cpu = str_replace("<br>", "",$zapytanie_cpu);	//usuwanie znaczników nowej linii
	$tabgpu = explode(" ", $gpu);
	foreach($tabgpu as $k => $v) {
		if(preg_match("/(\d)|(Titan)|(Black)/", $v))
			$zapytanie_gpu = $v;
	}
	$zapytanie_gpu = str_replace("<br>", "",$zapytanie_gpu);
	
	$zapytanie_proline = "http://proline.pl/?qp=";
	$zapytanie_xkom = "http://www.x-kom.pl/szukaj/";
	$kategoria_cpu_proline = "&gk=Procesory";
	$kategoria_cpu_xkom = "?f=1&group[0]=5";
	$kategoria_cpu_morele = "http://www.morele.net/komputery/podzespoly-komputerowe/procesory-45/,,,,,,,,,1,/1/?q=";
	$kategoria_gpu_proline = "&gk=Karty+graficzne%3BKarty+graficzne+PCI-E";
	$kategoria_gpu_xkom = "?f=1&category_id[0]=346"; 
	$kategoria_gpu_morele = "http://www.morele.net/komputery/podzespoly-komputerowe/karty-graficzne-12/0,0,,,,,,,,1,/1/?q=";
	$procesory = file_get_html($zapytanie_proline.$zapytanie_cpu.$kategoria_cpu_proline); //strona z proline z listą cpu
	$procesory2 = file_get_html($zapytanie_xkom.$zapytanie_cpu.$kategoria_cpu_xkom); //strona z X-KOM z listą cpu
	$procesory3 = file_get_html($kategoria_cpu_morele.$zapytanie_cpu); //strona z morele z listą cpu
	$karty = file_get_html($zapytanie_proline.$zapytanie_gpu.$kategoria_gpu_proline); //strona z proline z listą gpu
	$karty2 = file_get_html($zapytanie_xkom.$zapytanie_gpu.$kategoria_gpu_xkom); //strona z x-kom z listą gpu
	$karty3 = file_get_html($kategoria_gpu_morele.$zapytanie_gpu); //strona z morele z listą gpu
	
	//tworzenie tablicy produktów cpu proline
	foreach($procesory->find(".produkt") as $element) {
		$proc_nazwa[] = $element->innertext.'<br>';
	}
	foreach($proc_nazwa as $k => $v) {
		if($k%2 == 0)
			unset($proc_nazwa[$k]);
	}
	$proc_nazwa = array_values($proc_nazwa);
	foreach($procesory->find(".c") as $element) {
		$proc_cena[] = str_replace(",", ".", $element->innertext.'<br>');
	}
	unset($proc_cena[0]);
	$proc_cena = array_values($proc_cena);
	
	//tworzenie tablicy produktów gpu proline
	foreach($karty->find(".produkt,.nowosc") as $element) {
		$karta_nazwa[] = $element->innertext.'<br>';
	}
	foreach($karta_nazwa as $k => $v) {
		if($k%2 == 0)
			unset($karta_nazwa[$k]);
	}
	$karta_nazwa = array_values($karta_nazwa);
	foreach($karty->find(".c") as $element) {
		$karta_cena[] = str_replace(",", ".", $element->innertext.'<br>');
	}
	unset($karta_cena[0]);
	$karta_cena = array_values($karta_cena);
	foreach($proc_nazwa as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_cpu.'/', $v)) {
			unset($proc_nazwa[$k]);
			unset($proc_cena[$k]);
		}
	}
	$proc_nazwa = array_values($proc_nazwa);
	$proc_cena = array_values($proc_cena);	
	foreach($karta_nazwa as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_gpu.'/', $v)) {
			unset($karta_nazwa[$k]);
			unset($karta_cena[$k]);
		}
		if(preg_match('/(\('.$zapytanie_gpu.')|(\/'.$zapytanie_gpu.')|('.$zapytanie_gpu.'M.*)/', $v)) {		//usuwanie liczb z nawiasem lub ukośnikiem
			unset($karta_nazwa[$k]);
			unset($karta_cena[$k]);
		}
	}
	$karta_nazwa = array_values($karta_nazwa);
	$karta_cena = array_values($karta_cena);
	//tworzenie tablicy produktów cpu x-kom
	foreach($procesory2->find(".product-box-short-name") as $element) {
		$proc_nazwa2[] = $element->plaintext.'<br>';
	}
	foreach($proc_nazwa2 as $k => $v) {
		$proc_nazwa2[$k] = preg_replace('/&#8203;/', "", $v);	//usuwanie zero-width space z tekstu
	}
	foreach($procesory2->find(".value") as $element) {
		$proc_cena2[] = str_replace("zł", "", str_replace(" ", "", str_replace(",", ".", $element->innertext.'<br>')));
	}
	//tworzenie tablicy produktów gpu x-kom
	foreach($karty2->find(".product-box-short-name") as $element) {
		$karta_nazwa2[] = $element->plaintext.'<br>';
	}
	foreach($karty2->find(".value") as $element) {
		$karta_cena2[] = str_replace("zł", "", str_replace(" ", "", str_replace(",", ".", $element->innertext.'<br>')));
	}
	foreach($proc_nazwa2 as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_cpu.'/', $v)) {
			unset($proc_nazwa2[$k]);
			unset($proc_cena2[$k]);
		}
	}
	$proc_nazwa2 = array_values($proc_nazwa2);
	$proc_cena2 = array_values($proc_cena2);
	foreach($karta_nazwa2 as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_gpu.'/', $v)) {
			unset($karta_nazwa2[$k]);
			unset($karta_cena2[$k]);
		}
	}
	$karta_nazwa2 = array_values($karta_nazwa2);
	$karta_cena2 = array_values($karta_cena2);
	
	//tworzenie tablicy produktów cpu morele
	foreach($procesory3->find(".name") as $element) {
		$proc_nazwa3[] = $element->plaintext.'<br>';
	}
	foreach($procesory3->find(".price") as $element) {
		$proc_cena3[] = str_replace("zł", "", str_replace(" ", "", str_replace(",", ".", $element->innertext.'<br>')));
	}
	
	//tworzenie tablicy produktów gpu morele
	foreach($karty3->find(".name") as $element) {
		$karta_nazwa3[] = $element->plaintext.'<br>';
	}
	foreach($karty3->find(".price") as $element) {
		$karta_cena3[] = str_replace("zł", "", str_replace(" ", "", str_replace(",", ".", $element->innertext.'<br>')));
	}
	foreach($proc_nazwa3 as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_cpu.'/', $v)) {
			unset($proc_nazwa3[$k]);
			unset($proc_cena3[$k]);
		}
	}
	$proc_nazwa3 = array_values($proc_nazwa3);
	$proc_cena3 = array_values($proc_cena3);	
	foreach($karta_nazwa3 as $k => $v) {		//usuwanie elementów tablic nazw i cen, które nie odpowiadają zapytaniu
		if(!preg_match('/'.$zapytanie_gpu.'/', $v)) {
			unset($karta_nazwa3[$k]);
			unset($karta_cena3[$k]);
		}
		if(preg_match('/(\('.$zapytanie_gpu.')|(\/'.$zapytanie_gpu.')|('.$zapytanie_gpu.'M.*)|('.$zapytanie_gpu.'\/)/', $v)) {		//usuwanie liczb z nawiasem lub ukośnikiem
			unset($karta_nazwa3[$k]);
			unset($karta_cena3[$k]);
		}
	}
	$karta_nazwa3 = array_values($karta_nazwa3);
	$karta_cena3 = array_values($karta_cena3);
	
	//konwersja cen na float
	foreach($proc_cena as $k => $v) {
		$proc_cena[$k] = number_format((float)$v, 2, ".", "");
	}
	foreach($proc_cena2 as $k => $v) {
		$proc_cena2[$k] = number_format((float)$v, 2, ".", "");
	}
	foreach($proc_cena3 as $k => $v) {
		$proc_cena3[$k] = number_format((float)$v, 2, ".", "");
	}
	foreach($karta_cena as $k => $v) {
		$karta_cena[$k] = number_format((float)$v, 2, ".", "");
	}
	foreach($karta_cena2 as $k => $v) {
		$karta_cena2[$k] = number_format((float)$v, 2, ".", "");
	}
	foreach($karta_cena3 as $k => $v) {
		$karta_cena3[$k] = number_format((float)$v, 2, ".", "");
	}
	//usunięcie nadmiaru z tablicy cen x-kom
	$liczba1 = count($proc_nazwa2);
	$liczba2 = count($proc_cena2);
	for ($i = $liczba1; $i < $liczba2; $i++) {
		unset($proc_cena2[$i]);
	}
	//tworzenie tablic procow i kart, gdzie kluczem jest opis a wartoscia cena
	$proc_cena2 = array_values($proc_cena2);
	$proce = array_combine($proc_nazwa, $proc_cena);
	$proce2 = array_combine($proc_nazwa2, $proc_cena2);
	$proce3 = array_combine($proc_nazwa3, $proc_cena3);
	$karty_graficzne = array_combine($karta_nazwa, $karta_cena);
	$karty_graficzne2 = array_combine($karta_nazwa2, $karta_cena2);
	$karty_graficzne3 = array_combine($karta_nazwa3, $karta_cena3);
	asort($proce);
	asort($proce2);
	asort($proce3);
	asort($karty_graficzne);
	asort($karty_graficzne2);
	asort($karty_graficzne3);
	$nazwa_proline1 = key($proce);
	$cena_proline1 = current($proce);
	$nazwa_xkom1 = key($proce2);
	$cena_xkom1 = current($proce2);
	$nazwa_morele1 = key($proce3);
	$cena_morele1 = current($proce3);
	$nazwa_proline2 = key($karty_graficzne);
	$cena_proline2 = current($karty_graficzne);
	$nazwa_xkom2 = key($karty_graficzne2);
	$cena_xkom2 = current($karty_graficzne2);
	$nazwa_morele2 = key($karty_graficzne3);	//klucz 1 elementu tablicy
	$cena_morele2 = current($karty_graficzne3);	//wartość 1 elementu tablicy
	
	if(empty($proce))
		$cena_proline1 = 99999;
	if(empty($proce2))
		$cena_xkom1 = 99999;
	if(empty($proce3))
		$cena_morele1 = 99999;
	if(empty($karty_graficzne))
		$cena_proline2 = 999999;
	if(empty($karty_graficzne2))
		$cena_xkom2 = 99999;
	if(empty($karty_graficzne3))
		$cena_morele2 = 99999;
	
	//obliczanie minimalnej ceny komponentów
	$min_cena_proc = min($cena_proline1, $cena_xkom1, $cena_morele1);
	$min_cena_karta = min($cena_proline2, $cena_xkom2, $cena_morele2);
	$suma = $min_cena_proc+$min_cena_karta;
	switch($min_cena_proc) {
		case $cena_proline1: 
			$zestaw_proc = $nazwa_proline1;
			$sklep_proc = "Proline.pl";
			break;
		case $cena_xkom1:
			$zestaw_proc = $nazwa_xkom1;
			$sklep_proc = "X-KOM.pl";
			break;
		case $cena_morele1:
			$zestaw_proc = $nazwa_morele1;
			$sklep_proc = "Morele.net";
			break;
	}
	switch($min_cena_karta) {
		case $cena_proline2: 
			$zestaw_karta = $nazwa_proline2;
			$sklep_karta = "Proline.pl";
			break;
		case $cena_xkom2:
			$zestaw_karta = $nazwa_xkom2;
			$sklep_karta = "X-KOM.pl";
			break;
		case $cena_morele2:
			$zestaw_karta = $nazwa_morele2;
			$sklep_karta = "Morele.net";
			break;
	}
	
	//tabelka z wynikami zestawu
	echo "<h3>Najtanszy zestaw:</h3>";
	echo '<table border="1">
	<caption align="top"><b>Najtanszy zestaw</b></caption>
	<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th><th style="cursor: pointer;">Sklep</th></tr></thead><tbody>';
	echo '<tr><td>'.$zestaw_proc.'</td>'; 
	echo '<td>'.$min_cena_proc.'</td>';
	echo '<td>'.$sklep_proc.'</td></tr>';
	echo '<tr><td>'.$zestaw_karta.'</td>';
	echo '<td>'.$min_cena_karta.'</td>';
	echo '<td>'.$sklep_karta.'</td></tr>';
	echo '<tr><td><b>Suma do zaplaty</b></td><td><b>'.$suma.'</b></td><td><input type="button" name="zestaw" value="Kup zestaw" onclick="location.href=\'/kup\'"></td></tr>';
	echo '</tbody></table><br />';
	
 	echo "<p>Wyniki wyszukiwania w sklepach:</p>";
	
	//Wyniki dla proline.pl
	echo "<h3>SKLEP PROLINE.PL:</h3>";
	if(empty($proc_nazwa)) {
		echo "Nie znaleziono wynikow dla procesora w sklepie. Procesor nie jest dostepny w sklepie w tym momencie.<br />";
	}
	else {
	//tabelka z wynikami dla procesorów proline
		echo '<table border="1" class="sortable"> 
		<caption align="top"><b>Procesory</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($proc_nazwa); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$proc_nazwa[$i].'</td>';
				echo '<td>'.$proc_cena[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	if(empty($karta_nazwa)) {
		echo "Nie znaleziono wynikow dla karty graficznej w sklepie. Karta graficzna nie jest dostepna w sklepie w tym momencie.<br />";
	}
	else {
		//tabelka z wynikami dla kart proline
		echo '<table border="1" class="sortable">
		<caption align="top"><b>Karty graficzne</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($karta_nazwa); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$karta_nazwa[$i].'</td>';
				echo '<td>'.$karta_cena[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	
	//Wyniki dla x-kom.pl
	echo "<h3>SKLEP X-KOM.PL:</h3>";
	if(empty($proc_nazwa2)) {
		echo "Nie znaleziono wynikow dla procesora w sklepie. Procesor nie jest dostepny w sklepie w tym momencie.<br />";
	}
	else {
	//tabelka z wynikami dla procesorów x-kom
		echo '<table border="1" class="sortable"> 
		<caption align="top"><b>Procesory</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($proc_nazwa2); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$proc_nazwa2[$i].'</td>';
				echo '<td>'.$proc_cena2[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	if(empty($karta_nazwa2)) {
		echo "Nie znaleziono wynikow dla karty graficznej w sklepie. Karta graficzna nie jest dostepna w sklepie w tym momencie.<br />";
	}
	else {
		//tabelka z wynikami dla kart x-kom
		echo '<table border="1" class="sortable">
		<caption align="top"><b>Karty graficzne</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($karta_nazwa2); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$karta_nazwa2[$i].'</td>';
				echo '<td>'.$karta_cena2[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	
	//Wyniki dla morele.net
	echo "<h3>SKLEP MORELE.NET:</h3>";
	if(empty($proc_nazwa3)) {
		echo "Nie znaleziono wynikow dla procesora w sklepie. Procesor nie jest dostepny w sklepie w tym momencie.<br />";
	}
	else {
	//tabelka z wynikami dla procesorów morele
		echo '<table border="1" class="sortable"> 
		<caption align="top"><b>Procesory</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($proc_nazwa3); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$proc_nazwa3[$i].'</td>';
				echo '<td>'.$proc_cena3[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	if(empty($karta_nazwa3)) {
		echo "Nie znaleziono wynikow dla karty graficznej w sklepie. Karta graficzna nie jest dostepna w sklepie w tym momencie.<br />";
	}
	else {
		//tabelka z wynikami dla kart morele
		echo '<table border="1" class="sortable">
		<caption align="top"><b>Karty graficzne</b></caption>
		<thead><tr><th style="cursor: pointer;">Nazwa</th><th style="cursor: pointer;">Cena (PLN)</th></tr></thead><tbody>';
		for ($i = 0; $i < count($karta_nazwa3); $i++) {
			echo '<tr>'; 
			for ($j = 0 ; $j < 1; $j++) {
				echo '<td>'.$karta_nazwa3[$i].'</td>';
				echo '<td>'.$karta_cena3[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table><br />';
	}
	
$xml = new XMLWriter;
$xml->openURI($_SERVER["DOCUMENT_ROOT"].'/app/sklepy.xml');
$xml->setIndent(true); // makes output cleaner

$xml->startElement('Zestaw');
	$xml->startElement('CPU');
	$xml->writeElement('Nazwa', $zestaw_proc);
	$xml->writeElement('Cena', $min_cena_proc);
	$xml->writeElement('Sklep', $sklep_proc);
	$xml->endElement();	  
	$xml->startElement('GPU');
	$xml->writeElement('Nazwa', $zestaw_karta);
	$xml->writeElement('Cena', $min_cena_karta);
	$xml->writeElement('Sklep', $sklep_karta);
	$xml->endElement();	  
$xml->endElement();	
?>
</body>
</html>