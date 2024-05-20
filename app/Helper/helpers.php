<?php

use App\Models\GeneralSetting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use JetBrains\PhpStorm\Pure;

/**
 * Sets admin sidebar menu active
 *
 * @param array $routes
 * @return string
 */
function setActive(array $routes): string
{
    $request = request(); // Get the request object first

    if ($request && is_array($routes)) {
        foreach ($routes as $route) {
            // Ensure request()->routeIs() is called on a valid object
            if ($request->routeIs($route)) {
                return 'active';
            }
        }
    }

    return '';
}

/**
 * @param $val
 * @return bool
 */
function hasVal($val): bool
{
    return isset($val) && !empty($val);
}

/**
 * Checks product discount state
 *
 * @param $product
 * @return bool
 */
function hasDiscount($product): bool
{
    $current_date = date('Y-m-d');

    return $product->offer_price > 0
        && $current_date >= $product->offer_start_date
        && $current_date <= $product->offer_end_date;
}

/**
 * Calculates Price Discount Percentage
 *
 * @param $price_original
 * @param $price_discount
 * @return float|int
 */
function discountPercent($price_original, $price_discount): float|int
{
    return 100 * ($price_original - $price_discount) / $price_original;
}

/**
 * @param $type
 * @return string
 */
function productType($type): string
{
    return match ($type) {
        'featured_product' => 'Featured',
        'top_product' => 'Top',
        'best_product' => 'Best',
        'new_arrival' => 'New',
        'basic_pack' => 'Basic',
        default => '',
    };
}

/**
 * Display number with decimals
 *
 * @param $number
 * @param $decimal
 * @return string
 */
function displayNumber($number, $decimal): string
{
    return number_format($number, (str_contains($number, '.') ? $decimal : 0));
}

/**
 * Currency lists with corresponding attributes
 *
 * @param string|null $code
 * @param bool $decode_html_entity
 * @return array[]|null
 */
