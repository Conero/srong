const fs = require('fs');

// 国家列表
const contrys = [
    "Angola-安哥拉-0244",
    "Afghanistan-阿富汗-93",
    "Albania-阿尔巴尼亚-335",
    "Algeria-阿尔及利亚-213",
    "Andorra-安道尔共和国-376",
    "Anguilla-安圭拉岛-1254",
    "Antigua and Barbuda-安提瓜和巴布达-1268",
    "Argentina-阿根廷-54",
    "Armenia-亚美尼亚-374",
    "Ascension-阿森松-247",
    "Australia-澳大利亚-61",
    "Austria-奥地利-43",
    "Azerbaijan-阿塞拜疆-994",
    "Bahamas-巴哈马-1242",
    "Bahrain-巴林-973",
    "Bangladesh-孟加拉国-880",
    "Barbados-巴巴多斯-1246",
    "Belarus-白俄罗斯-375",
    "Belgium-比利时-32",
    "Belize-伯利兹-501",
    "Benin-贝宁-229",
    "Bermuda Is-百慕大群岛-1441",
    "Bolivia-玻利维亚-591",
    "Botswana-博茨瓦纳-267",
    "Brazil-巴西-55",
    "Brunei-文莱-673",
    "Bulgaria-保加利亚-359",
    "Burkina Faso-布基纳法索-226",
    "Burma-缅甸-95",
    "Burundi-布隆迪-257",
    "Cameroon-喀麦隆-237",
    "Canada-加拿大-1",
    "Cayman Is-开曼群岛-1345",
    "Central African Republic-中非共和国-236",
    "Chad-乍得-235",
    "Chile-智利-56",
    "China-中国-86",
    "Colombia-哥伦比亚-57",
    "Congo-刚果-242",
    "Cook Is-库克群岛-682",
    "Costa Rica-哥斯达黎加-506",
    "Cuba-古巴-53",
    "Cyprus-塞浦路斯-357",
    "Czech Republic-捷克-420",
    "Denmark-丹麦-45",
    "Djibouti-吉布提-253",
    "Dominica Rep-多米尼加共和国-1890",
    "Ecuador-厄瓜多尔-593",
    "Egypt-埃及-20",
    "EI Salvador-萨尔瓦多-503",
    "Estonia-爱沙尼亚-372",
    "Ethiopia-埃塞俄比亚-251",
    "Fiji-斐济-679",
    "Finland-芬兰-358",
    "France-法国-33",
    "French Guiana-法属圭亚那-594",
    "French Polynesia-法属玻利尼西亚-689",
    "Gabon-加蓬-241",
    "Gambia-冈比亚-220",
    "Georgia-格鲁吉亚-995",
    "Germany-德国-49",
    "Ghana-加纳-233",
    "Gibraltar-直布罗陀-350",
    "Greece-希腊-30",
    "Grenada-格林纳达-1809",
    "Guam-关岛-1671",
    "Guatemala-危地马拉-502",
    "Guinea-几内亚-224",
    "Guyana-圭亚那-592",
    "Haiti-海地-509",
    "Honduras-洪都拉斯-504",
    "Hongkong-香港-852",
    "Hungary-匈牙利-36",
    "Iceland-冰岛-354",
    "India-印度-91",
    "Indonesia-印度尼西亚-62",
    "Iran-伊朗-98",
    "Iraq-伊拉克-964",
    "Ireland-爱尔兰-353",
    "Israel-以色列-972",
    "Italy-意大利-39",
    "Ivory Coast-科特迪瓦-225",
    "Jamaica-牙买加-1876",
    "Japan-日本-81",
    "Jordan-约旦-962",
    "Kampuchea (Cambodia )-柬埔寨-855",
    "Kazakstan-哈萨克斯坦-327",
    "Kenya-肯尼亚-254",
    "Korea-韩国-82",
    "Kuwait-科威特-965",
    "Kyrgyzstan-吉尔吉斯坦-331",
    "Laos-老挝-856",
    "Latvia-拉脱维亚-371",
    "Lebanon-黎巴嫩-961",
    "Lesotho-莱索托-266",
    "Liberia-利比里亚-231",
    "Libya-利比亚-218",
    "Liechtenstein-列支敦士登--423",
    "Lithuania-立陶宛-370",
    "Luxembourg-卢森堡-352",
    "Macao-澳门-853",
    "Madagascar-马达加斯加-261",
    "Malawi-马拉维-265",
    "Malaysia-马来西亚-60",
    "Maldives-马尔代夫-960",
    "Mali-马里-223",
    "Malta-马耳他-356",
    "Mariana Is-马里亚那群岛-1670",
    "Martinique-马提尼克-596",
    "Mauritius-毛里求斯-230",
    "Mexico-墨西哥-52",
    "Moldova-摩尔多瓦-373",
    "Monaco-摩纳哥-377",
    "Mongolia-蒙古-976",
    "Montserrat Is-蒙特塞拉特岛-1664",
    "Morocco-摩洛哥-212",
    "Mozambique-莫桑比克-258",
    "Namibia-纳米比亚-264",
    "Nauru-瑙鲁-674",
    "Nepal-尼泊尔-977",
    "Netheriands Antilles-荷属安的列斯-599",
    "Netherlands-荷兰-31",
    "New Zealand-新西兰-64",
    "Nicaragua-尼加拉瓜-505",
    "Niger-尼日尔-227",
    "Nigeria-尼日利亚-234",
    "North Korea-朝鲜-850",
    "Norway-挪威-47",
    "Oman-阿曼-968",
    "Pakistan-巴基斯坦-92",
    "Panama-巴拿马-507",
    "Papua New Cuinea-巴布亚新几内亚-675",
    "Paraguay-巴拉圭-595",
    "Peru-秘鲁-51",
    "Philippines-菲律宾-63",
    "Poland-波兰-48",
    "Portugal-葡萄牙-351",
    "Puerto Rico-波多黎各-1787",
    "Qatar-卡塔尔-974",
    "Reunion-留尼旺-262",
    "Romania-罗马尼亚-40",
    "Russia-俄罗斯-7",
    "Saint Lueia-圣卢西亚-1758",
    "Saint Vincent-圣文森特岛-1784",
    "Samoa Eastern-东萨摩亚(美)-684",
    "Samoa Western-西萨摩亚-685",
    "San Marino-圣马力诺-378",
    "Sao Tome and Principe-圣多美和普林西比-239",
    "Saudi Arabia-沙特阿拉伯-966",
    "Senegal-塞内加尔-221",
    "Seychelles-塞舌尔-248",
    "Sierra Leone-塞拉利昂-232",
    "Singapore-新加坡-65",
    "Slovakia-斯洛伐克-421",
    "Slovenia-斯洛文尼亚-386",
    "Solomon Is-所罗门群岛-677",
    "Somali-索马里-252",
    "South Africa-南非-27",
    "Spain-西班牙-34",
    "SriLanka-斯里兰卡-94",
    "St.Lucia-圣卢西亚-1758",
    "St.Vincent-圣文森特-1784",
    "Sudan-苏丹-249",
    "Suriname-苏里南-597",
    "Swaziland-斯威士兰-268",
    "Sweden-瑞典-46",
    "Switzerland-瑞士-41",
    "Syria-叙利亚-963",
    "Taiwan-台湾省-886",
    "Tajikstan-塔吉克斯坦-992",
    "Tanzania-坦桑尼亚-255",
    "Thailand-泰国-66",
    "Togo-多哥-228",
    "Tonga-汤加-676",
    "Trinidad and Tobago-特立尼达和多巴哥-1809",
    "Tunisia-突尼斯-216",
    "Turkey-土耳其-90",
    "Turkmenistan-土库曼斯坦-993",
    "Uganda-乌干达-256",
    "Ukraine-乌克兰-380",
    "United Arab Emirates-阿拉伯联合酋长国-971",
    "United Kiongdom-英国-44",
    "United States of America-美国-1",
    "Uruguay-乌拉圭-598",
    "Uzbekistan-乌兹别克斯坦-233",
    "Venezuela-委内瑞拉-58",
    "Vietnam-越南-84",
    "Yemen-也门-967",
    "Yugoslavia-南斯拉夫-381",
    "Zimbabwe-津巴布韦-263",
    "Zaire-扎伊尔-243",
    "Zambia-赞比亚-260"
];

