<?php

// output: 470 (370 alappont + 100 többletpont)
$exampleData = [
    'valasztott-szak' => [
        'egyetem' => 'ELTE',
        'kar' => 'IK',
        'szak' => 'Programtervező informatikus',
    ],
    'erettsegi-eredmenyek' => [
        [
            'nev' => 'magyar nyelv és irodalom',
            'tipus' => 'közép',
            'eredmeny' => '70%',
        ],
        [
            'nev' => 'történelem',
            'tipus' => 'közép',
            'eredmeny' => '80%',
        ],
        [
            'nev' => 'matematika',
            'tipus' => 'emelt',
            'eredmeny' => '90%',
        ],
        [
            'nev' => 'angol nyelv',
            'tipus' => 'közép',
            'eredmeny' => '94%',
        ],
        [
            'nev' => 'informatika',
            'tipus' => 'közép',
            'eredmeny' => '95%',
        ],
    ],
    'tobbletpontok' => [
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'B2',
            'nyelv' => 'angol',
        ],
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'C1',
            'nyelv' => 'német',
        ],
    ],
];

// output: 476 (376 alappont + 100 többletpont)
$exampleData1 = [
    'valasztott-szak' => [
        'egyetem' => 'ELTE',
        'kar' => 'IK',
        'szak' => 'Programtervező informatikus',
    ],
    'erettsegi-eredmenyek' => [
        [
            'nev' => 'magyar nyelv és irodalom',
            'tipus' => 'közép',
            'eredmeny' => '70%',
        ],
        [
            'nev' => 'történelem',
            'tipus' => 'közép',
            'eredmeny' => '80%',
        ],
        [
            'nev' => 'matematika',
            'tipus' => 'emelt',
            'eredmeny' => '90%',
        ],
        [
            'nev' => 'angol nyelv',
            'tipus' => 'közép',
            'eredmeny' => '94%',
        ],
        [
            'nev' => 'informatika',
            'tipus' => 'közép',
            'eredmeny' => '95%',
        ],
        [
            'nev' => 'fizika',
            'tipus' => 'közép',
            'eredmeny' => '98%',
        ],
    ],
    'tobbletpontok' => [
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'B2',
            'nyelv' => 'angol',
        ],
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'C1',
            'nyelv' => 'német',
        ],
    ],
];

// output: hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt
$exampleData2 = [
    'valasztott-szak' => [
        'egyetem' => 'ELTE',
        'kar' => 'IK',
        'szak' => 'Programtervező informatikus',
    ],
    'erettsegi-eredmenyek' => [
        [
            'nev' => 'matematika',
            'tipus' => 'emelt',
            'eredmeny' => '90%',
        ],
        [
            'nev' => 'angol nyelv',
            'tipus' => 'közép',
            'eredmeny' => '94%',
        ],
        [
            'nev' => 'informatika',
            'tipus' => 'közép',
            'eredmeny' => '95%',
        ],
    ],
    'tobbletpontok' => [
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'B2',
            'nyelv' => 'angol',
        ],
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'C1',
            'nyelv' => 'német',
        ],
    ],
];

