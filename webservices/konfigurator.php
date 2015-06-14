<!DOCTYPE html>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">

<!-- Formularz dla webserwisu -->
<form action="konfigurator" method="POST">

Witamy w konfiguratorze komputera. Podaj swoje kryteria wyboru komputera:<br />
<!-- Karta graficzna:
	<select name="firma">
		<option>AMD Radeon</option>
		<option>NVIDIA GeForce</option>
	</select><br /> -->
Przedzial wydajnosci procesora:
	<select id="proc" name="procesor">
		<option></option>
		<option>Bardzo wydajny</option>
		<option>Wydajny</option>
		<option>Srednio wydajny</option>
		<option>Ekonomiczny</option>
		<option>Biurowy</option>
	</select><br />
<label for="amount01">Przedzial punktowy procesora:</label>
<input type="text" id="amount01" name="amount01" hidden size="4" readonly style="border:0; color:#f6931f; font-weight:bold;"><input type="text" id="a1" value="-" size="1" readonly style="border:0" hidden><input type="text" id="amount02" name="amount02" hidden readonly style="border:0; color:#f6931f; font-weight:bold;">
<div id="slider-range01" hidden></div>
<div id="slider-range02" hidden></div>
<div id="slider-range03" hidden></div>
<div id="slider-range04" hidden></div>
<div id="slider-range05" hidden></div><br />
Przedzial wydajnosci karty graficznej:
	<select id="karta_graf" name="karta">
		<option></option>
		<option>Bardzo wydajny</option>
		<option>Wydajny</option>
		<option>Srednio wydajny</option>
		<option>Ekonomiczny</option>
		<option>Biurowy</option>
	</select><br />
<label for="amount2">Przedzial punktowy karty graficznej:</label>
<input type="text" id="amount11" name="amount11" hidden size="4" readonly style="border:0; color:#f6931f; font-weight:bold;"><input type="text" id="a2" value="-" size="1" readonly style="border:0" hidden><input type="text" id="amount12" name="amount12" hidden readonly style="border:0; color:#f6931f; font-weight:bold;">
<div id="slider-range1" hidden></div>
<div id="slider-range2" hidden></div>
<div id="slider-range3" hidden></div>
<div id="slider-range4" hidden></div>
<div id="slider-range5" hidden></div>
<br />
<input type="submit" name="licz" value="Pokaz propozycje" />
</form>