// 国家列表
const globalCountries = [
    {code: "HK", en: "Hong Kong", cn: "香港"},
    {code: "TW", en: "Taiwan", cn: "台湾"},
    {code: "MO", en: "Macao", cn: "澳门"},
    {code: "US", en: "United States of America (USA)", cn: "美国"},
    {code: "AR", en: "Argentina", cn: "阿根廷"},
    {code: "AD", en: "Andorra", cn: "安道尔"},
    {code: "AE", en: "United Arab Emirates", cn: "阿联酋"},
    {code: "AF", en: "Afghanistan", cn: "阿富汗"},
    {code: "AG", en: "Antigua & Barbuda", cn: "安提瓜和巴布达"},
    {code: "AI", en: "Anguilla", cn: "安圭拉"},
    {code: "AL", en: "Albania", cn: "阿尔巴尼亚"},
    {code: "AM", en: "Armenia", cn: "亚美尼亚"},
    {code: "AO", en: "Angola", cn: "安哥拉"},
    {code: "AQ", en: "Antarctica", cn: "南极洲"},
    {code: "AS", en: "American Samoa", cn: "美属萨摩亚"},
    {code: "AT", en: "Austria", cn: "奥地利"},
    {code: "AU", en: "Australia", cn: "澳大利亚"},
    {code: "AW", en: "Aruba", cn: "阿鲁巴"},
    {code: "AX", en: "Aland Island", cn: "奥兰群岛"},
    {code: "AZ", en: "Azerbaijan", cn: "阿塞拜疆"},
    {code: "BA", en: "Bosnia & Herzegovina", cn: "波黑"},
    {code: "BB", en: "Barbados", cn: "巴巴多斯"},
    {code: "BD", en: "Bangladesh", cn: "孟加拉"},
    {code: "BE", en: "Belgium", cn: "比利时"},
    {code: "BF", en: "Burkina", cn: "布基纳法索"},
    {code: "BG", en: "Bulgaria", cn: "保加利亚"},
    {code: "BH", en: "Bahrain", cn: "巴林"},
    {code: "BI", en: "Burundi", cn: "布隆迪"},
    {code: "BJ", en: "Benin", cn: "贝宁"},
    {code: "BL", en: "Saint Barthélemy", cn: "圣巴泰勒米岛"},
    {code: "BM", en: "Bermuda", cn: "百慕大"},
    {code: "BN", en: "Brunei", cn: "文莱"},
    {code: "BO", en: "Bolivia", cn: "玻利维亚"},
    {code: "BQ", en: "Caribbean Netherlands", cn: "荷兰加勒比区"},
    {code: "BR", en: "Brazil", cn: "巴西"},
    {code: "BS", en: "The Bahamas", cn: "巴哈马"},
    {code: "BT", en: "Bhutan", cn: "不丹"},
    {code: "BV", en: "Bouvet Island", cn: "布韦岛"},
    {code: "BW", en: "Botswana", cn: "博茨瓦纳"},
    {code: "BY", en: "Belarus", cn: "白俄罗斯"},
    {code: "BZ", en: "Belize", cn: "伯利兹"},
    {code: "CA", en: "Canada", cn: "加拿大"},
    {code: "CC", en: "Cocos (Keeling) Islands", cn: "科科斯群岛"},
    {code: "CD", en: "Democratic Republic of the Congo", cn: "刚果（金）"},
    {code: "CF", en: "Central African Republic", cn: "中非"},
    {code: "CG", en: "Republic of the Congo", cn: "刚果（布）"},
    {code: "CH", en: "Switzerland", cn: "瑞士"},
    {code: "CI", en: "Cote d'Ivoire", cn: "科特迪瓦"},
    {code: "CK", en: "Cook Islands", cn: "库克群岛"},
    {code: "CL", en: "Chile", cn: "智利"},
    {code: "CM", en: "Cameroon", cn: "喀麦隆"},
    {code: "CN", en: "China", cn: "中国"},
    {code: "CO", en: "Colombia", cn: "哥伦比亚"},
    {code: "CR", en: "Costa Rica", cn: "哥斯达黎加"},
    {code: "CU", en: "Cuba", cn: "古巴"},
    {code: "CV", en: "Cape Verde", cn: "佛得角"},
    {code: "CW", en: "Curacao", cn: "库拉索"},
    {code: "CX", en: "Christmas Island", cn: "圣诞岛"},
    {code: "CY", en: "Cyprus", cn: "塞浦路斯"},
    {code: "CZ", en: "Czech Republic", cn: "捷克"},
    {code: "DE", en: "Germany", cn: "德国"},
    {code: "DJ", en: "Djibouti", cn: "吉布提"},
    {code: "DK", en: "Denmark", cn: "丹麦"},
    {code: "DM", en: "Dominica", cn: "多米尼克"},
    {code: "DO", en: "Dominican Republic", cn: "多米尼加"},
    {code: "DZ", en: "Algeria", cn: "阿尔及利亚"},
    {code: "EC", en: "Ecuador", cn: "厄瓜多尔"},
    {code: "EE", en: "Estonia", cn: "爱沙尼亚"},
    {code: "EG", en: "Egypt", cn: "埃及"},
    {code: "EH", en: "Western Sahara", cn: "西撒哈拉"},
    {code: "ER", en: "Eritrea", cn: "厄立特里亚"},
    {code: "ES", en: "Spain", cn: "西班牙"},
    {code: "ET", en: "Ethiopia", cn: "埃塞俄比亚"},
    {code: "FI", en: "Finland", cn: "芬兰"},
    {code: "FJ", en: "Fiji", cn: "斐济群岛"},
    {code: "FK", en: "Falkland Islands", cn: "马尔维纳斯群岛（福克兰）"},
    {code: "FM", en: "Federated States of Micronesia", cn: "密克罗尼西亚联邦"},
    {code: "FO", en: "Faroe Islands", cn: "法罗群岛"},
    {code: "FR", en: "France", cn: "法国 法国"},
    {code: "GA", en: "Gabon", cn: "加蓬"},
    {code: "GB", en: "Great Britain (United Kingdom; England)", cn: "英国"},
    {code: "GD", en: "Grenada", cn: "格林纳达"},
    {code: "GE", en: "Georgia", cn: "格鲁吉亚"},
    {code: "GF", en: "French Guiana", cn: "法属圭亚那"},
    {code: "GG", en: "Guernsey", cn: "根西岛"},
    {code: "GH", en: "Ghana", cn: "加纳"},
    {code: "GI", en: "Gibraltar", cn: "直布罗陀"},
    {code: "GL", en: "Greenland", cn: "格陵兰"},
    {code: "GM", en: "Gambia", cn: "冈比亚"},
    {code: "GN", en: "Guinea", cn: "几内亚"},
    {code: "GP", en: "Guadeloupe", cn: "瓜德罗普"},
    {code: "GQ", en: "Equatorial Guinea", cn: "赤道几内亚"},
    {code: "GR", en: "Greece", cn: "希腊"},
    {code: "GS", en: "South Georgia and the South Sandwich Islands", cn: "南乔治亚岛和南桑威奇群岛"},
    {code: "GT", en: "Guatemala", cn: "危地马拉"},
    {code: "GU", en: "Guam", cn: "关岛"},
    {code: "GW", en: "Guinea-Bissau", cn: "几内亚比绍"},
    {code: "GY", en: "Guyana", cn: "圭亚那"},
    {code: "HM", en: "Heard Island and McDonald Islands", cn: "赫德岛和麦克唐纳群岛"},
    {code: "HN", en: "Honduras", cn: "洪都拉斯"},
    {code: "HR", en: "Croatia", cn: "克罗地亚"},
    {code: "HT", en: "Haiti", cn: "海地"},
    {code: "HU", en: "Hungary", cn: "匈牙利"},
    {code: "ID", en: "Indonesia", cn: "印尼"},
    {code: "IE", en: "Ireland", cn: "爱尔兰"},
    {code: "IL", en: "Israel", cn: "以色列"},
    {code: "IM", en: "Isle of Man", cn: "马恩岛"},
    {code: "IN", en: "India", cn: "印度"},
    {code: "IO", en: "British Indian Ocean Territory", cn: "英属印度洋领地"},
    {code: "IQ", en: "Iraq", cn: "伊拉克"},
    {code: "IR", en: "Iran", cn: "伊朗"},
    {code: "IS", en: "Iceland", cn: "冰岛"},
    {code: "IT", en: "Italy", cn: "意大利"},
    {code: "JE", en: "Jersey", cn: "泽西岛"},
    {code: "JM", en: "Jamaica", cn: "牙买加"},
    {code: "JO", en: "Jordan", cn: "约旦"},
    {code: "JP", en: "Japan", cn: "日本"},
    {code: "KE", en: "Kenya", cn: "肯尼亚"},
    {code: "KG", en: "Kyrgyzstan", cn: "吉尔吉斯斯坦"},
    {code: "KH", en: "Cambodia", cn: "柬埔寨"},
    {code: "KI", en: "Kiribati", cn: "基里巴斯"},
    {code: "KM", en: "The Comoros", cn: "科摩罗"},
    {code: "KN", en: "St. Kitts & Nevis", cn: "圣基茨和尼维斯"},
    {code: "KP", en: "North Korea", cn: "朝鲜"},
    {code: "KR", en: "South Korea", cn: "韩国"},
    {code: "KW", en: "Kuwait", cn: "科威特"},
    {code: "KY", en: "Cayman Islands", cn: "开曼群岛"},
    {code: "KZ", en: "Kazakhstan", cn: "哈萨克斯坦"},
    {code: "LA", en: "Laos", cn: "老挝"},
    {code: "LB", en: "Lebanon", cn: "黎巴嫩"},
    {code: "LC", en: "St. Lucia", cn: "圣卢西亚"},
    {code: "LI", en: "Liechtenstein", cn: "列支敦士登"},
    {code: "LK", en: "Sri Lanka", cn: "斯里兰卡"},
    {code: "LR", en: "Liberia", cn: "利比里亚"},
    {code: "LS", en: "Lesotho", cn: "莱索托"},
    {code: "LT", en: "Lithuania", cn: "立陶宛"},
    {code: "LU", en: "Luxembourg", cn: "卢森堡"},
    {code: "LV", en: "Latvia", cn: "拉脱维亚"},
    {code: "LY", en: "Libya", cn: "利比亚"},
    {code: "MA", en: "Morocco", cn: "摩洛哥"},
    {code: "MC", en: "Monaco", cn: "摩纳哥"},
    {code: "MD", en: "Moldova", cn: "摩尔多瓦"},
    {code: "ME", en: "Montenegro", cn: "黑山"},
    {code: "MF", en: "Saint Martin (France)", cn: "法属圣马丁"},
    {code: "MG", en: "Madagascar", cn: "马达加斯加"},
    {code: "MH", en: "Marshall islands", cn: "马绍尔群岛"},
    {code: "MK", en: "Republic of Macedonia (FYROM)", cn: "马其顿"},
    {code: "ML", en: "Mali", cn: "马里"},
    {code: "MM", en: "Myanmar (Burma)", cn: "缅甸"},
    {code: "MN", en: "Mongolia", cn: "蒙古国"},
    {code: "MP", en: "Northern Mariana Islands", cn: "北马里亚纳群岛"},
    {code: "MQ", en: "Martinique", cn: "马提尼克"},
    {code: "MR", en: "Mauritania", cn: "毛里塔尼亚"},
    {code: "MS", en: "Montserrat", cn: "蒙塞拉特岛"},
    {code: "MT", en: "Malta", cn: "马耳他"},
    {code: "MU", en: "Mauritius", cn: "毛里求斯"},
    {code: "MV", en: "Maldives", cn: "马尔代夫"},
    {code: "MW", en: "Malawi", cn: "马拉维"},
    {code: "MX", en: "Mexico", cn: "墨西哥"},
    {code: "MY", en: "Malaysia", cn: "马来西亚"},
    {code: "MZ", en: "Mozambique", cn: "莫桑比克"},
    {code: "NA", en: "Namibia", cn: "纳米比亚"},
    {code: "NC", en: "New Caledonia", cn: "新喀里多尼亚"},
    {code: "NE", en: "Niger", cn: "尼日尔"},
    {code: "NF", en: "Norfolk Island", cn: "诺福克岛"},
    {code: "NG", en: "Nigeria", cn: "尼日利亚"},
    {code: "NI", en: "Nicaragua", cn: "尼加拉瓜"},
    {code: "NL", en: "Netherlands", cn: "荷兰"},
    {code: "NO", en: "Norway", cn: "挪威"},
    {code: "NP", en: "Nepal", cn: "尼泊尔"},
    {code: "NR", en: "Nauru", cn: "瑙鲁"},
    {code: "NU", en: "Niue", cn: "纽埃"},
    {code: "NZ", en: "New Zealand", cn: "新西兰"},
    {code: "OM", en: "Oman", cn: "阿曼"},
    {code: "PA", en: "Panama", cn: "巴拿马"},
    {code: "PE", en: "Peru", cn: "秘鲁"},
    {code: "PF", en: "French polynesia", cn: "法属波利尼西亚"},
    {code: "PG", en: "Papua New Guinea", cn: "巴布亚新几内亚"},
    {code: "PH", en: "The Philippines", cn: "菲律宾"},
    {code: "PK", en: "Pakistan", cn: "巴基斯坦"},
    {code: "PL", en: "Poland", cn: "波兰"},
    {code: "PM", en: "Saint-Pierre and Miquelon", cn: "圣皮埃尔和密克隆"},
    {code: "PN", en: "Pitcairn Islands", cn: "皮特凯恩群岛"},
    {code: "PR", en: "Puerto Rico", cn: "波多黎各"},
    {code: "PS", en: "Palestinian territories", cn: "巴勒斯坦"},
    {code: "PT", en: "Portugal", cn: "葡萄牙"},
    {code: "PW", en: "Palau", cn: "帕劳"},
    {code: "PY", en: "Paraguay", cn: "巴拉圭"},
    {code: "QA", en: "Qatar", cn: "卡塔尔"},
    {code: "RE", en: "Réunion", cn: "留尼汪"},
    {code: "RO", en: "Romania", cn: "罗马尼亚"},
    {code: "RS", en: "Serbia", cn: "塞尔维亚"},
    {code: "RU", en: "Russian Federation", cn: "俄罗斯"},
    {code: "RW", en: "Rwanda", cn: "卢旺达"},
    {code: "SA", en: "Saudi Arabia", cn: "沙特阿拉伯"},
    {code: "SB", en: "Solomon Islands", cn: "所罗门群岛"},
    {code: "SC", en: "Seychelles", cn: "塞舌尔"},
    {code: "SD", en: "Sudan", cn: "苏丹"},
    {code: "SE", en: "Sweden", cn: "瑞典"},
    {code: "SG", en: "Singapore", cn: "新加坡"},
    {code: "SH", en: "St. Helena & Dependencies", cn: "圣赫勒拿"},
    {code: "SI", en: "Slovenia", cn: "斯洛文尼亚"},
    {code: "SJ", en: "Svalbard and Jan Mayen", cn: "斯瓦尔巴群岛和扬马延岛"},
    {code: "SK", en: "Slovakia", cn: "斯洛伐克"},
    {code: "SL", en: "Sierra Leone", cn: "塞拉利昂"},
    {code: "SM", en: "San Marino", cn: "圣马力诺"},
    {code: "SN", en: "Senegal", cn: "塞内加尔"},
    {code: "SO", en: "Somalia", cn: "索马里"},
    {code: "SR", en: "Suriname", cn: "苏里南"},
    {code: "SS", en: "South Sudan", cn: "南苏丹"},
    {code: "ST", en: "Sao Tome & Principe", cn: "圣多美和普林西比"},
    {code: "SV", en: "El Salvador", cn: "萨尔瓦多"},
    {code: "SX", en: "Sint Maarten", cn: "荷属圣马丁"},
    {code: "SY", en: "Syria", cn: "叙利亚"},
    {code: "SZ", en: "Swaziland", cn: "斯威士兰"},
    {code: "TC", en: "Turks & Caicos Islands", cn: "特克斯和凯科斯群岛"},
    {code: "TD", en: "Chad", cn: "乍得"},
    {code: "TF", en: "French Southern Territories", cn: "法属南部领地"},
    {code: "TG", en: "Togo", cn: "多哥"},
    {code: "TH", en: "Thailand", cn: "泰国"},
    {code: "TJ", en: "Tajikistan", cn: "塔吉克斯坦"},
    {code: "TK", en: "Tokelau", cn: "托克劳"},
    {code: "TL", en: "Timor-Leste (East Timor)", cn: "东帝汶"},
    {code: "TM", en: "Turkmenistan", cn: "土库曼斯坦"},
    {code: "TN", en: "Tunisia", cn: "突尼斯"},
    {code: "TO", en: "Tonga", cn: "汤加"},
    {code: "TR", en: "Turkey", cn: "土耳其"},
    {code: "TT", en: "Trinidad & Tobago", cn: "特立尼达和多巴哥"},
    {code: "TV", en: "Tuvalu", cn: "图瓦卢"},
    {code: "TZ", en: "Tanzania", cn: "坦桑尼亚"},
    {code: "UA", en: "Ukraine", cn: "乌克兰"},
    {code: "UG", en: "Uganda", cn: "乌干达"},
    {code: "UM", en: "United States Minor Outlying Islands", cn: "美国本土外小岛屿"},
    {code: "UY", en: "Uruguay", cn: "乌拉圭"},
    {code: "UZ", en: "Uzbekistan", cn: "乌兹别克斯坦"},
    {code: "VA", en: "Vatican City (The Holy See)", cn: "梵蒂冈"},
    {code: "VC", en: "St. Vincent & the Grenadines", cn: "圣文森特和格林纳丁斯"},
    {code: "VE", en: "Venezuela", cn: "委内瑞拉"},
    {code: "VG", en: "British Virgin Islands", cn: "英属维尔京群岛"},
    {code: "VI", en: "United States Virgin Islands", cn: "美属维尔京群岛"},
    {code: "VN", en: "Vietnam", cn: "越南"},
    {code: "VU", en: "Vanuatu", cn: "瓦努阿图"},
    {code: "WF", en: "Wallis and Futuna", cn: "瓦利斯和富图纳"},
    {code: "WS", en: "Samoa", cn: "萨摩亚"},
    {code: "YE", en: "Yemen", cn: "也门"},
    {code: "YT", en: "Mayotte", cn: "马约特"},
    {code: "ZA", en: "South Africa", cn: "南非"},
    {code: "ZM", en: "Zambia", cn: "赞比亚"},
    {code: "ZW", en: "Zimbabwe", cn: "津巴布韦"}
];

