<?php
/*if (isset($_POST['licz'])) {
	$liczba_a=floatval($_POST['a']); // Konwersja na liczb� zmiennoprzecinkow�
	$liczba_b=floatval($_POST['b']);
	echo "Chcesz obliczy� sum� nast�puj�cych liczb:" . "<br />" . "<b>";
	print_r($liczba_a);
	echo "</b>" . "<br />" . "Oraz:" . "<br />" . "<b>";
	print_r($liczba_b);
	echo "</b>" . "<hr />";
	echo "Ich suma to:" . " <b>";
	$wynik = $liczba_a + $liczba_b;
	echo $wynik;
	echo "</b>";
} else {
	echo "Wpisz liczby.";
}*/
?>


<!-- Formularz dla webserwisu -->
<form action="<?php echo ($_SERVER['SCRIPT_NAME']); ?>" method="POST">
Witamy w konfiguratorze komputera. Podaj swoje kryteria wyboru komputera:<br />
Wydajnosc procesora: <input name="a" /><br />
Wydajnosc karty graficznej: <input name="b" /><br />
<!-- Karta graficzna:
	<select name="firma">
		<option>AMD Radeon</option>
		<option>NVIDIA GeForce</option>
	</select><br /> -->
Przedzial wydajnosci procesora:
	<select name="procesor">
		<option>Bardzo wydajny</option>
		<option>Wydajny</option>
		<option>Srednio wydajny</option>
		<option>Ekonomiczny</option>
		<option>Biurowy</option>
	</select><br />
Przedzial wydajnosci karty graficznej:
	<select name="karta">
		<option>Bardzo wydajny</option>
		<option>Wydajny</option>
		<option>Srednio wydajny</option>
		<option>Ekonomiczny</option>
		<option>Biurowy</option>
	</select><br />
<input type="submit" name="licz" value="Pokaz propozycje" />

</form>

<?php
require('simple_html_dom.php'); //parser
$gpu = file_get_html("http://www.futuremark.com/hardware/gpu"); //strona z list� gpu
$cpu = file_get_html("http://www.futuremark.com/hardware/cpu"); //strona z list� cpu

//funkcja do przeszukiwania warto�ci tablicy
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
			
//tablica punkt�w cpu	
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
	$TabCPU = array_combine($punkty_cpu,$proce);	//tablica procesor�w, gdzie kluczem jest nazwa, a waro�ci� punkty
	
	$procesory = array_search2("/(^Intel(?!.*-2)(?!.*Core 2)(.*\d{4})(?!.*U)(?!.*Q)(?!.*H)(?!.*M).*$)|(^AMD (FX|A\d)(?!.*M).*$)/",$TabCPU);	// regex z zanegowaniem mobilnych procesor�w oraz tych niewyst�puj�cych w sklepach
	foreach($procesory as $k => $v) {
			//echo "$k - $v</br>";
			//echo "$TabCPU[$v]";
			
			//przedzia�y wydajno�ci
			if($procesory[$k] >= 10000) {
				$bardzo_wydajne[] = $procesory[$k];
			}
			else if($procesory[$k] < 10000 && $procesory[$k] >= 6400) {
				$wydajne[] = $procesory[$k];
			}
			else if($procesory[$k] < 6400 && $procesory[$k] >= 4200) {
				$srednio_wydajne[] = $procesory[$k];
			}
			else if($procesory[$k] < 4200 && $procesory[$k] >= 3200) {
				$ekonomiczne[] = $procesory[$k];
			}
			else {$biurowe[] = $procesory[$k]; }
		}
/*				echo '<pre>';
				print_r($bardzo_wydajne);
				print_r($wydajne);
				print_r($srednio_wydajne);
				print_r($ekonomiczne);
				print_r($biurowe);				
				echo '</pre>';
*/				
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_POST['procesor'] == 'Bardzo wydajny') {	//wy�wietlanie bardzo wydajnych procesor�w
		foreach($bardzo_wydajne as $k => $v) {
			//echo "$k - $v</br>";
			echo $BWydajne[] = "$TabCPU[$v]";	//przypisanie nazw do tablicy (wcze�niejsze tablice zawieraj� warto�ci)
		}
	}
	else if($_POST['procesor'] == 'Wydajny') {	//wy�wietlanie wydajnych procesor�w
		foreach($wydajne as $k => $v) {
			//echo "$k - $v</br>";
			echo $Wydajne[] = "$TabCPU[$v]";
		}
	}
	else if($_POST['procesor'] == 'Srednio wydajny') {	//wy�wietlanie �rednio wydajnych procesor�w
		foreach($srednio_wydajne as $k => $v) {
			//echo "$k - $v</br>";
			echo $SWydajne[] = "$TabCPU[$v]";
		}
	}
	else if($_POST['procesor'] == 'Ekonomiczny') {	//wy�wietlanie wydajnych procesor�w
		foreach($ekonomiczne as $k => $v) {
			//echo "$k - $v</br>";
			echo $Ekonomiczne[] = "$TabCPU[$v]";
		}
	}
	else if($_POST['procesor'] == 'Biurowy') {	//wy�wietlanie wydajnych procesor�w
		foreach($biurowe as $k => $v) {
			//echo "$k - $v</br>";
			$Biurowe[] = "$TabCPU[$v]";
		}
				echo $Biurowe[0];
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
            IF(!preg_match('/Radeon|GeForce|Intel|FirePro|NVS/',$value)){	//usuwanie element�w z tablicy, kt�re nie s� nazw� karty
				unset($karty[$key]);
			}
		}
		$karty = array_values($karty);
		array_walk($karty, 'trim_value');	// usuwa odst�py z pocz�tku dla kazdego elementu tablicy
		//echo '<pre>';  
		//print_r($karty);  //wy�wietlanie tablicy
		//echo '</pre>';
			
