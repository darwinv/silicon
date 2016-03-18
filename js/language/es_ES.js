(function($) {
    /**
     * Spanish language package
     * Translated by @vadail
     */
    FormValidation.I18n = $.extend(true, FormValidation.I18n, {
        'es_ES': {
            base64: {
                'default': 'Por favor introduce un valor v\u00E1lido en base 64'
            },
            between: {
                'default': 'Por favor introduce un valor entre %s y %s',
                notInclusive: 'Por favor introduce un valor s\u00F3lo entre %s and %s'
            },
            bic: {
                'default': 'Por favor introduce un n\u00FAmero BIC v\u00E1lido'
            },
            blank: {
                'default': 'Por favor introduce un valor'
            },
            callback: {
                'default': 'Por favor introduce un valor v\u00E1lido'
            },
            choice: {
                'default': 'Por favor introduce un valor v\u00E1lido',
                less: 'Por favor elija %s opciones como m\u00EDnimo',
                more: 'Por favor elija %s optiones como m\u00E1ximo',
                between: 'Por favor elija de %s a %s opciones'
            },
            color: {
                'default': 'Por favor introduce un color v\u00E1lido'
            },
            creditCard: {
                'default': 'Por favor introduce un n\u00FAmero v\u00E1lido de tarjeta de cr\u00E9dito'
            },
            cusip: {
                'default': 'Por favor introduce un n\u00FAmero CUSIP v\u00E1lido'
            },
            cvv: {
                'default': 'Por favor introduce un n\u00FAmero CVV v\u00E1lido'
            },
            date: {
                'default': 'Por favor introduce una fecha v\u00E1lida',
                min: 'Por favor introduce una fecha posterior al %s',
                max: 'Por favor introduce una fecha previa al %s',
                range: 'Por favor introduce una fecha entre el %s y el %s'
            },
            different: {
                'default': 'Por favor introduce un valor distinto'
            },
            digits: {
                'default': 'Por favor introduce s\u00F3lo d\u00EDgitos'
            },
            ean: {
                'default': 'Por favor introduce un n\u00FAmero EAN v\u00E1lido'
            },
            ein: {
                'default': 'Por favor introduce un n\u00FAmero EIN v\u00E1lido'
            },
            emailAddress: {
                'default': 'Por favor introduce un email v\u00E1lido'
            },
            file: {
                'default': 'Por favor elija un archivo v\u00E1lido'
            },
            greaterThan: {
                'default': 'Por favor introduce un valor mayor o igual a %s',
                notInclusive: 'Por favor introduce un valor mayor que %s'
            },
            grid: {
                'default': 'Por favor introduce un n\u00FAmero GRId v\u00E1lido'
            },
            hex: {
                'default': 'Por favor introduce un valor hexadecimal v\u00E1lido'
            },
            iban: {
                'default': 'Por favor introduce un n\u00FAmero IBAN v\u00E1lido',
                country: 'Por favor introduce un n\u00FAmero IBAN v\u00E1lido en %s',
                countries: {
                    AD: 'Andorra',
                    AE: 'Emiratos \u00E1rabes Unidos',
                    AL: 'Albania',
                    AO: 'Angola',
                    AT: 'Austria',
                    AZ: 'Azerbaiy\u00E1n',
                    BA: 'Bosnia-Herzegovina',
                    BE: 'B\u00E9lgica',
                    BF: 'Burkina Faso',
                    BG: 'Bulgaria',
                    BH: 'Bar\u00E9in',
                    BI: 'Burundi',
                    BJ: 'Ben\u00EDn',
                    BR: 'Brasil',
                    CH: 'Suiza',
                    CI: 'Costa de Marfil',
                    CM: 'Camer\u00FAn',
                    CR: 'Costa Rica',
                    CV: 'Cabo Verde',
                    CY: 'Cyprus',
                    CZ: 'Rep\u00FAblica Checa',
                    DE: 'Alemania',
                    DK: 'Dinamarca',
                    DO: 'Rep\u00FAblica Dominicana',
                    DZ: 'Argelia',
                    EE: 'Estonia',
                    ES: 'Espa&ntilde;a',
                    FI: 'Finlandia',
                    FO: 'Islas Feroe',
                    FR: 'Francia',
                    GB: 'Reino Unido',
                    GE: 'Georgia',
                    GI: 'Gibraltar',
                    GL: 'Groenlandia',
                    GR: 'Grecia',
                    GT: 'Guatemala',
                    HR: 'Croacia',
                    HU: 'Hungr\u00EDa',
                    IE: 'Irlanda',
                    IL: 'Israel',
                    IR: 'Iran',
                    IS: 'Islandia',
                    IT: 'Italia',
                    JO: 'Jordania',
                    KW: 'Kuwait',
                    KZ: 'Kazajist\u00E1n',
                    LB: 'L\u00EDbano',
                    LI: 'Liechtenstein',
                    LT: 'Lituania',
                    LU: 'Luxemburgo',
                    LV: 'Letonia',
                    MC: 'M\u00F3naco',
                    MD: 'Moldavia',
                    ME: 'Montenegro',
                    MG: 'Madagascar',
                    MK: 'Macedonia',
                    ML: 'Mal\u00ED',
                    MR: 'Mauritania',
                    MT: 'Malta',
                    MU: 'Mauricio',
                    MZ: 'Mozambique',
                    NL: 'Pa\u00EDses Bajos',
                    NO: 'Noruega',
                    PK: 'Pakist\u00E1n',
                    PL: 'Poland',
                    PS: 'Palestina',
                    PT: 'Portugal',
                    QA: 'Catar',
                    RO: 'Rumania',
                    RS: 'Serbia',
                    SA: 'Arabia Saudita',
                    SE: 'Suecia',
                    SI: 'Eslovenia',
                    SK: 'Eslovaquia',
                    SM: 'San Marino',
                    SN: 'Senegal',
                    TL: 'Timor Oriental',
                    TN: 'T\u00FAnez',
                    TR: 'Turqu\u00EDa',
                    VG: 'Islas V\u00EDrgenes Brit\u00E1nicas',
                    XK: 'Rep\u00FAblica de Kosovo'
                }
            },
            id: {
                'default': 'Por favor introduce un n\u00FAmero de identificaci\u00F3n v\u00E1lido',
                country: 'Por favor introduce un n\u00FAmero v\u00E1lido de identificaci\u00F3n en %s',
                countries: {
                    BA: 'Bosnia Herzegovina',
                    BG: 'Bulgaria',
                    BR: 'Brasil',
                    CH: 'Suiza',
                    CL: 'Chile',
                    CN: 'China',
                    CZ: 'Rep\u00FAblica Checa',
                    DK: 'Dinamarca',
                    EE: 'Estonia',
                    ES: 'Espa&ntilde;a',
                    FI: 'Finlandia',
                    HR: 'Croacia',
                    IE: 'Irlanda',
                    IS: 'Islandia',
                    LT: 'Lituania',
                    LV: 'Letonia',
                    ME: 'Montenegro',
                    MK: 'Macedonia',
                    NL: 'Pa\u00EDses Bajos',
                    PL: 'Poland',
                    RO: 'Romania',
                    RS: 'Serbia',
                    SE: 'Suecia',
                    SI: 'Eslovenia',
                    SK: 'Eslovaquia',
                    SM: 'San Marino',
                    TH: 'Tailandia',
                    ZA: 'Sud\u00E1frica'
                }
            },
            identical: {
                'default': 'Por favor introduce el mismo valor'
            },
            imei: {
                'default': 'Por favor introduce un n\u00FAmero IMEI v\u00E1lido'
            },
            imo: {
                'default': 'Por favor introduce un n\u00FAmero IMO v\u00E1lido'
            },
            integer: {
                'default': 'Por favor introduce un n\u00FAmero v\u00E1lido'
            },
            ip: {
                'default': 'Por favor introduce una direcci\u00F3n IP v\u00E1lida',
                ipv4: 'Por favor introduce una direcci\u00F3n IPv4 v\u00E1lida',
                ipv6: 'Por favor introduce una direcci\u00F3n IPv6 v\u00E1lida'
            },
            isbn: {
                'default': 'Por favor introduce un n\u00FAmero ISBN v\u00E1lido'
            },
            isin: {
                'default': 'Por favor introduce un n\u00FAmero ISIN v\u00E1lido'
            },
            ismn: {
                'default': 'Por favor introduce un n\u00FAmero ISMN v\u00E1lido'
            },
            issn: {
                'default': 'Por favor introduce un n\u00FAmero ISSN v\u00E1lido'
            },
            lessThan: {
                'default': 'Por favor introduce un valor menor o igual a %s',
                notInclusive: 'Por favor introduce un valor menor que %s'
            },
            mac: {
                'default': 'Por favor introduce una direcci\u00F3n MAC v\u00E1lida'
            },
            meid: {
                'default': 'Por favor introduce un n\u00FAmero MEID v\u00E1lido'
            },
            notEmpty: {
                'default': 'Por favor introduce un valor'
            },
            numeric: {
                'default': 'Por favor introduce un n\u00FAmero decimal v\u00E1lido'
            },
            phone: {
                'default': 'Por favor introduce un n\u00FAmero v\u00E1lido de tel\u00E9fono',
                country: 'Por favor introduce un n\u00FAmero v\u00E1lido de tel\u00E9fono en %s',
                countries: {
                    AE: 'Emiratos \u00E1rabes Unidos',
                    BG: 'Bulgaria',
                    BR: 'Brasil',
                    CN: 'China',
                    CZ: 'Rep\u00FAblica Checa',
                    DE: 'Alemania',
                    DK: 'Dinamarca',
                    ES: 'Espa&ntilde;a',
                    FR: 'Francia',
                    GB: 'Reino Unido',
                    IN: 'India',
                    MA: 'Marruecos',
                    NL: 'Pa\u00EDses Bajos',
                    PK: 'Pakist\u00E1n',
                    RO: 'Rumania',
                    RU: 'Rusa',
                    SK: 'Eslovaquia',
                    TH: 'Tailandia',
                    US: 'Estados Unidos',
                    VE: 'Venezuela'
                }
            },
            promise: {
                'default': 'Por favor introduce un valor v\u00E1lido'
            },
            regexp: {
                'default': 'Por favor introduce un valor que coincida con el patr\u00F3n',
                'nombres': 'El valor solo puede contener letras y espacios'
            },
            remote: {
                'default': 'Por favor introduce un valor v\u00E1lido'
            },
            rtn: {
                'default': 'Por favor introduce un n\u00FAmero RTN v\u00E1lido'
            },
            sedol: {
                'default': 'Por favor introduce un n\u00FAmero SEDOL v\u00E1lido'
            },
            siren: {
                'default': 'Por favor introduce un n\u00FAmero SIREN v\u00E1lido'
            },
            siret: {
                'default': 'Por favor introduce un n\u00FAmero SIRET v\u00E1lido'
            },
            step: {
                'default': 'Por favor introduce un paso v\u00E1lido de %s'
            },
            stringCase: {
                'default': 'Por favor introduce s\u00F3lo caracteres en min\u00FAscula',
                upper: 'Por favor introduce s\u00F3lo caracteres en may\u00FAscula'
            },
            stringLength: {
                'default': 'Por favor introduce un valor con una longitud v\u00E1lida',
                less: 'Por favor introduce menos de %s caracteres',
                more: 'Por favor introduce m\u00E1s de %s caracteres',
                between: 'Por favor introduce un valor con una longitud entre %s y %s caracteres'
            },
            uri: {
                'default': 'Por favor introduce una URI v\u00E1lida'
            },
            uuid: {
                'default': 'Por favor introduce un n\u00FAmero UUID v\u00E1lido',
                version: 'Por favor introduce una versi\u00F3n UUID v\u00E1lida para %s'
            },
            vat: {
                'default': 'Por favor introduce un n\u00FAmero IVA v\u00E1lido',
                country: 'Por favor introduce un n\u00FAmero IVA v\u00E1lido en %s',
                countries: {
                    AT: 'Austria',
                    BE: 'B\u00E9lgica',
                    BG: 'Bulgaria',
                    BR: 'Brasil',
                    CH: 'Suiza',
                    CY: 'Chipre',
                    CZ: 'Rep\u00FAblica Checa',
                    DE: 'Alemania',
                    DK: 'Dinamarca',
                    EE: 'Estonia',
                    ES: 'Espa&ntilde;a',
                    FI: 'Finlandia',
                    FR: 'Francia',
                    GB: 'Reino Unido',
                    GR: 'Grecia',
                    EL: 'Grecia',
                    HU: 'Hungr\u00EDa',
                    HR: 'Croacia',
                    IE: 'Irlanda',
                    IS: 'Islandia',
                    IT: 'Italia',
                    LT: 'Lituania',
                    LU: 'Luxemburgo',
                    LV: 'Letonia',
                    MT: 'Malta',
                    NL: 'Pa\u00EDses Bajos',
                    NO: 'Noruega',
                    PL: 'Polonia',
                    PT: 'Portugal',
                    RO: 'Ruman\u00EDa',
                    RU: 'Rusa',
                    RS: 'Serbia',
                    SE: 'Suecia',
                    SI: 'Eslovenia',
                    SK: 'Eslovaquia',
                    VE: 'Venezuela',
                    ZA: 'Sud\u00E1frica'
                }
            },
            vin: {
                'default': 'Por favor introduce un n\u00FAmero VIN v\u00E1lido'
            },
            zipCode: {
                'default': 'Por favor introduce un c\u00F3digo postal v\u00E1lido',
                country: 'Por favor introduce un c\u00F3digo postal v\u00E1lido en %s',
                countries: {
                    AT: 'Austria',
                    BG: 'Bulgaria',
                    BR: 'Brasil',
                    CA: 'Canad\u00E1',
                    CH: 'Suiza',
                    CZ: 'Rep\u00FAblica Checa',
                    DE: 'Alemania',
                    DK: 'Dinamarca',
                    ES: 'Espa&ntilde;a',
                    FR: 'Francia',
                    GB: 'Reino Unido',
                    IE: 'Irlanda',
                    IN: 'India',
                    IT: 'Italia',
                    MA: 'Marruecos',
                    NL: 'Pa\u00EDses Bajos',
                    PL: 'Poland',
                    PT: 'Portugal',
                    RO: 'Ruman\u00EDa',
                    RU: 'Rusa',
                    SE: 'Suecia',
                    SG: 'Singapur',
                    SK: 'Eslovaquia',
                    US: 'Estados Unidos'
                }
            }
        }
    });
}(jQuery));
