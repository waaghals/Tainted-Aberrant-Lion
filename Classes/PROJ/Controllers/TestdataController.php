<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestdataControllerr
 *
 * @author Dennis
 */

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use \PROJ\Entities\Institute;
use \PROJ\Entities\Account;
use \PROJ\Entities\Student;
use \PROJ\Entities\Project;
use \PROJ\Entities\Review;
use PROJ\Entities\Country;

class TestdataController extends BaseController {

    private function emptyTables($em) {
        $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));
        $command1 = "orm:schema-tool:drop --force";
        $command2 = "orm:schema-tool:update --force";
        $commandarray1 = array_merge(array('doctrine'), explode(" ", $command1));
        $commandarray2 = array_merge(array('doctrine'), explode(" ", $command2));
        \PROJ\Tools\CodeConsoleRunner::run($helperSet, new \Symfony\Component\Console\Input\ArgvInput($commandarray1), new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w')));
        echo "<br />";
        \PROJ\Tools\CodeConsoleRunner::run($helperSet, new \Symfony\Component\Console\Input\ArgvInput($commandarray2), new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w')));
        echo "<br /><br />";
    }

    private function createInstitute($em, $name, $type, $place, $lat, $long) {
        $institute = new Institute();
        $institute->setName($name);
        $institute->setType($type);
        $institute->setPlace($place);
        $institute->setLat($lat);
        $institute->setLng($long);
        $em->persist($institute);
        $em->flush();
        echo "Institute with the following data has been succesfully added to the database:"
        . "<br />Name: " . $name
        . "<br />Type: " . $type
        . "<br />Place: " . $place
        . "<br />Latitude: " . $lat
        . "<br />Longtitude: " . $long
        . "<br /><br />";
        return $institute;
    }

    private function createUser($em, $username, $password, $salt) {
        $account = new Account();
        $account->setUsername($username);
        $hash = hash('sha512', $password . $salt);
        $account->setPassword($hash);
        $account->setSalt($salt);
        $em->persist($account);
        $em->flush();
        echo "New account with the following data has been succesfully added to the database:"
        . "<br />Username: " . $username
        . "<br />Password: " . $password
        . "<br />Salt: " . $salt
        . "<br /><br />";
        return $account;
    }

    private function createStudent($em, $fName, $sName, $street, $housenr, $zipcode, $city, $country, $account, $email) {
        $student = new Student();
        $student->setFirstname($fName);
        $student->setSurname($sName);
        $student->setStreet($street);
        $student->setHousenumber($housenr);
        $student->setZipcode($zipcode);
        $student->setCity($city);
        $student->setCountry($country);
        $student->setAccount($account);
        $student->setEmail($email);
        $em->persist($student);
        $em->flush();
        echo "New student with the following data has been succesfully added to the database:"
        . "<br />Firstname: " . $fName
        . "<br />Surname: " . $sName
        . "<br />Street: " . $street
        . "<br />Housenumber: " . $housenr
        . "<br />Zipcode: " . $zipcode
        . "<br />City: " . $city
        . "<br />Account: " . $account->getUsername()
        . "<br />Email: " . $email
        . "<br /><br />";
        return $student;
    }

    private function createProject($em, $student, $institute, $type, $startDate, $endDate) {
        $project = new Project();
        $project->setStudent($student);
        $project->setInstitute($institute);
        $project->setType($type);
        $project->setStartdate($startDate);
        $project->setendDate($endDate);
        $em->persist($project);
        $em->flush();
        echo "New project with the following data has been succesfully added to the database:"
        . "<br />Student: " . $student->getFirstname() . " " . $student->getSurname()
        . "<br />Institute: " . $institute->getName()       
        . "<br />Type: " . $type
        . "<br /><br />";
        return $project;
    }

    private function createReview($em, $project, $assignRate, $accoRate, $guidRate, $text) {
        $review = new Review();
        $review->setProject($project);
        $review->setAssignmentRating($assignRate);
        $review->setAccommodationRating($accoRate);
        $review->setGuidanceRating($guidRate);
        $review->setText($text);
        $em->persist($review);
        $em->flush();
        echo "New review with the following data has been succesfully added to the database:"
        . "<br />Institute: " . $project->getInstitute()->getName()
        . "<br />Assignment rating: " . $assignRate
        . "<br />Accomodation rating: " . $accoRate
        . "<br />Guidance rating: " . $guidRate
        . "<br />Text: " . $text
        . "<br /><br />";
    }

    private function createCountry($em, $iso_alpha2, $iso_alpha3, $iso_numeric, $fips_code, $name, $capital, $areainsqkm, $population, $continent, $tld, $currency, $languages)
    {
        $country = new Country();
        $country->setIso_alpha2($iso_alpha2);
        $country->setIso_alpha3($iso_alpha3);
        $country->setIso_numeric($iso_numeric);
        $country->setFips_code($fips_code);
        $country->setName($name);
        $country->setCapital($capital);
        $country->setAreainsqkm($areainsqkm);
        $country->setPopulation($population);
        $country->setContinent($continent);
        $country->setTld($tld);
        $country->setCurrency($currency);
        $country->setLanguages($languages);
        $em->persist($country);
        $em->flush();
        echo "New review with the following data has been succesfully added to the database:"
        . "<br />Iso_alpha2: " . $iso_alpha2
        . "<br />Iso_alpha3: " . $iso_alpha3
        . "<br />Iso_numeric: " . $iso_numeric
        . "<br />Fips_code: " . $fips_code
        . "<br />Name: " . $name
        . "<br />Capital: " . $capital
        . "<br />Areainsqkm: " . $areainsqkm
        . "<br />Population: " . $population
        . "<br />Continent: " . $continent
        . "<br />Tld: " . $tld
        . "<br />Currency: " . $currency
        . "<br />Languages: " . $languages
        . "<br /><br />";
    }
    
    public function IndexAction() {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

        $this->emptyTables($em);

        $avans = $this->createInstitute($em, "Avans Hogeschool", "education", "`s-Hertogenbosch", 51.688946, 5.287256);
        $mac = $this->createInstitute($em, "McDonald's", "business", "Arnhem", 51.9635996, 5.8930421);

        $kjansen = $this->createUser($em, "kjansen", "qwerty", "HGJDGFSJHDFJHSDf");
        $hbakker = $this->createUser($em, "hbakker", "password", "E*(%&YUIERHDGFER");

        $kees = $this->createStudent($em, "Kees", "Jansen", "Jansenlaan", 15, "1234AB", "eindhoven", "netherlands", $kjansen, "k.jansen@student.avans.nl");
        $harry = $this->createStudent($em, "Harry", "Bakker", "Bakkersweg", 15, "5678CD", "utrecht", "netherlands", $hbakker, "h.bakker@student.avans.nl");

        $projectX = $this->createProject($em, $kees, $avans, "internship", new \DateTime('03/17/2014'), new \DateTime('05/17/2014'));
        $projectZ = $this->createProject($em, $harry, $mac, "minor", new \DateTime('02/04/2014'), new \DateTime('06/20/2014'));

        $this->createReview($em, $projectX, 5, 3, 4, "Many fun activities to do here!");
        $this->createReview($em, $projectZ, 4, 4, 1, "Just do your job and they're happy.");
        
        $this->createCountry(1, 'AD', 'AND', 20, 'AN', 'Andorra', 'Andorra la Vella', 468, 84000, 'EU', '', 'EUR', '.ad');
        $this->createCountry(2, 'AE', 'ARE', 784, 'AE', 'United Arab Emirates', 'Abu Dhabi', 82880, 4975593, 'AS', '', 'AED', '.ae');
        $this->createCountry(3, 'AF', 'AFG', 4, 'AF', 'Afghanistan', 'Kabul', 647500, 29121286, 'AS', '', 'AFN', '.af');
        $this->createCountry(4, 'AG', 'ATG', 28, 'AC', 'Antigua and Barbuda', 'St. John\'s', 443, 86754, 'NA', '', 'XCD', '.ag');
        $this->createCountry(5, 'AI', 'AIA', 660, 'AV', 'Anguilla', 'The Valley', 102, 13254, 'NA', '', 'XCD', '.ai');
        $this->createCountry(6, 'AL', 'ALB', 8, 'AL', 'Albania', 'Tirana', 28748, 2986952, 'EU', '', 'ALL', '.al');
        $this->createCountry(7, 'AM', 'ARM', 51, 'AM', 'Armenia', 'Yerevan', 29800, 2968000, 'AS', '', 'AMD', '.am');
        $this->createCountry(8, 'AO', 'AGO', 24, 'AO', 'Angola', 'Luanda', 1246700, 13068161, 'AF', '', 'AOA', '.ao');
        $this->createCountry(9, 'AQ', 'ATA', 10, 'AY', 'Antarctica', '', 14000000, 0, 'AN', '', '', '.aq');
        $this->createCountry(10, 'AR', 'ARG', 32, 'AR', 'Argentina', 'Buenos Aires', 2766890, 41343201, 'SA', '', 'ARS', '.ar');
        $this->createCountry(11, 'AS', 'ASM', 16, 'AQ', 'American Samoa', 'Pago Pago', 199, 57881, 'OC', '', 'USD', '.as');
        $this->createCountry(12, 'AT', 'AUT', 40, 'AU', 'Austria', 'Vienna', 83858, 8205000, 'EU', '', 'EUR', '.at');
        $this->createCountry(13, 'AU', 'AUS', 36, 'AS', 'Australia', 'Canberra', 7686850, 21515754, 'OC', '', 'AUD', '.au');
        $this->createCountry(14, 'AW', 'ABW', 533, 'AA', 'Aruba', 'Oranjestad', 193, 71566, 'NA', '', 'AWG', '.aw');
        $this->createCountry(15, 'AX', 'ALA', 248, '', 'Aland Islands', 'Mariehamn', 0, 26711, 'EU', '', 'EUR', '.ax');
        $this->createCountry(16, 'AZ', 'AZE', 31, 'AJ', 'Azerbaijan', 'Baku', 86600, 8303512, 'AS', '', 'AZN', '.az');
        $this->createCountry(17, 'BA', 'BIH', 70, 'BK', 'Bosnia and Herzegovina', 'Sarajevo', 51129, 4590000, 'EU', '', 'BAM', '.ba');
        $this->createCountry(18, 'BB', 'BRB', 52, 'BB', 'Barbados', 'Bridgetown', 431, 285653, 'NA', '', 'BBD', '.bb');
        $this->createCountry(19, 'BD', 'BGD', 50, 'BG', 'Bangladesh', 'Dhaka', 144000, 156118464, 'AS', '', 'BDT', '.bd');
        $this->createCountry(20, 'BE', 'BEL', 56, 'BE', 'Belgium', 'Brussels', 30510, 10403000, 'EU', '', 'EUR', '.be');
        $this->createCountry(21, 'BF', 'BFA', 854, 'UV', 'Burkina Faso', 'Ouagadougou', 274200, 16241811, 'AF', '', 'XOF', '.bf');
        $this->createCountry(22, 'BG', 'BGR', 100, 'BU', 'Bulgaria', 'Sofia', 110910, 7148785, 'EU', '', 'BGN', '.bg');
        $this->createCountry(23, 'BH', 'BHR', 48, 'BA', 'Bahrain', 'Manama', 665, 738004, 'AS', '', 'BHD', '.bh');
        $this->createCountry(24, 'BI', 'BDI', 108, 'BY', 'Burundi', 'Bujumbura', 27830, 9863117, 'AF', '', 'BIF', '.bi');
        $this->createCountry(25, 'BJ', 'BEN', 204, 'BN', 'Benin', 'Porto-Novo', 112620, 9056010, 'AF', '', 'XOF', '.bj');
        $this->createCountry(26, 'BL', 'BLM', 652, 'TB', 'Saint Barthelemy', 'Gustavia', 21, 8450, 'NA', '', 'EUR', '.gp');
        $this->createCountry(27, 'BM', 'BMU', 60, 'BD', 'Bermuda', 'Hamilton', 53, 65365, 'NA', '', 'BMD', '.bm');
        $this->createCountry(28, 'BN', 'BRN', 96, 'BX', 'Brunei', 'Bandar Seri Begawan', 5770, 395027, 'AS', '', 'BND', '.bn');
        $this->createCountry(29, 'BO', 'BOL', 68, 'BL', 'Bolivia', 'Sucre', 1098580, 9947418, 'SA', '', 'BOB', '.bo');
        $this->createCountry(30, 'BQ', 'BES', 535, '', 'Bonaire, Saint Eustatius and Saba ', '', 0, 18012, 'NA', '', 'USD', '.bq');
        $this->createCountry(31, 'BR', 'BRA', 76, 'BR', 'Brazil', 'Brasilia', 8511965, 201103330, 'SA', '', 'BRL', '.br');
        $this->createCountry(32, 'BS', 'BHS', 44, 'BF', 'Bahamas', 'Nassau', 13940, 301790, 'NA', '', 'BSD', '.bs');
        $this->createCountry(33, 'BT', 'BTN', 64, 'BT', 'Bhutan', 'Thimphu', 47000, 699847, 'AS', '', 'BTN', '.bt');
        $this->createCountry(34, 'BV', 'BVT', 74, 'BV', 'Bouvet Island', '', 0, 0, 'AN', '', 'NOK', '.bv');
        $this->createCountry(35, 'BW', 'BWA', 72, 'BC', 'Botswana', 'Gaborone', 600370, 2029307, 'AF', '', 'BWP', '.bw');
        $this->createCountry(36, 'BY', 'BLR', 112, 'BO', 'Belarus', 'Minsk', 207600, 9685000, 'EU', '', 'BYR', '.by');
        $this->createCountry(37, 'BZ', 'BLZ', 84, 'BH', 'Belize', 'Belmopan', 22966, 314522, 'NA', '', 'BZD', '.bz');
        $this->createCountry(38, 'CA', 'CAN', 124, 'CA', 'Canada', 'Ottawa', 9984670, 33679000, 'NA', '', 'CAD', '.ca');
        $this->createCountry(39, 'CC', 'CCK', 166, 'CK', 'Cocos Islands', 'West Island', 14, 628, 'AS', '', 'AUD', '.cc');
        $this->createCountry(40, 'CD', 'COD', 180, 'CG', 'Democratic Republic of the Congo', 'Kinshasa', 2345410, 70916439, 'AF', '', 'CDF', '.cd');
        $this->createCountry(41, 'CF', 'CAF', 140, 'CT', 'Central African Republic', 'Bangui', 622984, 4844927, 'AF', '', 'XAF', '.cf');
        $this->createCountry(42, 'CG', 'COG', 178, 'CF', 'Republic of the Congo', 'Brazzaville', 342000, 3039126, 'AF', '', 'XAF', '.cg');
        $this->createCountry(43, 'CH', 'CHE', 756, 'SZ', 'Switzerland', 'Berne', 41290, 7581000, 'EU', '', 'CHF', '.ch');
        $this->createCountry(44, 'CI', 'CIV', 384, 'IV', 'Ivory Coast', 'Yamoussoukro', 322460, 21058798, 'AF', '', 'XOF', '.ci');
        $this->createCountry(45, 'CK', 'COK', 184, 'CW', 'Cook Islands', 'Avarua', 240, 21388, 'OC', '', 'NZD', '.ck');
        $this->createCountry(46, 'CL', 'CHL', 152, 'CI', 'Chile', 'Santiago', 756950, 16746491, 'SA', '', 'CLP', '.cl');
        $this->createCountry(47, 'CM', 'CMR', 120, 'CM', 'Cameroon', 'Yaounde', 475440, 19294149, 'AF', '', 'XAF', '.cm');
        $this->createCountry(48, 'CN', 'CHN', 156, 'CH', 'China', 'Beijing', 9596960, 1330044000, 'AS', '', 'CNY', '.cn');
        $this->createCountry(49, 'CO', 'COL', 170, 'CO', 'Colombia', 'Bogota', 1138910, 44205293, 'SA', '', 'COP', '.co');
        $this->createCountry(50, 'CR', 'CRI', 188, 'CS', 'Costa Rica', 'San Jose', 51100, 4516220, 'NA', '', 'CRC', '.cr');
        $this->createCountry(51, 'CU', 'CUB', 192, 'CU', 'Cuba', 'Havana', 110860, 11423000, 'NA', '', 'CUP', '.cu');
        $this->createCountry(52, 'CV', 'CPV', 132, 'CV', 'Cape Verde', 'Praia', 4033, 508659, 'AF', '', 'CVE', '.cv');
        $this->createCountry(53, 'CW', 'CUW', 531, 'UC', 'Curacao', ' Willemstad', 0, 141766, 'NA', '', 'ANG', '.cw');
        $this->createCountry(54, 'CX', 'CXR', 162, 'KT', 'Christmas Island', 'Flying Fish Cove', 135, 1500, 'AS', '', 'AUD', '.cx');
        $this->createCountry(55, 'CY', 'CYP', 196, 'CY', 'Cyprus', 'Nicosia', 9250, 1102677, 'EU', '', 'EUR', '.cy');
        $this->createCountry(56, 'CZ', 'CZE', 203, 'EZ', 'Czech Republic', 'Prague', 78866, 10476000, 'EU', '', 'CZK', '.cz');
        $this->createCountry(57, 'DE', 'DEU', 276, 'GM', 'Germany', 'Berlin', 357021, 81802257, 'EU', '', 'EUR', '.de');
        $this->createCountry(58, 'DJ', 'DJI', 262, 'DJ', 'Djibouti', 'Djibouti', 23000, 740528, 'AF', '', 'DJF', '.dj');
        $this->createCountry(59, 'DK', 'DNK', 208, 'DA', 'Denmark', 'Copenhagen', 43094, 5484000, 'EU', '', 'DKK', '.dk');
        $this->createCountry(60, 'DM', 'DMA', 212, 'DO', 'Dominica', 'Roseau', 754, 72813, 'NA', '', 'XCD', '.dm');
        $this->createCountry(61, 'DO', 'DOM', 214, 'DR', 'Dominican Republic', 'Santo Domingo', 48730, 9823821, 'NA', '', 'DOP', '.do');
        $this->createCountry(62, 'DZ', 'DZA', 12, 'AG', 'Algeria', 'Algiers', 2381740, 34586184, 'AF', '', 'DZD', '.dz');
        $this->createCountry(63, 'EC', 'ECU', 218, 'EC', 'Ecuador', 'Quito', 283560, 14790608, 'SA', '', 'USD', '.ec');
        $this->createCountry(64, 'EE', 'EST', 233, 'EN', 'Estonia', 'Tallinn', 45226, 1291170, 'EU', '', 'EUR', '.ee');
        $this->createCountry(65, 'EG', 'EGY', 818, 'EG', 'Egypt', 'Cairo', 1001450, 80471869, 'AF', '', 'EGP', '.eg');
        $this->createCountry(66, 'EH', 'ESH', 732, 'WI', 'Western Sahara', 'El-Aaiun', 266000, 273008, 'AF', '', 'MAD', '.eh');
        $this->createCountry(67, 'ER', 'ERI', 232, 'ER', 'Eritrea', 'Asmara', 121320, 5792984, 'AF', '', 'ERN', '.er');
        $this->createCountry(68, 'ES', 'ESP', 724, 'SP', 'Spain', 'Madrid', 504782, 46505963, 'EU', '', 'EUR', '.es');
        $this->createCountry(69, 'ET', 'ETH', 231, 'ET', 'Ethiopia', 'Addis Ababa', 1127127, 88013491, 'AF', '', 'ETB', '.et');
        $this->createCountry(70, 'FI', 'FIN', 246, 'FI', 'Finland', 'Helsinki', 337030, 5244000, 'EU', '', 'EUR', '.fi');
        $this->createCountry(71, 'FJ', 'FJI', 242, 'FJ', 'Fiji', 'Suva', 18270, 875983, 'OC', '', 'FJD', '.fj');
        $this->createCountry(72, 'FK', 'FLK', 238, 'FK', 'Falkland Islands', 'Stanley', 12173, 2638, 'SA', '', 'FKP', '.fk');
        $this->createCountry(73, 'FM', 'FSM', 583, 'FM', 'Micronesia', 'Palikir', 702, 107708, 'OC', '', 'USD', '.fm');
        $this->createCountry(74, 'FO', 'FRO', 234, 'FO', 'Faroe Islands', 'Torshavn', 1399, 48228, 'EU', '', 'DKK', '.fo');
        $this->createCountry(75, 'FR', 'FRA', 250, 'FR', 'France', 'Paris', 547030, 64768389, 'EU', '', 'EUR', '.fr');
        $this->createCountry(76, 'GA', 'GAB', 266, 'GB', 'Gabon', 'Libreville', 267667, 1545255, 'AF', '', 'XAF', '.ga');
        $this->createCountry(77, 'GB', 'GBR', 826, 'UK', 'United Kingdom', 'London', 244820, 62348447, 'EU', '', 'GBP', '.uk');
        $this->createCountry(78, 'GD', 'GRD', 308, 'GJ', 'Grenada', 'St. George\'s', 344, 107818, 'NA', '', 'XCD', '.gd');
        $this->createCountry(79, 'GE', 'GEO', 268, 'GG', 'Georgia', 'Tbilisi', 69700, 4630000, 'AS', '', 'GEL', '.ge');
        $this->createCountry(80, 'GF', 'GUF', 254, 'FG', 'French Guiana', 'Cayenne', 91000, 195506, 'SA', '', 'EUR', '.gf');
        $this->createCountry(81, 'GG', 'GGY', 831, 'GK', 'Guernsey', 'St Peter Port', 78, 65228, 'EU', '', 'GBP', '.gg');
        $this->createCountry(82, 'GH', 'GHA', 288, 'GH', 'Ghana', 'Accra', 239460, 24339838, 'AF', '', 'GHS', '.gh');
        $this->createCountry(83, 'GI', 'GIB', 292, 'GI', 'Gibraltar', 'Gibraltar', 6.5, 27884, 'EU', '', 'GIP', '.gi');
        $this->createCountry(84, 'GL', 'GRL', 304, 'GL', 'Greenland', 'Nuuk', 2166086, 56375, 'NA', '', 'DKK', '.gl');
        $this->createCountry(85, 'GM', 'GMB', 270, 'GA', 'Gambia', 'Banjul', 11300, 1593256, 'AF', '', 'GMD', '.gm');
        $this->createCountry(86, 'GN', 'GIN', 324, 'GV', 'Guinea', 'Conakry', 245857, 10324025, 'AF', '', 'GNF', '.gn');
        $this->createCountry(87, 'GP', 'GLP', 312, 'GP', 'Guadeloupe', 'Basse-Terre', 1780, 443000, 'NA', '', 'EUR', '.gp');
        $this->createCountry(88, 'GQ', 'GNQ', 226, 'EK', 'Equatorial Guinea', 'Malabo', 28051, 1014999, 'AF', '', 'XAF', '.gq');
        $this->createCountry(89, 'GR', 'GRC', 300, 'GR', 'Greece', 'Athens', 131940, 11000000, 'EU', '', 'EUR', '.gr');
        $this->createCountry(90, 'GS', 'SGS', 239, 'SX', 'South Georgia and the South Sandwich Islands', 'Grytviken', 3903, 30, 'AN', '', 'GBP', '.gs');
        $this->createCountry(91, 'GT', 'GTM', 320, 'GT', 'Guatemala', 'Guatemala City', 108890, 13550440, 'NA', '', 'GTQ', '.gt');
        $this->createCountry(92, 'GU', 'GUM', 316, 'GQ', 'Guam', 'Hagatna', 549, 159358, 'OC', '', 'USD', '.gu');
        $this->createCountry(93, 'GW', 'GNB', 624, 'PU', 'Guinea-Bissau', 'Bissau', 36120, 1565126, 'AF', '', 'XOF', '.gw');
        $this->createCountry(94, 'GY', 'GUY', 328, 'GY', 'Guyana', 'Georgetown', 214970, 748486, 'SA', '', 'GYD', '.gy');
        $this->createCountry(95, 'HK', 'HKG', 344, 'HK', 'Hong Kong', 'Hong Kong', 1092, 6898686, 'AS', '', 'HKD', '.hk');
        $this->createCountry(96, 'HM', 'HMD', 334, 'HM', 'Heard Island and McDonald Islands', '', 412, 0, 'AN', '', 'AUD', '.hm');
        $this->createCountry(97, 'HN', 'HND', 340, 'HO', 'Honduras', 'Tegucigalpa', 112090, 7989415, 'NA', '', 'HNL', '.hn');
        $this->createCountry(98, 'HR', 'HRV', 191, 'HR', 'Croatia', 'Zagreb', 56542, 4491000, 'EU', '', 'HRK', '.hr');
        $this->createCountry(99, 'HT', 'HTI', 332, 'HA', 'Haiti', 'Port-au-Prince', 27750, 9648924, 'NA', '', 'HTG', '.ht');
        $this->createCountry(100, 'HU', 'HUN', 348, 'HU', 'Hungary', 'Budapest', 93030, 9982000, 'EU', '', 'HUF', '.hu');
        $this->createCountry(101, 'ID', 'IDN', 360, 'ID', 'Indonesia', 'Jakarta', 1919440, 242968342, 'AS', '', 'IDR', '.id');
        $this->createCountry(102, 'IE', 'IRL', 372, 'EI', 'Ireland', 'Dublin', 70280, 4622917, 'EU', '', 'EUR', '.ie');
        $this->createCountry(103, 'IL', 'ISR', 376, 'IS', 'Israel', 'Jerusalem', 20770, 7353985, 'AS', '', 'ILS', '.il');
        $this->createCountry(104, 'IM', 'IMN', 833, 'IM', 'Isle of Man', 'Douglas, Isle of Man', 572, 75049, 'EU', '', 'GBP', '.im');
        $this->createCountry(105, 'IN', 'IND', 356, 'IN', 'India', 'New Delhi', 3287590, 1173108018, 'AS', '', 'INR', '.in');
        $this->createCountry(106, 'IO', 'IOT', 86, 'IO', 'British Indian Ocean Territory', 'Diego Garcia', 60, 4000, 'AS', '', 'USD', '.io');
        $this->createCountry(107, 'IQ', 'IRQ', 368, 'IZ', 'Iraq', 'Baghdad', 437072, 29671605, 'AS', '', 'IQD', '.iq');
        $this->createCountry(108, 'IR', 'IRN', 364, 'IR', 'Iran', 'Tehran', 1648000, 76923300, 'AS', '', 'IRR', '.ir');
        $this->createCountry(109, 'IS', 'ISL', 352, 'IC', 'Iceland', 'Reykjavik', 103000, 308910, 'EU', '', 'ISK', '.is');
        $this->createCountry(110, 'IT', 'ITA', 380, 'IT', 'Italy', 'Rome', 301230, 60340328, 'EU', '', 'EUR', '.it');
        $this->createCountry(111, 'JE', 'JEY', 832, 'JE', 'Jersey', 'Saint Helier', 116, 90812, 'EU', '', 'GBP', '.je');
        $this->createCountry(112, 'JM', 'JAM', 388, 'JM', 'Jamaica', 'Kingston', 10991, 2847232, 'NA', '', 'JMD', '.jm');
        $this->createCountry(113, 'JO', 'JOR', 400, 'JO', 'Jordan', 'Amman', 92300, 6407085, 'AS', '', 'JOD', '.jo');
        $this->createCountry(114, 'JP', 'JPN', 392, 'JA', 'Japan', 'Tokyo', 377835, 127288000, 'AS', '', 'JPY', '.jp');
        $this->createCountry(115, 'KE', 'KEN', 404, 'KE', 'Kenya', 'Nairobi', 582650, 40046566, 'AF', '', 'KES', '.ke');
        $this->createCountry(116, 'KG', 'KGZ', 417, 'KG', 'Kyrgyzstan', 'Bishkek', 198500, 5508626, 'AS', '', 'KGS', '.kg');
        $this->createCountry(117, 'KH', 'KHM', 116, 'CB', 'Cambodia', 'Phnom Penh', 181040, 14453680, 'AS', '', 'KHR', '.kh');
        $this->createCountry(118, 'KI', 'KIR', 296, 'KR', 'Kiribati', 'Tarawa', 811, 92533, 'OC', '', 'AUD', '.ki');
        $this->createCountry(119, 'KM', 'COM', 174, 'CN', 'Comoros', 'Moroni', 2170, 773407, 'AF', '', 'KMF', '.km');
        $this->createCountry(120, 'KN', 'KNA', 659, 'SC', 'Saint Kitts and Nevis', 'Basseterre', 261, 49898, 'NA', '', 'XCD', '.kn');
        $this->createCountry(121, 'KP', 'PRK', 408, 'KN', 'North Korea', 'Pyongyang', 120540, 22912177, 'AS', '', 'KPW', '.kp');
        $this->createCountry(122, 'KR', 'KOR', 410, 'KS', 'South Korea', 'Seoul', 98480, 48422644, 'AS', '', 'KRW', '.kr');
        $this->createCountry(123, 'XK', 'XKX', 0, 'KV', 'Kosovo', 'Pristina', 0, 1800000, 'EU', '', 'EUR', '');
        $this->createCountry(124, 'KW', 'KWT', 414, 'KU', 'Kuwait', 'Kuwait City', 17820, 2789132, 'AS', '', 'KWD', '.kw');
        $this->createCountry(125, 'KY', 'CYM', 136, 'CJ', 'Cayman Islands', 'George Town', 262, 44270, 'NA', '', 'KYD', '.ky');
        $this->createCountry(126, 'KZ', 'KAZ', 398, 'KZ', 'Kazakhstan', 'Astana', 2717300, 15340000, 'AS', '', 'KZT', '.kz');
        $this->createCountry(127, 'LA', 'LAO', 418, 'LA', 'Laos', 'Vientiane', 236800, 6368162, 'AS', '', 'LAK', '.la');
        $this->createCountry(128, 'LB', 'LBN', 422, 'LE', 'Lebanon', 'Beirut', 10400, 4125247, 'AS', '', 'LBP', '.lb');
        $this->createCountry(129, 'LC', 'LCA', 662, 'ST', 'Saint Lucia', 'Castries', 616, 160922, 'NA', '', 'XCD', '.lc');
        $this->createCountry(130, 'LI', 'LIE', 438, 'LS', 'Liechtenstein', 'Vaduz', 160, 35000, 'EU', '', 'CHF', '.li');
        $this->createCountry(131, 'LK', 'LKA', 144, 'CE', 'Sri Lanka', 'Colombo', 65610, 21513990, 'AS', '', 'LKR', '.lk');
        $this->createCountry(132, 'LR', 'LBR', 430, 'LI', 'Liberia', 'Monrovia', 111370, 3685076, 'AF', '', 'LRD', '.lr');
        $this->createCountry(133, 'LS', 'LSO', 426, 'LT', 'Lesotho', 'Maseru', 30355, 1919552, 'AF', '', 'LSL', '.ls');
        $this->createCountry(134, 'LT', 'LTU', 440, 'LH', 'Lithuania', 'Vilnius', 65200, 3565000, 'EU', '', 'LTL', '.lt');
        $this->createCountry(135, 'LU', 'LUX', 442, 'LU', 'Luxembourg', 'Luxembourg', 2586, 497538, 'EU', '', 'EUR', '.lu');
        $this->createCountry(136, 'LV', 'LVA', 428, 'LG', 'Latvia', 'Riga', 64589, 2217969, 'EU', '', 'LVL', '.lv');
        $this->createCountry(137, 'LY', 'LBY', 434, 'LY', 'Libya', 'Tripolis', 1759540, 6461454, 'AF', '', 'LYD', '.ly');
        $this->createCountry(138, 'MA', 'MAR', 504, 'MO', 'Morocco', 'Rabat', 446550, 31627428, 'AF', '', 'MAD', '.ma');
        $this->createCountry(139, 'MC', 'MCO', 492, 'MN', 'Monaco', 'Monaco', 1.95, 32965, 'EU', '', 'EUR', '.mc');
        $this->createCountry(140, 'MD', 'MDA', 498, 'MD', 'Moldova', 'Chisinau', 33843, 4324000, 'EU', '', 'MDL', '.md');
        $this->createCountry(141, 'ME', 'MNE', 499, 'MJ', 'Montenegro', 'Podgorica', 14026, 666730, 'EU', '', 'EUR', '.me');
        $this->createCountry(142, 'MF', 'MAF', 663, 'RN', 'Saint Martin', 'Marigot', 53, 35925, 'NA', '', 'EUR', '.gp');
        $this->createCountry(143, 'MG', 'MDG', 450, 'MA', 'Madagascar', 'Antananarivo', 587040, 21281844, 'AF', '', 'MGA', '.mg');
        $this->createCountry(144, 'MH', 'MHL', 584, 'RM', 'Marshall Islands', 'Majuro', 181.3, 65859, 'OC', '', 'USD', '.mh');
        $this->createCountry(145, 'MK', 'MKD', 807, 'MK', 'Macedonia', 'Skopje', 25333, 2061000, 'EU', '', 'MKD', '.mk');
        $this->createCountry(146, 'ML', 'MLI', 466, 'ML', 'Mali', 'Bamako', 1240000, 13796354, 'AF', '', 'XOF', '.ml');
        $this->createCountry(147, 'MM', 'MMR', 104, 'BM', 'Myanmar', 'Nay Pyi Taw', 678500, 53414374, 'AS', '', 'MMK', '.mm');
        $this->createCountry(148, 'MN', 'MNG', 496, 'MG', 'Mongolia', 'Ulan Bator', 1565000, 3086918, 'AS', '', 'MNT', '.mn');
        $this->createCountry(149, 'MO', 'MAC', 446, 'MC', 'Macao', 'Macao', 254, 449198, 'AS', '', 'MOP', '.mo');
        $this->createCountry(150, 'MP', 'MNP', 580, 'CQ', 'Northern Mariana Islands', 'Saipan', 477, 53883, 'OC', '', 'USD', '.mp');
        $this->createCountry(151, 'MQ', 'MTQ', 474, 'MB', 'Martinique', 'Fort-de-France', 1100, 432900, 'NA', '', 'EUR', '.mq');
        $this->createCountry(152, 'MR', 'MRT', 478, 'MR', 'Mauritania', 'Nouakchott', 1030700, 3205060, 'AF', '', 'MRO', '.mr');
        $this->createCountry(153, 'MS', 'MSR', 500, 'MH', 'Montserrat', 'Plymouth', 102, 9341, 'NA', '', 'XCD', '.ms');
        $this->createCountry(154, 'MT', 'MLT', 470, 'MT', 'Malta', 'Valletta', 316, 403000, 'EU', '', 'EUR', '.mt');
        $this->createCountry(155, 'MU', 'MUS', 480, 'MP', 'Mauritius', 'Port Louis', 2040, 1294104, 'AF', '', 'MUR', '.mu');
        $this->createCountry(156, 'MV', 'MDV', 462, 'MV', 'Maldives', 'Male', 300, 395650, 'AS', '', 'MVR', '.mv');
        $this->createCountry(157, 'MW', 'MWI', 454, 'MI', 'Malawi', 'Lilongwe', 118480, 15447500, 'AF', '', 'MWK', '.mw');
        $this->createCountry(158, 'MX', 'MEX', 484, 'MX', 'Mexico', 'Mexico City', 1972550, 112468855, 'NA', '', 'MXN', '.mx');
        $this->createCountry(159, 'MY', 'MYS', 458, 'MY', 'Malaysia', 'Kuala Lumpur', 329750, 28274729, 'AS', '', 'MYR', '.my');
        $this->createCountry(160, 'MZ', 'MOZ', 508, 'MZ', 'Mozambique', 'Maputo', 801590, 22061451, 'AF', '', 'MZN', '.mz');
        $this->createCountry(161, 'NA', 'NAM', 516, 'WA', 'Namibia', 'Windhoek', 825418, 2128471, 'AF', '', 'NAD', '.na');
        $this->createCountry(162, 'NC', 'NCL', 540, 'NC', 'New Caledonia', 'Noumea', 19060, 216494, 'OC', '', 'XPF', '.nc');
        $this->createCountry(163, 'NE', 'NER', 562, 'NG', 'Niger', 'Niamey', 1267000, 15878271, 'AF', '', 'XOF', '.ne');
        $this->createCountry(164, 'NF', 'NFK', 574, 'NF', 'Norfolk Island', 'Kingston', 34.6, 1828, 'OC', '', 'AUD', '.nf');
        $this->createCountry(165, 'NG', 'NGA', 566, 'NI', 'Nigeria', 'Abuja', 923768, 154000000, 'AF', '', 'NGN', '.ng');
        $this->createCountry(166, 'NI', 'NIC', 558, 'NU', 'Nicaragua', 'Managua', 129494, 5995928, 'NA', '', 'NIO', '.ni');
        $this->createCountry(167, 'NL', 'NLD', 528, 'NL', 'Netherlands', 'Amsterdam', 41526, 16645000, 'EU', '', 'EUR', '.nl');
        $this->createCountry(168, 'NO', 'NOR', 578, 'NO', 'Norway', 'Oslo', 324220, 5009150, 'EU', '', 'NOK', '.no');
        $this->createCountry(169, 'NP', 'NPL', 524, 'NP', 'Nepal', 'Kathmandu', 140800, 28951852, 'AS', '', 'NPR', '.np');
        $this->createCountry(170, 'NR', 'NRU', 520, 'NR', 'Nauru', 'Yaren', 21, 10065, 'OC', '', 'AUD', '.nr');
        $this->createCountry(171, 'NU', 'NIU', 570, 'NE', 'Niue', 'Alofi', 260, 2166, 'OC', '', 'NZD', '.nu');
        $this->createCountry(172, 'NZ', 'NZL', 554, 'NZ', 'New Zealand', 'Wellington', 268680, 4252277, 'OC', '', 'NZD', '.nz');
        $this->createCountry(173, 'OM', 'OMN', 512, 'MU', 'Oman', 'Muscat', 212460, 2967717, 'AS', '', 'OMR', '.om');
        $this->createCountry(174, 'PA', 'PAN', 591, 'PM', 'Panama', 'Panama City', 78200, 3410676, 'NA', '', 'PAB', '.pa');
        $this->createCountry(175, 'PE', 'PER', 604, 'PE', 'Peru', 'Lima', 1285220, 29907003, 'SA', '', 'PEN', '.pe');
        $this->createCountry(176, 'PF', 'PYF', 258, 'FP', 'French Polynesia', 'Papeete', 4167, 270485, 'OC', '', 'XPF', '.pf');
        $this->createCountry(177, 'PG', 'PNG', 598, 'PP', 'Papua New Guinea', 'Port Moresby', 462840, 6064515, 'OC', '', 'PGK', '.pg');
        $this->createCountry(178, 'PH', 'PHL', 608, 'RP', 'Philippines', 'Manila', 300000, 99900177, 'AS', '', 'PHP', '.ph');
        $this->createCountry(179, 'PK', 'PAK', 586, 'PK', 'Pakistan', 'Islamabad', 803940, 184404791, 'AS', '', 'PKR', '.pk');
        $this->createCountry(180, 'PL', 'POL', 616, 'PL', 'Poland', 'Warsaw', 312685, 38500000, 'EU', '', 'PLN', '.pl');
        $this->createCountry(181, 'PM', 'SPM', 666, 'SB', 'Saint Pierre and Miquelon', 'Saint-Pierre', 242, 7012, 'NA', '', 'EUR', '.pm');
        $this->createCountry(182, 'PN', 'PCN', 612, 'PC', 'Pitcairn', 'Adamstown', 47, 46, 'OC', '', 'NZD', '.pn');
        $this->createCountry(183, 'PR', 'PRI', 630, 'RQ', 'Puerto Rico', 'San Juan', 9104, 3916632, 'NA', '', 'USD', '.pr');
        $this->createCountry(184, 'PS', 'PSE', 275, 'WE', 'Palestinian Territory', 'East Jerusalem', 5970, 3800000, 'AS', '', 'ILS', '.ps');
        $this->createCountry(185, 'PT', 'PRT', 620, 'PO', 'Portugal', 'Lisbon', 92391, 10676000, 'EU', '', 'EUR', '.pt');
        $this->createCountry(186, 'PW', 'PLW', 585, 'PS', 'Palau', 'Melekeok', 458, 19907, 'OC', '', 'USD', '.pw');
        $this->createCountry(187, 'PY', 'PRY', 600, 'PA', 'Paraguay', 'Asuncion', 406750, 6375830, 'SA', '', 'PYG', '.py');
        $this->createCountry(188, 'QA', 'QAT', 634, 'QA', 'Qatar', 'Doha', 11437, 840926, 'AS', '', 'QAR', '.qa');
        $this->createCountry(189, 'RE', 'REU', 638, 'RE', 'Reunion', 'Saint-Denis', 2517, 776948, 'AF', '', 'EUR', '.re');
        $this->createCountry(190, 'RO', 'ROU', 642, 'RO', 'Romania', 'Bucharest', 237500, 21959278, 'EU', '', 'RON', '.ro');
        $this->createCountry(191, 'RS', 'SRB', 688, 'RI', 'Serbia', 'Belgrade', 88361, 7344847, 'EU', '', 'RSD', '.rs');
        $this->createCountry(192, 'RU', 'RUS', 643, 'RS', 'Russia', 'Moscow', 17100000, 140702000, 'EU', '', 'RUB', '.ru');
        $this->createCountry(193, 'RW', 'RWA', 646, 'RW', 'Rwanda', 'Kigali', 26338, 11055976, 'AF', '', 'RWF', '.rw');
        $this->createCountry(194, 'SA', 'SAU', 682, 'SA', 'Saudi Arabia', 'Riyadh', 1960582, 25731776, 'AS', '', 'SAR', '.sa');
        $this->createCountry(195, 'SB', 'SLB', 90, 'BP', 'Solomon Islands', 'Honiara', 28450, 559198, 'OC', '', 'SBD', '.sb');
        $this->createCountry(196, 'SC', 'SYC', 690, 'SE', 'Seychelles', 'Victoria', 455, 88340, 'AF', '', 'SCR', '.sc');
        $this->createCountry(197, 'SD', 'SDN', 729, 'SU', 'Sudan', 'Khartoum', 1861484, 35000000, 'AF', '', 'SDG', '.sd');
        $this->createCountry(198, 'SS', 'SSD', 728, 'OD', 'South Sudan', 'Juba', 644329, 8260490, 'AF', '', 'SSP', '');
        $this->createCountry(199, 'SE', 'SWE', 752, 'SW', 'Sweden', 'Stockholm', 449964, 9555893, 'EU', '', 'SEK', '.se');
        $this->createCountry(200, 'SG', 'SGP', 702, 'SN', 'Singapore', 'Singapur', 692.7, 4701069, 'AS', '', 'SGD', '.sg');
        $this->createCountry(201, 'SH', 'SHN', 654, 'SH', 'Saint Helena', 'Jamestown', 410, 7460, 'AF', '', 'SHP', '.sh');
        $this->createCountry(202, 'SI', 'SVN', 705, 'SI', 'Slovenia', 'Ljubljana', 20273, 2007000, 'EU', '', 'EUR', '.si');
        $this->createCountry(203, 'SJ', 'SJM', 744, 'SV', 'Svalbard and Jan Mayen', 'Longyearbyen', 62049, 2550, 'EU', '', 'NOK', '.sj');
        $this->createCountry(204, 'SK', 'SVK', 703, 'LO', 'Slovakia', 'Bratislava', 48845, 5455000, 'EU', '', 'EUR', '.sk');
        $this->createCountry(205, 'SL', 'SLE', 694, 'SL', 'Sierra Leone', 'Freetown', 71740, 5245695, 'AF', '', 'SLL', '.sl');
        $this->createCountry(206, 'SM', 'SMR', 674, 'SM', 'San Marino', 'San Marino', 61.2, 31477, 'EU', '', 'EUR', '.sm');
        $this->createCountry(207, 'SN', 'SEN', 686, 'SG', 'Senegal', 'Dakar', 196190, 12323252, 'AF', '', 'XOF', '.sn');
        $this->createCountry(208, 'SO', 'SOM', 706, 'SO', 'Somalia', 'Mogadishu', 637657, 10112453, 'AF', '', 'SOS', '.so');
        $this->createCountry(209, 'SR', 'SUR', 740, 'NS', 'Suriname', 'Paramaribo', 163270, 492829, 'SA', '', 'SRD', '.sr');
        $this->createCountry(210, 'ST', 'STP', 678, 'TP', 'Sao Tome and Principe', 'Sao Tome', 1001, 175808, 'AF', '', 'STD', '.st');
        $this->createCountry(211, 'SV', 'SLV', 222, 'ES', 'El Salvador', 'San Salvador', 21040, 6052064, 'NA', '', 'USD', '.sv');
        $this->createCountry(212, 'SX', 'SXM', 534, 'NN', 'Sint Maarten', 'Philipsburg', 0, 37429, 'NA', '', 'ANG', '.sx');
        $this->createCountry(213, 'SY', 'SYR', 760, 'SY', 'Syria', 'Damascus', 185180, 22198110, 'AS', '', 'SYP', '.sy');
        $this->createCountry(214, 'SZ', 'SWZ', 748, 'WZ', 'Swaziland', 'Mbabane', 17363, 1354051, 'AF', '', 'SZL', '.sz');
        $this->createCountry(215, 'TC', 'TCA', 796, 'TK', 'Turks and Caicos Islands', 'Cockburn Town', 430, 20556, 'NA', '', 'USD', '.tc');
        $this->createCountry(216, 'TD', 'TCD', 148, 'CD', 'Chad', 'N\'Djamena', 1284000, 10543464, 'AF', '', 'XAF', '.td');
        $this->createCountry(217, 'TF', 'ATF', 260, 'FS', 'French Southern Territories', 'Port-aux-Francais', 7829, 140, 'AN', '', 'EUR', '.tf');
        $this->createCountry(218, 'TG', 'TGO', 768, 'TO', 'Togo', 'Lome', 56785, 6587239, 'AF', '', 'XOF', '.tg');
        $this->createCountry(219, 'TH', 'THA', 764, 'TH', 'Thailand', 'Bangkok', 514000, 67089500, 'AS', '', 'THB', '.th');
        $this->createCountry(220, 'TJ', 'TJK', 762, 'TI', 'Tajikistan', 'Dushanbe', 143100, 7487489, 'AS', '', 'TJS', '.tj');
        $this->createCountry(221, 'TK', 'TKL', 772, 'TL', 'Tokelau', '', 10, 1466, 'OC', '', 'NZD', '.tk');
        $this->createCountry(222, 'TL', 'TLS', 626, 'TT', 'East Timor', 'Dili', 15007, 1154625, 'OC', '', 'USD', '.tl');
        $this->createCountry(223, 'TM', 'TKM', 795, 'TX', 'Turkmenistan', 'Ashgabat', 488100, 4940916, 'AS', '', 'TMT', '.tm');
        $this->createCountry(224, 'TN', 'TUN', 788, 'TS', 'Tunisia', 'Tunis', 163610, 10589025, 'AF', '', 'TND', '.tn');
        $this->createCountry(225, 'TO', 'TON', 776, 'TN', 'Tonga', 'Nuku\'alofa', 748, 122580, 'OC', '', 'TOP', '.to');
        $this->createCountry(226, 'TR', 'TUR', 792, 'TU', 'Turkey', 'Ankara', 780580, 77804122, 'AS', '', 'TRY', '.tr');
        $this->createCountry(227, 'TT', 'TTO', 780, 'TD', 'Trinidad and Tobago', 'Port of Spain', 5128, 1228691, 'NA', '', 'TTD', '.tt');
        $this->createCountry(228, 'TV', 'TUV', 798, 'TV', 'Tuvalu', 'Funafuti', 26, 10472, 'OC', '', 'AUD', '.tv');
        $this->createCountry(229, 'TW', 'TWN', 158, 'TW', 'Taiwan', 'Taipei', 35980, 22894384, 'AS', '', 'TWD', '.tw');
        $this->createCountry(230, 'TZ', 'TZA', 834, 'TZ', 'Tanzania', 'Dodoma', 945087, 41892895, 'AF', '', 'TZS', '.tz');
        $this->createCountry(231, 'UA', 'UKR', 804, 'UP', 'Ukraine', 'Kiev', 603700, 45415596, 'EU', '', 'UAH', '.ua');
        $this->createCountry(232, 'UG', 'UGA', 800, 'UG', 'Uganda', 'Kampala', 236040, 33398682, 'AF', '', 'UGX', '.ug');
        $this->createCountry(233, 'UM', 'UMI', 581, '', 'United States Minor Outlying Islands', '', 0, 0, 'OC', '', 'USD', '.um');
        $this->createCountry(234, 'US', 'USA', 840, 'US', 'United States', 'Washington', 9629091, 310232863, 'NA', '', 'USD', '.us');
        $this->createCountry(235, 'UY', 'URY', 858, 'UY', 'Uruguay', 'Montevideo', 176220, 3477000, 'SA', '', 'UYU', '.uy');
        $this->createCountry(236, 'UZ', 'UZB', 860, 'UZ', 'Uzbekistan', 'Tashkent', 447400, 27865738, 'AS', '', 'UZS', '.uz');
        $this->createCountry(237, 'VA', 'VAT', 336, 'VT', 'Vatican', 'Vatican City', 0.44, 921, 'EU', '', 'EUR', '.va');
        $this->createCountry(238, 'VC', 'VCT', 670, 'VC', 'Saint Vincent and the Grenadines', 'Kingstown', 389, 104217, 'NA', '', 'XCD', '.vc');
        $this->createCountry(239, 'VE', 'VEN', 862, 'VE', 'Venezuela', 'Caracas', 912050, 27223228, 'SA', '', 'VEF', '.ve');
        $this->createCountry(240, 'VG', 'VGB', 92, 'VI', 'British Virgin Islands', 'Road Town', 153, 21730, 'NA', '', 'USD', '.vg');
        $this->createCountry(241, 'VI', 'VIR', 850, 'VQ', 'U.S. Virgin Islands', 'Charlotte Amalie', 352, 108708, 'NA', '', 'USD', '.vi');
        $this->createCountry(242, 'VN', 'VNM', 704, 'VM', 'Vietnam', 'Hanoi', 329560, 89571130, 'AS', '', 'VND', '.vn');
        $this->createCountry(243, 'VU', 'VUT', 548, 'NH', 'Vanuatu', 'Port Vila', 12200, 221552, 'OC', '', 'VUV', '.vu');
        $this->createCountry(244, 'WF', 'WLF', 876, 'WF', 'Wallis and Futuna', 'Mata Utu', 274, 16025, 'OC', '', 'XPF', '.wf');
        $this->createCountry(245, 'WS', 'WSM', 882, 'WS', 'Samoa', 'Apia', 2944, 192001, 'OC', '', 'WST', '.ws');
        $this->createCountry(246, 'YE', 'YEM', 887, 'YM', 'Yemen', 'Sanaa', 527970, 23495361, 'AS', '', 'YER', '.ye');
        $this->createCountry(247, 'YT', 'MYT', 175, 'MF', 'Mayotte', 'Mamoudzou', 374, 159042, 'AF', '', 'EUR', '.yt');
        $this->createCountry(248, 'ZA', 'ZAF', 710, 'SF', 'South Africa', 'Pretoria', 1219912, 49000000, 'AF', '', 'ZAR', '.za');
        $this->createCountry(249, 'ZM', 'ZMB', 894, 'ZA', 'Zambia', 'Lusaka', 752614, 13460305, 'AF', '', 'ZMK', '.zm');
        $this->createCountry(250, 'ZW', 'ZWE', 716, 'ZI', 'Zimbabwe', 'Harare', 390580, 11651858, 'AF', '', 'ZWL', '.zw');
        $this->createCountry(251, 'CS', 'SCG', 891, 'YI', 'Serbia and Montenegro', 'Belgrade', 102350, 10829175, 'EU', '', 'RSD', '.cs');
        $this->createCountry(252, 'AN', 'ANT', 530, 'NT', 'Netherlands Antilles', 'Willemstad', 960, 136197, 'NA', '', 'ANG', '.an');
    }

}
?>