// 大洲
const world =
    [
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "斯瓦尔巴群岛和扬马延岛",
            "country_code": "SJ",
            "country_name": "Svalbard & Jan Mayen"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "荷兰加勒比区",
            "country_code": "BQ",
            "country_name": "Caribbean Netherlands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "蒙塞拉特岛",
            "country_code": "MS",
            "country_name": "Montserrat"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "西撒哈拉",
            "country_code": "EH",
            "country_name": "Western Sahara"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "不丹",
            "country_code": "BT",
            "country_name": "Bhutan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "东帝汶",
            "country_code": "TL",
            "country_name": "Timor-Leste (East Timor)"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "中国",
            "country_code": "CN",
            "country_name": "China"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "乌兹别克斯坦",
            "country_code": "UZ",
            "country_name": "Uzbekistan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "也门",
            "country_code": "YE",
            "country_name": "Yemen"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "亚美尼亚",
            "country_code": "AM",
            "country_name": "Armenia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "以色列",
            "country_code": "IL",
            "country_name": "Israel"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "伊拉克",
            "country_code": "IQ",
            "country_name": "Iraq"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "伊朗",
            "country_code": "IR",
            "country_name": "Iran"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "卡塔尔",
            "country_code": "QA",
            "country_name": "Qatar"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "印尼",
            "country_code": "ID",
            "country_name": "Indonesia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "印度",
            "country_code": "IN",
            "country_name": "India"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "叙利亚",
            "country_code": "SY",
            "country_name": "Syria"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "台湾",
            "country_code": "TW",
            "country_name": "Taiwan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "吉尔吉斯斯坦",
            "country_code": "KG",
            "country_name": "Kyrgyzstan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "哈萨克斯坦",
            "country_code": "KZ",
            "country_name": "Kazakhstan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "土库曼斯坦",
            "country_code": "TM",
            "country_name": "Turkmenistan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "土耳其",
            "country_code": "TR",
            "country_name": "Turkey"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "圣诞岛",
            "country_code": "CX",
            "country_name": "Christmas Island"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "塔吉克斯坦",
            "country_code": "TJ",
            "country_name": "Tajikistan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "塞浦路斯",
            "country_code": "CY",
            "country_name": "Cyprus"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "孟加拉",
            "country_code": "BD",
            "country_name": "Bangladesh"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "尼泊尔",
            "country_code": "NP",
            "country_name": "Nepal"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "巴勒斯坦",
            "country_code": "PS",
            "country_name": "Palestinian territories"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "巴基斯坦",
            "country_code": "PK",
            "country_name": "Pakistan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "巴林",
            "country_code": "BH",
            "country_name": "Bahrain"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "文莱",
            "country_code": "BN",
            "country_name": "Brunei"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "斯里兰卡",
            "country_code": "LK",
            "country_name": "Sri Lanka"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "新加坡",
            "country_code": "SG",
            "country_name": "Singapore"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "日本",
            "country_code": "JP",
            "country_name": "Japan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "朝鲜",
            "country_code": "KP",
            "country_name": "North Korea"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "柬埔寨",
            "country_code": "KH",
            "country_name": "Cambodia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "格鲁吉亚",
            "country_code": "GE",
            "country_name": "Georgia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "沙特阿拉伯",
            "country_code": "SA",
            "country_name": "Saudi Arabia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "泰国",
            "country_code": "TH",
            "country_name": "Thailand"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "澳门",
            "country_code": "MO",
            "country_name": "Macao"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "科威特",
            "country_code": "KW",
            "country_name": "Kuwait"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "科科斯群岛",
            "country_code": "CC",
            "country_name": "Cocos (Keeling) Islands"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "约旦",
            "country_code": "JO",
            "country_name": "Jordan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "缅甸",
            "country_code": "MM",
            "country_name": "Myanmar (Burma)"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "老挝",
            "country_code": "LA",
            "country_name": "Laos"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "菲律宾",
            "country_code": "PH",
            "country_name": "The Philippines"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "蒙古国",
            "country_code": "MN",
            "country_name": "Mongolia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "越南",
            "country_code": "VN",
            "country_name": "Vietnam"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "阿塞拜疆",
            "country_code": "AZ",
            "country_name": "Azerbaijan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "阿富汗",
            "country_code": "AF",
            "country_name": "Afghanistan"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "阿曼",
            "country_code": "OM",
            "country_name": "Oman"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "阿根廷",
            "country_code": "AR",
            "country_name": "Argentina"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "阿联酋",
            "country_code": "AE",
            "country_name": "United Arab Emirates"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "韩国",
            "country_code": "KR",
            "country_name": "South Korea"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "香港",
            "country_code": "HK",
            "country_name": "Hong Kong"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "马尔代夫",
            "country_code": "MV",
            "country_name": "Maldives"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "马来西亚",
            "country_code": "MY",
            "country_name": "Malaysia"
        },
        {
            "continent_cname": "亚洲",
            "continent_name": "AS",
            "country_cname": "黎巴嫩",
            "country_code": "LB",
            "country_name": "Lebanon"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "伯利兹",
            "country_code": "BZ",
            "country_name": "Belize"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "加拿大",
            "country_code": "CA",
            "country_name": "Canada"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "危地马拉",
            "country_code": "GT",
            "country_name": "Guatemala"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "古巴",
            "country_code": "CU",
            "country_name": "Cuba"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "哥斯达黎加",
            "country_code": "CR",
            "country_name": "Costa Rica"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "圣卢西亚",
            "country_code": "LC",
            "country_name": "St. Lucia"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "圣基茨和尼维斯",
            "country_code": "KN",
            "country_name": "St. Kitts & Nevis"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "圣巴泰勒米岛",
            "country_code": "BL",
            "country_name": "Saint Barthélemy"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "圣文森特和格林纳丁斯",
            "country_code": "VC",
            "country_name": "St. Vincent & the Grenadines"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "圣皮埃尔和密克隆",
            "country_code": "PM",
            "country_name": "Saint-Pierre & Miquelon"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "墨西哥",
            "country_code": "MX",
            "country_name": "Mexico"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "多米尼克",
            "country_code": "DM",
            "country_name": "Dominica"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "多米尼加",
            "country_code": "DO",
            "country_name": "Dominican Republic"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "安圭拉",
            "country_code": "AI",
            "country_name": "Anguilla"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "安提瓜和巴布达",
            "country_code": "AG",
            "country_name": "Antigua & Barbuda"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "尼加拉瓜",
            "country_code": "NI",
            "country_name": "Nicaragua"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "巴哈马",
            "country_code": "BS",
            "country_name": "The Bahamas"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "巴巴多斯",
            "country_code": "BB",
            "country_name": "Barbados"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "巴拿马",
            "country_code": "PA",
            "country_name": "Panama"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "库拉索",
            "country_code": "CW",
            "country_name": "Curacao"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "开曼群岛",
            "country_code": "KY",
            "country_name": "Cayman Islands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "格林纳达",
            "country_code": "GD",
            "country_name": "Grenada"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "格陵兰",
            "country_code": "GL",
            "country_name": "Greenland"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "法属圣马丁",
            "country_code": "MF",
            "country_name": "Saint Martin (France)"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "波多黎各",
            "country_code": "PR",
            "country_name": "Puerto Rico"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "洪都拉斯",
            "country_code": "HN",
            "country_name": "Honduras"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "海地",
            "country_code": "HT",
            "country_name": "Haiti"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "牙买加",
            "country_code": "JM",
            "country_name": "Jamaica"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "特克斯和凯科斯群岛",
            "country_code": "TC",
            "country_name": "Turks & Caicos Islands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "特立尼达和多巴哥",
            "country_code": "TT",
            "country_name": "Trinidad & Tobago"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "瓜德罗普",
            "country_code": "GP",
            "country_name": "Guadeloupe"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "百慕大",
            "country_code": "BM",
            "country_name": "Bermuda"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "美国",
            "country_code": "US",
            "country_name": "United States of America (USA)"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "美国本土外小岛屿",
            "country_code": "UM",
            "country_name": "United States Minor Outlying Islands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "美属维尔京群岛",
            "country_code": "VI",
            "country_name": "United States Virgin Islands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "英属维尔京群岛",
            "country_code": "VG",
            "country_name": "British Virgin Islands"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "荷属圣马丁",
            "country_code": "SX",
            "country_name": "Sint Maarten"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "萨尔瓦多",
            "country_code": "SV",
            "country_name": "El Salvador"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "阿鲁巴",
            "country_code": "AW",
            "country_name": "Aruba"
        },
        {
            "continent_cname": "北美洲",
            "continent_name": "NA",
            "country_cname": "马提尼克",
            "country_code": "MQ",
            "country_name": "Martinique"
        },
        {
            "continent_cname": "南极洲",
            "continent_name": "AN",
            "country_cname": "南乔治亚岛和南桑威奇群岛",
            "country_code": "GS",
            "country_name": "South Georgia & the South Sandwich Islands"
        },
        {
            "continent_cname": "南极洲",
            "continent_name": "AN",
            "country_cname": "南极洲",
            "country_code": "AQ",
            "country_name": "Antarctica"
        },
        {
            "continent_cname": "南极洲",
            "continent_name": "AN",
            "country_cname": "布韦岛",
            "country_code": "BV",
            "country_name": "Bouvet Island"
        },
        {
            "continent_cname": "南极洲",
            "continent_name": "AN",
            "country_cname": "法属南部领地",
            "country_code": "TF",
            "country_name": "French Southern Territories"
        },
        {
            "continent_cname": "南极洲",
            "continent_name": "AN",
            "country_cname": "赫德岛和麦克唐纳群岛",
            "country_code": "HM",
            "country_name": "Heard Island & McDonald Islands"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "乌拉圭",
            "country_code": "UY",
            "country_name": "Uruguay"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "厄瓜多尔",
            "country_code": "EC",
            "country_name": "Ecuador"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "哥伦比亚",
            "country_code": "CO",
            "country_name": "Colombia"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "圭亚那",
            "country_code": "GY",
            "country_name": "Guyana"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "委内瑞拉",
            "country_code": "VE",
            "country_name": "Venezuela"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "巴拉圭",
            "country_code": "PY",
            "country_name": "Paraguay"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "巴西",
            "country_code": "BR",
            "country_name": "Brazil"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "智利",
            "country_code": "CL",
            "country_name": "Chile"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "法属圭亚那",
            "country_code": "GF",
            "country_name": "French Guiana"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "玻利维亚",
            "country_code": "BO",
            "country_name": "Bolivia"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "秘鲁",
            "country_code": "PE",
            "country_name": "Peru"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "苏里南",
            "country_code": "SR",
            "country_name": "Suriname"
        },
        {
            "continent_cname": "南美洲",
            "continent_name": "SA",
            "country_cname": "马尔维纳斯群岛(福克兰)",
            "country_code": "FK",
            "country_name": "Falkland Islands"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "关岛",
            "country_code": "GU",
            "country_name": "Guam"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "北马里亚纳群岛",
            "country_code": "MP",
            "country_name": "Northern Mariana Islands"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "图瓦卢",
            "country_code": "TV",
            "country_name": "Tuvalu"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "基里巴斯",
            "country_code": "KI",
            "country_name": "Kiribati"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "密克罗尼西亚联邦",
            "country_code": "FM",
            "country_name": "Federated States of Micronesia"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "巴布亚新几内亚",
            "country_code": "PG",
            "country_name": "Papua New Guinea"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "帕劳",
            "country_code": "PW",
            "country_name": "Palau"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "库克群岛",
            "country_code": "CK",
            "country_name": "Cook Islands"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "所罗门群岛",
            "country_code": "SB",
            "country_name": "Solomon Islands"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "托克劳",
            "country_code": "TK",
            "country_name": "Tokelau"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "斐济群岛",
            "country_code": "FJ",
            "country_name": "Fiji"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "新喀里多尼亚",
            "country_code": "NC",
            "country_name": "New Caledonia"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "新西兰",
            "country_code": "NZ",
            "country_name": "New Zealand"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "汤加",
            "country_code": "TO",
            "country_name": "Tonga"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "法属波利尼西亚",
            "country_code": "PF",
            "country_name": "French polynesia"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "澳大利亚",
            "country_code": "AU",
            "country_name": "Australia"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "瑙鲁",
            "country_code": "NR",
            "country_name": "Nauru"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "瓦利斯和富图纳",
            "country_code": "WF",
            "country_name": "Wallis & Futuna"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "瓦努阿图",
            "country_code": "VU",
            "country_name": "Vanuatu"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "皮特凯恩群岛",
            "country_code": "PN",
            "country_name": "Pitcairn Islands"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "纽埃",
            "country_code": "NU",
            "country_name": "Niue"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "美属萨摩亚",
            "country_code": "AS",
            "country_name": "American Samoa"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "萨摩亚",
            "country_code": "WS",
            "country_name": "Samoa"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "诺福克岛",
            "country_code": "NF",
            "country_name": "Norfolk Island"
        },
        {
            "continent_cname": "大洋洲",
            "continent_name": "OA",
            "country_cname": "马绍尔群岛",
            "country_code": "MH",
            "country_name": "Marshall islands"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "丹麦",
            "country_code": "DK",
            "country_name": "Denmark"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "乌克兰",
            "country_code": "UA",
            "country_name": "Ukraine"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "俄罗斯",
            "country_code": "RU",
            "country_name": "Russian Federation"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "保加利亚",
            "country_code": "BG",
            "country_name": "Bulgaria"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "克罗地亚",
            "country_code": "HR",
            "country_name": "Croatia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "冰岛",
            "country_code": "IS",
            "country_name": "Iceland"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "列支敦士登",
            "country_code": "LI",
            "country_name": "Liechtenstein"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "匈牙利",
            "country_code": "HU",
            "country_name": "Hungary"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "卢森堡",
            "country_code": "LU",
            "country_name": "Luxembourg"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "圣马力诺",
            "country_code": "SM",
            "country_name": "San Marino"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "塞尔维亚",
            "country_code": "RS",
            "country_name": "Serbia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "奥兰群岛",
            "country_code": "AX",
            "country_name": "Aland Island"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "奥地利",
            "country_code": "AT",
            "country_name": "Austria"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "安道尔",
            "country_code": "AD",
            "country_name": "Andorra"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "希腊",
            "country_code": "GR",
            "country_name": "Greece"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "德国",
            "country_code": "DE",
            "country_name": "Germany"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "意大利",
            "country_code": "IT",
            "country_name": "Italy"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "拉脱维亚",
            "country_code": "LV",
            "country_name": "Latvia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "挪威",
            "country_code": "NO",
            "country_name": "Norway"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "捷克",
            "country_code": "CZ",
            "country_name": "Czech Republic"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "摩尔多瓦",
            "country_code": "MD",
            "country_name": "Moldova"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "摩纳哥",
            "country_code": "MC",
            "country_name": "Monaco"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "斯洛伐克",
            "country_code": "SK",
            "country_name": "Slovakia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "斯洛文尼亚",
            "country_code": "SI",
            "country_name": "Slovenia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "根西岛",
            "country_code": "GG",
            "country_name": "Guernsey"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "梵蒂冈",
            "country_code": "VA",
            "country_name": "Vatican City (The Holy See)"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "比利时",
            "country_code": "BE",
            "country_name": "Belgium"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "法国",
            "country_code": "FR",
            "country_name": "France"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "法罗群岛",
            "country_code": "FO",
            "country_name": "Faroe Islands"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "波兰",
            "country_code": "PL",
            "country_name": "Poland"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "波黑",
            "country_code": "BA",
            "country_name": "Bosnia & Herzegovina"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "泽西岛",
            "country_code": "JE",
            "country_name": "Jersey"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "爱尔兰",
            "country_code": "IE",
            "country_name": "Ireland"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "爱沙尼亚",
            "country_code": "EE",
            "country_name": "Estonia"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "瑞典",
            "country_code": "SE",
            "country_name": "Sweden"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "瑞士",
            "country_code": "CH",
            "country_name": "Switzerland"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "白俄罗斯",
            "country_code": "BY",
            "country_name": "Belarus"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "直布罗陀",
            "country_code": "GI",
            "country_name": "Gibraltar"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "立陶宛",
            "country_code": "LT",
            "country_name": "Lithuania"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "罗马尼亚",
            "country_code": "RO",
            "country_name": "Romania"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "芬兰",
            "country_code": "FI",
            "country_name": "Finland"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "英国",
            "country_code": "GB",
            "country_name": "Great Britain (United Kingdom / England)"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "荷兰",
            "country_code": "NL",
            "country_name": "Netherlands"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "葡萄牙",
            "country_code": "PT",
            "country_name": "Portugal"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "西班牙",
            "country_code": "ES",
            "country_name": "Spain"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "阿尔巴尼亚",
            "country_code": "AL",
            "country_name": "Albania"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "马其顿",
            "country_code": "MK",
            "country_name": "Republic of Macedonia (FYROM)"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "马恩岛",
            "country_code": "IM",
            "country_name": "Isle of Man"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "马耳他",
            "country_code": "MT",
            "country_name": "Malta"
        },
        {
            "continent_cname": "欧洲",
            "continent_name": "EU",
            "country_cname": "黑山",
            "country_code": "ME",
            "country_name": "Montenegro"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "中非",
            "country_code": "CF",
            "country_name": "Central African Republic"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "乌干达",
            "country_code": "UG",
            "country_name": "Uganda"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "乍得",
            "country_code": "TD",
            "country_name": "Chad"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "佛得角",
            "country_code": "CV",
            "country_name": "Cape Verde"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "冈比亚",
            "country_code": "GM",
            "country_name": "Gambia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "几内亚",
            "country_code": "GN",
            "country_name": "Guinea"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "几内亚比绍",
            "country_code": "GW",
            "country_name": "Guinea-Bissau"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "刚果(布)",
            "country_code": "CG",
            "country_name": "Republic of the Congo"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "刚果(金)",
            "country_code": "CD",
            "country_name": "Democratic Republic of the Congo"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "利比亚",
            "country_code": "LY",
            "country_name": "Libya"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "利比里亚",
            "country_code": "LR",
            "country_name": "Liberia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "加纳",
            "country_code": "GH",
            "country_name": "Ghana"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "加蓬",
            "country_code": "GA",
            "country_name": "Gabon"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "南苏丹",
            "country_code": "SS",
            "country_name": "South Sudan"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "南非",
            "country_code": "ZA",
            "country_name": "South Africa"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "博茨瓦纳",
            "country_code": "BW",
            "country_name": "Botswana"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "卢旺达",
            "country_code": "RW",
            "country_name": "Rwanda"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "厄立特里亚",
            "country_code": "ER",
            "country_name": "Eritrea"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "吉布提",
            "country_code": "DJ",
            "country_name": "Djibouti"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "喀麦隆",
            "country_code": "CM",
            "country_name": "Cameroon"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "圣多美和普林西比",
            "country_code": "ST",
            "country_name": "Sao Tome & Principe"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "圣赫勒拿",
            "country_code": "SH",
            "country_name": "St. Helena & Dependencies"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "坦桑尼亚",
            "country_code": "TZ",
            "country_name": "Tanzania"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "埃及",
            "country_code": "EG",
            "country_name": "Egypt"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "埃塞俄比亚",
            "country_code": "ET",
            "country_name": "Ethiopia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "塞内加尔",
            "country_code": "SN",
            "country_name": "Senegal"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "塞拉利昂",
            "country_code": "SL",
            "country_name": "Sierra Leone"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "塞舌尔",
            "country_code": "SC",
            "country_name": "Seychelles"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "多哥",
            "country_code": "TG",
            "country_name": "Togo"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "安哥拉",
            "country_code": "AO",
            "country_name": "Angola"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "尼日利亚",
            "country_code": "NG",
            "country_name": "Nigeria"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "尼日尔",
            "country_code": "NE",
            "country_name": "Niger"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "布基纳法索",
            "country_code": "BF",
            "country_name": "Burkina"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "布隆迪",
            "country_code": "BI",
            "country_name": "Burundi"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "摩洛哥",
            "country_code": "MA",
            "country_name": "Morocco"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "斯威士兰",
            "country_code": "SZ",
            "country_name": "Swaziland"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "毛里塔尼亚",
            "country_code": "MR",
            "country_name": "Mauritania"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "毛里求斯",
            "country_code": "MU",
            "country_name": "Mauritius"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "津巴布韦",
            "country_code": "ZW",
            "country_name": "Zimbabwe"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "留尼汪",
            "country_code": "RE",
            "country_name": "Réunion"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "科摩罗",
            "country_code": "KM",
            "country_name": "The Comoros"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "科特迪瓦",
            "country_code": "CI",
            "country_name": "Cote d'Ivoire"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "突尼斯",
            "country_code": "TN",
            "country_name": "Tunisia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "索马里",
            "country_code": "SO",
            "country_name": "Somalia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "纳米比亚",
            "country_code": "NA",
            "country_name": "Namibia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "肯尼亚",
            "country_code": "KE",
            "country_name": "Kenya"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "苏丹",
            "country_code": "SD",
            "country_name": "Sudan"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "英属印度洋领地",
            "country_code": "IO",
            "country_name": "British Indian Ocean Territory"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "莫桑比克",
            "country_code": "MZ",
            "country_name": "Mozambique"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "莱索托",
            "country_code": "LS",
            "country_name": "Lesotho"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "贝宁",
            "country_code": "BJ",
            "country_name": "Benin"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "赞比亚",
            "country_code": "ZM",
            "country_name": "Zambia"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "赤道几内亚",
            "country_code": "GQ",
            "country_name": "Equatorial Guinea"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "阿尔及利亚",
            "country_code": "DZ",
            "country_name": "Algeria"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "马拉维",
            "country_code": "MW",
            "country_name": "Malawi"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "马约特",
            "country_code": "YT",
            "country_name": "Mayotte"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "马达加斯加",
            "country_code": "MG",
            "country_name": "Madagascar"
        },
        {
            "continent_cname": "非洲",
            "continent_name": "AF",
            "country_cname": "马里",
            "country_code": "ML",
            "country_name": "Mali"
        }
    ]