function currencyList(?string $code = null, bool $decode_html_entity = true): array|null
{
    $currencies = [
        ['code' => 'AFN', 'countries' => ['Afghanistan'], 'name' => 'Afghanistan Afghani', 'symbol' => '&#1547;'],
        ['code' => 'ARS', 'countries' => ['Argentina'], 'name' => 'Argentine Peso', 'symbol' => '&#36;'],
        ['code' => 'AWG', 'countries' => ['Aruba'], 'name' => 'Aruban florin', 'symbol' => '&#402;'],
        ['code' => 'AUD', 'countries' => ['Australia'], 'name' => 'Australian Dollar', 'symbol' => '&#65;&#36;'],
        ['code' => 'AZN', 'countries' => ['Azerbaijan'], 'name' => 'Azerbaijani Manat', 'symbol' => '&#8380;'],
        ['code' => 'BSD', 'countries' => ['The Bahamas'], 'name' => 'Bahamas Dollar', 'symbol' => '&#66;&#36;'],
        ['code' => 'BBD', 'countries' => ['Barbados'], 'name' => 'Barbados Dollar', 'symbol' => '&#66;&#100;&#115;&#36;'],
        ['code' => 'BDT', 'countries' => ['People\'s Republic of Bangladesh'], 'name' => 'Bangladeshi taka', 'symbol' => '&#2547;'],
        ['code' => 'BYN', 'countries' => ['Belarus'], 'name' => 'Belarus Ruble', 'symbol' => '&#66;&#114;'],
        ['code' => 'BZD', 'countries' => ['Belize'], 'name' => 'Belize Dollar', 'symbol' => '&#66;&#90;&#36;'],
        ['code' => 'BMD', 'countries' => ['British Overseas Territory of Bermuda'], 'name' => 'Bermudian Dollar', 'symbol' => '&#66;&#68;&#36;'],
        ['code' => 'BOP', 'countries' => ['Bolivia'], 'name' => 'Boliviano', 'symbol' => '&#66;&#115;'],
        ['code' => 'BAM', 'countries' => ['Bosnia', 'Herzegovina'], 'name' => 'Bosnia-Herzegovina Convertible Marka', 'symbol' => '&#75;&#77;'],
        ['code' => 'BWP', 'countries' => ['Botswana'], 'name' => 'Botswana pula', 'symbol' => '&#80;'],
        ['code' => 'BGN', 'countries' => ['Bulgaria'], 'name' => 'Bulgarian lev', 'symbol' => '&#1083;&#1074;'],
        ['code' => 'BRL', 'countries' => ['Brazil'], 'name' => 'Brazilian real', 'symbol' => '&#82;&#36;'],
        ['code' => 'BND', 'countries' => ['Sultanate of Brunei'], 'name' => 'Brunei dollar', 'symbol' => '&#66;&#36;'],
        ['code' => 'KHR', 'countries' => ['Cambodia'], 'name' => 'Cambodian riel', 'symbol' => '&#6107;'],
        ['code' => 'CAD', 'countries' => ['Canada'], 'name' => 'Canadian dollar', 'symbol' => '&#67;&#36;'],
        ['code' => 'KYD', 'countries' => ['Cayman Islands'], 'name' => 'Cayman Islands dollar', 'symbol' => '&#36;'],
        ['code' => 'CLP', 'countries' => ['Chile'], 'name' => 'Chilean peso', 'symbol' => '&#36;'],
        ['code' => 'CNY', 'countries' => ['China'], 'name' => 'Chinese Yuan Renminbi', 'symbol' => '&#165;'],
        ['code' => 'COP', 'countries' => ['Colombia'], 'name' => 'Colombian peso', 'symbol' => '&#36;'],
        ['code' => 'CRC', 'countries' => ['Costa Rica'], 'name' => 'Costa Rican colón', 'symbol' => '&#8353;'],
        ['code' => 'HRK', 'countries' => ['Croatia'], 'name' => 'Croatian kuna', 'symbol' => '&#107;&#110;'],
        ['code' => 'CUP', 'countries' => ['Cuba'], 'name' => 'Cuban peso', 'symbol' => '&#8369;'],
        ['code' => 'CZK', 'countries' => ['Czech Republic'], 'name' => 'Czech koruna', 'symbol' => '&#75;&#269;'],
        ['code' => 'DKK', 'countries' => ['Denmark', 'Greenland', 'The Faroe Islands'], 'name' => 'Danish krone', 'symbol' => '&#107;&#114;'],
        ['code' => 'DOP', 'countries' => ['Dominican Republic'], 'name' => 'Dominican peso', 'symbol' => '&#82;&#68;&#36;'],
        ['code' => 'XCD', 'countries' => ['Antigua and Barbuda', 'Commonwealth of Dominica', 'Grenada', 'Montserrat', 'St. Kitts and Nevis', 'Saint Lucia and St. Vincent', 'The Grenadines'], 'name' => 'Eastern Caribbean dollar', 'symbol' => '&#36;'],
        ['code' => 'EGP', 'countries' => ['Egypt'], 'name' => 'Egyptian pound', 'symbol' => '&#163;'],
        ['code' => 'SVC', 'countries' => ['El Salvador'], 'name' => 'Salvadoran colón', 'symbol' => '&#36;'],
        ['code' => 'EEK', 'countries' => ['Estonia'], 'name' => 'Estonian kroon', 'symbol' => '&#75;&#114;'],
        ['code' => 'EUR', 'countries' => ['European Union', 'Italy', 'Belgium', 'Bulgaria', 'Croatia', 'Cyprus', 'Czechia', 'Denmark', 'Estonia', 'Finland', 'France', 'Germany', 'Greece', 'Hungary', 'Ireland', 'Latvia', 'Lithuania', 'Luxembourg', 'Malta', 'Netherlands', 'Poland', 'Portugal', 'Romania', 'Slovakia', 'Slovenia', 'Spain', 'Sweden'], 'name' => 'Euro', 'symbol' => '&#8364;'],
        ['code' => 'FKP', 'countries' => ['Falkland Islands'], 'name' => 'Falkland Islands (Malvinas) Pound', 'symbol' => '&#70;&#75;&#163;'],
        ['code' => 'FJD', 'countries' => ['Fiji'], 'name' => 'Fijian dollar', 'symbol' => '&#70;&#74;&#36;'],
        ['code' => 'GHC', 'countries' => ['Ghana'], 'name' => 'Ghanaian cedi', 'symbol' => '&#71;&#72;&#162;'],
        ['code' => 'GIP', 'countries' => ['Gibraltar'], 'name' => 'Gibraltar pound', 'symbol' => '&#163;'],
        ['code' => 'GTQ', 'countries' => ['Guatemala'], 'name' => 'Guatemalan quetzal', 'symbol' => '&#81;'],
        ['code' => 'GGP', 'countries' => ['Guernsey'], 'name' => 'Guernsey pound', 'symbol' => '&#81;'],
        ['code' => 'GYD', 'countries' => ['Guyana'], 'name' => 'Guyanese dollar', 'symbol' => '&#71;&#89;&#36;'],
        ['code' => 'HNL', 'countries' => ['Honduras'], 'name' => 'Honduran lempira', 'symbol' => '&#76;'],
        ['code' => 'HKD', 'countries' => ['Hong Kong'], 'name' => 'Hong Kong dollar', 'symbol' => '&#72;&#75;&#36;'],
        ['code' => 'HUF', 'countries' => ['Hungary'], 'name' => 'Hungarian forint', 'symbol' => '&#70;&#116;'],
        ['code' => 'ISK', 'countries' => ['Iceland'], 'name' => 'Icelandic króna', 'symbol' => '&#237;&#107;&#114;'],
        ['code' => 'INR', 'countries' => ['India'], 'name' => 'Indian rupee', 'symbol' => '&#8377;'],
        ['code' => 'IDR', 'countries' => ['Indonesia'], 'name' => 'Indonesian rupiah', 'symbol' => '&#82;&#112;'],
        ['code' => 'IRR', 'countries' => ['Iran'], 'name' => 'Iranian rial', 'symbol' => '&#65020;'],
        ['code' => 'IMP', 'countries' => ['Isle of Man'], 'name' => 'Manx pound', 'symbol' => '&#163;'],
        ['code' => 'ILS', 'countries' => ['Israel', 'Palestinian territories of the West Bank', 'The Gaza Strip'], 'name' => 'Israeli Shekel', 'symbol' => '&#8362;'],
        ['code' => 'JMD', 'countries' => ['Jamaica'], 'name' => 'Jamaican dollar', 'symbol' => '&#74;&#36;'],
        ['code' => 'JPY', 'countries' => ['Japan'], 'name' => 'Japanese yen', 'symbol' => '&#165;'],
        ['code' => 'JEP', 'countries' => ['Jersey'], 'name' => 'Jersey pound', 'symbol' => '&#163;'],
        ['code' => 'KES', 'countries' => ['Kenya'], 'name' => 'Kenyan shilling', 'symbol' => '&#75;&#83;&#104;'],
        ['code' => 'KZT', 'countries' => ['Kazakhstan'], 'name' => 'Kazakhstani tenge', 'symbol' => '&#8376;'],
        ['code' => 'KPW', 'countries' => ['North Korea'], 'name' => 'North Korean won', 'symbol' => '&#8361;'],
        ['code' => 'KPW', 'countries' => ['South Korea'], 'name' => 'South Korean won', 'symbol' => '&#8361;'],
        ['code' => 'KGS', 'countries' => ['Kyrgyz Republic'], 'name' => 'Kyrgyzstani som', 'symbol' => '&#1083;&#1074;'],
        ['code' => 'LAK', 'countries' => ['Laos'], 'name' => 'Lao kip', 'symbol' => '&#8365;'],
        ['code' => 'LAK', 'countries' => ['Laos'], 'name' => 'Latvian lats', 'symbol' => '&#8364;'],
        ['code' => 'LVL', 'countries' => ['Laos'], 'name' => 'Latvian lats', 'symbol' => '&#8364;'],
        ['code' => 'LBP', 'countries' => ['Lebanon'], 'name' => 'Lebanese pound', 'symbol' => '&#76;&#163;'],
        ['code' => 'LRD', 'countries' => ['Liberia'], 'name' => 'Liberian dollar', 'symbol' => '&#76;&#68;&#36;'],
        ['code' => 'LTL', 'countries' => ['Lithuania'], 'name' => 'Lithuanian litas', 'symbol' => '&#8364;'],
        ['code' => 'MKD', 'countries' => ['North Macedonia'], 'name' => 'Macedonian denar', 'symbol' => '&#1076;&#1077;&#1085;'],
        ['code' => 'MYR', 'countries' => ['Malaysia'], 'name' => 'Malaysian ringgit', 'symbol' => '&#82;&#77;'],
        ['code' => 'MUR', 'countries' => ['Mauritius'], 'name' => 'Mauritian rupee', 'symbol' => '&#82;&#115;'],
        ['code' => 'MXN', 'countries' => ['Mexico'], 'name' => 'Mexican peso', 'symbol' => '&#77;&#101;&#120;&#36;'],
        ['code' => 'MNT', 'countries' => ['Mongolia'], 'name' => 'Mongolian tögrög', 'symbol' => '&#8366;'],
        ['code' => 'MZN', 'countries' => ['Mozambique'], 'name' => 'Mozambican metical', 'symbol' => '&#77;&#84;'],
        ['code' => 'NAD', 'countries' => ['Namibia'], 'name' => 'Namibian dollar', 'symbol' => '&#78;&#36;'],
        ['code' => 'NPR', 'countries' => ['Federal Democratic Republic of Nepal'], 'name' => 'Nepalese rupee', 'symbol' => '&#82;&#115;&#46;'],
        ['code' => 'ANG', 'countries' => ['Curaçao', 'Sint Maarten'], 'name' => 'Netherlands Antillean guilder', 'symbol' => '&#402;'],
        ['code' => 'NZD', 'countries' => ['New Zealand', 'The Cook Islands', 'Niue', 'The Ross Dependency', 'Tokelau', 'The Pitcairn Islands'], 'name' => 'New Zealand Dollar', 'symbol' => '&#36;'],
        ['code' => 'NIO', 'countries' => ['Nicaragua'], 'name' => 'Nicaraguan córdoba', 'symbol' => '&#67;&#36;'],
        ['code' => 'NGN', 'countries' => ['Nigeria'], 'name' => 'Nigerian Naira', 'symbol' => '&#8358;'],
        ['code' => 'NOK', 'countries' => ['Norway and its dependent territories'], 'name' => 'Norwegian krone', 'symbol' => '&#107;&#114;'],
        ['code' => 'OMR', 'countries' => ['Oman'], 'name' => 'Omani rial', 'symbol' => '&#65020;'],
        ['code' => 'PKR', 'countries' => ['Pakistan'], 'name' => 'Pakistani rupee', 'symbol' => '&#82;&#115;'],
        ['code' => 'PAB', 'countries' => ['Panama'], 'name' => 'Panamanian balboa', 'symbol' => '&#66;&#47;&#46;'],
        ['code' => 'PYG', 'countries' => ['Paraguay'], 'name' => 'Paraguayan Guaraní', 'symbol' => '&#8370;'],
        ['code' => 'PEN', 'countries' => ['Peru'], 'name' => 'Sol', 'symbol' => '&#83;&#47;&#46;'],
        ['code' => 'PHP', 'countries' => ['Philippines'], 'name' => 'Philippine peso', 'symbol' => '&#8369;'],
        ['code' => 'PLN', 'countries' => ['Poland'], 'name' => 'Polish złoty', 'symbol' => '&#122;&#322;'],
        ['code' => 'QAR', 'countries' => ['State of Qatar'], 'name' => 'Qatari Riyal', 'symbol' => '&#65020;'],
        ['code' => 'RON', 'countries' => ['Romania'], 'name' => 'Romanian leu (Leu românesc)', 'symbol' => '&#76;'],
        ['code' => 'RUB', 'countries' => ['Russian Federation', 'Abkhazia and South Ossetia', 'Donetsk and Luhansk'], 'name' => 'Russian ruble', 'symbol' => '&#8381;'],
        ['code' => 'SHP', 'countries' => ['Saint Helena', 'Ascension', 'Tristan da Cunha'], 'name' => 'Saint Helena pound', 'symbol' => '&#163;'],
        ['code' => 'SAR', 'countries' => ['Saudi Arabia'], 'name' => 'Saudi riyal', 'symbol' => '&#65020;'],
        ['code' => 'RSD', 'countries' => ['Serbia'], 'name' => 'Serbian dinar', 'symbol' => '&#100;&#105;&#110;'],
        ['code' => 'SCR', 'countries' => ['Seychelles'], 'name' => 'Seychellois rupee', 'symbol' => '&#82;&#115;'],
        ['code' => 'SGD', 'countries' => ['Singapore'], 'name' => 'Singapore dollar', 'symbol' => '&#83;&#36;'],
        ['code' => 'SBD', 'countries' => ['Solomon Islands'], 'name' => 'Solomon Islands dollar', 'symbol' => '&#83;&#73;&#36;'],
        ['code' => 'SOS', 'countries' => ['Somalia'], 'name' => 'Somali shilling', 'symbol' => '&#83;&#104;&#46;&#83;&#111;'],
        ['code' => 'ZAR', 'countries' => ['South Africa'], 'name' => 'South African rand', 'symbol' => '&#82;'],
        ['code' => 'LKR', 'countries' => ['Sri Lanka'], 'name' => 'Sri Lankan rupee', 'symbol' => '&#82;&#115;'],
        ['code' => 'SEK', 'countries' => ['Sweden'], 'name' => 'Swedish krona', 'symbol' => '&#107;&#114;'],
        ['code' => 'CHF', 'countries' => ['Switzerland'], 'name' => 'Swiss franc', 'symbol' => '&#67;&#72;&#102;'],
        ['code' => 'SRD', 'countries' => ['Suriname'], 'name' => 'Suriname Dollar', 'symbol' => '&#83;&#114;&#36;'],
        ['code' => 'SYP', 'countries' => ['Syria'], 'name' => 'Syrian pound', 'symbol' => '&#163;&#83;'],
        ['code' => 'TWD', 'countries' => ['Taiwan'], 'name' => 'New Taiwan dollar', 'symbol' => '&#78;&#84;&#36;'],
        ['code' => 'THB', 'countries' => ['Thailand'], 'name' => 'Thai baht', 'symbol' => '&#3647;'],
        ['code' => 'TTD', 'countries' => ['Trinidad', 'Tobago'], 'name' => 'Trinidad and Tobago dollar', 'symbol' => '&#84;&#84;&#36;'],
        ['code' => 'TRY', 'countries' => ['Turkey', 'Turkish Republic of Northern Cyprus'], 'name' => 'Turkey Lira', 'symbol' => '&#8378;'],
        ['code' => 'TVD', 'countries' => ['Tuvalu'], 'name' => 'Tuvaluan dollar', 'symbol' => '&#84;&#86;&#36;'],
        ['code' => 'UAH', 'countries' => ['Ukraine'], 'name' => 'Ukrainian hryvnia', 'symbol' => '&#8372;'],
        ['code' => 'GBP', 'countries' => ['United Kingdom', 'Jersey', 'Guernsey', 'The Isle of Man', 'Gibraltar', 'South Georgia', 'The South Sandwich Islands', 'The British Antarctic', 'Territory', 'Tristan da Cunha'], 'name' => 'Pound sterling', 'symbol' => '&#163;'],
        ['code' => 'UGX', 'countries' => ['Uganda'], 'name' => 'Ugandan shilling', 'symbol' => '&#85;&#83;&#104;'],
        ['code' => 'USD', 'countries' => ['United States'], 'name' => 'United States dollar', 'symbol' => '&#36;'],
        ['code' => 'UYU', 'countries' => ['Uruguayan'], 'name' => 'Peso Uruguayolar', 'symbol' => '&#36;&#85;'],
        ['code' => 'UZS', 'countries' => ['Uzbekistan'], 'name' => 'Uzbekistani soʻm', 'symbol' => '&#1083;&#1074;'],
        ['code' => 'VEF', 'countries' => ['Venezuela'], 'name' => 'Venezuelan bolívar', 'symbol' => '&#66;&#115;'],
        ['code' => 'VND', 'countries' => ['Vietnam'], 'name' => 'Vietnamese dong (Đồng)', 'symbol' => '&#8363;'],
        ['code' => 'VND', 'countries' => ['Yemen'], 'name' => 'Yemeni rial', 'symbol' => '&#65020;'],
        ['code' => 'ZWD', 'countries' => ['Zimbabwe'], 'name' => 'Zimbabwean dollar', 'symbol' => '&#90;&#36;'],
    ];

    if (true === $decode_html_entity) {

        $currencies = array_map(static function ($each_cur) {

            $each_cur['symbol'] = html_entity_decode($each_cur['symbol']);

            return $each_cur;

        }, $currencies);
    }

    if (!is_null($code)) {
        return array_values(array_filter(
            $currencies, static fn($c) => strtolower($c['code']) === strtolower($code)))[0] ?? null;
    }

    return $currencies;
}

