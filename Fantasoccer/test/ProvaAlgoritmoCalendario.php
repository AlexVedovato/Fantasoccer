<?php

function AlgoritmoCalendario($arrSquadre,$ngiornate)
 {
 
    $numero_squadre = count($arrSquadre);
    if ($numero_squadre % 2 == 1) {
    	    $arrSquadre[]="NULL";   // numero giocatori dispari? aggiungere un riposo (NULL)!
    	    $numero_squadre++;
    }
    /* crea gli array per le due liste in casa e fuori */
    for ($i = 0; $i < $numero_squadre /2; $i++) 
    {
        $casa[$i] = $arrSquadre[$i]; 
        $trasferta[$i] = $arrSquadre[$numero_squadre - 1 - $i];

    }
 
    for ($i = 0; $i < $ngiornate; $i++) 
    {
        /* stampa le partite di questa giornata */
        echo '<br />'.($i+1).'a Giornata<br />';
 
        /* alterna le partite in casa e fuori */
        if (($i % 2) == 0) 
        {
            for ($j = 0; $j < $numero_squadre /2 ; $j++)
            {
                 echo ' '.$trasferta[$j].' - '.$casa[$j].'<br />';
            }
        }
        else 
        {
            for ($j = 0; $j < $numero_squadre /2 ; $j++) 
            {
                 echo ' '.$casa[$j].' - '.$trasferta[$j].'<br />';
            }
                 
        }
 
        if($numero_squadre>2){
            // Ruota in gli elementi delle liste, tenendo fisso il primo elemento
            // Salva l'elemento fisso
            $pivot = $casa[0];
    
            /* sposta in avanti gli elementi di "trasferta" inserendo 
            all'inizio l'elemento casa[1] e salva l'elemento uscente in "riporto" */
            array_unshift($trasferta, $casa[1]);
            $riporto = array_pop($trasferta);

            /* sposta a sinistra gli elementi di "casa" inserendo all'ultimo 
            posto l'elemento "riporto" */
            array_shift($casa);
            array_push($casa, $riporto);
    
            // ripristina l'elemento fisso
            $casa[0] = $pivot ;
        }
    } 
} 

$ngiornate=38;

//prova con squadre pari
$arrSquadre=["a"];
AlgoritmoCalendario($arrSquadre,$ngiornate);

echo("---------------------------");

//prova con squadre dispari
$arrSquadre=["a","b","c","d","e"];
AlgoritmoCalendario($arrSquadre,$ngiornate);
?>