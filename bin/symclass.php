<?
/**
 * Генератор классификатора символов для Jevix
 * @author ur001 <ur001ur001@gmail.com>, http://ur001.habrahabr.ru
 * 
 * В Jevix::$chClasses уже есть сгенерированный классификатор
 * Этот файл необходим только чтобы изменить правила классификации
 */

require '../src/Jevix/Jevix.php';

use Jevix\Func;
use Jevix\Jevix;

//РЕНДЕРИНГ КЛАССИФИКАТОРА СИМВОЛОВ
function addChClass(&$tbl, $chars, $class, $add = false){
	foreach($chars as $ch) {
		$ord = uniord($ch);
		if(!$add || !isset($tbl[$ord])){
			$tbl[$ord] = $class;
		} else {
			$tbl[$ord] = (isset($tbl[$ord]) ? $tbl[$ord] : 0) | $class;	
		}		
	}
}

function addChRangeClass(&$tbl, $chFrom, $chTo, $class, $add = false){
	for($i = $chFrom; $i<=$chTo; $i++) {
		if(!$add || !isset($tbl[$i])){
			$tbl[$i] = $class;
		} else {
			$tbl[$i] = (isset($tbl[$i]) ? $tbl[$i] : 0) | $class;	
		}
	}
}

addChRangeClass($tbl, 0, 0x20, Jevix::NOPRINT);
addChRangeClass($tbl, Func::uniord('a'), Func::uniord('z'), Jevix::ALPHA | Jevix::LAT |  Jevix::PRINATABLE | Jevix::NAME);
addChRangeClass($tbl, Func::uniord('A'), Func::uniord('Z'), Jevix::ALPHA | Jevix::LAT |  Jevix::PRINATABLE | Jevix::NAME);
addChRangeClass($tbl, Func::uniord('а'), Func::uniord('я'), Jevix::ALPHA | Jevix::PRINATABLE | Jevix::RUS);
addChRangeClass($tbl, Func::uniord('А'), Func::uniord('Я'), Jevix::ALPHA | Jevix::PRINATABLE | Jevix::RUS);
addChRangeClass($tbl, Func::uniord('0'), Func::uniord('9'), Jevix::NUMERIC | Jevix::NAME | Jevix::PRINATABLE | Jevix::URL);
addChClass($tbl, array(' ', "\t"), Jevix::SPACE);
addChClass($tbl, array("\r", "\n"), Jevix::NL, true);
addChClass($tbl, array('"'), Jevix::TAG_QUOTE  | Jevix::HTML_QUOTE | Jevix::TAG_QUOTE | Jevix::QUOTE_OPEN | Jevix::QUOTE_CLOSE| Jevix::PRINATABLE);
addChClass($tbl, array("'"), Jevix::TAG_QUOTE  | Jevix::TAG_QUOTE | Jevix::PRINATABLE);
addChClass($tbl, array('.', ',', '!', '?', ':', ';'), Jevix::PUNCTUATUON | Jevix::PRINATABLE, true);
addChClass($tbl, array('ё', 'Ё'), Jevix::ALPHA | Jevix::PRINATABLE | Jevix::RUS);
addChClass($tbl, array('/', '.', '&', '?', '%', '-', '_', '=', ';', '+', '#', '|'),  Jevix::URL | Jevix::PRINATABLE, true);

ob_start();
var_export($tbl);
$res = ob_get_clean();
print str_replace(array("\n", ' '), '', $res).';';