<script>
//wybór przedzia³u punktowego procesora
$( "#proc" ).change(function() {
	var selection = document.getElementById("proc").options.selectedIndex;
	if(selection == 1) {
		//slider dla procesorów bardzo wydajnych
		$( "#slider-range01" ).slider({
			range: true,
			min: 10000,
			max: 12501,
			values: [ 10000, 12501 ],
			slide: function( event, ui ) {
				$( "#amount01" ).val( "" + ui.values[ 0 ]);
				$( "#amount02" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount01" ).val( "" + $( "#slider-range01" ).slider( "values", 0 ) );
		$( "#amount02" ).val( "" + $( "#slider-range01" ).slider( "values", 1 ) );
		$("#slider-range01, #amount01, #amount02, #a1").show();
		$("#slider-range02").hide();
		$("#slider-range03").hide();
		$("#slider-range04").hide();
		$("#slider-range05").hide();
	}
	else if(selection == 2) {
		//slider dla procesorów wydajnych
		$( "#slider-range02" ).slider({
			range: true,
			min: 6400,
			max: 9999,
			values: [ 6400, 9999 ],
			slide: function( event, ui ) {
				$( "#amount01" ).val( "" + ui.values[ 0 ]);
				$( "#amount02" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount01" ).val( "" + $( "#slider-range02" ).slider( "values", 0 ) );
		$( "#amount02" ).val( "" + $( "#slider-range02" ).slider( "values", 1 ) );
		$("#slider-range01").hide();
		$("#slider-range02, #amount01, #amount02, #a1").show();
		$("#slider-range03").hide();
		$("#slider-range04").hide();
		$("#slider-range05").hide();
	}
	else if(selection == 3) {
		//slider dla proceosrów œrednio wydajnych
		$( "#slider-range03" ).slider({
			range: true,
			min: 4200,
			max: 6399,
			values: [ 4200, 6399 ],
			slide: function( event, ui ) {
				$( "#amount01" ).val( "" + ui.values[ 0 ]);
				$( "#amount02" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount01" ).val( "" + $( "#slider-range03" ).slider( "values", 0 ) );
		$( "#amount02" ).val( "" + $( "#slider-range03" ).slider( "values", 1 ) );
		$("#slider-range01").hide();
		$("#slider-range02").hide();
		$("#slider-range03, #amount01, #amount02, #a1").show();
		$("#slider-range04").hide();
		$("#slider-range05").hide();
	}
	else if(selection == 4) {
		//slider dla procesorów ekonomicznych
		$( "#slider-range04" ).slider({
			range: true,
			min: 3200,
			max: 4199,
			values: [ 3200, 4199 ],
			slide: function( event, ui ) {
				$( "#amount01" ).val( "" + ui.values[ 0 ]);
				$( "#amount02" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount01" ).val( "" + $( "#slider-range04" ).slider( "values", 0 ) );
		$( "#amount02" ).val( "" + $( "#slider-range04" ).slider( "values", 1 ) );
		$("#slider-range01").hide();
		$("#slider-range02").hide();
		$("#slider-range03").hide();
		$("#slider-range04, #amount01, #amount02, #a1").show();
		$("#slider-range05").hide();
	}
	else if(selection == 5) {
		//slider dla procesorów biurowych
		$( "#slider-range05" ).slider({
			range: true,
			min: 1700,
			max: 3199,
			values: [ 1700, 3199 ],
			slide: function( event, ui ) {
				$( "#amount01" ).val( "" + ui.values[ 0 ]);
				$( "#amount02" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount01" ).val( "" + $( "#slider-range05" ).slider( "values", 0 ) );
		$( "#amount02" ).val( "" + $( "#slider-range05" ).slider( "values", 1 ) );
		$("#slider-range01").hide();
		$("#slider-range02").hide();
		$("#slider-range03").hide();
		$("#slider-range04").hide();
		$("#slider-range05, #amount01, #amount02, #a1").show();
	}
	else {
		$("#slider-range01, #amount01, #amount02, #a1").hide();
		$("#slider-range02").hide();
		$("#slider-range03").hide();
		$("#slider-range04").hide();
		$("#slider-range05").hide();
	}
});

//wybór przedzia³u punktowego karty graficznej
$( "#karta_graf" ).change(function() {
	var selection = document.getElementById("karta_graf").options.selectedIndex;
	if(selection == 1) {
		//slider dla kart bardzo wydajnych
		$( "#slider-range1" ).slider({
			range: true,
			min: 15000,
			max: 26811,
			values: [ 15000, 26811 ],
			slide: function( event, ui ) {
				$( "#amount11" ).val( "" + ui.values[ 0 ]);
				$( "#amount12" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount11" ).val( "" + $( "#slider-range1" ).slider( "values", 0 ) );
		$( "#amount12" ).val( "" + $( "#slider-range1" ).slider( "values", 1 ) );
		$("#slider-range1, #amount11, #amount12, #a2").show();
		$("#slider-range2").hide();
		$("#slider-range3").hide();
		$("#slider-range4").hide();
		$("#slider-range5").hide();
	}
	else if(selection == 2) {
		//slider dla kart wydajnych
		$( "#slider-range2" ).slider({
			range: true,
			min: 8000,
			max: 14999,
			values: [ 8000, 14999 ],
			slide: function( event, ui ) {
				$( "#amount11" ).val( "" + ui.values[ 0 ]);
				$( "#amount12" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount11" ).val( "" + $( "#slider-range2" ).slider( "values", 0 ) );
		$( "#amount12" ).val( "" + $( "#slider-range2" ).slider( "values", 1 ) );
		$("#slider-range1").hide();
		$("#slider-range2, #amount11, #amount12, #a2").show();
		$("#slider-range3").hide();
		$("#slider-range4").hide();
		$("#slider-range5").hide();
	}
	else if(selection == 3) {
		//slider dla kart œrednio wydajnych
		$( "#slider-range3" ).slider({
			range: true,
			min: 5000,
			max: 7999,
			values: [ 5000, 7999 ],
			slide: function( event, ui ) {
				$( "#amount11" ).val( "" + ui.values[ 0 ]);
				$( "#amount12" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount11" ).val( "" + $( "#slider-range3" ).slider( "values", 0 ) );
		$( "#amount12" ).val( "" + $( "#slider-range3" ).slider( "values", 1 ) );
		$("#slider-range1").hide();
		$("#slider-range2").hide();
		$("#slider-range3, #amount11, #amount12, #a2").show();
		$("#slider-range4").hide();
		$("#slider-range5").hide();
	}
	else if(selection == 4) {
		//slider dla kart ekonomicznych
		$( "#slider-range4" ).slider({
			range: true,
			min: 2000,
			max: 4999,
			values: [ 2000, 4999 ],
			slide: function( event, ui ) {
				$( "#amount11" ).val( "" + ui.values[ 0 ]);
				$( "#amount12" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount11" ).val( "" + $( "#slider-range4" ).slider( "values", 0 ) );
		$( "#amount12" ).val( "" + $( "#slider-range4" ).slider( "values", 1 ) );
		$("#slider-range1").hide();
		$("#slider-range2").hide();
		$("#slider-range3").hide();
		$("#slider-range4, #amount11, #amount12, #a2").show();
		$("#slider-range5").hide();
	}
	else if(selection == 5) {
		//slider dla kart biurowych
		$( "#slider-range5" ).slider({
			range: true,
			min: 300,
			max: 1999,
			values: [ 300, 1999 ],
			slide: function( event, ui ) {
				$( "#amount11" ).val( "" + ui.values[ 0 ]);
				$( "#amount12" ).val( "" + ui.values[ 1 ] );
			}
		});
		$( "#amount11" ).val( "" + $( "#slider-range5" ).slider( "values", 0 ) );
		$( "#amount12" ).val( "" + $( "#slider-range5" ).slider( "values", 1 ) );
		$("#slider-range1").hide();
		$("#slider-range2").hide();
		$("#slider-range3").hide();
		$("#slider-range4").hide();
		$("#slider-range5, #amount11, #amount12, #a2").show();
	}
		else {
		$("#slider-range1, #amount11, #amount12, #a2").hide();
		$("#slider-range2").hide();
		$("#slider-range3").hide();
		$("#slider-range4").hide();
		$("#slider-range5").hide();
	}
});
</script>
<br />
</html>

<?php
error_reporting(0); //wy³¹cza raportowanie b³êdów
require('simple_html_dom.php'); //parser html
$gpu = file_get_html("http://www.futuremark.com/hardware/gpu"); //strona z list¹ gpu
$cpu = file_get_html("http://www.futuremark.com/hardware/cpu"); //strona z list¹ cpu

//funkcja do przeszukiwania wartoœci tablicy
		function array_search2($regex,$array){
			foreach($array as $key => $value){
                IF(preg_match($regex,$value)){$result[] = $key;}
			}
			IF(!empty($result)){
                return $result;
        }else{
                return false;
			}
		}

//tworzenie tablicy nazw cpu
			foreach($cpu->find(".productnameBold") as $element) {
				$proc = $element->innertext.'<br>';
				$proce[] = $proc;
			}
			
//tablica punktów cpu	
			foreach($cpu->find('.barScore') as $element) {
				$pktCPU = $element->innertext.'<br>';
				$punktyCPU[] = $pktCPU;
				$punkty_cpu[]=intval($pktCPU);	//konwersja na int
			}

			foreach($punkty_cpu as $k => $v) {	//usuwanie tego co nie jest punktami
				if($punkty_cpu[$k] < 1500) {
					unset($punkty_cpu[$k]);
				}
			}
	$punkty_cpu = array_values($punkty_cpu);
	$TabCPU = array_combine($punkty_cpu,$proce);	//tablica procesorów, gdzie kluczem jest nazwa, a waroœci¹ punkty
	
	$procesory = array_search2("/(^Intel(?!.*-2)(?!.*E\d\d\d\d)(?!.*Core 2)(.*\d{4})(?!.*U)(?!.*Q)(?!.*H)(?!.*M).*$)|(^AMD (FX|A\d)(?!.*M).*$)/",$TabCPU);	// regex z zanegowaniem mobilnych procesorów oraz tych niewystêpuj¹cych w sklepach

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$min_proc = intval($_POST['amount01']);
	$max_proc = intval($_POST['amount02']);

	foreach($procesory as $k => $v) {
		//echo "$k - $v</br>";
		//echo "$TabCPU[$v]";
			
		//tablica procesorów po ustaleniu przedzia³u ze sliderów
		if($procesory[$k] < $max_proc && $procesory[$k] >= $min_proc) {
			$procki[] = $procesory[$k];
		}
	}
	foreach($procki as $k => $v) {
		//echo "$k - $v</br>";
		$Procki[] = "$TabCPU[$v]";	//przypisanie nazw do tablicy (wczeœniejsze tablice zawieraj¹ wartoœci)
	}
	if(empty($Procki)) {
		echo "Nie znaleziono procesora w podanym przedziale. Podaj inny przedzial punktowy.<br />";
	}
	else {
		echo "Procesor: ", $Procki[0];	//pierwszy element tablicy dla przedzia³u (najwydajniejszy procesor w przedziale)
	}
}
		
//tworzenie tablicy nazw gpu
		foreach($gpu->find(".overviewtablerow") as $element) {
			$karta = $element->plaintext.'<br>';
			$karty[] = $karta;
			//echo $karta;
		}
		function trim_value(&$value) { 
			$value = trim($value); 
		}
		foreach($karty as $key => $value){
            IF(!preg_match('/Radeon|GeForce|Intel|FirePro|NVS/',$value)){	//usuwanie elementów z tablicy, które nie s¹ nazw¹ karty
				unset($karty[$key]);
			}
		}
		$karty = array_values($karty);		//porz¹dkuje indeksy tablicy
		array_walk($karty, 'trim_value');	// usuwa odstêpy z pocz¹tku dla kazdego elementu tablicy
		//echo '<pre>';  
		//print_r($karty);  //wyœwietlanie tablicy
		//echo '</pre>';
			
//tworzenie tablicy punktów gpu
		foreach($gpu->find('.barScore') as $element) {
			$pktGPU = $element->innertext.'<br>';
			$punktyGPU[] = $pktGPU;
			$punkty_gpu[]=intval($pktGPU);	//konwersja na int
		}
			//print_r($punktyGPU);
		
	//$punkty_gpu=intval($_POST['b']);

		foreach($punkty_gpu as $k => $v) {	//usuwanie tego co nie jest punktami
			if($punkty_gpu[$k] < 310) {
				unset($punkty_gpu[$k]);
			}
		}
	$punkty_gpu = array_values($punkty_gpu);
	$TabGPU = array_combine($punkty_gpu,$karty);	//tablica kart, gdzie klucz to punkty, wartoœæ to nazwa
		
	$karty_graficzne = array_search2("/(^AMD Radeon R\d(?!.*M).*$)|(^... Radeon HD (5|6)450.*$)|(^NVIDIA GeForce(?!.*(4|5)\d\d)(?!.*M).*$)/",$TabGPU);	// regex z zanegowaniem mobilnych kart oraz tych niewystêpuj¹cych w sklepach

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$min_karta = intval($_POST['amount11']);
	$max_karta = intval($_POST['amount12']);
	
	foreach($karty_graficzne as $k => $v) {
			//echo "$k - $v</br>";
			//echo "$TabGPU[$v]";
			
			//tablica kart graficznych po ustaleniu przedzia³u ze sliderów
		if($karty_graficzne[$k] < $max_karta && $karty_graficzne[$k] >= $min_karta) {
			$karty_graf[] = $karty_graficzne[$k];
		}
	}
	foreach($karty_graf as $k => $v) {
		$Karty[] = "$TabGPU[$v]";	//przypisanie nazw do tablicy (wczeœniejsze tablice zawieraj¹ wartoœci)
	}
	if(empty($Karty)) {
		echo "Nie znaleziono karty graficznej w podanym przedziale. Podaj inny przedzial punktowy.<br />";
	}
	else {
		echo "Karta graficzna: ", $Karty[0];	//pierwszy element tablicy dla przedzia³u (najwydajniejsza karta w przedziale)
	}
	if(!empty($Karty) && !empty($Procki))
		echo '<br /><form action="sklepy" method="POST"><input type="submit" name="sklepy" value="Wyszukaj w sklepach"></form>';
}
	
$xml = new XMLWriter;
$xml->openURI($_SERVER["DOCUMENT_ROOT"].'/app/konfigurator.xml');
$xml->setIndent(true); // makes output cleaner

$xml->startElement('Konfigurator');
//while ($line = fgetcsv($fp)) {
//   if (count($line) < 4) continue; // skip lines that aren't full

//   $xml->startElement();
   $xml->writeElement('CPU', $Procki[0]);
   $xml->writeElement('GPU', $Karty[0]);
   $xml->endElement();
//}


?>