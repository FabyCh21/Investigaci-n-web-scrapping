<?php


echo ('<h1>Web Scrapping Paola</h1>');
            $file = file_get_contents('http://es.mobafire.com/league-of-legends/campeones');
            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML($file);
            libxml_clear_errors();            

            $xpath = new DOMXPath($doc);
    
            $names = $xpath->query('//div[@class="champ-name"]');


            $nombres = array();
            for($j = 0; $j < $names->length; $j++){
                array_push($nombres, $names[$j]->nodeValue);
            }
            for($j = 0; $j < count($nombres); $j++){
                $nombres[$j]= str_replace(' ', '', $nombres[$j]);
                $nombres[$j] = strtolower($nombres[$j]);
                $nombres[$j]= str_replace("'", '', $nombres[$j]);
                $nombres[$j]= str_replace(".", '', $nombres[$j]);
            }

            for($j = 0; $j < 40; $j++){
                $file = file_get_contents('http://gameinfo.lan.leagueoflegends.com/es/game-info/champions/'.$nombres[$j].'/');
                libxml_use_internal_errors(true);
                $doc = new DOMDocument();
                $doc->loadHTML($file);
                libxml_clear_errors(); 

                $xpath = new DOMXPath($doc);

                $name = $xpath->query("//div[@class='default-2-3']/h3");
                echo "<br>".$name[0]->nodeValue."<br>";

                $campIMG = $xpath->query("//div[contains(@class,'default-1-3')]/img");
                $src = $campIMG[0]->getAttribute('src');
                echo ('<img src="'.$src.'">');

                
                

                $shortStory = $xpath->query("//div[contains(@class,'default-1-2')]/p");

                $campeonStats = $xpath->query("//span[@class='stat-value']");
                echo "<p>Vida del campeon: ".$campeonStats[0]->nodeValue."</p>";
                echo "<p>Daño de ataque: ".$campeonStats[1]->nodeValue."</p>";
                echo "<p>Velocidad de ataque: ".$campeonStats[2]->nodeValue."</p>";
                echo "<p>Velocidad de movimiento: ".$campeonStats[3]->nodeValue."</p>";
                echo "<p>Regeneración de vida: ".$campeonStats[4]->nodeValue."</p>";
                echo "<p>Armadura: ".$campeonStats[5]->nodeValue."</p>";
                echo "<p>Resistenca magica: ".$campeonStats[6]->nodeValue."</p>";
                echo "<p>Descripcion Pequeña: ".$shortStory[7]->nodeValue."</p>";

                echo "<p>Habilidades:</p>";
                $campIMG = $xpath->query("//div[contains(@id,'ability-summary')]/div/span/a/img");
                $src2 = $campIMG[0]->getAttribute('src');
                echo ('<img src="'.$src2.'">');
                $src2 = $campIMG[1]->getAttribute('src');
                echo ('<img src="'.$src2.'">');
                $src2 = $campIMG[2]->getAttribute('src');
                echo ('<img src="'.$src2.'">');
                $src2 = $campIMG[3]->getAttribute('src');
                echo ('<img src="'.$src2.'">');
                $src2 = $campIMG[4]->getAttribute('src');
                echo ('<img src="'.$src2.'">');
                echo "</br>";


                echo "<p>Aspectos:</p>";
                $skinsIMG = $xpath->query("//a[contains(@class,'skins')]/img");

                $size = 100 / $skinsIMG->length;
                for ($i = 0; $i < $skinsIMG->length; $i++){
                    $srcSkin = $skinsIMG[$i]->getAttribute('src');
                    echo ('<img src="'.$srcSkin.'" width="'.$size.'%">');
                }

                echo "<br>";
                echo "<br>";
            }  
            
        
?>