;

// 获取数据
function data() {
    // 字典处理
    let dickByCn = {};
    let dickByEn = {};
    let ctt = globalCountries.length;
    for (let i = 0; i < ctt; i++) {
        let gc = globalCountries[i];
        let dickDt = Object.assign({}, gc);
        dickByCn[gc.cn] = dickDt;
        dickByEn[gc.en] = Object.assign({}, dickDt);
    }

    // 数据循环
    let len = contrys.length;
    let data = [];
    for (let i = 0; i < len; i++) {
        let que = contrys[i].split('-');
        let dd = {en: que[0], zh: que[1], phone: que[2]};
        if((dickByEn[dd.en] || false)){
            dd.code = dickByEn[dd.en].code;
        }else if((dickByCn[dd.zh] || false)){
            dd.code = dickByCn[dd.zh].code;
        }
        data.push(dd);
    }
    return data;
}

function Country(){
    let len = world.length;
    let dick = {zh: {}, code: {}, en: {}};
    for (let i = 0; i < len; i++) {
        let d = world[i];
        dick.zh[d.country_cname] = d;
        dick.code[d.country_code] = d;
        dick.en[d.country_name] = d;
    }
    let dd = data();
    len = dd.length;
    for (let i = 0; i < len; i++) {
        let d2 = dd[i];
        let td = {};
        if((td = (dick.en[d2.en] || false))){
            d2.continent_zh = td.continent_cname;
            d2.continent_code = td.continent_name;
        } else if((td = (dick.zh[d2.zh] || false))){
            d2.continent_zh = td.continent_cname;
            d2.continent_code = td.continent_name;
        } else if((td = (dick.code[d2.code] || false))){
            d2.continent_zh = td.continent_cname;
            d2.continent_code = td.continent_name;
        }
        dd[i] = d2;
    }
    return dd;
}

function createSqlite() {
    let data = Country();
    const br = "\n";
    let sql = `delete from country;${br}`;
    let len = data.length;
    for (let i = 0; i < len; i++) {
        let {en, zh,phone,code,continent_zh,continent_code} = data[i];
        en = en || '';
        zh = zh || '';
        phone = phone || '';
        continent_zh = continent_zh || '';
        continent_code = continent_code || '';

        sql += `insert into country (code, cname, ename, phone_coe, continent, continent_jc) values `+
            `('${code}', '${zh}', '${en}', '${phone}', '${continent_zh}', '${continent_code}');${br}`;
    }
    return sql;
}

console.log('生成 country 表数据插入语句');
//fs.writeFileSync('./sqlite.country.sql', createSqlite());
fs.writeFileSync('./tests/sqlite.country.sql', createSqlite());
//console.log(createSqlite());