/**
 * Lists of Timezone values
 *
 * @return string[]
 */
function timezoneList(): array
{
    return [
        'Pacific/Midway' => '(UTC-11:00) Midway',
        'Pacific/Niue' => '(UTC-11:00) Niue',
        'Pacific/Pago_Pago' => '(UTC-11:00) Pago Pago',
        'America/Adak' => '(UTC-10:00) Adak',
        'Pacific/Honolulu' => '(UTC-10:00) Honolulu',
        'Pacific/Johnston' => '(UTC-10:00) Johnston',
        'Pacific/Rarotonga' => '(UTC-10:00) Rarotonga',
        'Pacific/Tahiti' => '(UTC-10:00) Tahiti',
        'Pacific/Marquesas' => '(UTC-09:30) Marquesas',
        'America/Anchorage' => '(UTC-09:00) Anchorage',
        'Pacific/Gambier' => '(UTC-09:00) Gambier',
        'America/Juneau' => '(UTC-09:00) Juneau',
        'America/Nome' => '(UTC-09:00) Nome',
        'America/Sitka' => '(UTC-09:00) Sitka',
        'America/Yakutat' => '(UTC-09:00) Yakutat',
        'America/Dawson' => '(UTC-08:00) Dawson',
        'America/Los_Angeles' => '(UTC-08:00) Los Angeles',
        'America/Metlakatla' => '(UTC-08:00) Metlakatla',
        'Pacific/Pitcairn' => '(UTC-08:00) Pitcairn',
        'America/Santa_Isabel' => '(UTC-08:00) Santa Isabel',
        'America/Tijuana' => '(UTC-08:00) Tijuana',
        'America/Vancouver' => '(UTC-08:00) Vancouver',
        'America/Whitehorse' => '(UTC-08:00) Whitehorse',
        'America/Boise' => '(UTC-07:00) Boise',
        'America/Cambridge_Bay' => '(UTC-07:00) Cambridge Bay',
        'America/Chihuahua' => '(UTC-07:00) Chihuahua',
        'America/Creston' => '(UTC-07:00) Creston',
        'America/Dawson_Creek' => '(UTC-07:00) Dawson Creek',
        'America/Denver' => '(UTC-07:00) Denver',
        'America/Edmonton' => '(UTC-07:00) Edmonton',
        'America/Hermosillo' => '(UTC-07:00) Hermosillo',
        'America/Inuvik' => '(UTC-07:00) Inuvik',
        'America/Mazatlan' => '(UTC-07:00) Mazatlan',
        'America/Ojinaga' => '(UTC-07:00) Ojinaga',
        'America/Phoenix' => '(UTC-07:00) Phoenix',
        'America/Shiprock' => '(UTC-07:00) Shiprock',
        'America/Yellowknife' => '(UTC-07:00) Yellowknife',
        'America/Bahia_Banderas' => '(UTC-06:00) Bahia Banderas',
        'America/Belize' => '(UTC-06:00) Belize',
        'America/North_Dakota/Beulah' => '(UTC-06:00) Beulah',
        'America/Cancun' => '(UTC-06:00) Cancun',
        'America/North_Dakota/Center' => '(UTC-06:00) Center',
        'America/Chicago' => '(UTC-06:00) Chicago',
        'America/Costa_Rica' => '(UTC-06:00) Costa Rica',
        'Pacific/Easter' => '(UTC-06:00) Easter',
        'America/El_Salvador' => '(UTC-06:00) El Salvador',
        'Pacific/Galapagos' => '(UTC-06:00) Galapagos',
        'America/Guatemala' => '(UTC-06:00) Guatemala',
        'America/Indiana/Knox' => '(UTC-06:00) Knox',
        'America/Managua' => '(UTC-06:00) Managua',
        'America/Matamoros' => '(UTC-06:00) Matamoros',
        'America/Menominee' => '(UTC-06:00) Menominee',
        'America/Merida' => '(UTC-06:00) Merida',
        'America/Mexico_City' => '(UTC-06:00) Mexico City',
        'America/Monterrey' => '(UTC-06:00) Monterrey',
        'America/North_Dakota/New_Salem' => '(UTC-06:00) New Salem',
        'America/Rainy_River' => '(UTC-06:00) Rainy River',
        'America/Rankin_Inlet' => '(UTC-06:00) Rankin Inlet',
        'America/Regina' => '(UTC-06:00) Regina',
        'America/Resolute' => '(UTC-06:00) Resolute',
        'America/Swift_Current' => '(UTC-06:00) Swift Current',
        'America/Tegucigalpa' => '(UTC-06:00) Tegucigalpa',
        'America/Indiana/Tell_City' => '(UTC-06:00) Tell City',
        'America/Winnipeg' => '(UTC-06:00) Winnipeg',
        'America/Atikokan' => '(UTC-05:00) Atikokan',
        'America/Bogota' => '(UTC-05:00) Bogota',
        'America/Cayman' => '(UTC-05:00) Cayman',
        'America/Detroit' => '(UTC-05:00) Detroit',
        'America/Grand_Turk' => '(UTC-05:00) Grand Turk',
        'America/Guayaquil' => '(UTC-05:00) Guayaquil',
        'America/Havana' => '(UTC-05:00) Havana',
        'America/Indiana/Indianapolis' => '(UTC-05:00) Indianapolis',
        'America/Iqaluit' => '(UTC-05:00) Iqaluit',
        'America/Jamaica' => '(UTC-05:00) Jamaica',
        'America/Lima' => '(UTC-05:00) Lima',
        'America/Kentucky/Louisville' => '(UTC-05:00) Louisville',
        'America/Indiana/Marengo' => '(UTC-05:00) Marengo',
        'America/Kentucky/Monticello' => '(UTC-05:00) Monticello',
        'America/Montreal' => '(UTC-05:00) Montreal',
        'America/Nassau' => '(UTC-05:00) Nassau',
        'America/New_York' => '(UTC-05:00) New York',
        'America/Nipigon' => '(UTC-05:00) Nipigon',
        'America/Panama' => '(UTC-05:00) Panama',
        'America/Pangnirtung' => '(UTC-05:00) Pangnirtung',
        'America/Indiana/Petersburg' => '(UTC-05:00) Petersburg',
        'America/Port-au-Prince' => '(UTC-05:00) Port-au-Prince',
        'America/Thunder_Bay' => '(UTC-05:00) Thunder Bay',
        'America/Toronto' => '(UTC-05:00) Toronto',
        'America/Indiana/Vevay' => '(UTC-05:00) Vevay',
        'America/Indiana/Vincennes' => '(UTC-05:00) Vincennes',
        'America/Indiana/Winamac' => '(UTC-05:00) Winamac',
        'America/Caracas' => '(UTC-04:30) Caracas',
        'America/Anguilla' => '(UTC-04:00) Anguilla',
        'America/Antigua' => '(UTC-04:00) Antigua',
        'America/Aruba' => '(UTC-04:00) Aruba',
        'America/Asuncion' => '(UTC-04:00) Asuncion',
        'America/Barbados' => '(UTC-04:00) Barbados',
        'Atlantic/Bermuda' => '(UTC-04:00) Bermuda',
        'America/Blanc-Sablon' => '(UTC-04:00) Blanc-Sablon',
        'America/Boa_Vista' => '(UTC-04:00) Boa Vista',
        'America/Campo_Grande' => '(UTC-04:00) Campo Grande',
        'America/Cuiaba' => '(UTC-04:00) Cuiaba',
        'America/Curacao' => '(UTC-04:00) Curacao',
        'America/Dominica' => '(UTC-04:00) Dominica',
        'America/Eirunepe' => '(UTC-04:00) Eirunepe',
        'America/Glace_Bay' => '(UTC-04:00) Glace Bay',
        'America/Goose_Bay' => '(UTC-04:00) Goose Bay',
        'America/Grenada' => '(UTC-04:00) Grenada',
        'America/Guadeloupe' => '(UTC-04:00) Guadeloupe',
        'America/Guyana' => '(UTC-04:00) Guyana',
        'America/Halifax' => '(UTC-04:00) Halifax',
        'America/Kralendijk' => '(UTC-04:00) Kralendijk',
        'America/La_Paz' => '(UTC-04:00) La Paz',
        'America/Lower_Princes' => '(UTC-04:00) Lower Princes',
        'America/Manaus' => '(UTC-04:00) Manaus',
        'America/Marigot' => '(UTC-04:00) Marigot',
        'America/Martinique' => '(UTC-04:00) Martinique',
        'America/Moncton' => '(UTC-04:00) Moncton',
        'America/Montserrat' => '(UTC-04:00) Montserrat',
        'Antarctica/Palmer' => '(UTC-04:00) Palmer',
        'America/Port_of_Spain' => '(UTC-04:00) Port of Spain',
        'America/Porto_Velho' => '(UTC-04:00) Porto Velho',
        'America/Puerto_Rico' => '(UTC-04:00) Puerto Rico',
        'America/Rio_Branco' => '(UTC-04:00) Rio Branco',
        'America/Santiago' => '(UTC-04:00) Santiago',
        'America/Santo_Domingo' => '(UTC-04:00) Santo Domingo',
        'America/St_Barthelemy' => '(UTC-04:00) St. Barthelemy',
        'America/St_Kitts' => '(UTC-04:00) St. Kitts',
        'America/St_Lucia' => '(UTC-04:00) St. Lucia',
        'America/St_Thomas' => '(UTC-04:00) St. Thomas',
        'America/St_Vincent' => '(UTC-04:00) St. Vincent',
        'America/Thule' => '(UTC-04:00) Thule',
        'America/Tortola' => '(UTC-04:00) Tortola',
        'America/St_Johns' => '(UTC-03:30) St. Johns',
        'America/Araguaina' => '(UTC-03:00) Araguaina',
        'America/Bahia' => '(UTC-03:00) Bahia',
        'America/Belem' => '(UTC-03:00) Belem',
        'America/Argentina/Buenos_Aires' => '(UTC-03:00) Buenos Aires',
        'America/Argentina/Catamarca' => '(UTC-03:00) Catamarca',
        'America/Cayenne' => '(UTC-03:00) Cayenne',
        'America/Argentina/Cordoba' => '(UTC-03:00) Cordoba',
        'America/Fortaleza' => '(UTC-03:00) Fortaleza',
        'America/Godthab' => '(UTC-03:00) Godthab',
        'America/Argentina/Jujuy' => '(UTC-03:00) Jujuy',
        'America/Argentina/La_Rioja' => '(UTC-03:00) La Rioja',
        'America/Maceio' => '(UTC-03:00) Maceio',
        'America/Argentina/Mendoza' => '(UTC-03:00) Mendoza',
        'America/Miquelon' => '(UTC-03:00) Miquelon',
        'America/Montevideo' => '(UTC-03:00) Montevideo',
        'America/Paramaribo' => '(UTC-03:00) Paramaribo',
        'America/Recife' => '(UTC-03:00) Recife',
        'America/Argentina/Rio_Gallegos' => '(UTC-03:00) Rio Gallegos',
        'Antarctica/Rothera' => '(UTC-03:00) Rothera',
        'America/Argentina/Salta' => '(UTC-03:00) Salta',
        'America/Argentina/San_Juan' => '(UTC-03:00) San Juan',
        'America/Argentina/San_Luis' => '(UTC-03:00) San Luis',
        'America/Santarem' => '(UTC-03:00) Santarem',
        'America/Sao_Paulo' => '(UTC-03:00) Sao Paulo',
        'Atlantic/Stanley' => '(UTC-03:00) Stanley',
        'America/Argentina/Tucuman' => '(UTC-03:00) Tucuman',
        'America/Argentina/Ushuaia' => '(UTC-03:00) Ushuaia',
        'America/Noronha' => '(UTC-02:00) Noronha',
        'Atlantic/South_Georgia' => '(UTC-02:00) South Georgia',
        'Atlantic/Azores' => '(UTC-01:00) Azores',
        'Atlantic/Cape_Verde' => '(UTC-01:00) Cape Verde',
        'America/Scoresbysund' => '(UTC-01:00) Scoresbysund',
        'Africa/Abidjan' => '(UTC+00:00) Abidjan',
        'Africa/Accra' => '(UTC+00:00) Accra',
        'Africa/Bamako' => '(UTC+00:00) Bamako',
        'Africa/Banjul' => '(UTC+00:00) Banjul',
        'Africa/Bissau' => '(UTC+00:00) Bissau',
        'Atlantic/Canary' => '(UTC+00:00) Canary',
        'Africa/Casablanca' => '(UTC+00:00) Casablanca',
        'Africa/Conakry' => '(UTC+00:00) Conakry',
        'Africa/Dakar' => '(UTC+00:00) Dakar',
        'America/Danmarkshavn' => '(UTC+00:00) Danmarkshavn',
        'Europe/Dublin' => '(UTC+00:00) Dublin',
        'Africa/El_Aaiun' => '(UTC+00:00) El Aaiun',
        'Atlantic/Faroe' => '(UTC+00:00) Faroe',
        'Africa/Freetown' => '(UTC+00:00) Freetown',
        'Europe/Guernsey' => '(UTC+00:00) Guernsey',
        'Europe/Isle_of_Man' => '(UTC+00:00) Isle of Man',
        'Europe/Jersey' => '(UTC+00:00) Jersey',
        'Europe/Lisbon' => '(UTC+00:00) Lisbon',
        'Africa/Lome' => '(UTC+00:00) Lome',
        'Europe/London' => '(UTC+00:00) London',
        'Atlantic/Madeira' => '(UTC+00:00) Madeira',
        'Africa/Monrovia' => '(UTC+00:00) Monrovia',
        'Africa/Nouakchott' => '(UTC+00:00) Nouakchott',
        'Africa/Ouagadougou' => '(UTC+00:00) Ouagadougou',
        'Atlantic/Reykjavik' => '(UTC+00:00) Reykjavik',
        'Africa/Sao_Tome' => '(UTC+00:00) Sao Tome',
        'Atlantic/St_Helena' => '(UTC+00:00) St. Helena',
        'UTC' => '(UTC+00:00) UTC',
        'Africa/Algiers' => '(UTC+01:00) Algiers',
        'Europe/Amsterdam' => '(UTC+01:00) Amsterdam',
        'Europe/Andorra' => '(UTC+01:00) Andorra',
        'Africa/Bangui' => '(UTC+01:00) Bangui',
        'Europe/Belgrade' => '(UTC+01:00) Belgrade',
        'Europe/Berlin' => '(UTC+01:00) Berlin',
        'Europe/Bratislava' => '(UTC+01:00) Bratislava',
        'Africa/Brazzaville' => '(UTC+01:00) Brazzaville',
        'Europe/Brussels' => '(UTC+01:00) Brussels',
        'Europe/Budapest' => '(UTC+01:00) Budapest',
        'Europe/Busingen' => '(UTC+01:00) Busingen',
        'Africa/Ceuta' => '(UTC+01:00) Ceuta',
        'Europe/Copenhagen' => '(UTC+01:00) Copenhagen',
        'Africa/Douala' => '(UTC+01:00) Douala',
        'Europe/Gibraltar' => '(UTC+01:00) Gibraltar',
        'Africa/Kinshasa' => '(UTC+01:00) Kinshasa',
        'Africa/Lagos' => '(UTC+01:00) Lagos',
        'Africa/Libreville' => '(UTC+01:00) Libreville',
        'Europe/Ljubljana' => '(UTC+01:00) Ljubljana',
        'Arctic/Longyearbyen' => '(UTC+01:00) Longyearbyen',
        'Africa/Luanda' => '(UTC+01:00) Luanda',
        'Europe/Luxembourg' => '(UTC+01:00) Luxembourg',
        'Europe/Madrid' => '(UTC+01:00) Madrid',
        'Africa/Malabo' => '(UTC+01:00) Malabo',
        'Europe/Malta' => '(UTC+01:00) Malta',
        'Europe/Monaco' => '(UTC+01:00) Monaco',
        'Africa/Ndjamena' => '(UTC+01:00) Ndjamena',
        'Africa/Niamey' => '(UTC+01:00) Niamey',
        'Europe/Oslo' => '(UTC+01:00) Oslo',
        'Europe/Paris' => '(UTC+01:00) Paris',
        'Europe/Podgorica' => '(UTC+01:00) Podgorica',
        'Africa/Porto-Novo' => '(UTC+01:00) Porto-Novo',
        'Europe/Prague' => '(UTC+01:00) Prague',
        'Europe/Rome' => '(UTC+01:00) Rome',
        'Europe/San_Marino' => '(UTC+01:00) San Marino',
        'Europe/Sarajevo' => '(UTC+01:00) Sarajevo',
        'Europe/Skopje' => '(UTC+01:00) Skopje',
        'Europe/Stockholm' => '(UTC+01:00) Stockholm',
        'Europe/Tirane' => '(UTC+01:00) Tirane',
        'Africa/Tripoli' => '(UTC+01:00) Tripoli',
        'Africa/Tunis' => '(UTC+01:00) Tunis',
        'Europe/Vaduz' => '(UTC+01:00) Vaduz',
        'Europe/Vatican' => '(UTC+01:00) Vatican',
        'Europe/Vienna' => '(UTC+01:00) Vienna',
        'Europe/Warsaw' => '(UTC+01:00) Warsaw',
        'Africa/Windhoek' => '(UTC+01:00) Windhoek',
        'Europe/Zagreb' => '(UTC+01:00) Zagreb',
        'Europe/Zurich' => '(UTC+01:00) Zurich',
        'Europe/Athens' => '(UTC+02:00) Athens',
        'Asia/Beirut' => '(UTC+02:00) Beirut',
        'Africa/Blantyre' => '(UTC+02:00) Blantyre',
        'Europe/Bucharest' => '(UTC+02:00) Bucharest',
        'Africa/Bujumbura' => '(UTC+02:00) Bujumbura',
        'Africa/Cairo' => '(UTC+02:00) Cairo',
        'Europe/Chisinau' => '(UTC+02:00) Chisinau',
        'Asia/Damascus' => '(UTC+02:00) Damascus',
        'Africa/Gaborone' => '(UTC+02:00) Gaborone',
        'Asia/Gaza' => '(UTC+02:00) Gaza',
        'Africa/Harare' => '(UTC+02:00) Harare',
        'Asia/Hebron' => '(UTC+02:00) Hebron',
        'Europe/Helsinki' => '(UTC+02:00) Helsinki',
        'Europe/Istanbul' => '(UTC+02:00) Istanbul',
        'Asia/Jerusalem' => '(UTC+02:00) Jerusalem',
        'Africa/Johannesburg' => '(UTC+02:00) Johannesburg',
        'Europe/Kiev' => '(UTC+02:00) Kiev',
        'Africa/Kigali' => '(UTC+02:00) Kigali',
        'Africa/Lubumbashi' => '(UTC+02:00) Lubumbashi',
        'Africa/Lusaka' => '(UTC+02:00) Lusaka',
        'Africa/Maputo' => '(UTC+02:00) Maputo',
        'Europe/Mariehamn' => '(UTC+02:00) Mariehamn',
        'Africa/Maseru' => '(UTC+02:00) Maseru',
        'Africa/Mbabane' => '(UTC+02:00) Mbabane',
        'Asia/Nicosia' => '(UTC+02:00) Nicosia',
        'Europe/Riga' => '(UTC+02:00) Riga',
        'Europe/Simferopol' => '(UTC+02:00) Simferopol',
        'Europe/Sofia' => '(UTC+02:00) Sofia',
        'Europe/Tallinn' => '(UTC+02:00) Tallinn',
        'Europe/Uzhgorod' => '(UTC+02:00) Uzhgorod',
        'Europe/Vilnius' => '(UTC+02:00) Vilnius',
        'Europe/Zaporozhye' => '(UTC+02:00) Zaporozhye',
        'Africa/Addis_Ababa' => '(UTC+03:00) Addis Ababa',
        'Asia/Aden' => '(UTC+03:00) Aden',
        'Asia/Amman' => '(UTC+03:00) Amman',
        'Indian/Antananarivo' => '(UTC+03:00) Antananarivo',
        'Africa/Asmara' => '(UTC+03:00) Asmara',
        'Asia/Baghdad' => '(UTC+03:00) Baghdad',
        'Asia/Bahrain' => '(UTC+03:00) Bahrain',
        'Indian/Comoro' => '(UTC+03:00) Comoro',
        'Africa/Dar_es_Salaam' => '(UTC+03:00) Dar es Salaam',
        'Africa/Djibouti' => '(UTC+03:00) Djibouti',
        'Africa/Juba' => '(UTC+03:00) Juba',
        'Europe/Kaliningrad' => '(UTC+03:00) Kaliningrad',
        'Africa/Kampala' => '(UTC+03:00) Kampala',
        'Africa/Khartoum' => '(UTC+03:00) Khartoum',
        'Asia/Kuwait' => '(UTC+03:00) Kuwait',
        'Indian/Mayotte' => '(UTC+03:00) Mayotte',
        'Europe/Minsk' => '(UTC+03:00) Minsk',
        'Africa/Mogadishu' => '(UTC+03:00) Mogadishu',
        'Europe/Moscow' => '(UTC+03:00) Moscow',
        'Africa/Nairobi' => '(UTC+03:00) Nairobi',
        'Asia/Qatar' => '(UTC+03:00) Qatar',
        'Asia/Riyadh' => '(UTC+03:00) Riyadh',
        'Antarctica/Syowa' => '(UTC+03:00) Syowa',
        'Asia/Tehran' => '(UTC+03:30) Tehran',
        'Asia/Baku' => '(UTC+04:00) Baku',
        'Asia/Dubai' => '(UTC+04:00) Dubai',
        'Indian/Mahe' => '(UTC+04:00) Mahe',
        'Indian/Mauritius' => '(UTC+04:00) Mauritius',
        'Asia/Muscat' => '(UTC+04:00) Muscat',
        'Indian/Reunion' => '(UTC+04:00) Reunion',
        'Europe/Samara' => '(UTC+04:00) Samara',
        'Asia/Tbilisi' => '(UTC+04:00) Tbilisi',
        'Europe/Volgograd' => '(UTC+04:00) Volgograd',
        'Asia/Yerevan' => '(UTC+04:00) Yerevan',
        'Asia/Kabul' => '(UTC+04:30) Kabul',
        'Asia/Aqtau' => '(UTC+05:00) Aqtau',
        'Asia/Aqtobe' => '(UTC+05:00) Aqtobe',
        'Asia/Ashgabat' => '(UTC+05:00) Ashgabat',
        'Asia/Dushanbe' => '(UTC+05:00) Dushanbe',
        'Asia/Karachi' => '(UTC+05:00) Karachi',
        'Indian/Kerguelen' => '(UTC+05:00) Kerguelen',
        'Indian/Maldives' => '(UTC+05:00) Maldives',
        'Antarctica/Mawson' => '(UTC+05:00) Mawson',
        'Asia/Oral' => '(UTC+05:00) Oral',
        'Asia/Samarkand' => '(UTC+05:00) Samarkand',
        'Asia/Tashkent' => '(UTC+05:00) Tashkent',
        'Asia/Colombo' => '(UTC+05:30) Colombo',
        'Asia/Kolkata' => '(UTC+05:30) Kolkata',
        'Asia/Kathmandu' => '(UTC+05:45) Kathmandu',
        'Asia/Almaty' => '(UTC+06:00) Almaty',
        'Asia/Bishkek' => '(UTC+06:00) Bishkek',
        'Indian/Chagos' => '(UTC+06:00) Chagos',
        'Asia/Dhaka' => '(UTC+06:00) Dhaka',
        'Asia/Qyzylorda' => '(UTC+06:00) Qyzylorda',
        'Asia/Thimphu' => '(UTC+06:00) Thimphu',
        'Antarctica/Vostok' => '(UTC+06:00) Vostok',
        'Asia/Yekaterinburg' => '(UTC+06:00) Yekaterinburg',
        'Indian/Cocos' => '(UTC+06:30) Cocos',
        'Asia/Rangoon' => '(UTC+06:30) Rangoon',
        'Asia/Bangkok' => '(UTC+07:00) Bangkok',
        'Indian/Christmas' => '(UTC+07:00) Christmas',
        'Antarctica/Davis' => '(UTC+07:00) Davis',
        'Asia/Ho_Chi_Minh' => '(UTC+07:00) Ho Chi Minh',
        'Asia/Hovd' => '(UTC+07:00) Hovd',
        'Asia/Jakarta' => '(UTC+07:00) Jakarta',
        'Asia/Novokuznetsk' => '(UTC+07:00) Novokuznetsk',
        'Asia/Novosibirsk' => '(UTC+07:00) Novosibirsk',
        'Asia/Omsk' => '(UTC+07:00) Omsk',
        'Asia/Phnom_Penh' => '(UTC+07:00) Phnom Penh',
        'Asia/Pontianak' => '(UTC+07:00) Pontianak',
        'Asia/Vientiane' => '(UTC+07:00) Vientiane',
        'Asia/Brunei' => '(UTC+08:00) Brunei',
        'Antarctica/Casey' => '(UTC+08:00) Casey',
        'Asia/Choibalsan' => '(UTC+08:00) Choibalsan',
        'Asia/Chongqing' => '(UTC+08:00) Chongqing',
        'Asia/Harbin' => '(UTC+08:00) Harbin',
        'Asia/Hong_Kong' => '(UTC+08:00) Hong Kong',
        'Asia/Kashgar' => '(UTC+08:00) Kashgar',
        'Asia/Krasnoyarsk' => '(UTC+08:00) Krasnoyarsk',
        'Asia/Kuala_Lumpur' => '(UTC+08:00) Kuala Lumpur',
        'Asia/Kuching' => '(UTC+08:00) Kuching',
        'Asia/Macau' => '(UTC+08:00) Macau',
        'Asia/Makassar' => '(UTC+08:00) Makassar',
        'Asia/Manila' => '(UTC+08:00) Manila',
        'Australia/Perth' => '(UTC+08:00) Perth',
        'Asia/Shanghai' => '(UTC+08:00) Shanghai',
        'Asia/Singapore' => '(UTC+08:00) Singapore',
        'Asia/Taipei' => '(UTC+08:00) Taipei',
        'Asia/Ulaanbaatar' => '(UTC+08:00) Ulaanbaatar',
        'Asia/Urumqi' => '(UTC+08:00) Urumqi',
        'Australia/Eucla' => '(UTC+08:45) Eucla',
        'Asia/Dili' => '(UTC+09:00) Dili',
        'Asia/Irkutsk' => '(UTC+09:00) Irkutsk',
        'Asia/Jayapura' => '(UTC+09:00) Jayapura',
        'Pacific/Palau' => '(UTC+09:00) Palau',
        'Asia/Pyongyang' => '(UTC+09:00) Pyongyang',
        'Asia/Seoul' => '(UTC+09:00) Seoul',
        'Asia/Tokyo' => '(UTC+09:00) Tokyo',
        'Australia/Adelaide' => '(UTC+09:30) Adelaide',
        'Australia/Broken_Hill' => '(UTC+09:30) Broken Hill',
        'Australia/Darwin' => '(UTC+09:30) Darwin',
        'Australia/Brisbane' => '(UTC+10:00) Brisbane',
        'Pacific/Chuuk' => '(UTC+10:00) Chuuk',
        'Australia/Currie' => '(UTC+10:00) Currie',
        'Antarctica/DumontDUrville' => '(UTC+10:00) DumontDUrville',
        'Pacific/Guam' => '(UTC+10:00) Guam',
        'Australia/Hobart' => '(UTC+10:00) Hobart',
        'Asia/Khandyga' => '(UTC+10:00) Khandyga',
        'Australia/Lindeman' => '(UTC+10:00) Lindeman',
        'Australia/Melbourne' => '(UTC+10:00) Melbourne',
        'Pacific/Port_Moresby' => '(UTC+10:00) Port Moresby',
        'Pacific/Saipan' => '(UTC+10:00) Saipan',
        'Australia/Sydney' => '(UTC+10:00) Sydney',
        'Asia/Yakutsk' => '(UTC+10:00) Yakutsk',
        'Australia/Lord_Howe' => '(UTC+10:30) Lord Howe',
        'Pacific/Efate' => '(UTC+11:00) Efate',
        'Pacific/Guadalcanal' => '(UTC+11:00) Guadalcanal',
        'Pacific/Kosrae' => '(UTC+11:00) Kosrae',
        'Antarctica/Macquarie' => '(UTC+11:00) Macquarie',
        'Pacific/Noumea' => '(UTC+11:00) Noumea',
        'Pacific/Pohnpei' => '(UTC+11:00) Pohnpei',
        'Asia/Sakhalin' => '(UTC+11:00) Sakhalin',
        'Asia/Ust-Nera' => '(UTC+11:00) Ust-Nera',
        'Asia/Vladivostok' => '(UTC+11:00) Vladivostok',
        'Pacific/Norfolk' => '(UTC+11:30) Norfolk',
        'Asia/Anadyr' => '(UTC+12:00) Anadyr',
        'Pacific/Auckland' => '(UTC+12:00) Auckland',
        'Pacific/Fiji' => '(UTC+12:00) Fiji',
        'Pacific/Funafuti' => '(UTC+12:00) Funafuti',
        'Asia/Kamchatka' => '(UTC+12:00) Kamchatka',
        'Pacific/Kwajalein' => '(UTC+12:00) Kwajalein',
        'Asia/Magadan' => '(UTC+12:00) Magadan',
        'Pacific/Majuro' => '(UTC+12:00) Majuro',
        'Antarctica/McMurdo' => '(UTC+12:00) McMurdo',
        'Pacific/Nauru' => '(UTC+12:00) Nauru',
        'Antarctica/South_Pole' => '(UTC+12:00) South Pole',
        'Pacific/Tarawa' => '(UTC+12:00) Tarawa',
        'Pacific/Wake' => '(UTC+12:00) Wake',
        'Pacific/Wallis' => '(UTC+12:00) Wallis',
        'Pacific/Chatham' => '(UTC+12:45) Chatham',
        'Pacific/Apia' => '(UTC+13:00) Apia',
        'Pacific/Enderbury' => '(UTC+13:00) Enderbury',
        'Pacific/Fakaofo' => '(UTC+13:00) Fakaofo',
        'Pacific/Tongatapu' => '(UTC+13:00) Tongatapu',
        'Pacific/Kiritimati' => '(UTC+14:00) Kiritimati',
    ];
}

