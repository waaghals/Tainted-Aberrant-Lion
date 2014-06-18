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
use PROJ\Entities\RightGroup;
use PROJ\Entities\Recht;
use PROJ\Entities\Clippy;
use PROJ\DBAL\ApprovalStateType as Status;
use PROJ\Entities\Translation;
use PROJ\DBAL\LanguageType as Language;

class TestdataController extends BaseController
{

    private function emptyTables($em)
    {
        $helperSet     = new \Symfony\Component\Console\Helper\HelperSet(array(
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));
        $command1      = "orm:schema-tool:drop --force";
        $command2      = "orm:schema-tool:update --force";
        $commandarray1 = array_merge(array('doctrine'), explode(" ", $command1));
        $commandarray2 = array_merge(array('doctrine'), explode(" ", $command2));
        \PROJ\Tools\CodeConsoleRunner::run($helperSet,
                new \Symfony\Component\Console\Input\ArgvInput($commandarray1),
                new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output',
                        'w')));
        echo "<br />";
        \PROJ\Tools\CodeConsoleRunner::run($helperSet,
                new \Symfony\Component\Console\Input\ArgvInput($commandarray2),
                new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output',
                        'w')));
        echo "<br /><br />";

        ob_flush();
    }

    private function createInstitute($em, $name, $type, $place, $lat, $long, $creator, $country, $street, $housenumber, $postalcode, $email, $telephone)
    {
        $institute = new Institute();
        $institute->setName($name);
        $institute->setType($type);
        $institute->setPlace($place);
        $institute->setLat($lat);
        $institute->setLng($long);
        $institute->setCreator($creator);
        $institute->setCountry($country);
        $institute->setStreet($street);
        $institute->setHousenumber($housenumber);
        $institute->setPostalcode($postalcode);
        $institute->setEmail($email);
        $institute->setTelephone($telephone);
        $institute->setAcceptanceStatus(Status::APPROVED);
        $em->persist($institute);

        echo "Institute with the following data has been succesfully added to the database:"
        . "<br />Name: " . $name
        . "<br />Type: " . $type
        . "<br />Place: " . $place
        . "<br />Latitude: " . $lat
        . "<br />Longtitude: " . $long
        . "<br />Owner: " . $creator->getFullName()
        . "<br />Country: " . $country->getName()
        . "<br />Street: " . $street
        . "<br />Housenumber: " . $housenumber
        . "<br />Postalcode: " . $postalcode
        . "<br />Email: " . $email
        . "<br />Telephone: " . $telephone
        . "<br /><br />";

        ob_flush();
        return $institute;
    }

    private function createUser($em, $username, $password, $salt, $rightGroup)
    {
        $account = new Account();
        $account->setUsername($username);
        $hash    = hash('sha512', $password . $salt);
        $account->setPassword($hash);
        $account->setSalt($salt);
        $account->setRightgroup($rightGroup);
        $em->persist($account);

        echo "New account with the following data has been succesfully added to the database:"
        . "<br />Username: " . $username
        . "<br />Password: " . $password
        . "<br />Salt: " . $salt
        . "<br /><br />";

        ob_flush();
        return $account;
    }

    private function createStudent($em, $fName, $sName, $street, $housenr, $zipcode, $city, $account, $email)
    {
        $student = new Student();
        $student->setFirstname($fName);
        $student->setSurname($sName);
        $student->setStreet($street);
        $student->setHousenumber($housenr);
        $student->setZipcode($zipcode);
        $student->setCity($city);
        $student->setAccount($account);
        $student->setEmail($email);
        $em->persist($student);

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

        ob_flush();
        return $student;
    }

    private function createProject($em, $student, $institute, $type, $startDate, $endDate)
    {
        $project = new Project();
        $project->setStudent($student);
        $project->setInstitute($institute);
        $project->setType($type);
        $project->setStartdate($startDate);
        $project->setendDate($endDate);
        $project->setAcceptanceStatus(Status::APPROVED);
        $em->persist($project);

        echo "New project with the following data has been succesfully added to the database:"
        . "<br />Student: " . $student->getFirstname() . " " . $student->getSurname()
        . "<br />Institute: " . $institute->getName()
        . "<br />Type: " . $type
        . "<br /><br />";

        ob_flush();
        return $project;
    }

    private function createRightGroup($em, $name)
    {
        $rightGroup = new RightGroup();
        $rightGroup->setName($name);
        $em->persist($rightGroup);

        echo "New RightGroup with the following data has been succesfully added to the database:"
        . "<br />Name: " . $rightGroup->getName()
        . "<br /><br />";

        ob_flush();

        return $rightGroup;
    }

    private function addRightToRightGroup($em, $right, $rightgroup)
    {
        $rightgroup->addRight($right);
        $em->persist($rightgroup);
        $em->persist($right);

        echo "a Right has been linked to a RightGroup:"
        . "<br />Right: " . $right->getName()
        . "<br />RightGroup: " . $rightgroup->getName()
        . "<br /><br />";

        ob_flush();
    }

    private function createRight($em, $name)
    {
        $right = new Recht();
        $right->setName($name);
        $em->persist($right);

        echo "New Right with the following data has been succesfully added to the database:"
        . "<br />Name: " . $right->getName()
        . "<br /><br />";

        ob_flush();

        return $right;
    }

    private function createReview($em, $project, $assignRate, $accoRate, $guidRate, $text)
    {
        $review = new Review();
        $review->setProject($project);
        $review->setAssignmentRating($assignRate);
        $review->setAccommodationRating($accoRate);
        $review->setGuidanceRating($guidRate);
        $review->setRating(($assignRate + $accoRate + $guidRate) / 3);
        $review->setText($text);
        $review->setAcceptanceStatus(Status::APPROVED);
        $em->persist($review);

        echo "New review with the following data has been succesfully added to the database:"
        . "<br />Institute: " . $project->getInstitute()->getName()
        . "<br />Assignment rating: " . $assignRate
        . "<br />Accomodation rating: " . $accoRate
        . "<br />Guidance rating: " . $guidRate
        . "<br />Text: " . $text
        . "<br /><br />";

        ob_flush();
        return $review;
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

        ob_flush();
        return $country;
    }

    private function createClippy($em, $controller, $action, $description)
    {
        $clippy = new Clippy();
        $clippy->setController($controller);
        $clippy->setAction($action);
        $clippy->setDescription($description);
        $em->persist($clippy);

        echo "Clippy information added to " . $controller . " for action " . $action . "<br />";

        ob_flush();
        return $clippy;
    }

    private function createTranslation($em, $key, $language, $translation)
    {
        $translator = new Translation();
        $translator->setSentenceKey($key);
        $translator->setLanguage($language);
        $translator->setTranslation($translation);

        $em->persist($translator);

        echo "New Translation with the following data has been succesfully added to the database:"
        . "<br />Key: " . $key
        . "<br />Language: " . $language
        . "<br />Translation: " . $translation
        . "<br /><br />";

        ob_flush();
    }

    public function IndexAction()
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

        ob_start();

        $this->emptyTables($em);
        echo "Database Cleared.<br /><br />";

        $this->createCountry($em, 'AD', 'AND', 20, 'AN', 'Andorra',
                'Andorra la Vella', 468, 84000, 'EU', '', 'EUR', '.ad');
        $this->createCountry($em, 'AE', 'ARE', 784, 'AE',
                'United Arab Emirates', 'Abu Dhabi', 82880, 4975593, 'AS', '',
                'AED', '.ae');
        $this->createCountry($em, 'AF', 'AFG', 4, 'AF', 'Afghanistan', 'Kabul',
                647500, 29121286, 'AS', '', 'AFN', '.af');
        $this->createCountry($em, 'AG', 'ATG', 28, 'AC', 'Antigua and Barbuda',
                'St. John\'s', 443, 86754, 'NA', '', 'XCD', '.ag');
        $this->createCountry($em, 'AI', 'AIA', 660, 'AV', 'Anguilla',
                'The Valley', 102, 13254, 'NA', '', 'XCD', '.ai');
        $this->createCountry($em, 'AL', 'ALB', 8, 'AL', 'Albania', 'Tirana',
                28748, 2986952, 'EU', '', 'ALL', '.al');
        $this->createCountry($em, 'AM', 'ARM', 51, 'AM', 'Armenia', 'Yerevan',
                29800, 2968000, 'AS', '', 'AMD', '.am');
        $this->createCountry($em, 'AO', 'AGO', 24, 'AO', 'Angola', 'Luanda',
                1246700, 13068161, 'AF', '', 'AOA', '.ao');
        $this->createCountry($em, 'AQ', 'ATA', 10, 'AY', 'Antarctica', '',
                14000000, 0, 'AN', '', '', '.aq');
        $this->createCountry($em, 'AR', 'ARG', 32, 'AR', 'Argentina',
                'Buenos Aires', 2766890, 41343201, 'SA', '', 'ARS', '.ar');
        $this->createCountry($em, 'AS', 'ASM', 16, 'AQ', 'American Samoa',
                'Pago Pago', 199, 57881, 'OC', '', 'USD', '.as');
        $this->createCountry($em, 'AT', 'AUT', 40, 'AU', 'Austria', 'Vienna',
                83858, 8205000, 'EU', '', 'EUR', '.at');
        $this->createCountry($em, 'AU', 'AUS', 36, 'AS', 'Australia',
                'Canberra', 7686850, 21515754, 'OC', '', 'AUD', '.au');
        $this->createCountry($em, 'AW', 'ABW', 533, 'AA', 'Aruba', 'Oranjestad',
                193, 71566, 'NA', '', 'AWG', '.aw');
        $this->createCountry($em, 'AX', 'ALA', 248, '', 'Aland Islands',
                'Mariehamn', 0, 26711, 'EU', '', 'EUR', '.ax');
        $this->createCountry($em, 'AZ', 'AZE', 31, 'AJ', 'Azerbaijan', 'Baku',
                86600, 8303512, 'AS', '', 'AZN', '.az');
        $this->createCountry($em, 'BA', 'BIH', 70, 'BK',
                'Bosnia and Herzegovina', 'Sarajevo', 51129, 4590000, 'EU', '',
                'BAM', '.ba');
        $this->createCountry($em, 'BB', 'BRB', 52, 'BB', 'Barbados',
                'Bridgetown', 431, 285653, 'NA', '', 'BBD', '.bb');
        $this->createCountry($em, 'BD', 'BGD', 50, 'BG', 'Bangladesh', 'Dhaka',
                144000, 156118464, 'AS', '', 'BDT', '.bd');
        $this->createCountry($em, 'BE', 'BEL', 56, 'BE', 'Belgium', 'Brussels',
                30510, 10403000, 'EU', '', 'EUR', '.be');
        $this->createCountry($em, 'BF', 'BFA', 854, 'UV', 'Burkina Faso',
                'Ouagadougou', 274200, 16241811, 'AF', '', 'XOF', '.bf');
        $this->createCountry($em, 'BG', 'BGR', 100, 'BU', 'Bulgaria', 'Sofia',
                110910, 7148785, 'EU', '', 'BGN', '.bg');
        $this->createCountry($em, 'BH', 'BHR', 48, 'BA', 'Bahrain', 'Manama',
                665, 738004, 'AS', '', 'BHD', '.bh');
        $this->createCountry($em, 'BI', 'BDI', 108, 'BY', 'Burundi',
                'Bujumbura', 27830, 9863117, 'AF', '', 'BIF', '.bi');
        $this->createCountry($em, 'BJ', 'BEN', 204, 'BN', 'Benin', 'Porto-Novo',
                112620, 9056010, 'AF', '', 'XOF', '.bj');
        $this->createCountry($em, 'BL', 'BLM', 652, 'TB', 'Saint Barthelemy',
                'Gustavia', 21, 8450, 'NA', '', 'EUR', '.gp');
        $this->createCountry($em, 'BM', 'BMU', 60, 'BD', 'Bermuda', 'Hamilton',
                53, 65365, 'NA', '', 'BMD', '.bm');
        $this->createCountry($em, 'BN', 'BRN', 96, 'BX', 'Brunei',
                'Bandar Seri Begawan', 5770, 395027, 'AS', '', 'BND', '.bn');
        $this->createCountry($em, 'BO', 'BOL', 68, 'BL', 'Bolivia', 'Sucre',
                1098580, 9947418, 'SA', '', 'BOB', '.bo');
        $this->createCountry($em, 'BQ', 'BES', 535, '',
                'Bonaire, Saint Eustatius and Saba ', '', 0, 18012, 'NA', '',
                'USD', '.bq');
        $this->createCountry($em, 'BR', 'BRA', 76, 'BR', 'Brazil', 'Brasilia',
                8511965, 201103330, 'SA', '', 'BRL', '.br');
        $this->createCountry($em, 'BS', 'BHS', 44, 'BF', 'Bahamas', 'Nassau',
                13940, 301790, 'NA', '', 'BSD', '.bs');
        $this->createCountry($em, 'BT', 'BTN', 64, 'BT', 'Bhutan', 'Thimphu',
                47000, 699847, 'AS', '', 'BTN', '.bt');
        $this->createCountry($em, 'BV', 'BVT', 74, 'BV', 'Bouvet Island', '', 0,
                0, 'AN', '', 'NOK', '.bv');
        $this->createCountry($em, 'BW', 'BWA', 72, 'BC', 'Botswana', 'Gaborone',
                600370, 2029307, 'AF', '', 'BWP', '.bw');
        $this->createCountry($em, 'BY', 'BLR', 112, 'BO', 'Belarus', 'Minsk',
                207600, 9685000, 'EU', '', 'BYR', '.by');
        $this->createCountry($em, 'BZ', 'BLZ', 84, 'BH', 'Belize', 'Belmopan',
                22966, 314522, 'NA', '', 'BZD', '.bz');
        $this->createCountry($em, 'CA', 'CAN', 124, 'CA', 'Canada', 'Ottawa',
                9984670, 33679000, 'NA', '', 'CAD', '.ca');
        $this->createCountry($em, 'CC', 'CCK', 166, 'CK', 'Cocos Islands',
                'West Island', 14, 628, 'AS', '', 'AUD', '.cc');
        $this->createCountry($em, 'CD', 'COD', 180, 'CG',
                'Democratic Republic of the Congo', 'Kinshasa', 2345410,
                70916439, 'AF', '', 'CDF', '.cd');
        $this->createCountry($em, 'CF', 'CAF', 140, 'CT',
                'Central African Republic', 'Bangui', 622984, 4844927, 'AF', '',
                'XAF', '.cf');
        $this->createCountry($em, 'CG', 'COG', 178, 'CF',
                'Republic of the Congo', 'Brazzaville', 342000, 3039126, 'AF',
                '', 'XAF', '.cg');
        $this->createCountry($em, 'CH', 'CHE', 756, 'SZ', 'Switzerland',
                'Berne', 41290, 7581000, 'EU', '', 'CHF', '.ch');
        $this->createCountry($em, 'CI', 'CIV', 384, 'IV', 'Ivory Coast',
                'Yamoussoukro', 322460, 21058798, 'AF', '', 'XOF', '.ci');
        $this->createCountry($em, 'CK', 'COK', 184, 'CW', 'Cook Islands',
                'Avarua', 240, 21388, 'OC', '', 'NZD', '.ck');
        $this->createCountry($em, 'CL', 'CHL', 152, 'CI', 'Chile', 'Santiago',
                756950, 16746491, 'SA', '', 'CLP', '.cl');
        $this->createCountry($em, 'CM', 'CMR', 120, 'CM', 'Cameroon', 'Yaounde',
                475440, 19294149, 'AF', '', 'XAF', '.cm');
        $this->createCountry($em, 'CN', 'CHN', 156, 'CH', 'China', 'Beijing',
                9596960, 1330044000, 'AS', '', 'CNY', '.cn');
        $this->createCountry($em, 'CO', 'COL', 170, 'CO', 'Colombia', 'Bogota',
                1138910, 44205293, 'SA', '', 'COP', '.co');
        $this->createCountry($em, 'CR', 'CRI', 188, 'CS', 'Costa Rica',
                'San Jose', 51100, 4516220, 'NA', '', 'CRC', '.cr');
        $this->createCountry($em, 'CU', 'CUB', 192, 'CU', 'Cuba', 'Havana',
                110860, 11423000, 'NA', '', 'CUP', '.cu');
        $this->createCountry($em, 'CV', 'CPV', 132, 'CV', 'Cape Verde', 'Praia',
                4033, 508659, 'AF', '', 'CVE', '.cv');
        $this->createCountry($em, 'CW', 'CUW', 531, 'UC', 'Curacao',
                ' Willemstad', 0, 141766, 'NA', '', 'ANG', '.cw');
        $this->createCountry($em, 'CX', 'CXR', 162, 'KT', 'Christmas Island',
                'Flying Fish Cove', 135, 1500, 'AS', '', 'AUD', '.cx');
        $this->createCountry($em, 'CY', 'CYP', 196, 'CY', 'Cyprus', 'Nicosia',
                9250, 1102677, 'EU', '', 'EUR', '.cy');
        $this->createCountry($em, 'CZ', 'CZE', 203, 'EZ', 'Czech Republic',
                'Prague', 78866, 10476000, 'EU', '', 'CZK', '.cz');
        $duitsland = $this->createCountry($em, 'DE', 'DEU', 276, 'GM',
                'Germany', 'Berlin', 357021, 81802257, 'EU', '', 'EUR', '.de');
        $this->createCountry($em, 'DJ', 'DJI', 262, 'DJ', 'Djibouti',
                'Djibouti', 23000, 740528, 'AF', '', 'DJF', '.dj');
        $this->createCountry($em, 'DK', 'DNK', 208, 'DA', 'Denmark',
                'Copenhagen', 43094, 5484000, 'EU', '', 'DKK', '.dk');
        $this->createCountry($em, 'DM', 'DMA', 212, 'DO', 'Dominica', 'Roseau',
                754, 72813, 'NA', '', 'XCD', '.dm');
        $this->createCountry($em, 'DO', 'DOM', 214, 'DR', 'Dominican Republic',
                'Santo Domingo', 48730, 9823821, 'NA', '', 'DOP', '.do');
        $this->createCountry($em, 'DZ', 'DZA', 12, 'AG', 'Algeria', 'Algiers',
                2381740, 34586184, 'AF', '', 'DZD', '.dz');
        $this->createCountry($em, 'EC', 'ECU', 218, 'EC', 'Ecuador', 'Quito',
                283560, 14790608, 'SA', '', 'USD', '.ec');
        $this->createCountry($em, 'EE', 'EST', 233, 'EN', 'Estonia', 'Tallinn',
                45226, 1291170, 'EU', '', 'EUR', '.ee');
        $this->createCountry($em, 'EG', 'EGY', 818, 'EG', 'Egypt', 'Cairo',
                1001450, 80471869, 'AF', '', 'EGP', '.eg');
        $this->createCountry($em, 'EH', 'ESH', 732, 'WI', 'Western Sahara',
                'El-Aaiun', 266000, 273008, 'AF', '', 'MAD', '.eh');
        $this->createCountry($em, 'ER', 'ERI', 232, 'ER', 'Eritrea', 'Asmara',
                121320, 5792984, 'AF', '', 'ERN', '.er');
        $this->createCountry($em, 'ES', 'ESP', 724, 'SP', 'Spain', 'Madrid',
                504782, 46505963, 'EU', '', 'EUR', '.es');
        $this->createCountry($em, 'ET', 'ETH', 231, 'ET', 'Ethiopia',
                'Addis Ababa', 1127127, 88013491, 'AF', '', 'ETB', '.et');
        $this->createCountry($em, 'FI', 'FIN', 246, 'FI', 'Finland', 'Helsinki',
                337030, 5244000, 'EU', '', 'EUR', '.fi');
        $this->createCountry($em, 'FJ', 'FJI', 242, 'FJ', 'Fiji', 'Suva', 18270,
                875983, 'OC', '', 'FJD', '.fj');
        $this->createCountry($em, 'FK', 'FLK', 238, 'FK', 'Falkland Islands',
                'Stanley', 12173, 2638, 'SA', '', 'FKP', '.fk');
        $this->createCountry($em, 'FM', 'FSM', 583, 'FM', 'Micronesia',
                'Palikir', 702, 107708, 'OC', '', 'USD', '.fm');
        $this->createCountry($em, 'FO', 'FRO', 234, 'FO', 'Faroe Islands',
                'Torshavn', 1399, 48228, 'EU', '', 'DKK', '.fo');
        $this->createCountry($em, 'FR', 'FRA', 250, 'FR', 'France', 'Paris',
                547030, 64768389, 'EU', '', 'EUR', '.fr');
        $this->createCountry($em, 'GA', 'GAB', 266, 'GB', 'Gabon', 'Libreville',
                267667, 1545255, 'AF', '', 'XAF', '.ga');
        $this->createCountry($em, 'GB', 'GBR', 826, 'UK', 'United Kingdom',
                'London', 244820, 62348447, 'EU', '', 'GBP', '.uk');
        $this->createCountry($em, 'GD', 'GRD', 308, 'GJ', 'Grenada',
                'St. George\'s', 344, 107818, 'NA', '', 'XCD', '.gd');
        $this->createCountry($em, 'GE', 'GEO', 268, 'GG', 'Georgia', 'Tbilisi',
                69700, 4630000, 'AS', '', 'GEL', '.ge');
        $this->createCountry($em, 'GF', 'GUF', 254, 'FG', 'French Guiana',
                'Cayenne', 91000, 195506, 'SA', '', 'EUR', '.gf');
        $this->createCountry($em, 'GG', 'GGY', 831, 'GK', 'Guernsey',
                'St Peter Port', 78, 65228, 'EU', '', 'GBP', '.gg');
        $this->createCountry($em, 'GH', 'GHA', 288, 'GH', 'Ghana', 'Accra',
                239460, 24339838, 'AF', '', 'GHS', '.gh');
        $this->createCountry($em, 'GI', 'GIB', 292, 'GI', 'Gibraltar',
                'Gibraltar', 6.5, 27884, 'EU', '', 'GIP', '.gi');
        $this->createCountry($em, 'GL', 'GRL', 304, 'GL', 'Greenland', 'Nuuk',
                2166086, 56375, 'NA', '', 'DKK', '.gl');
        $this->createCountry($em, 'GM', 'GMB', 270, 'GA', 'Gambia', 'Banjul',
                11300, 1593256, 'AF', '', 'GMD', '.gm');
        $this->createCountry($em, 'GN', 'GIN', 324, 'GV', 'Guinea', 'Conakry',
                245857, 10324025, 'AF', '', 'GNF', '.gn');
        $this->createCountry($em, 'GP', 'GLP', 312, 'GP', 'Guadeloupe',
                'Basse-Terre', 1780, 443000, 'NA', '', 'EUR', '.gp');
        $this->createCountry($em, 'GQ', 'GNQ', 226, 'EK', 'Equatorial Guinea',
                'Malabo', 28051, 1014999, 'AF', '', 'XAF', '.gq');
        $this->createCountry($em, 'GR', 'GRC', 300, 'GR', 'Greece', 'Athens',
                131940, 11000000, 'EU', '', 'EUR', '.gr');
        $this->createCountry($em, 'GS', 'SGS', 239, 'SX',
                'South Georgia and the South Sandwich Islands', 'Grytviken',
                3903, 30, 'AN', '', 'GBP', '.gs');
        $this->createCountry($em, 'GT', 'GTM', 320, 'GT', 'Guatemala',
                'Guatemala City', 108890, 13550440, 'NA', '', 'GTQ', '.gt');
        $this->createCountry($em, 'GU', 'GUM', 316, 'GQ', 'Guam', 'Hagatna',
                549, 159358, 'OC', '', 'USD', '.gu');
        $this->createCountry($em, 'GW', 'GNB', 624, 'PU', 'Guinea-Bissau',
                'Bissau', 36120, 1565126, 'AF', '', 'XOF', '.gw');
        $this->createCountry($em, 'GY', 'GUY', 328, 'GY', 'Guyana',
                'Georgetown', 214970, 748486, 'SA', '', 'GYD', '.gy');
        $this->createCountry($em, 'HK', 'HKG', 344, 'HK', 'Hong Kong',
                'Hong Kong', 1092, 6898686, 'AS', '', 'HKD', '.hk');
        $this->createCountry($em, 'HM', 'HMD', 334, 'HM',
                'Heard Island and McDonald Islands', '', 412, 0, 'AN', '',
                'AUD', '.hm');
        $this->createCountry($em, 'HN', 'HND', 340, 'HO', 'Honduras',
                'Tegucigalpa', 112090, 7989415, 'NA', '', 'HNL', '.hn');
        $this->createCountry($em, 'HR', 'HRV', 191, 'HR', 'Croatia', 'Zagreb',
                56542, 4491000, 'EU', '', 'HRK', '.hr');
        $this->createCountry($em, 'HT', 'HTI', 332, 'HA', 'Haiti',
                'Port-au-Prince', 27750, 9648924, 'NA', '', 'HTG', '.ht');
        $this->createCountry($em, 'HU', 'HUN', 348, 'HU', 'Hungary', 'Budapest',
                93030, 9982000, 'EU', '', 'HUF', '.hu');
        $this->createCountry($em, 'ID', 'IDN', 360, 'ID', 'Indonesia',
                'Jakarta', 1919440, 242968342, 'AS', '', 'IDR', '.id');
        $this->createCountry($em, 'IE', 'IRL', 372, 'EI', 'Ireland', 'Dublin',
                70280, 4622917, 'EU', '', 'EUR', '.ie');
        $this->createCountry($em, 'IL', 'ISR', 376, 'IS', 'Israel', 'Jerusalem',
                20770, 7353985, 'AS', '', 'ILS', '.il');
        $this->createCountry($em, 'IM', 'IMN', 833, 'IM', 'Isle of Man',
                'Douglas, Isle of Man', 572, 75049, 'EU', '', 'GBP', '.im');
        $this->createCountry($em, 'IN', 'IND', 356, 'IN', 'India', 'New Delhi',
                3287590, 1173108018, 'AS', '', 'INR', '.in');
        $this->createCountry($em, 'IO', 'IOT', 86, 'IO',
                'British Indian Ocean Territory', 'Diego Garcia', 60, 4000,
                'AS', '', 'USD', '.io');
        $this->createCountry($em, 'IQ', 'IRQ', 368, 'IZ', 'Iraq', 'Baghdad',
                437072, 29671605, 'AS', '', 'IQD', '.iq');
        $this->createCountry($em, 'IR', 'IRN', 364, 'IR', 'Iran', 'Tehran',
                1648000, 76923300, 'AS', '', 'IRR', '.ir');
        $this->createCountry($em, 'IS', 'ISL', 352, 'IC', 'Iceland',
                'Reykjavik', 103000, 308910, 'EU', '', 'ISK', '.is');
        $this->createCountry($em, 'IT', 'ITA', 380, 'IT', 'Italy', 'Rome',
                301230, 60340328, 'EU', '', 'EUR', '.it');
        $this->createCountry($em, 'JE', 'JEY', 832, 'JE', 'Jersey',
                'Saint Helier', 116, 90812, 'EU', '', 'GBP', '.je');
        $this->createCountry($em, 'JM', 'JAM', 388, 'JM', 'Jamaica', 'Kingston',
                10991, 2847232, 'NA', '', 'JMD', '.jm');
        $this->createCountry($em, 'JO', 'JOR', 400, 'JO', 'Jordan', 'Amman',
                92300, 6407085, 'AS', '', 'JOD', '.jo');
        $this->createCountry($em, 'JP', 'JPN', 392, 'JA', 'Japan', 'Tokyo',
                377835, 127288000, 'AS', '', 'JPY', '.jp');
        $this->createCountry($em, 'KE', 'KEN', 404, 'KE', 'Kenya', 'Nairobi',
                582650, 40046566, 'AF', '', 'KES', '.ke');
        $this->createCountry($em, 'KG', 'KGZ', 417, 'KG', 'Kyrgyzstan',
                'Bishkek', 198500, 5508626, 'AS', '', 'KGS', '.kg');
        $this->createCountry($em, 'KH', 'KHM', 116, 'CB', 'Cambodia',
                'Phnom Penh', 181040, 14453680, 'AS', '', 'KHR', '.kh');
        $this->createCountry($em, 'KI', 'KIR', 296, 'KR', 'Kiribati', 'Tarawa',
                811, 92533, 'OC', '', 'AUD', '.ki');
        $this->createCountry($em, 'KM', 'COM', 174, 'CN', 'Comoros', 'Moroni',
                2170, 773407, 'AF', '', 'KMF', '.km');
        $this->createCountry($em, 'KN', 'KNA', 659, 'SC',
                'Saint Kitts and Nevis', 'Basseterre', 261, 49898, 'NA', '',
                'XCD', '.kn');
        $this->createCountry($em, 'KP', 'PRK', 408, 'KN', 'North Korea',
                'Pyongyang', 120540, 22912177, 'AS', '', 'KPW', '.kp');
        $this->createCountry($em, 'KR', 'KOR', 410, 'KS', 'South Korea',
                'Seoul', 98480, 48422644, 'AS', '', 'KRW', '.kr');
        $this->createCountry($em, 'XK', 'XKX', 0, 'KV', 'Kosovo', 'Pristina', 0,
                1800000, 'EU', '', 'EUR', '');
        $this->createCountry($em, 'KW', 'KWT', 414, 'KU', 'Kuwait',
                'Kuwait City', 17820, 2789132, 'AS', '', 'KWD', '.kw');
        $this->createCountry($em, 'KY', 'CYM', 136, 'CJ', 'Cayman Islands',
                'George Town', 262, 44270, 'NA', '', 'KYD', '.ky');
        $this->createCountry($em, 'KZ', 'KAZ', 398, 'KZ', 'Kazakhstan',
                'Astana', 2717300, 15340000, 'AS', '', 'KZT', '.kz');
        $this->createCountry($em, 'LA', 'LAO', 418, 'LA', 'Laos', 'Vientiane',
                236800, 6368162, 'AS', '', 'LAK', '.la');
        $this->createCountry($em, 'LB', 'LBN', 422, 'LE', 'Lebanon', 'Beirut',
                10400, 4125247, 'AS', '', 'LBP', '.lb');
        $this->createCountry($em, 'LC', 'LCA', 662, 'ST', 'Saint Lucia',
                'Castries', 616, 160922, 'NA', '', 'XCD', '.lc');
        $this->createCountry($em, 'LI', 'LIE', 438, 'LS', 'Liechtenstein',
                'Vaduz', 160, 35000, 'EU', '', 'CHF', '.li');
        $this->createCountry($em, 'LK', 'LKA', 144, 'CE', 'Sri Lanka',
                'Colombo', 65610, 21513990, 'AS', '', 'LKR', '.lk');
        $this->createCountry($em, 'LR', 'LBR', 430, 'LI', 'Liberia', 'Monrovia',
                111370, 3685076, 'AF', '', 'LRD', '.lr');
        $this->createCountry($em, 'LS', 'LSO', 426, 'LT', 'Lesotho', 'Maseru',
                30355, 1919552, 'AF', '', 'LSL', '.ls');
        $this->createCountry($em, 'LT', 'LTU', 440, 'LH', 'Lithuania',
                'Vilnius', 65200, 3565000, 'EU', '', 'LTL', '.lt');
        $this->createCountry($em, 'LU', 'LUX', 442, 'LU', 'Luxembourg',
                'Luxembourg', 2586, 497538, 'EU', '', 'EUR', '.lu');
        $this->createCountry($em, 'LV', 'LVA', 428, 'LG', 'Latvia', 'Riga',
                64589, 2217969, 'EU', '', 'LVL', '.lv');
        $this->createCountry($em, 'LY', 'LBY', 434, 'LY', 'Libya', 'Tripolis',
                1759540, 6461454, 'AF', '', 'LYD', '.ly');
        $this->createCountry($em, 'MA', 'MAR', 504, 'MO', 'Morocco', 'Rabat',
                446550, 31627428, 'AF', '', 'MAD', '.ma');
        $this->createCountry($em, 'MC', 'MCO', 492, 'MN', 'Monaco', 'Monaco',
                1.95, 32965, 'EU', '', 'EUR', '.mc');
        $this->createCountry($em, 'MD', 'MDA', 498, 'MD', 'Moldova', 'Chisinau',
                33843, 4324000, 'EU', '', 'MDL', '.md');
        $this->createCountry($em, 'ME', 'MNE', 499, 'MJ', 'Montenegro',
                'Podgorica', 14026, 666730, 'EU', '', 'EUR', '.me');
        $this->createCountry($em, 'MF', 'MAF', 663, 'RN', 'Saint Martin',
                'Marigot', 53, 35925, 'NA', '', 'EUR', '.gp');
        $this->createCountry($em, 'MG', 'MDG', 450, 'MA', 'Madagascar',
                'Antananarivo', 587040, 21281844, 'AF', '', 'MGA', '.mg');
        $this->createCountry($em, 'MH', 'MHL', 584, 'RM', 'Marshall Islands',
                'Majuro', 181.3, 65859, 'OC', '', 'USD', '.mh');
        $this->createCountry($em, 'MK', 'MKD', 807, 'MK', 'Macedonia', 'Skopje',
                25333, 2061000, 'EU', '', 'MKD', '.mk');
        $this->createCountry($em, 'ML', 'MLI', 466, 'ML', 'Mali', 'Bamako',
                1240000, 13796354, 'AF', '', 'XOF', '.ml');
        $this->createCountry($em, 'MM', 'MMR', 104, 'BM', 'Myanmar',
                'Nay Pyi Taw', 678500, 53414374, 'AS', '', 'MMK', '.mm');
        $this->createCountry($em, 'MN', 'MNG', 496, 'MG', 'Mongolia',
                'Ulan Bator', 1565000, 3086918, 'AS', '', 'MNT', '.mn');
        $this->createCountry($em, 'MO', 'MAC', 446, 'MC', 'Macao', 'Macao', 254,
                449198, 'AS', '', 'MOP', '.mo');
        $this->createCountry($em, 'MP', 'MNP', 580, 'CQ',
                'Northern Mariana Islands', 'Saipan', 477, 53883, 'OC', '',
                'USD', '.mp');
        $this->createCountry($em, 'MQ', 'MTQ', 474, 'MB', 'Martinique',
                'Fort-de-France', 1100, 432900, 'NA', '', 'EUR', '.mq');
        $this->createCountry($em, 'MR', 'MRT', 478, 'MR', 'Mauritania',
                'Nouakchott', 1030700, 3205060, 'AF', '', 'MRO', '.mr');
        $this->createCountry($em, 'MS', 'MSR', 500, 'MH', 'Montserrat',
                'Plymouth', 102, 9341, 'NA', '', 'XCD', '.ms');
        $this->createCountry($em, 'MT', 'MLT', 470, 'MT', 'Malta', 'Valletta',
                316, 403000, 'EU', '', 'EUR', '.mt');
        $this->createCountry($em, 'MU', 'MUS', 480, 'MP', 'Mauritius',
                'Port Louis', 2040, 1294104, 'AF', '', 'MUR', '.mu');
        $this->createCountry($em, 'MV', 'MDV', 462, 'MV', 'Maldives', 'Male',
                300, 395650, 'AS', '', 'MVR', '.mv');
        $this->createCountry($em, 'MW', 'MWI', 454, 'MI', 'Malawi', 'Lilongwe',
                118480, 15447500, 'AF', '', 'MWK', '.mw');
        $this->createCountry($em, 'MX', 'MEX', 484, 'MX', 'Mexico',
                'Mexico City', 1972550, 112468855, 'NA', '', 'MXN', '.mx');
        $this->createCountry($em, 'MY', 'MYS', 458, 'MY', 'Malaysia',
                'Kuala Lumpur', 329750, 28274729, 'AS', '', 'MYR', '.my');
        $this->createCountry($em, 'MZ', 'MOZ', 508, 'MZ', 'Mozambique',
                'Maputo', 801590, 22061451, 'AF', '', 'MZN', '.mz');
        $this->createCountry($em, 'NA', 'NAM', 516, 'WA', 'Namibia', 'Windhoek',
                825418, 2128471, 'AF', '', 'NAD', '.na');
        $this->createCountry($em, 'NC', 'NCL', 540, 'NC', 'New Caledonia',
                'Noumea', 19060, 216494, 'OC', '', 'XPF', '.nc');
        $this->createCountry($em, 'NE', 'NER', 562, 'NG', 'Niger', 'Niamey',
                1267000, 15878271, 'AF', '', 'XOF', '.ne');
        $this->createCountry($em, 'NF', 'NFK', 574, 'NF', 'Norfolk Island',
                'Kingston', 34.6, 1828, 'OC', '', 'AUD', '.nf');
        $this->createCountry($em, 'NG', 'NGA', 566, 'NI', 'Nigeria', 'Abuja',
                923768, 154000000, 'AF', '', 'NGN', '.ng');
        $this->createCountry($em, 'NI', 'NIC', 558, 'NU', 'Nicaragua',
                'Managua', 129494, 5995928, 'NA', '', 'NIO', '.ni');
        $nederland = $this->createCountry($em, 'NL', 'NLD', 528, 'NL',
                'Netherlands', 'Amsterdam', 41526, 16645000, 'EU', '', 'EUR',
                '.nl');
        $this->createCountry($em, 'NO', 'NOR', 578, 'NO', 'Norway', 'Oslo',
                324220, 5009150, 'EU', '', 'NOK', '.no');
        $this->createCountry($em, 'NP', 'NPL', 524, 'NP', 'Nepal', 'Kathmandu',
                140800, 28951852, 'AS', '', 'NPR', '.np');
        $this->createCountry($em, 'NR', 'NRU', 520, 'NR', 'Nauru', 'Yaren', 21,
                10065, 'OC', '', 'AUD', '.nr');
        $this->createCountry($em, 'NU', 'NIU', 570, 'NE', 'Niue', 'Alofi', 260,
                2166, 'OC', '', 'NZD', '.nu');
        $this->createCountry($em, 'NZ', 'NZL', 554, 'NZ', 'New Zealand',
                'Wellington', 268680, 4252277, 'OC', '', 'NZD', '.nz');
        $this->createCountry($em, 'OM', 'OMN', 512, 'MU', 'Oman', 'Muscat',
                212460, 2967717, 'AS', '', 'OMR', '.om');
        $this->createCountry($em, 'PA', 'PAN', 591, 'PM', 'Panama',
                'Panama City', 78200, 3410676, 'NA', '', 'PAB', '.pa');
        $this->createCountry($em, 'PE', 'PER', 604, 'PE', 'Peru', 'Lima',
                1285220, 29907003, 'SA', '', 'PEN', '.pe');
        $this->createCountry($em, 'PF', 'PYF', 258, 'FP', 'French Polynesia',
                'Papeete', 4167, 270485, 'OC', '', 'XPF', '.pf');
        $this->createCountry($em, 'PG', 'PNG', 598, 'PP', 'Papua New Guinea',
                'Port Moresby', 462840, 6064515, 'OC', '', 'PGK', '.pg');
        $this->createCountry($em, 'PH', 'PHL', 608, 'RP', 'Philippines',
                'Manila', 300000, 99900177, 'AS', '', 'PHP', '.ph');
        $this->createCountry($em, 'PK', 'PAK', 586, 'PK', 'Pakistan',
                'Islamabad', 803940, 184404791, 'AS', '', 'PKR', '.pk');
        $this->createCountry($em, 'PL', 'POL', 616, 'PL', 'Poland', 'Warsaw',
                312685, 38500000, 'EU', '', 'PLN', '.pl');
        $this->createCountry($em, 'PM', 'SPM', 666, 'SB',
                'Saint Pierre and Miquelon', 'Saint-Pierre', 242, 7012, 'NA',
                '', 'EUR', '.pm');
        $this->createCountry($em, 'PN', 'PCN', 612, 'PC', 'Pitcairn',
                'Adamstown', 47, 46, 'OC', '', 'NZD', '.pn');
        $this->createCountry($em, 'PR', 'PRI', 630, 'RQ', 'Puerto Rico',
                'San Juan', 9104, 3916632, 'NA', '', 'USD', '.pr');
        $this->createCountry($em, 'PS', 'PSE', 275, 'WE',
                'Palestinian Territory', 'East Jerusalem', 5970, 3800000, 'AS',
                '', 'ILS', '.ps');
        $this->createCountry($em, 'PT', 'PRT', 620, 'PO', 'Portugal', 'Lisbon',
                92391, 10676000, 'EU', '', 'EUR', '.pt');
        $this->createCountry($em, 'PW', 'PLW', 585, 'PS', 'Palau', 'Melekeok',
                458, 19907, 'OC', '', 'USD', '.pw');
        $this->createCountry($em, 'PY', 'PRY', 600, 'PA', 'Paraguay',
                'Asuncion', 406750, 6375830, 'SA', '', 'PYG', '.py');
        $this->createCountry($em, 'QA', 'QAT', 634, 'QA', 'Qatar', 'Doha',
                11437, 840926, 'AS', '', 'QAR', '.qa');
        $this->createCountry($em, 'RE', 'REU', 638, 'RE', 'Reunion',
                'Saint-Denis', 2517, 776948, 'AF', '', 'EUR', '.re');
        $this->createCountry($em, 'RO', 'ROU', 642, 'RO', 'Romania',
                'Bucharest', 237500, 21959278, 'EU', '', 'RON', '.ro');
        $this->createCountry($em, 'RS', 'SRB', 688, 'RI', 'Serbia', 'Belgrade',
                88361, 7344847, 'EU', '', 'RSD', '.rs');
        $this->createCountry($em, 'RU', 'RUS', 643, 'RS', 'Russia', 'Moscow',
                17100000, 140702000, 'EU', '', 'RUB', '.ru');
        $this->createCountry($em, 'RW', 'RWA', 646, 'RW', 'Rwanda', 'Kigali',
                26338, 11055976, 'AF', '', 'RWF', '.rw');
        $this->createCountry($em, 'SA', 'SAU', 682, 'SA', 'Saudi Arabia',
                'Riyadh', 1960582, 25731776, 'AS', '', 'SAR', '.sa');
        $this->createCountry($em, 'SB', 'SLB', 90, 'BP', 'Solomon Islands',
                'Honiara', 28450, 559198, 'OC', '', 'SBD', '.sb');
        $this->createCountry($em, 'SC', 'SYC', 690, 'SE', 'Seychelles',
                'Victoria', 455, 88340, 'AF', '', 'SCR', '.sc');
        $this->createCountry($em, 'SD', 'SDN', 729, 'SU', 'Sudan', 'Khartoum',
                1861484, 35000000, 'AF', '', 'SDG', '.sd');
        $this->createCountry($em, 'SS', 'SSD', 728, 'OD', 'South Sudan', 'Juba',
                644329, 8260490, 'AF', '', 'SSP', '');
        $this->createCountry($em, 'SE', 'SWE', 752, 'SW', 'Sweden', 'Stockholm',
                449964, 9555893, 'EU', '', 'SEK', '.se');
        $this->createCountry($em, 'SG', 'SGP', 702, 'SN', 'Singapore',
                'Singapur', 692.7, 4701069, 'AS', '', 'SGD', '.sg');
        $this->createCountry($em, 'SH', 'SHN', 654, 'SH', 'Saint Helena',
                'Jamestown', 410, 7460, 'AF', '', 'SHP', '.sh');
        $this->createCountry($em, 'SI', 'SVN', 705, 'SI', 'Slovenia',
                'Ljubljana', 20273, 2007000, 'EU', '', 'EUR', '.si');
        $this->createCountry($em, 'SJ', 'SJM', 744, 'SV',
                'Svalbard and Jan Mayen', 'Longyearbyen', 62049, 2550, 'EU', '',
                'NOK', '.sj');
        $this->createCountry($em, 'SK', 'SVK', 703, 'LO', 'Slovakia',
                'Bratislava', 48845, 5455000, 'EU', '', 'EUR', '.sk');
        $this->createCountry($em, 'SL', 'SLE', 694, 'SL', 'Sierra Leone',
                'Freetown', 71740, 5245695, 'AF', '', 'SLL', '.sl');
        $this->createCountry($em, 'SM', 'SMR', 674, 'SM', 'San Marino',
                'San Marino', 61.2, 31477, 'EU', '', 'EUR', '.sm');
        $this->createCountry($em, 'SN', 'SEN', 686, 'SG', 'Senegal', 'Dakar',
                196190, 12323252, 'AF', '', 'XOF', '.sn');
        $this->createCountry($em, 'SO', 'SOM', 706, 'SO', 'Somalia',
                'Mogadishu', 637657, 10112453, 'AF', '', 'SOS', '.so');
        $this->createCountry($em, 'SR', 'SUR', 740, 'NS', 'Suriname',
                'Paramaribo', 163270, 492829, 'SA', '', 'SRD', '.sr');
        $this->createCountry($em, 'ST', 'STP', 678, 'TP',
                'Sao Tome and Principe', 'Sao Tome', 1001, 175808, 'AF', '',
                'STD', '.st');
        $this->createCountry($em, 'SV', 'SLV', 222, 'ES', 'El Salvador',
                'San Salvador', 21040, 6052064, 'NA', '', 'USD', '.sv');
        $this->createCountry($em, 'SX', 'SXM', 534, 'NN', 'Sint Maarten',
                'Philipsburg', 0, 37429, 'NA', '', 'ANG', '.sx');
        $this->createCountry($em, 'SY', 'SYR', 760, 'SY', 'Syria', 'Damascus',
                185180, 22198110, 'AS', '', 'SYP', '.sy');
        $this->createCountry($em, 'SZ', 'SWZ', 748, 'WZ', 'Swaziland',
                'Mbabane', 17363, 1354051, 'AF', '', 'SZL', '.sz');
        $this->createCountry($em, 'TC', 'TCA', 796, 'TK',
                'Turks and Caicos Islands', 'Cockburn Town', 430, 20556, 'NA',
                '', 'USD', '.tc');
        $this->createCountry($em, 'TD', 'TCD', 148, 'CD', 'Chad', 'N\'Djamena',
                1284000, 10543464, 'AF', '', 'XAF', '.td');
        $this->createCountry($em, 'TF', 'ATF', 260, 'FS',
                'French Southern Territories', 'Port-aux-Francais', 7829, 140,
                'AN', '', 'EUR', '.tf');
        $this->createCountry($em, 'TG', 'TGO', 768, 'TO', 'Togo', 'Lome', 56785,
                6587239, 'AF', '', 'XOF', '.tg');
        $this->createCountry($em, 'TH', 'THA', 764, 'TH', 'Thailand', 'Bangkok',
                514000, 67089500, 'AS', '', 'THB', '.th');
        $this->createCountry($em, 'TJ', 'TJK', 762, 'TI', 'Tajikistan',
                'Dushanbe', 143100, 7487489, 'AS', '', 'TJS', '.tj');
        $this->createCountry($em, 'TK', 'TKL', 772, 'TL', 'Tokelau', '', 10,
                1466, 'OC', '', 'NZD', '.tk');
        $this->createCountry($em, 'TL', 'TLS', 626, 'TT', 'East Timor', 'Dili',
                15007, 1154625, 'OC', '', 'USD', '.tl');
        $this->createCountry($em, 'TM', 'TKM', 795, 'TX', 'Turkmenistan',
                'Ashgabat', 488100, 4940916, 'AS', '', 'TMT', '.tm');
        $this->createCountry($em, 'TN', 'TUN', 788, 'TS', 'Tunisia', 'Tunis',
                163610, 10589025, 'AF', '', 'TND', '.tn');
        $this->createCountry($em, 'TO', 'TON', 776, 'TN', 'Tonga',
                'Nuku\'alofa', 748, 122580, 'OC', '', 'TOP', '.to');
        $this->createCountry($em, 'TR', 'TUR', 792, 'TU', 'Turkey', 'Ankara',
                780580, 77804122, 'AS', '', 'TRY', '.tr');
        $this->createCountry($em, 'TT', 'TTO', 780, 'TD', 'Trinidad and Tobago',
                'Port of Spain', 5128, 1228691, 'NA', '', 'TTD', '.tt');
        $this->createCountry($em, 'TV', 'TUV', 798, 'TV', 'Tuvalu', 'Funafuti',
                26, 10472, 'OC', '', 'AUD', '.tv');
        $this->createCountry($em, 'TW', 'TWN', 158, 'TW', 'Taiwan', 'Taipei',
                35980, 22894384, 'AS', '', 'TWD', '.tw');
        $this->createCountry($em, 'TZ', 'TZA', 834, 'TZ', 'Tanzania', 'Dodoma',
                945087, 41892895, 'AF', '', 'TZS', '.tz');
        $this->createCountry($em, 'UA', 'UKR', 804, 'UP', 'Ukraine', 'Kiev',
                603700, 45415596, 'EU', '', 'UAH', '.ua');
        $this->createCountry($em, 'UG', 'UGA', 800, 'UG', 'Uganda', 'Kampala',
                236040, 33398682, 'AF', '', 'UGX', '.ug');
        $this->createCountry($em, 'UM', 'UMI', 581, '',
                'United States Minor Outlying Islands', '', 0, 0, 'OC', '',
                'USD', '.um');
        $this->createCountry($em, 'US', 'USA', 840, 'US', 'United States',
                'Washington', 9629091, 310232863, 'NA', '', 'USD', '.us');
        $this->createCountry($em, 'UY', 'URY', 858, 'UY', 'Uruguay',
                'Montevideo', 176220, 3477000, 'SA', '', 'UYU', '.uy');
        $this->createCountry($em, 'UZ', 'UZB', 860, 'UZ', 'Uzbekistan',
                'Tashkent', 447400, 27865738, 'AS', '', 'UZS', '.uz');
        $this->createCountry($em, 'VA', 'VAT', 336, 'VT', 'Vatican',
                'Vatican City', 0.44, 921, 'EU', '', 'EUR', '.va');
        $this->createCountry($em, 'VC', 'VCT', 670, 'VC',
                'Saint Vincent and the Grenadines', 'Kingstown', 389, 104217,
                'NA', '', 'XCD', '.vc');
        $this->createCountry($em, 'VE', 'VEN', 862, 'VE', 'Venezuela',
                'Caracas', 912050, 27223228, 'SA', '', 'VEF', '.ve');
        $this->createCountry($em, 'VG', 'VGB', 92, 'VI',
                'British Virgin Islands', 'Road Town', 153, 21730, 'NA', '',
                'USD', '.vg');
        $this->createCountry($em, 'VI', 'VIR', 850, 'VQ', 'U.S. Virgin Islands',
                'Charlotte Amalie', 352, 108708, 'NA', '', 'USD', '.vi');
        $this->createCountry($em, 'VN', 'VNM', 704, 'VM', 'Vietnam', 'Hanoi',
                329560, 89571130, 'AS', '', 'VND', '.vn');
        $this->createCountry($em, 'VU', 'VUT', 548, 'NH', 'Vanuatu',
                'Port Vila', 12200, 221552, 'OC', '', 'VUV', '.vu');
        $this->createCountry($em, 'WF', 'WLF', 876, 'WF', 'Wallis and Futuna',
                'Mata Utu', 274, 16025, 'OC', '', 'XPF', '.wf');
        $this->createCountry($em, 'WS', 'WSM', 882, 'WS', 'Samoa', 'Apia', 2944,
                192001, 'OC', '', 'WST', '.ws');
        $this->createCountry($em, 'YE', 'YEM', 887, 'YM', 'Yemen', 'Sanaa',
                527970, 23495361, 'AS', '', 'YER', '.ye');
        $this->createCountry($em, 'YT', 'MYT', 175, 'MF', 'Mayotte',
                'Mamoudzou', 374, 159042, 'AF', '', 'EUR', '.yt');
        $this->createCountry($em, 'ZA', 'ZAF', 710, 'SF', 'South Africa',
                'Pretoria', 1219912, 49000000, 'AF', '', 'ZAR', '.za');
        $this->createCountry($em, 'ZM', 'ZMB', 894, 'ZA', 'Zambia', 'Lusaka',
                752614, 13460305, 'AF', '', 'ZMK', '.zm');
        $this->createCountry($em, 'ZW', 'ZWE', 716, 'ZI', 'Zimbabwe', 'Harare',
                390580, 11651858, 'AF', '', 'ZWL', '.zw');
        $this->createCountry($em, 'CS', 'SCG', 891, 'YI',
                'Serbia and Montenegro', 'Belgrade', 102350, 10829175, 'EU', '',
                'RSD', '.cs');
        $this->createCountry($em, 'AN', 'ANT', 530, 'NT',
                'Netherlands Antilles', 'Willemstad', 960, 136197, 'NA', '',
                'ANG', '.an');

        $coordinator = $this->createRightGroup($em, "Coordinator");

        $right = $this->createRight($em, "DELETE_LOCATION");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "UPDATE_LOCATION");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "VIEW_LOCATIONS");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "VIEW_USERS");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "CREATE_USER");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "UPDATE_USER");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "DELETE_USER");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "VIEW_REVIEWS");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "DELETE_REVIEW");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "UPDATE_REVIEW");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "VIEW_PROJECTS");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "DELETE_PROJECT");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "UPDATE_PROJECT");
        $this->addRightToRightGroup($em, $right, $coordinator);
        $right = $this->createRight($em, "UPLOAD_EXCEL");
        $this->addRightToRightGroup($em, $right, $coordinator);

        $this->createClippy($em, "home", "index",
                "This is the map overview. Click on a marker to view the info.");
        $this->createClippy($em, "account", "login",
                "Here you can login to the system.");
        $this->createClippy($em, "account", "register",
                "Here you can register for the website.");
        $this->createClippy($em, "contact", "show",
                "Here you can contact the person who wrote the review.");
        $this->createClippy($em, "management", "home",
                "Here you can manage the content of the website.");
        $this->createClippy($em, "management", "myreviews",
                "Here you can view and edit your reviews.");
        $this->createClippy($em, "management", "myprojects",
                "Here you can view and edit your projects.");
        $this->createClippy($em, "management", "mylocations",
                "Here you can view and edit your locations.");
        $this->createClippy($em, "management", "myaccount",
                "Here you can change your personal information.");
        $this->createClippy($em, "management", "changepassword",
                "Here you can change your password.");
        $this->createClippy($em, "management", "users",
                "Here you can manage all the users.");
        $this->createClippy($em, "management", "createuser",
                "Just type in an email twice and the person will be notified to create an account.");
        $this->createClippy($em, "management", "locations",
                "Here you can change the status of locations.");
        $this->createClippy($em, "management", "reviews",
                "Here you can change the status of reviews.");
        $this->createClippy($em, "management", "projects",
                "Here you can change the status of projects.");
        $this->createClippy($em, "management", "upload",
                "Select an Excel file to be imported into the system.");
        $this->createClippy($em, "management", "uploadfile",
                "Here you can view what has been added and what already existed.");

        $kjansen = $this->createUser($em, "kjansen", "qwerty",
                "HGJDGFSJHDFJHSDf", null);
        $hbakker = $this->createUser($em, "hbakker", "password",
                "E*(%&YUIERHDGFER", $coordinator);

        $kees  = $this->createStudent($em, "Kees", "Jansen", "Jansenlaan", 15,
                "1234AB", "eindhoven", $kjansen, "k.jansen@student.avans.nl");
        $harry = $this->createStudent($em, "Harry", "Bakker", "Bakkersweg", 15,
                "5678CD", "utrecht", $hbakker, "h.bakker@student.avans.nl");

        $avans = $this->createInstitute($em, "Avans Hogeschool", "education",
                "'s-Hertogenbosch", 51.688946, 5.287256, $kees, $nederland,
                "Onderwijsboulevard", "215", "5223DE", "contact@avans.nl",
                "(073) 629 52 95");
        $mac   = $this->createInstitute($em, "McDonald's", "business", "Arnhem",
                51.9635996, 5.8930421, $harry, $nederland, "Rijnstraat", "36",
                "6811EW", "arnhem@mcdonalds.nl", "026-4456234");
        $RWTH  = $this->createInstitute($em, "RWTH University Aachen",
                "business", "Aachen", 50.78692, 6.04635, $harry, $duitsland,
                "Steinbachstrase", "7", "52074", "test@toip.nl", "3292-234659");

        $projectX = $this->createProject($em, $kees, $avans, "internship",
                new \DateTime('03/17/2014'), new \DateTime('05/17/2014'));
        $projectZ = $this->createProject($em, $harry, $mac, "minor",
                new \DateTime('02/04/2014'), new \DateTime('06/20/2014'));
        $projectY = $this->createProject($em, $harry, $RWTH, "minor",
                new \DateTime('07/23/2013'), new \DateTime('02/07/2014'));

        $review1 = $this->createReview($em, $projectX, 5, 3, 4,
                "Many fun activities to do here!");
        $review2 = $this->createReview($em, $projectZ, 4, 4, 1,
                "Just do your job and they're happy.");

        //Engels
        $this->createTranslation($em, "worldmap", "english", "Worldmap");
        $this->createTranslation($em, "logout", "english", "Logout");
        $this->createTranslation($em, "welcome", "english", "Welcome");
        $this->createTranslation($em, "login", "english", "Login");
        $this->createTranslation($em, "register", "english", "Register");
        $this->createTranslation($em, "location_type", "english",
                "Location Type");
        $this->createTranslation($em, "education", "english", "Education");
        $this->createTranslation($em, "business", "english", "Business");
        $this->createTranslation($em, "project_type", "english", "Project Type");
        $this->createTranslation($em, "minor", "english", "Minor");
        $this->createTranslation($em, "eps", "english", "EPS");
        $this->createTranslation($em, "graduation", "english", "Graduation");
        $this->createTranslation($em, "internship", "english", "Internship");
        $this->createTranslation($em, "country", "english", "Country");
        $this->createTranslation($em, "contact_form", "english", "Contact Form");
        $this->createTranslation($em, "to", "english", "To");
        $this->createTranslation($em, "from", "english", "From");
        $this->createTranslation($em, "subject", "english", "Subject");
        $this->createTranslation($em, "message", "english", "Message");
        $this->createTranslation($em, "fields_marked", "english",
                "Fields marked with asterisk (*) are required.");
        $this->createTranslation($em, "send", "english", "Send");
        $this->createTranslation($em, "successfully", "english",
                "Your message was sent successfully.");
        $this->createTranslation($em, "back", "english", "Back");
        $this->createTranslation($em, "username", "english", "Username");
        $this->createTranslation($em, "password", "english", "Password");
        $this->createTranslation($em, "repeat_password", "english",
                "Repeat Password");
        $this->createTranslation($em, "email", "english", "E-Mail");
        $this->createTranslation($em, "first_name", "english", "First name");
        $this->createTranslation($em, "surname", "english", "Surname");
        $this->createTranslation($em, "city", "english", "City");
        $this->createTranslation($em, "zipcode", "english", "Zip code");
        $this->createTranslation($em, "street", "english", "Street");
        $this->createTranslation($em, "street_number", "english",
                "Street number");
        $this->createTranslation($em, "addition", "english", "Addition");
        $this->createTranslation($em, "registration_code", "english",
                "Registration Code");
        $this->createTranslation($em, "search", "english", "Search");
        $this->createTranslation($em, "reset", "english", "Reset");
        $this->createTranslation($em, "language", "english", "Language");
        $this->createTranslation($em, "dutch", "english", "Dutch");
        $this->createTranslation($em, "english", "english", "English");
        //Clippy
        $this->createTranslation($em, "klik", Language::ENGLISH,
                "Click me for help!");
        $this->createTranslation($em, "homeindex", Language::ENGLISH,
                "This is the map overview. Click on a marker to view the info.");
        $this->createTranslation($em, "accountlogin", Language::ENGLISH,
                "Here you can login to the system.");
        $this->createTranslation($em, "accountregister", Language::ENGLISH,
                "Here you can register for the website.");
        $this->createTranslation($em, "contactshow", Language::ENGLISH,
                "Here you can contact the person who wrote the review.");
        $this->createTranslation($em, "managementhome", Language::ENGLISH,
                "Here you can manage the content of the website.");
        $this->createTranslation($em, "managementmyreviews", Language::ENGLISH,
                "Here you can view and edit your reviews.");
        $this->createTranslation($em, "managementmyprojects", Language::ENGLISH,
                "Here you can view and edit your projects.");
        $this->createTranslation($em, "managementmylocations",
                Language::ENGLISH, "Here you can view and edit your locations.");
        $this->createTranslation($em, "managementmyaccount", Language::ENGLISH,
                "Here you can change your personal information.");
        $this->createTranslation($em, "managementchangepassword",
                Language::ENGLISH, "Here you can change your password.");
        $this->createTranslation($em, "managementusers", Language::ENGLISH,
                "Here you can manage all the users.");
        $this->createTranslation($em, "managementcreateuser", Language::ENGLISH,
                "Just type in an email twice and the person will be notified to create an account.");
        $this->createTranslation($em, "managementlocations", Language::ENGLISH,
                "Here you can change the status of locations.");
        $this->createTranslation($em, "managementreviews", Language::ENGLISH,
                "Here you can change the status of reviews.");
        $this->createTranslation($em, "managementprojects", Language::ENGLISH,
                "Here you can change the status of projects.");
        $this->createTranslation($em, "managementupload", Language::ENGLISH,
                "Select an Excel file to be imported into the system.");
        $this->createTranslation($em, "managementuploadfile", Language::ENGLISH,
                "Here you can view what has been added and what already existed.");
        //tutorial
        $this->createTranslation($em, "tut1", Language::ENGLISH,
                "Hi, and welcome to our website!");
        $this->createTranslation($em, "tut2", Language::ENGLISH,
                "Let's start with a quick tutorial.");
        $this->createTranslation($em, "tut3", Language::ENGLISH,
                "This is the country filter.");
        $this->createTranslation($em, "tut4", Language::ENGLISH,
                "With this filter you can show the projects in a specific country.");
        $this->createTranslation($em, "tut5", Language::ENGLISH,
                "This is the projecttype filter");
        $this->createTranslation($em, "tut6", Language::ENGLISH,
                "With this filter you can filter the projects by type.");
        $this->createTranslation($em, "tut7", Language::ENGLISH,
                "The types are: Minor, EPS, Internship, and Graduation.");
        $this->createTranslation($em, "tut8", Language::ENGLISH,
                "This is the locationtype filter");
        $this->createTranslation($em, "tut9", Language::ENGLISH,
                "With this filter you can filter the projects by locationtype.");
        $this->createTranslation($em, "tut10", Language::ENGLISH,
                "The types are: Education and Business.");
        $this->createTranslation($em, "tut11", Language::ENGLISH,
                "This is the search bar.");
        $this->createTranslation($em, "tut12", Language::ENGLISH,
                "You can basically search on everything you like.");
        $this->createTranslation($em, "tut13", Language::ENGLISH,
                "Such as Student name, Institute name, Review Text, and a lot more.");
        $this->createTranslation($em, "tut14", Language::ENGLISH,
                "This is a marker.");
        $this->createTranslation($em, "tut15", Language::ENGLISH,
                "If you click on a marker the screen on the left will become visible.");
        $this->createTranslation($em, "tut16", Language::ENGLISH,
                "These are all the reviews available for this institute.");
        $this->createTranslation($em, "tut17", Language::ENGLISH,
                "You can click on the name to view the full review.");
        $this->createTranslation($em, "tut18", Language::ENGLISH,
                "This is the end of the tutorial");
        $this->createTranslation($em, "tut19", Language::ENGLISH,
                "Thank you for watching and if you need anything in the future, just click me :)");
        //Nederlands
        $this->createTranslation($em, "worldmap", "dutch", "Wereldkaart");
        $this->createTranslation($em, "logout", "dutch", "Log uit");
        $this->createTranslation($em, "welcome", "dutch", "Welkom");
        $this->createTranslation($em, "login", "dutch", "Log in");
        $this->createTranslation($em, "register", "dutch", "Registreren");
        $this->createTranslation($em, "location_type", "dutch", "Locatie Type");
        $this->createTranslation($em, "education", "dutch",
                "Opleidingsinstituut");
        $this->createTranslation($em, "business", "dutch", "Bedrijf");
        $this->createTranslation($em, "project_type", "dutch", "Project Type");
        $this->createTranslation($em, "minor", "dutch", "Minor");
        $this->createTranslation($em, "eps", "dutch", "EPS");
        $this->createTranslation($em, "graduation", "dutch", "Afstudeer stage");
        $this->createTranslation($em, "internship", "dutch", "Meeloop stage");
        $this->createTranslation($em, "country", "dutch", "Land");
        $this->createTranslation($em, "contact_form", "dutch",
                "Contact Formulier");
        $this->createTranslation($em, "to", "dutch", "Aan");
        $this->createTranslation($em, "from", "dutch", "Van");
        $this->createTranslation($em, "subject", "dutch", "Onderwerp");
        $this->createTranslation($em, "message", "dutch", "Bericht");
        $this->createTranslation($em, "fields_marked", "dutch",
                "Velden met een asterisk (*) zijn verplicht.");
        $this->createTranslation($em, "send", "dutch", "Stuur");
        $this->createTranslation($em, "successfully", "dutch",
                "Jouw bericht is succesvol verstuurd.");
        $this->createTranslation($em, "back", "dutch", "Terug");
        $this->createTranslation($em, "username", "dutch", "Gebruikersnaam");
        $this->createTranslation($em, "password", "dutch", "Wachtwoord");
        $this->createTranslation($em, "repeat_password", "dutch",
                "Herhaal Wachtwoord");
        $this->createTranslation($em, "email", "dutch", "E-Mail");
        $this->createTranslation($em, "first_name", "dutch", "Voornaam");
        $this->createTranslation($em, "surname", "dutch", "Achternaam");
        $this->createTranslation($em, "city", "dutch", "Stad");
        $this->createTranslation($em, "zipcode", "dutch", "Postcode");
        $this->createTranslation($em, "street", "dutch", "Straat");
        $this->createTranslation($em, "street_number", "dutch", "Straat nummer");
        $this->createTranslation($em, "addition", "dutch", "Toevoeging");
        $this->createTranslation($em, "registration_code", "dutch",
                "Registratie Code");
        $this->createTranslation($em, "search", "dutch", "Zoeken");
        $this->createTranslation($em, "reset", "dutch", "Reset");
        $this->createTranslation($em, "language", "dutch", "Taal");
        $this->createTranslation($em, "dutch", "dutch", "Nederlands");
        $this->createTranslation($em, "english", "dutch", "Engels");

        //Clippy
        $this->createTranslation($em, "klik", Language::DUTCH,
                "Klik op me voor hulp!");
        $this->createTranslation($em, "homeindex", Language::DUTCH,
                "Dit is de kaart, klik op een marker voor meer informatie.");
        $this->createTranslation($em, "accountlogin", Language::DUTCH,
                "Dit is het inlogscherm, hier kan je inloggen.");
        $this->createTranslation($em, "accountregister", Language::DUTCH,
                "Dit is het registratiescherm, hier kan je registreren.");
        $this->createTranslation($em, "contactshow", Language::DUTCH,
                "Hier kun je contact opnemen met de schrijver van de review.");
        $this->createTranslation($em, "managementhome", Language::DUTCH,
                "Hier kun je de content van de website aanpassen.");
        $this->createTranslation($em, "managementmyreviews", Language::DUTCH,
                "Hier kun je je eigen reviews schrijven en aanpassen.");
        $this->createTranslation($em, "managementmyprojects", Language::DUTCH,
                "Hier kun je je eigen projecten maken en aanpassen.");
        $this->createTranslation($em, "managementmylocations", Language::DUTCH,
                "Hier kun je je eigen locaties maken en aanpassen.");
        $this->createTranslation($em, "managementmyaccount", Language::DUTCH,
                "Hier kun je je persoonlijke informatie aanpassen.");
        $this->createTranslation($em, "managementchangepassword",
                Language::DUTCH, "Hier kun je je wachtwoord veranderen.");
        $this->createTranslation($em, "managementusers", Language::DUTCH,
                "Hier kun je al de users zien en aanpassen.");
        $this->createTranslation($em, "managementcreateuser", Language::DUTCH,
                "Type hier twee keer hetzelde emailadres in en er word een mail gestuurd om deze persoon te laten registreren.");
        $this->createTranslation($em, "managementlocations", Language::DUTCH,
                "Hier kun je de status van een locaties aanpassen.");
        $this->createTranslation($em, "managementreviews", Language::DUTCH,
                "Hier kun je de status van een reviews aanpassen.");
        $this->createTranslation($em, "managementprojects", Language::DUTCH,
                "Hier kun je de status van een project aanpassen.");
        $this->createTranslation($em, "managementupload", Language::DUTCH,
                "Selecteer een excel bestand, zodat dit geimporteerd kan worden in het systeem.");
        $this->createTranslation($em, "managementuploadfile", Language::DUTCH,
                "Hier kun je het resultaat zien van het net geuploade bestand.");

        //tutorial
        $this->createTranslation($em, "tut1", Language::DUTCH,
                "Hallo, en welkom bij onze website!");
        $this->createTranslation($em, "tut2", Language::DUTCH,
                "Laten we beginnen met een snelle tutorial.");
        $this->createTranslation($em, "tut3", Language::DUTCH,
                "Dit is de landen filter.");
        $this->createTranslation($em, "tut4", Language::DUTCH,
                "Met deze filter kan je projecten laten zien in een specifiek land.");
        $this->createTranslation($em, "tut5", Language::DUTCH,
                "Dit is de projecttype filter.");
        $this->createTranslation($em, "tut6", Language::DUTCH,
                "Met deze filter kan je de projecten filteren op type.");
        $this->createTranslation($em, "tut7", Language::DUTCH,
                "De types zijn: Minor, EPS, Meeloop Stage en Afstudeer Stage.");
        $this->createTranslation($em, "tut8", Language::DUTCH,
                "Dit is de locatietype filter.");
        $this->createTranslation($em, "tut9", Language::DUTCH,
                "Met deze filter kun je projecten filteren op locatietype.");
        $this->createTranslation($em, "tut10", Language::DUTCH,
                "De types zijn: Opleidingsinstituut en Bedrijf.");
        $this->createTranslation($em, "tut11", Language::DUTCH,
                "Dit is de zoekbalk.");
        $this->createTranslation($em, "tut12", Language::DUTCH,
                "Je kan eigenlijk overal op zoeken.");
        $this->createTranslation($em, "tut13", Language::DUTCH,
                "Zoals Student naam, Instituut naam, Beoordelings tekst en veel meer.");
        $this->createTranslation($em, "tut14", Language::DUTCH,
                "Dit is een marker.");
        $this->createTranslation($em, "tut15", Language::DUTCH,
                "Als je op een marker klikt dan komt er aan de linkerkant een scherm te staan.");
        $this->createTranslation($em, "tut16", Language::DUTCH,
                "Dit zijn alle beoordelingen die beschikbaar zijn voor dit instituut.");
        $this->createTranslation($em, "tut17", Language::DUTCH,
                "Je kan op de naam klikken voor de complete beoordeling.");
        $this->createTranslation($em, "tut18", Language::DUTCH,
                "Dit is het einde van de tutorial.");
        $this->createTranslation($em, "tut19", Language::DUTCH,
                "Bedankt voor het kijken en onthoud, als je iets nodig hebt klik maar op me :)");
        $em->flush();
        ob_end_flush();
    }

}
?>

