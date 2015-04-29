<?php
/*if (isset($_POST['licz'])) {
	$liczba_a=floatval($_POST['a']); // Konwersja na liczbê zmiennoprzecinkow¹
	$liczba_b=floatval($_POST['b']);
	echo "Chcesz obliczyæ sumê nastêpuj¹cych liczb:" . "<br />" . "<b>";
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
Karta graficzna:
	<select name="firma">
		<option>AMD Radeon</option>
		<option>NVIDIA GeForce</option>
	</select><br />
<input type="submit" name="licz" value="Pokaz propozycje" />

</form>

<?php
require('simple_html_dom.php');
$html = file_get_html("http://www.futuremark.com/hardware/gpu");


			foreach($html->find(".productnameBold") as $element) {
				$karta = $element->innertext.'<br>';
				echo $karta;
				//echo preg_replace('/Radeon/', '', $karta);
			}

			/*preg_match_all('/^AMD/', $_POST['firma'], $dopasowanie);
			echo "<pre>";
			var_dump ($dopasowanie);
			echo "</pre>";

			exit;*/
				
//function FilterData($data) {
// $data = stripslashes(htmlspecialchars(trim($data)));
//return $data;
//}
//$firma = FilterData($_POST['firma']);

/*	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		(preg_match('/^AMD/', $_POST['firma']));
			foreach($html->find(".productnameBold") as $element)
				echo $element->innertext.'<br>';
		}
	else
	{
		echo '';	
	}
*/

//foreach($html->find(".productnameBold") as $element)
//	echo $element->innertext.'<br>';
//echo $info['nazwa'] = $html->find(".productnameBold",1)->href;
//echo $es = $html->find('text');
?>