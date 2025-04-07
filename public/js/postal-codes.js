// Postal code mappings for Philippine addresses
const postalCodeMap = {
    // Region XIII (CARAGA)
    'REGION XIII': {
        'AGUSAN DEL NORTE': {
            'MAGALLANES': '8604',
            'BUTUAN CITY': '8600',
            'CABADBARAN': '8605',
            'BUENAVISTA': '8601',
            'CARMEN': '8603',
            'JABONGA': '8607',
            'KITCHARAO': '8609',
            'LAS NIEVES': '8610',
            'REMEDIOS T. ROMUALDEZ': '8611',
            'SANTIAGO': '8608',
            'TUBAY': '8612'
        },
        'AGUSAN DEL SUR': {
            'BAYUGAN': '8502',
            'SAN FRANCISCO': '8501',
            'BUNAWAN': '8506',
            'ESPERANZA': '8513',
            'LA PAZ': '8508',
            'LORETO': '8507',
            'PROSPERIDAD': '8500',
            'ROSARIO': '8504',
            'SAN LUIS': '8511',
            'SANTA JOSEFA': '8512',
            'SIBAGAT': '8503',
            'TALACOGON': '8510',
            'TRENTO': '8505',
            'VERUELA': '8509'
        },
        'SURIGAO DEL NORTE': {
            'SURIGAO CITY': '8400',
            'ALEGRIA': '8425',
            'BACUAG': '8408',
            'BURGOS': '8424',
            'CLAVER': '8410',
            'DAPA': '8417',
            'DEL CARMEN': '8418',
            'GENERAL LUNA': '8419',
            'GIGAQUIT': '8409',
            'MAINIT': '8407',
            'MALIMONO': '8402',
            'PILAR': '8420',
            'PLACER': '8405',
            'SAN BENITO': '8423',
            'SAN FRANCISCO': '8401',
            'SAN ISIDRO': '8421',
            'SANTA MONICA': '8422',
            'SISON': '8404',
            'SOCORRO': '8416',
            'TAGANA-AN': '8403',
            'TUBOD': '8406'
        },
        'SURIGAO DEL SUR': {
            'TANDAG': '8300',
            'BISLIG': '8311',
            'BAROBO': '8309',
            'BAYABAS': '8303',
            'CAGWAIT': '8304',
            'CANTILAN': '8317',
            'CARMEN': '8315',
            'CARRASCAL': '8318',
            'CORTES': '8313',
            'HINATUAN': '8310',
            'LANUZA': '8314',
            'LIANGA': '8307',
            'LINGIG': '8312',
            'MADRID': '8316',
            'MARIHATAG': '8306',
            'SAN AGUSTIN': '8305',
            'SAN MIGUEL': '8301',
            'TAGBINA': '8308',
            'TAGO': '8302'
        }
    },
    // Region XI (Davao Region)
    'REGION XI': {
        'DAVAO DEL NORTE': {
            'TAGUM': '8100',
            'PANABO': '8105',
            'ASUNCION': '8102',
            'BRAULIO E. DUJALI': '8104',
            'CARMEN': '8101',
            'KAPALONG': '8113',
            'NEW CORELLA': '8104',
            'SAN ISIDRO': '8110',
            'SANTO TOMAS': '8112',
            'TALAINGOD': '8114'
        },
        'DAVAO DEL SUR': {
            'DAVAO CITY': '8000',
            'DIGOS': '8002',
            'BANSALAN': '8005',
            'DON MARCELINO': '8013',
            'HAGONOY': '8006',
            'JOSE ABAD SANTOS': '8014',
            'KIBLAWAN': '8008',
            'MAGSAYSAY': '8004',
            'MALALAG': '8010',
            'MALITA': '8012',
            'MATANAO': '8003',
            'PADADA': '8007',
            'SANTA CRUZ': '8001',
            'SANTA MARIA': '8011',
            'SARANGANI': '8015',
            'SULOP': '8009'
        },
        'DAVAO ORIENTAL': {
            'MATI': '8200',
            'BAGANGA': '8204',
            'BANAYBANAY': '8208',
            'BOSTON': '8206',
            'CARAGA': '8203',
            'CATEEL': '8205',
            'GOVERNOR GENEROSO': '8210',
            'LUPON': '8207',
            'MANAY': '8202',
            'SAN ISIDRO': '8209',
            'TARRAGONA': '8201'
        },
        'DAVAO DE ORO': {
            'COMPOSTELA': '8803',
            'LAAK': '8810',
            'MABINI': '8807',
            'MACO': '8806',
            'MARAGUSAN': '8808',
            'MAWAB': '8802',
            'MONKAYO': '8805',
            'MONTEVISTA': '8801',
            'NABUNTURAN': '8800',
            'NEW BATAAN': '8804',
            'PANTUKAN': '8809'
        },
        'DAVAO OCCIDENTAL': {
            'MALITA': '8012',
            'DON MARCELINO': '8013',
            'JOSE ABAD SANTOS': '8014',
            'SANTA MARIA': '8011',
            'SARANGANI': '8015'
        }
    },
    // Region X (Northern Mindanao)
    'REGION X': {
        'BUKIDNON': {
            'MALAYBALAY': '8700',
            'BAUNGON': '8707',
            'CABANGLASAN': '8713',
            'DAMULOG': '8721',
            'DANGCAGAN': '8715',
            'DON CARLOS': '8712',
            'IMPASUG-ONG': '8702',
            'KADINGILAN': '8717',
            'KALILANGAN': '8718',
            'KIBAWE': '8720',
            'KITAOTAO': '8722',
            'LANTAPAN': '8722',
            'LIBONA': '8706',
            'MALITBOG': '8704',
            'MANOLO FORTICH': '8703',
            'MARAMAG': '8714',
            'PANGANTUCAN': '8717',
            'QUEZON': '8715',
            'SAN FERNANDO': '8711',
            'SUMILAO': '8701',
            'TALAKAG': '8708',
            'VALENCIA': '8709'
        },
        'CAMIGUIN': {
            'MAMBAJAO': '9100',
            'CATARMAN': '9104',
            'GUINSILIBAN': '9102',
            'MAHINOG': '9101',
            'SAGAY': '9103'
        },
        'LANAO DEL NORTE': {
            'TUBOD': '9209',
            'BACOLOD': '9205',
            'BALOI': '9217',
            'BAROY': '9210',
            'KAPATAGAN': '9214',
            'KAROMATAN': '9215',
            'KAUSWAGAN': '9202',
            'KOLAMBUGAN': '9207',
            'LALA': '9211',
            'LINAMON': '9201',
            'MAGSAYSAY': '9221',
            'MAIGO': '9206',
            'MATUNGAO': '9203',
            'MUNAI': '9219',
            'NUNUNGAN': '9216',
            'PANTAO RAGAT': '9208',
            'POONA PIAGAPO': '9204',
            'SALVADOR': '9212',
            'SAPAD': '9213',
            'SULTAN NAGA DIMAPORO': '9218',
            'TAGOLOAN': '9222',
            'TANGCAL': '9220'
        },
        'MISAMIS OCCIDENTAL': {
            'OZAMIZ': '7200',
            'ALORAN': '7208',
            'BALIANGAO': '7211',
            'BONIFACIO': '7215',
            'CALAMBA': '7210',
            'CLARIN': '7201',
            'CONCEPCION': '7213',
            'DON VICTORIANO': '7202',
            'JIMENEZ': '7204',
            'LOPEZ JAENA': '7208',
            'OROQUIETA': '7207',
            'PANAON': '7205',
            'PLARIDEL': '7209',
            'SAPANG DALAGA': '7212',
            'SINACABAN': '7203',
            'TANGUB': '7214',
            'TUDELA': '7202'
        },
        'MISAMIS ORIENTAL': {
            'CAGAYAN DE ORO': '9000',
            'ALUBIJID': '9018',
            'BALINGASAG': '9005',
            'BALINGOAN': '9011',
            'BINUANGAN': '9008',
            'CLAVERIA': '9004',
            'EL SALVADOR': '9017',
            'GINGOOG': '9014',
            'GITAGUM': '9020',
            'INITAO': '9022',
            'JASAAN': '9003',
            'KINOGUITAN': '9010',
            'LAGONGLONG': '9006',
            'LAGUINDINGAN': '9019',
            'LIBERTAD': '9021',
            'LUGAIT': '9025',
            'MAGSAYSAY': '9015',
            'MANTICAO': '9024',
            'MEDINA': '9013',
            'NAAWAN': '9023',
            'OPOL': '9016',
            'SALAY': '9007',
            'SUGBONGCOGON': '9012',
            'TAGOLOAN': '9001',
            'TALISAYAN': '9002',
            'VILLANUEVA': '9002'
        }
    }
    // Add more regions as needed
};

// Function to get postal code based on complete address
function getPostalCode(region, province, city) {
    try {
        return postalCodeMap[region.toUpperCase()]?.[province.toUpperCase()]?.[city.toUpperCase()] || '';
    } catch (error) {
        console.error('Error getting postal code:', error);
        return '';
    }
}

// Function to auto-fill postal code
function autoFillPostalCode(regionElement, provinceElement, cityElement, postalCodeElement) {
    const region = regionElement.value;
    const province = provinceElement.value;
    const city = cityElement.value;
    
    if (region && province && city) {
        const postalCode = getPostalCode(region, province, city);
        if (postalCode) {
            postalCodeElement.value = postalCode;
        }
    }
} 