/**
 * List of all countries
 *
 * @return string[]
 */
function countryList(): array
{
    return [
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "BQ" => "British Antarctic Territory",
        "IO" => "British Indian Ocean Territory",
        "VG" => "British Virgin Islands",
        "BN" => "Brunei",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CT" => "Canton and Enderbury Islands",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos [Keeling] Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo - Brazzaville",
        "CD" => "Congo - Kinshasa",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "CI" => "Côte d’Ivoire",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "NQ" => "Dronning Maud Land",
        "DD" => "East Germany",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "FQ" => "French Southern and Antarctic Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "HN" => "Honduras",
        "HK" => "Hong Kong SAR China",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JT" => "Johnston Island",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Laos",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau SAR China",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "FX" => "Metropolitan France",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MI" => "Midway Islands",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar [Burma]",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NT" => "Neutral Zone",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "KP" => "North Korea",
        "VD" => "North Vietnam",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PC" => "Pacific Islands Trust Territory",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territories",
        "PA" => "Panama",
        "PZ" => "Panama Canal Zone",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "YD" => "People's Democratic Republic of Yemen",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn Islands",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "RW" => "Rwanda",
        "RE" => "Réunion",
        "BL" => "Saint Barthélemy",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "KR" => "South Korea",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syria",
        "ST" => "São Tomé and Príncipe",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UM" => "U.S. Minor Outlying Islands",
        "PU" => "U.S. Miscellaneous Pacific Islands",
        "VI" => "U.S. Virgin Islands",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "SU" => "Union of Soviet Socialist Republics",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "ZZ" => "Unknown or Invalid Region",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VA" => "Vatican City",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "WK" => "Wake Island",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
        "AX" => "Åland Islands",
    ];
}