//tworzenie tablicy punkt�w gpu
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
	$TabGPU = array_combine($punkty_gpu,$karty);	//tablica kart, gdzie klucz to punkty, warto�� to nazwa
		
	$karty_graficzne = array_search2("/(^AMD Radeon R\d(?!.*M).*$)|(^... Radeon HD (5|6)450.*$)|(^NVIDIA GeForce(?!.*(4|5)\d\d)(?!.*M).*$)/",$TabGPU);	// regex z zanegowaniem mobilnych kart oraz tych niewyst�puj�cych w sklepach
	foreach($karty_graficzne as $k => $v) {
			//echo "$k - $v</br>";
			//echo "$TabGPU[$v]";
			
			//przedzia�y wydajno�ci
			if($karty_graficzne[$k] >= 15000) {
				$bardzo_wydajne2[] = $karty_graficzne[$k];
			}
			else if($karty_graficzne[$k] < 15000 && $karty_graficzne[$k] >= 8000) {
				$wydajne2[] = $karty_graficzne[$k];
			}
			else if($karty_graficzne[$k] < 8000 && $karty_graficzne[$k] >= 5000) {
				$srednio_wydajne2[] = $karty_graficzne[$k];
			}
			else if($karty_graficzne[$k] < 5000 && $karty_graficzne[$k] >= 2000) {
				$ekonomiczne2[] = $karty_graficzne[$k];
			}
			else {$biurowe2[] = $karty_graficzne[$k]; }
		}
		
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_POST['karta'] == 'Bardzo wydajny') {	//wy�wietlanie bardzo wydajnych kart
		foreach($bardzo_wydajne2 as $k => $v) {
			echo $BWydajne2[] = "$TabGPU[$v]";	//przypisanie nazw do tablicy (wcze�niejsze tablice zawieraj� warto�ci)
		}
	}
	else if($_POST['karta'] == 'Wydajny') {	//wy�wietlanie wydajnych kart
		foreach($wydajne2 as $k => $v) {
			echo $Wydajne2[] = "$TabGPU[$v]";
		}
	}
	else if($_POST['karta'] == 'Srednio wydajny') {	//wy�wietlanie �rednio wydajnych kart
		foreach($srednio_wydajne2 as $k => $v) {
			echo $SWydajne2[] = "$TabGPU[$v]";
		}
	}
	else if($_POST['karta'] == 'Ekonomiczny') {	//wy�wietlanie wydajnych kart
		foreach($ekonomiczne2 as $k => $v) {
			echo $Ekonomiczne2[] = "$TabGPU[$v]";
		}
	}
	else if($_POST['karta'] == 'Biurowy') {	//wy�wietlanie wydajnych kart
		foreach($biurowe2 as $k => $v) {
			echo $Biurowe2[] = "$TabGPU[$v]";
		}
			//	echo $Biurowe2[0];
	}
}		
/*		
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_POST['firma'] == 'AMD Radeon') {	// wy�wietlanie wynik�w dla amd bez mobilnych kart
		$wynikAMD = array_search2("/^AMD(?!.*M).*$/",$karty);	// regex z zanegowaniem M (mobilne karty)
		foreach($wynikAMD as $k => $v) {
			echo "$karty[$v]";
		}
	}
	else if($_POST['firma'] == 'NVIDIA GeForce') {	// wy�wietlanie dla nvidii bez mobilnych kart
		$wynikNVIDIA = array_search2("/^NVIDIA(?!.*M).*$/",$karty);
		foreach($wynikNVIDIA as $k => $v) {
			echo "$karty[$v]";
		}
	}
}
*/		
				//echo preg_replace('/Radeon/', '', $karta);
			/*preg_match_all('/^AMD/', $_POST['firma'], $dopasowanie);
			echo "<pre>";
			var_dump ($dopasowanie);
			echo "</pre>";

			exit;*/

?>