// output: hiba, nem lehetséges a pontszámítás a magyar nyelv és irodalom tárgyból elért 20% alatti eredmény miatt
$exampleData3 = [
    'valasztott-szak' => [
        'egyetem' => 'ELTE',
        'kar' => 'IK',
        'szak' => 'Programtervező informatikus',
    ],
    'erettsegi-eredmenyek' => [
        [
            'nev' => 'magyar nyelv és irodalom',
            'tipus' => 'közép',
            'eredmeny' => '15%',
        ],
        [
            'nev' => 'történelem',
            'tipus' => 'közép',
            'eredmeny' => '80%',
        ],
        [
            'nev' => 'matematika',
            'tipus' => 'emelt',
            'eredmeny' => '90%',
        ],
        [
            'nev' => 'angol nyelv',
            'tipus' => 'közép',
            'eredmeny' => '94%',
        ],
        [
            'nev' => 'informatika',
            'tipus' => 'közép',
            'eredmeny' => '95%',
        ],
    ],
    'tobbletpontok' => [
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'B2',
            'nyelv' => 'angol',
        ],
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'C1',
            'nyelv' => 'német',
        ],
    ],
];
function egyetem($adattomb,$valaszthato,$kotelezo, $tipus = null)
{
    $output = "";
    $erettsegi = array('magyar nyelv és irodalom','történelem','matematika');  
    $targynevek[] = null;
    $elertpont = 0;
    $tobbletpont = 0;
    $emeltek = array();
    foreach($adattomb['tobbletpontok'] as $row)
    {      
            if($row['nyelv'] == "angol")
            { 
                if($row['tipus'] == "B2" ) $tobbletpont += 28;
                else if($row['tipus'] == "C1") $tobbletpont += 40;
            }
            if($row['nyelv'] == "német")
            { 
                if($row['tipus'] == "B2") $tobbletpont += 28;
                else if($row['tipus'] == "C1") $tobbletpont += 40;
            }
    }
    foreach($adattomb['erettsegi-eredmenyek'] as $row)
    {
        
        array_push($targynevek,$row['nev']);
            if(trim($row['eredmeny'],"%") < 20) // Ha valamelyik tárgy százalék szintje alacsonyabb mint 20% akkor nem tudunk pontot számítani
            {
                return $output =  "hiba, nem lehetséges a pontszámítás a ".$row['nev']." tárgyból elért 20% alatti eredmény miatt";
            }
            else
                if(count(array_intersect($targynevek, $erettsegi)) == count($erettsegi))
                {
                    if(in_array($kotelezo[0],$targynevek)) //Ha a kötelező tárgy neve benne szerepel a elvégzett tárgyal listájában továbbmegyünk
                    {
                        if($tipus != null) //Ezt akkor vizsgálom, hogy ha a típus azaz van megadvan szint kikötés egy adott tárgynál, ha nincs megadva ez a lépés ki lesz hagyva
                        {
                            if(in_array($kotelezo[0],$row))
                            {
                                if(!in_array($row['tipus'],$tipus))
                                {
                                    $output = "hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak szintje miatt"; //Hibát dobok ha nem egyezik a kötelező tárgy szintje a kikötéssel
                                    break;
                                }
                            }
                        }
                        if(array_search('emelt',$row)) 
                        {
                            array_push($emeltek,trim($row['eredmeny'],"%"));
                            $vemelt = max($emeltek);
                            $elertpont = $elertpont + $vemelt;
                            $tobbletpont += 50;
                        }
                        
                        if($tobbletpont > 100) $tobbletpont = 100; //Ha a többletpont 100 főlött lenne akkor módosítom a többletpontot 100-ra
                        for($i = 0;$i < count($valaszthato); $i++)
                        {
                            if(in_array($valaszthato[$i],$row))
                            {
                                if(empty($emeltek)) 
                                {
                                    $vemelt = 0; //Ha nincs emeltek tömbbe semmi akkor az $vemeltz változó 0 pontos
                                }
                                
                                $eredmenyek = array();
                                
                                array_push($eredmenyek,trim($row['eredmeny'],"%"));
                                $veredmeny = max($eredmenyek); // A választható tárgyak valamelyikéből ha érettségizett az illető akkor azt eltárolom egy tömbbe, itt pedig kiválasztom, hogy melyik a maximum, mivel az lesz beleszámítva
                                $output = ($elertpont+$veredmeny)*2+$tobbletpont." pont (".(($elertpont+$veredmeny)*2)." alappont + ".$tobbletpont." többletpont)"; //Eltárolom az output változóba, amit később kiírok
                                
                            }
                            if(empty($eredmenyek)) //Megnézem, hogy van-e kötelezően választható tárgyból megadva eredmény, ha nincs, hibát dob
                                $output = "hiba, nincs kötelezően választható tárgy megadva";
                        }
                        
                    }
                    
                }
                else
                {
                    $output = "hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt";
                }
    }
    return $output; // Visszaküldöm az eredményt
}
$elteikpti = [
    'kotelezo' => 
        [
        'nev' => 'matematika'
        ]
    ,
    'kotelezoen-valaszthato' =>
    [
        [
            'nev' => 'biológia'
        ],
        [
            'nev' => 'fizika'
        ],
        [
            'nev' => 'informatika'
        ],
        [
            'nev' => 'kémia'
        ]
    ]
    ]
    ;
echo "<b>ELTE IK - Programtervező informatikus (0):</b> ".egyetem($exampleData,array_column($elteikpti['kotelezoen-valaszthato'],'nev'),array($elteikpti['kotelezo']['nev']));
echo "<br>";

echo "<b>ELTE IK - Programtervező informatikus (1):</b> ".egyetem($exampleData1,array_column($elteikpti['kotelezoen-valaszthato'],'nev'),array($elteikpti['kotelezo']['nev']));
echo "<br>";

echo "<b>ELTE IK - Programtervező informatikus (2):</b> ".egyetem($exampleData2,array_column($elteikpti['kotelezoen-valaszthato'],'nev'),array($elteikpti['kotelezo']['nev']));
echo "<br>";

echo "<b>ELTE IK - Programtervező informatikus (3):</b> ".egyetem($exampleData3,array_column($elteikpti['kotelezoen-valaszthato'],'nev'),array($elteikpti['kotelezo']['nev']));
echo "<br>";
$ppkebtk = [
    'kotelezo' => 
        [
        'nev' => 'angol nyelv',
        'tipus' => 'emelt'
        ]
    ,
    'kotelezoen-valaszthato' =>
    [
        [
            'nev' => 'francia'
        ],
        [
            'nev' => 'német'
        ],
        [
            'nev' => 'olasz'
        ],
        [
            'nev' => 'orosz'
        ],
        [
            'nev' => 'spanyol'
        ],
        [
            'nev' => 'történelem'
        ]
    ]
    ]
    ;
echo "<br>";


//Ez pedig a PPKE BTK – Anglisztika feladat lenne, nem volt minta adat rá, így készítettem egyet hozzá
$exampleData4 = [
    'valasztott-szak' => [
        'egyetem' => 'PPKE',
        'kar' => 'BTK',
        'szak' => 'Anglisztika',
    ],
    'erettsegi-eredmenyek' => [
        [
            'nev' => 'magyar nyelv és irodalom',
            'tipus' => 'közép',
            'eredmeny' => '70%',
        ],
        [
            'nev' => 'történelem',
            'tipus' => 'közép',
            'eredmeny' => '80%',
        ],
        [
            'nev' => 'matematika',
            'tipus' => 'emelt',
            'eredmeny' => '66%',
        ],
        [
            'nev' => 'angol nyelv',
            'tipus' => 'emelt',
            'eredmeny' => '94%',
        ],
        [
            'nev' => 'francia',
            'tipus' => 'közép',
            'eredmeny' => '94%',
        ],
    ],
    'tobbletpontok' => [
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'B2',
            'nyelv' => 'angol',
        ],
        [
            'kategoria' => 'Nyelvvizsga',
            'tipus' => 'C1',
            'nyelv' => 'német',
        ],
    ]
];

echo "<b>PPKE BTK – Anglisztika (saját):</b> ".egyetem($exampleData4,array_column($ppkebtk['kotelezoen-valaszthato'],'nev'),array($ppkebtk['kotelezo']['nev']),array($ppkebtk['kotelezo']['tipus']));