/**
 * Get Total for Each Cart Item
 *
 * @param $row_id
 * @return float|int
 */
function getProductTotal($row_id): float|int
{
    $product = Cart::get($row_id);

    $total = $product->price * $product->qty;

    if (property_exists($product->options, 'variant_price_total')) {
        $total += $product->options->variant_price_total;
    }

    return $total;
}


/**
 * Get Cart Subtotal
 *
 * @return float|int
 */
function cartSubtotal(): float|int
{
    $subtotal = 0;

    foreach (Cart::content() as $item) {
        $subtotal += getProductTotal($item->rowId);
    }

    return $subtotal;
}

/**
 * Cart Overall Total Price
 *
 * @return mixed
 */
function cartTotal(): mixed
{
    $total = cartSubtotal();

    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');

        if ($coupon['discount_type'] === 'percent') {
            $discount = $coupon['discount'] * $total / 100;

            return $total - $discount;
        }

        if ($coupon['discount_type'] === 'amount') {
            $discount = $coupon['discount'];

            return $total - $discount;
        }
    }

    return $total;
}

/**
 * Retrieves package in the cart
 *
 * @return array
 */
function cartPackage(): array
{
    $cart_package = [];

    if ( isset(session('cart')['default']) && session()->has('cart') ) {
        foreach (session('cart')['default'] as $val ) {
            if ($val->options->is_package === '1') {
                $cart_package[] = $val;
            }
        }
    }

    return $cart_package;
}

/**
 * Coupon Discount
 *
 * @return mixed
 */
function couponDiscount(): mixed
{
    $subtotal = cartSubtotal();

    $discount = 0;

    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');

        if ($coupon['discount_type'] === 'percent') {
            $discount = $coupon['discount'] * $subtotal / 100;
        } elseif ($coupon['discount_type'] === 'amount') {
            $discount = $coupon['discount'];
        }
    }

    return $discount;
}

/**
 * Shipping Fee from The Shipping Rule Session
 *
 * @return mixed
 */
function shippingFee(): mixed
{
    $shipping_fee = 0;

    if (Session::has('shipping_rule')) {
        $shipping_fee = Session::get('shipping_rule')['cost'];
    }

    return $shipping_fee;
}

/**
 * Payable Total Price
 *
 * @return mixed
 */
function payableTotal(): mixed
{
    return cartTotal() + shippingFee();
}

/**
 * Limit Text Length
 *
 * @param $text
 * @param int $limit
 * @return string
 */
#[Pure] function limitText($text, $limit = 20): string
{
    return Str::limit($text, $limit);
}

function getCurrencyIcon(): string
{
    return GeneralSetting::first()->currency_icon;
}
