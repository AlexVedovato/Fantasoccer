<?php

require_once('Database.php');

class Fantacalcio
{

    public static function checkLogin($usernameOrEmail, $password, $type)
    {
        $conn = Database::getConnection();
        $password = md5($password);
        if ($type == "Fantallenatore") {
            $query = "SELECT id_fantallenatore FROM fantallenatore WHERE (username=? or email=?) and password=?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($usernameOrEmail, $usernameOrEmail, $password));
            $result = $stmt->fetch();
            if (!empty($result)) {
                return $result["id_fantallenatore"];
            } else {
                return NULL;
            }
        } else {
            $query = "SELECT id_" . $type . " FROM " . $type . " WHERE username=? and password=?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($usernameOrEmail, $password));
            $result = $stmt->fetch();
            if (!empty($result)) {
                if ($type == "Admin") {
                    return $result["id_Admin"];
                } else {
                    return $result["id_Pagellista"];
                }
            } else {
                return NULL;
            }
        }
    }

    public static function checkUtenteEsistente($username, $email)
    {
        $conn = Database::getConnection();
        $query = "SELECT username, email FROM fantallenatore WHERE username=? or email=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($username, $email));
        $result = $stmt->fetch();
        if (!empty($result)) {
            if ($result["email"] == $email) {
                return 5;
            } else if ($result["username"] == $username) {
                return 6;
            }
        } else {
            return NULL;
        }
    }

    public static function inserisciFantallenatore($username,$email,$password,$id_fantallenatore)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO fantallenatore (
            username,
            password,
            email,
            id_fantallenatore )
            VALUES (?,?,?,?);";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($username,md5($password),$email,$id_fantallenatore));
        return $result;
    }

    public static function getNextIdFantallenatore() {
        $conn = Database::getConnection();
        $query = "SELECT max(id_fantallenatore) as MaxIdFantallenatore from fantallenatore";
        $row =$conn->query($query)->fetch();
        $id_fantallenatore= $row['MaxIdFantallenatore']+1;
        return $id_fantallenatore;
    }



    public static function getListaLeghe($id_fantallenatore)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome, fantalega.id_fantalega FROM fantalega JOIN fantalega_fantallenatore on fantalega_fantallenatore.id_fantalega = fantalega.id_fantalega WHERE fantalega_fantallenatore.id_fantallenatore = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantallenatore));
        $result = $stmt->fetchall();

        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public static function checkLega($nomeLega, $parolaOrdine)
    {
        $conn = Database::getConnection();
        $query = "SELECT id_fantalega, nome, logo FROM fantalega WHERE nome=? and parola_ordine=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($nomeLega, md5($parolaOrdine)));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public static function isCompetizioneAvviata($id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT competizione_avviataSN FROM fantalega WHERE id_fantalega=? ";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $result = $stmt->fetch();
        if($result['competizione_avviataSN']=='S'){
            return true;
        } else {
            return false;
        }
    }

    public static function getAmministratoreSN($id_fantallenatore,$id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT amministratoreSN FROM fantalega_fantallenatore WHERE id_fantallenatore=? and id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantallenatore,$id_fantalega));
        $result = $stmt->fetch();
        return $result['amministratoreSN'];
    }

    public static function inserisciFantallenatoreFantalega($amministratoreSN,$id_fantalega,$id_fantallenatore)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO fantalega_fantallenatore (
            amministratoreSN,
            id_fantalega,
            id_fantallenatore )
            VALUES (?,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($amministratoreSN,$id_fantalega,$id_fantallenatore));
        return $result;
    }

    public static function inserisciPrestazione($voto,$goal_azione,$assist,$ammonizioneSN,$espulsioneSN,$goal_subiti,$rigori_parati,$numero_giornata,$id_calciatore,$goal_decisivo_pareggioSN,$goal_decisivo_vittoriaSN,$rigori_sbagliati,$goal_rigore,$autogol,$entratoSN,$uscitoSN)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO prestazione (
            voto, 
            goal_azione, 
            assist, 
            ammonizioneSN, 
            espulsioneSN, 
            goal_subiti, 
            rigori_parati, 
            numero_giornata, 
            id_calciatore, 
            goal_decisivo_pareggioSN, 
            goal_decisivo_vittoriaSN, 
            rigori_sbagliati, 
            goal_rigore, 
            autogol, 
            entratoSN, 
            uscitoSN)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($voto,$goal_azione,$assist,$ammonizioneSN,$espulsioneSN,$goal_subiti,$rigori_parati,$numero_giornata,$id_calciatore,$goal_decisivo_pareggioSN,$goal_decisivo_vittoriaSN,$rigori_sbagliati,$goal_rigore,$autogol,$entratoSN,$uscitoSN));
        return $result;
    }

    public static function modificaPrestazione($voto,$goal_azione,$assist,$ammonizioneSN,$espulsioneSN,$goal_subiti,$rigori_parati,$numero_giornata,$id_calciatore,$goal_decisivo_pareggioSN,$goal_decisivo_vittoriaSN,$rigori_sbagliati,$goal_rigore,$autogol,$entratoSN,$uscitoSN)
    {
        $conn = Database::getConnection();
        $query = "UPDATE prestazione SET 
            voto = ?, 
            goal_azione = ?, 
            assist = ?, 
            ammonizioneSN = ?, 
            espulsioneSN = ?, 
            goal_subiti = ?, 
            rigori_parati = ?,
            goal_decisivo_pareggioSN = ?, 
            goal_decisivo_vittoriaSN = ?, 
            rigori_sbagliati = ?, 
            goal_rigore = ?, 
            autogol = ?, 
            entratoSN = ?, 
            uscitoSN = ?
            WHERE numero_giornata = ? AND id_calciatore = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($voto,$goal_azione,$assist,$ammonizioneSN,$espulsioneSN,$goal_subiti,$rigori_parati,$goal_decisivo_pareggioSN,$goal_decisivo_vittoriaSN,$rigori_sbagliati,$goal_rigore,$autogol,$entratoSN,$uscitoSN,$numero_giornata,$id_calciatore));
        return $result;
    }

    public static function eliminaPrestazione($numero_giornata,$id_calciatore) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM prestazione
                  WHERE numero_giornata = ? AND id_calciatore = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($numero_giornata,$id_calciatore));
        return $result;
    }

    public static function getNumeroLastGiornata()
    {
        $conn = Database::getConnection();
        $query = "SELECT MAX(numero_giornata) as giornata FROM Partita_serieA WHERE data_ora_inizio <= CURRENT_TIMESTAMP and rinviataSN='N'";
        $stmt = $conn->prepare($query);
        $stmt->execute(array());
        $result = $stmt->fetch();

        if (!empty($result)) {
            return $result["giornata"];
        } else {
            return NULL;
        }
    }

    public static function getNumeroNextGiornata()
    {
        return Fantacalcio::getNumeroLastGiornata()+1;
    }

    public static function getNumeroPrimaGiornata($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT min(numero_giornata) as primaGiornata FROM partita_fantacalcio where id_fantasquadra_casa in (SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?) OR id_fantasquadra_trasferta in (SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega,$id_fantalega));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["primaGiornata"];
        } else {
            return NULL;
        }
    }

    public static function getNumeroGiornate() {

        $conn = Database::getConnection();
        $query = "SELECT max(numero_giornata) as numero_giornate FROM partita_seriea";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["numero_giornate"];
        } else {
            return NULL;
        }
    }

    public static function getNomeStemmaSquadra($id_squadra_serieA)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome, stemma FROM Squadra_serieA  WHERE id_squadra_serieA=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_squadra_serieA));
        $result = $stmt->fetch();

        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public static function getNomeStemmaFantasquadra($id_fantasquadra)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome, stemma FROM fantasquadra  WHERE id_fantasquadra=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantasquadra));
        $result = $stmt->fetch();

        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public static function getPartiteGiornata($numero_giornata)
    {
        $conn = Database::getConnection();
        $query = "SELECT id_squadra_SerieA_casa, id_squadra_SerieA_trasferta, data_ora_inizio, rinviataSN FROM Partita_serieA  WHERE numero_giornata=? ORDER BY ISNULL(data_ora_inizio),data_ora_inizio";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $squadra_casa=Fantacalcio::getNomeStemmaSquadra($result["id_squadra_SerieA_casa"]);
                $squadra_trasferta=Fantacalcio::getNomeStemmaSquadra($result["id_squadra_SerieA_trasferta"]);
                $partita = array("nome_casa" => $squadra_casa["nome"], "stemma_casa" => $squadra_casa["stemma"], "nome_trasferta" => $squadra_trasferta["nome"],
                 "stemma_trasferta" => $squadra_trasferta["stemma"], "data_ora_inizio" => $result["data_ora_inizio"], "rinviataSN" => $result["rinviataSN"],
                 "id_squadra_SerieA_casa" => $result["id_squadra_SerieA_casa"], "id_squadra_SerieA_trasferta" => $result["id_squadra_SerieA_trasferta"]);
                $list[] = $partita;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getCalciatoriSquadra($id_squadra_serieA)
    {
        $conn = Database::getConnection();
        $query = "SELECT id_calciatore, nome, cognome, ruolo FROM Calciatore WHERE id_squadra_serieA=? ORDER BY ruolo";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_squadra_serieA));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_calciatore" => $result["id_calciatore"], "nome" => $result["nome"], "cognome" => $result["cognome"],
                 "ruolo" => $result["ruolo"]);
                $list[] = $calciatore;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getNumeroBonus()
    {
        $conn = Database::getConnection();
        $query = "SELECT count(*) numero_bonus FROM bonus WHERE valore_default<>0";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["numero_bonus"];
        } else {
            return NULL;
        }
    }

    public static function getImmaginiBonus()
    {
        $conn = Database::getConnection();
        $query = "SELECT descrizione,immagine FROM bonus";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $list[$result["descrizione"]] = $result["immagine"];
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getPrestazione($numero_giornata,$id_calciatore)
    {
        $conn = Database::getConnection();
        $query = "SELECT * FROM prestazione WHERE numero_giornata=? and id_calciatore=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata,$id_calciatore));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public static function getListaCalciatori() {

        $conn = Database::getConnection();
        $query = "SELECT * FROM Calciatore";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_calciatore" => $result["id_calciatore"], "nome" => $result["nome"], "cognome" => $result["cognome"],
                 "ruolo" => $result["ruolo"], "squadra" => Fantacalcio::getNomeStemmaSquadra($result["id_squadra_serieA"])["nome"], "valore" => $result["valore"], 
                 "infortunatoSCN" => $result["infortunatoSCN"], "esteroSN" => $result["esteroSN"], "squalificatoSN" => $result["squalificatoSN"], "prob_giocare" => $result["prob_giocare"]);
                $list[] = $calciatore;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getListaCalciatoriSvincolati($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT * FROM Calciatore WHERE id_calciatore NOT IN(SELECT id_calciatore FROM fantasquadra_calciatore WHERE id_fantasquadra IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?))";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_calciatore" => $result["id_calciatore"], "nome" => $result["nome"], "cognome" => $result["cognome"],
                 "ruolo" => $result["ruolo"], "squadra" => Fantacalcio::getNomeStemmaSquadra($result["id_squadra_serieA"])["nome"], "valore" => $result["valore"], 
                 "esteroSN" => $result["esteroSN"]);
                $list[] = $calciatore;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getListaCalciatoriNonSvincolati($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT * FROM Calciatore WHERE id_calciatore IN(SELECT id_calciatore FROM fantasquadra_calciatore WHERE id_fantasquadra IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?))";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_calciatore" => $result["id_calciatore"], "nome" => $result["nome"], "cognome" => $result["cognome"],
                 "ruolo" => $result["ruolo"], "squadra" => Fantacalcio::getNomeStemmaSquadra($result["id_squadra_serieA"])["nome"], "valore" => $result["valore"], 
                 "esteroSN" => $result["esteroSN"]);
                $list[] = $calciatore;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getListaSquadre() {

        $conn = Database::getConnection();
        $query = "SELECT * FROM squadra_serieA";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $squadra = array("id_squadra_serieA" => $result["id_squadra_serieA"], "nome" => $result["nome"], "stemma" => $result["stemma"]);
                $list[] = $squadra;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getListaPagellisti() {

        $conn = Database::getConnection();
        $query = "SELECT * FROM Pagellista";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $pagellista = array("username" => $result["username"], "id_pagellista" => $result["id_pagellista"]);
                $list[] = $pagellista;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getListaModuli() {
        $conn = Database::getConnection();
      $query = "SELECT * FROM modulo";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchall();
      if (!empty($results)) {
          foreach($results as $result){
              $modulo = array("id_modulo" => $result["id_modulo"], "numero_attaccanti" => $result["numero_attaccanti"], "numero_difensori" => $result["numero_difensori"],
               "numero_centrocampisti" => $result["numero_centrocampisti"]);
              $list[] = $modulo;
          }
          return $list;
      } else {
          return NULL;
      }
    }

	public static function getListaPartite(){
		$conn = Database::getConnection();
		$query = "SELECT * FROM partita_seriea";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchall();
		if (!empty($results)) {
			foreach($results as $result){
				$partita = array("data_ora_inizio" => $result["data_ora_inizio"], "rinviataSN" => $result["rinviataSN"], "numero_giornata" => $result["numero_giornata"],
				 "nome_casa" => Fantacalcio::getNomeStemmaSquadra($result["id_squadra_serieA_casa"])["nome"], "nome_trasferta" => Fantacalcio::getNomeStemmaSquadra($result["id_squadra_serieA_trasferta"])["nome"],
				 "id_squadra_serieA_casa" => $result["id_squadra_serieA_casa"], "id_squadra_serieA_trasferta" => $result["id_squadra_serieA_trasferta"]);
				$list[] = $partita;
			}
			return $list;
		} else {
			return NULL;
		}
    }
    public static function getListaBonus() {

        $conn = Database::getConnection();
        $query = "SELECT * FROM Bonus";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_bonus" => $result["id_bonus"], "descrizione" => $result["descrizione"], "immagine" => $result["immagine"], "valore_default" => $result["valore_default"]);
                $list[] = $calciatore;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getSquadre(){
		$conn = Database::getConnection();
		$query = "SELECT id_squadra_serieA,nome FROM squadra_seriea";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchall();
		if (!empty($results)) {
			foreach($results as $result){
				$squadra = array("id" => $result["id_squadra_serieA"], "nome" => $result["nome"]);
				$list[] = $squadra;
			}
			return $list;
		} else {
			return NULL;
		}
    }
    
    public static function getClassifica($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT nome,vittorie, pareggi,sconfitte,goal_fatti,goal_subiti,vittorie*3 + pareggi as punti, punteggio_totale FROM `fantasquadra` WHERE id_fantalega=?  
        ORDER BY `punti` DESC ,punteggio_totale DESC ,goal_fatti DESC,goal_subiti DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $squadra = array("nome" => $result["nome"], "vittorie" => $result["vittorie"], "pareggi" => $result["pareggi"],
                 "sconfitte" => $result["sconfitte"], "goal_fatti" => $result["goal_fatti"],  "goal_subiti" => $result["goal_subiti"],
                 "punti" => $result["punti"], "punteggio_totale" => $result["punteggio_totale"]);
                $list[] = $squadra;
            }
            return $list;
        } else {
            return NULL;
        }
    }
    
    public static function getSquadreFantalega($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT * FROM `fantasquadra` WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $classifica = array("nome" => $result["nome"],"id_fantasquadra" => $result["id_fantasquadra"],"stemma" => $result["stemma"], 
                "crediti" => $result["crediti"],"vittorie" => $result["vittorie"], "pareggi" => $result["pareggi"],"sconfitte" => $result["sconfitte"],
                 "goal_fatti" => $result["goal_fatti"],"goal_subiti" => $result["goal_subiti"],"punteggio_totale" => $result["punteggio_totale"],
                 "id_fantallenatore" => $result["id_fantallenatore"]);
                $list[] = $classifica;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getFantallenatoriFantelega($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT username,email, amministratoreSN FROM `Fantallenatore` join Fantalega_Fantallenatore USING(id_fantallenatore) where id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $Fantallenatori = array("username" => $result["username"],"email" => $result["email"],"amministratoreSN" => $result["amministratoreSN"]);
                $list[] = $Fantallenatori;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getCalciatore($id_calciatore){
		$conn = Database::getConnection();
		$query = "SELECT * FROM calciatore WHERE id_calciatore=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_calciatore));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

    public static function inserisciCalciatore($nome,$cognome,$ruolo,$id_squadra_serieA,$valore,$infortunatoSCN,$squalificatoSN,$esteroSN,$prob_giocare)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO Calciatore (
            id_calciatore, 
            nome,
            cognome,
            ruolo,
            id_squadra_serieA,
            valore,
            infortunatoSCN,
            squalificatoSN,
            esteroSN,
            prob_giocare)
            VALUES (NULL,?,?,?,?,?,?,?,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($nome,$cognome,$ruolo,$id_squadra_serieA,$valore,$infortunatoSCN,$squalificatoSN,$esteroSN,$prob_giocare));
        return $result;
    }

    public static function modificaCalciatore($id_calciatore,$nome,$cognome,$ruolo,$id_squadra_serieA,$valore,$infortunatoSCN,$squalificatoSN,$esteroSN,$prob_giocare)
    {
        $conn = Database::getConnection();
        $query = "UPDATE calciatore SET 
            nome = ?, 
            cognome = ?, 
            ruolo = ?, 
            id_squadra_serieA = ?, 
            valore = ?, 
            infortunatoSCN = ?,
            squalificatoSN = ?, 
            esteroSN = ?, 
            prob_giocare = ?
            WHERE id_calciatore = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($nome,$cognome,$ruolo,$id_squadra_serieA,$valore,$infortunatoSCN,$squalificatoSN,$esteroSN,$prob_giocare,$id_calciatore));
        return $result;
    }

    public static function eliminaCalciatore($id_calciatore) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM calciatore
                  WHERE id_calciatore = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_calciatore));
        return $result;
    }
    public static function getModulo($id_modulo){
		$conn = Database::getConnection();
		$query = "SELECT * FROM modulo WHERE id_modulo=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_modulo));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

    public static function checkModuloEsistente($numeroDifensori,$numeroCentrocampisti,$numeroAttaccanti)
    {
        $conn = Database::getConnection();
        $query = "SELECT * FROM modulo WHERE numero_difensori=? and numero_centrocampisti=? and numero_attaccanti=?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($numeroDifensori,$numeroCentrocampisti,$numeroAttaccanti));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

public static function inserisciModulo($numeroDifensori,$numeroCentrocampisti,$numeroAttaccanti)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO Modulo (
            id_modulo, 
            numero_attaccanti,
            numero_difensori,
            numero_centrocampisti)
            VALUES (NULL,?,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($numeroDifensori,$numeroCentrocampisti,$numeroAttaccanti));
        return $result;
    }

    public static function modificaModulo($id_modulo,$numeroDifensori,$numeroCentrocampisti,$numeroAttaccanti)
    {
        $conn = Database::getConnection();
        $query = "UPDATE modulo SET 
            numero_attaccanti = ?, 
            numero_difensori = ?, 
            numero_centrocampisti = ?
            WHERE id_modulo = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($numeroAttaccanti,$numeroDifensori,$numeroCentrocampisti,$id_modulo));
        return $result;
    }

    public static function eliminaModulo($id_modulo) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM modulo
                  WHERE id_modulo = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_modulo));
        return $result;
    }
	

    public static function getPartitaSerieA($numeroGiornata, $id_squadra_serieA_casa, $id_squadra_serieA_ospite){
		$conn = Database::getConnection();
		$query = "SELECT * FROM Partita_SerieA WHERE numero_giornata = ? and id_squadra_serieA_casa = ? and id_squadra_serieA_trasferta = ?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($numeroGiornata, $id_squadra_serieA_casa, $id_squadra_serieA_ospite));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

public static function inserisciPartitaSerieA($dataOraInizio,$numeroGiornata,$rinviata,$id_squadra_serieA_casa,$id_squadra_serieA_ospite)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO Partita_SerieA (
            data_ora_inizio,
            numero_giornata,
            rinviataSN, 
            id_squadra_serieA_casa,
            id_squadra_serieA_trasferta)
            VALUES (?,?,?,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($dataOraInizio,$numeroGiornata,$rinviata,$id_squadra_serieA_casa,$id_squadra_serieA_ospite));
        return $result;
    }

    public static function modificaPartitaSerieA($dataOraInizio,$numeroGiornata,$rinviata,$id_squadra_serieA_casa,$id_squadra_serieA_ospite)
    {
        $conn = Database::getConnection();
        $query = "UPDATE partita_seriea SET 
        data_ora_inizio = ?, 
        rinviataSN = ? WHERE 
        numero_giornata = ? AND 
        id_squadra_serieA_casa = ? AND 
        id_squadra_serieA_trasferta = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($dataOraInizio,$rinviata,$numeroGiornata,$id_squadra_serieA_casa,$id_squadra_serieA_ospite));
        return $result;
    }

    public static function eliminaPartitaSerieA($numeroGiornata, $id_squadra_serieA_casa, $id_squadra_serieA_ospite) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM Partita_SerieA
                  WHERE numero_giornata = ? and id_squadra_serieA_casa = ? and id_squadra_serieA_trasferta = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($numeroGiornata, $id_squadra_serieA_casa, $id_squadra_serieA_ospite));
        return $result;
    }


    public static function isAlreadyUsed($id_squadra, $numero_giornata){
		$conn = Database::getConnection();
		$query = "SELECT id_squadra_serieA_casa, id_squadra_serieA_trasferta  FROM Partita_SerieA WHERE numero_giornata = ? and (id_squadra_serieA_casa = ? or id_squadra_serieA_trasferta = ?)";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($numero_giornata, $id_squadra, $id_squadra));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return true;
		} else {
			return false;
		}
	}

    public static function checkSquadraEsistente($nome)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome FROM squadra_serieA WHERE nome=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($nome));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getSquadraSerieA($id_squadra_serieA){
		$conn = Database::getConnection();
		$query = "SELECT * FROM squadra_serieA WHERE id_squadra_serieA=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_squadra_serieA));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

    public static function inserisciSquadra($nome,$stemma)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO Squadra_serieA (
            id_squadra_serieA, 
            nome,
            stemma)
            VALUES (NULL,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($nome,$stemma));
        return $result;
    }

    public static function modificaSquadra($id_squadra_serieA,$nome,$stemma)
    {
        $conn = Database::getConnection();
        $query = "UPDATE squadra_serieA SET 
            nome = ?, 
            stemma = ?
            WHERE id_squadra_serieA = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($nome,$stemma,$id_squadra_serieA));
        return $result;
    }

    public static function modificaSquadraNoStemma($id_squadra_serieA,$nome)
    {
        $conn = Database::getConnection();
        $query = "UPDATE squadra_serieA SET 
            nome = ?
            WHERE id_squadra_serieA = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($nome,$id_squadra_serieA));
        return $result;
    }

    public static function eliminaSquadra($id_squadra_serieA) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM squadra_serieA
                  WHERE id_squadra_serieA = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_squadra_serieA));
        return $result;
    }
	
    public static function getBonus($id_bonus){
		$conn = Database::getConnection();
		$query = "SELECT * FROM bonus WHERE id_bonus=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_bonus));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

    public static function checkBonusEsistente($descrizione)
    {
        $conn = Database::getConnection();
        $query = "SELECT descrizione FROM bonus WHERE descrizione=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($descrizione));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function inserisciBonus($descrizione,$immagine,$valore_default)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO bonus (
            descrizione, 
            id_bonus,
            immagine,
            valore_default)
            VALUES (?,null,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($descrizione,$immagine,$valore_default));
        return $result;
    }

    public static function modificaBonus($id_bonus,$descrizione,$immagine,$valore_default)
    {
        $conn = Database::getConnection();
        $query = "UPDATE bonus SET 
            descrizione = ?, 
            immagine = ?,
            valore_default = ?
            WHERE id_bonus = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($descrizione,$immagine,$valore_default,$id_bonus));
        return $result;
    }

    public static function modificaBonusNoStemma($id_bonus,$descrizione,$valore_default)
    {
        $conn = Database::getConnection();
        $query = "UPDATE bonus SET 
            descrizione = ?,
            valore_default = ?
            WHERE id_bonus = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($descrizione,$valore_default,$id_bonus));
        return $result;
    }

    public static function eliminaBonus($id_bonus) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM bonus
                  WHERE id_bonus = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_bonus));
        return $result;
    }

    public static function getPagellista($id_pagellista){
		$conn = Database::getConnection();
		$query = "SELECT * FROM Pagellista WHERE id_pagellista=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_pagellista));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

public static function inserisciPagellista($username,$password)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO Pagellista (
            id_pagellista, 
            username,
            password)
            VALUES (NULL,?,?); ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($username,md5($password)));
        return $result;
    }

    public static function modificaPagellista($id_pagellista,$username,$password)
    {
        $conn = Database::getConnection();
        $query = "UPDATE Pagellista SET 
            username = ?, 
            password = ? 
            WHERE id_pagellista = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($username,md5($password),$id_pagellista));
        return $result;
    }

    public static function modificaPagellistaNoPassword($id_pagellista,$username)
    {
        $conn = Database::getConnection();
        $query = "UPDATE Pagellista SET 
            username = ?
            WHERE id_pagellista = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($username,$id_pagellista));
        return $result;
    }

    public static function eliminaPagellista($id_pagellista) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM Pagellista
                  WHERE id_pagellista = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_pagellista));
        return $result;
    }

    public static function checkPagellistaEsistente($username)
    {
        $conn = Database::getConnection();
        $query = "SELECT username FROM pagellista WHERE username=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        if (!empty($result)) {
            if ($result["username"] == $username) {
                return 5;
            }
        } else {
            return NULL;
        }
    }

    public static function getNextIdFantalega() {
        $conn = Database::getConnection();
        $query = "SELECT max(id_fantalega) as MaxIdFantalega from fantalega";
        $row =$conn->query($query)->fetch();
        $id_fantallenatore= $row['MaxIdFantalega']+1;
        return $id_fantallenatore;
    }

    public static function checkFantalegaEsistente($nome)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome FROM fantalega WHERE nome=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($nome));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function creaLega($nome,$logo,$parola_ordine,$id_fantalega,$id_fantallenatore,$crediti_iniziali, $soglia_goal,
     $punteggio_formazione_schierataN, $numero_attaccanti, $numero_difensori, $numero_centrocampisti, $numero_portieri,
      $tempo_termine_formazione, $voto_ammonito_sv,$moduli,$valori_bonus,$id_bonus)
    {
        $conn = Database::getConnection();
        $query = "START TRANSACTION;
            INSERT INTO fantalega (
            nome, 
            logo,
            parola_ordine,
            anno_fondazione,
            competizione_avviataSN,
            id_fantalega)
            VALUES (?,?,?,YEAR(CURRENT_TIMESTAMP),'N',?); 
            INSERT INTO regolamento (
            crediti_iniziali, 
            soglia_goal, 
            punteggio_formazione_schierataN, 
            numero_attaccanti, 
            numero_difensori, 
            numero_centrocampisti, 
            numero_portieri, 
            tempo_termine_formazione, 
            voto_ammonito_sv, 
            id_fantalega) 
            VALUES (?,?,?,?,?,?,?,?,?,?);
            INSERT INTO fantalega_modulo (
            id_fantalega,
            id_modulo)
            VALUES ";
        for($i=0;$i<count($moduli);$i++){
            if($i==count($moduli)-1){
                $query.="(?,?);";
            } else {
                $query.="(?,?), ";
            }
        }
        $query.="INSERT INTO fantalega_bonus (
            valore_bonus,
            id_fantalega,
            id_bonus )
            VALUES ";
        for($i=0;$i<count($valori_bonus);$i++){
            if($i==count($valori_bonus)-1){
                $query.="(?,?,?);";
            } else {
                $query.="(?,?,?), ";
            }
        }
        $query.="INSERT INTO fantalega_fantallenatore (
            amministratoreSN,
            id_fantalega,
            id_fantallenatore )
            VALUES ('S',?,?); 
        COMMIT;";
        $stmt = $conn->prepare($query);
        $array=array($nome,$logo,md5($parola_ordine),$id_fantalega,$crediti_iniziali, $soglia_goal, 
        $punteggio_formazione_schierataN, $numero_attaccanti, $numero_difensori, $numero_centrocampisti, $numero_portieri,
         $tempo_termine_formazione, $voto_ammonito_sv,$id_fantalega);
        for($i=0;$i<count($moduli);$i++){
            array_push($array,$id_fantalega,$moduli[$i]);
        }
        for($i=0;$i<count($valori_bonus);$i++){
            array_push($array,$valori_bonus[$i],$id_fantalega,$id_bonus[$i]);
        }
        array_push($array,$id_fantalega,$id_fantallenatore);
        $result = $stmt->execute($array);
        return $result;
    }

    public static function getRegolamento($id_fantalega){
		$conn = Database::getConnection();
		$query = "SELECT * FROM Regolamento WHERE id_fantalega=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantalega));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return NULL;
		}
	}

    public static function getIdModuliConsentiti($id_fantalega){
		$conn = Database::getConnection();
		$query = "SELECT id_modulo FROM fantalega_modulo WHERE id_fantalega=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantalega));
		$results = $stmt->fetchAll();
		if (!empty($results)) {
            $array=array();
            foreach($results as $result){
                array_push($array,$result["id_modulo"]);
            }
            return $array;
		} else {
			return NULL;
		}
	}

    public static function getValoriBonus($id_fantalega){
		$conn = Database::getConnection();
		$query = "SELECT valore_bonus,id_bonus FROM fantalega_bonus WHERE id_fantalega=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantalega));
		$results = $stmt->fetchAll();
		if (!empty($results)) {
			foreach($results as $result){
                $list[$result["id_bonus"]] = $result["valore_bonus"];
            }
            return $list;
		} else {
			return NULL;
		}
	}


    public static function getNextIdFantasquadra() {
        $conn = Database::getConnection();
        $query = "SELECT max(id_fantasquadra) as MaxIdFansquadra from fantasquadra";
        $row =$conn->query($query)->fetch();
        $id_fantasquadra= $row['MaxIdFansquadra']+1;
        return $id_fantasquadra;
    }

    public static function checkFantasquadraEsistente($nome, $id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT nome FROM fantasquadra WHERE nome=? and id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($nome,$id_fantalega));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCreditiInizialiFantalega($id_fantalega) {
        $conn = Database::getConnection();
        $query = "SELECT crediti_iniziali FROM regolamento WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["crediti_iniziali"];
        } else {
            return false;
        }
    }

    public static function creaSquadra($nome,$id_fantasquadra,$stemma, $id_fantallenatore, $id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "
            INSERT INTO fantasquadra (
            nome, 
            id_fantasquadra,
            stemma,
            crediti,
            vittorie,
            sconfitte,
            pareggi,
            goal_fatti,
            goal_subiti,
            punteggio_totale,
            id_fantallenatore,
            id_fantalega)
            VALUES (?,?,?,?,0,0,0,0,0,0,?,?)";
        $stmt = $conn->prepare($query);
        $array=array($nome,$id_fantasquadra,$stemma,Fantacalcio::getCreditiInizialiFantalega($id_fantalega),$id_fantallenatore, $id_fantalega);
        $result = $stmt->execute($array);
        return $result;
    }

    public static function getFantaquadra($id_fantallenatore,$id_fantalega){
		$conn = Database::getConnection();
		$query = "SELECT * FROM fantasquadra WHERE id_fantalega=? and id_fantallenatore=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantalega,$id_fantallenatore));
		$result = $stmt->fetch();
		if (!empty($result)) {
            return $result;
		} else {
			return NULL;
		}
	}

    public static function updateRegolamento($id_fantalega,$crediti_iniziali, $soglia_goal, $punteggio_formazione_schierataN, $numero_attaccanti, $numero_difensori, $numero_centrocampisti, $numero_portieri, $tempo_termine_formazione, $voto_ammonito_sv,$moduli,$valori_bonus,$id_bonus)
    {
        $conn = Database::getConnection();
        $query = "START TRANSACTION;
            UPDATE regolamento SET 
            crediti_iniziali = ?,
            soglia_goal = ?,
            punteggio_formazione_schierataN = ?,
            numero_attaccanti = ?,
            numero_difensori = ?,
            numero_centrocampisti = ?,
            numero_portieri = ?,
            tempo_termine_formazione = ?,
            voto_ammonito_sv = ?
            WHERE id_fantalega = ?;
            DELETE FROM fantalega_modulo WHERE id_fantalega = ?;
            INSERT INTO fantalega_modulo (
            id_fantalega,
            id_modulo)
            VALUES ";
        for($i=0;$i<count($moduli);$i++){
            if($i==count($moduli)-1){
                $query.="(?,?);";
            } else {
                $query.="(?,?), ";
            }
        }
        for($i=0;$i<count($valori_bonus);$i++){
            $query.="UPDATE fantalega_bonus SET
                     valore_bonus = ?
                     WHERE id_fantalega=? and id_bonus=?;";
        }
        $query.="COMMIT;";
        $stmt = $conn->prepare($query);
        $array=array($crediti_iniziali, $soglia_goal, $punteggio_formazione_schierataN, $numero_attaccanti, $numero_difensori, $numero_centrocampisti, $numero_portieri, $tempo_termine_formazione, $voto_ammonito_sv,$id_fantalega,$id_fantalega);
        for($i=0;$i<count($moduli);$i++){
            array_push($array,$id_fantalega,$moduli[$i]);
        }
        for($i=0;$i<count($valori_bonus);$i++){
            array_push($array,$valori_bonus[$i],$id_fantalega,$id_bonus[$i]);
        }
        $result = $stmt->execute($array);
        return $result;
    }

    public static function getIDSquadreFantalega($id_fantalega) {

        $conn = Database::getConnection();
        $query = "SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            $array=array();
            foreach($results as $result){
                array_push($array,$result["id_fantasquadra"]);
            }
            return $array;
        } else {
            return NULL;
        }
    }

    public static function avviaCompetizione($id_fantalega)
    {
        
        $conn = Database::getConnection();
        $query = "START TRANSACTION;
            UPDATE fantalega SET 
            competizione_avviataSN = 'S'
            where id_fantalega=?;";
        $giornataIniziale=Fantacalcio::getNumeroNextGiornata();
        $ngiornate=Fantacalcio::getNumeroGiornate()-$giornataIniziale+1;
        $squadre=Fantacalcio::getIDSquadreFantalega($id_fantalega);
        $numero_squadre = count($squadre);
        $array=array($id_fantalega);
        if ($numero_squadre % 2 == 1) {
                $squadre[]="-1";   // numero squadre dispari? aggiungo un riposo (-1)!
                $numero_squadre++;
        }
        /* crea gli array per le due liste di squadre che chiamo casa e fuori */
        for ($i = 0; $i < $numero_squadre /2; $i++) 
        {
            $casa[$i] = $squadre[$i]; 
            $trasferta[$i] = $squadre[$numero_squadre - 1 - $i];

        }
        $query.="INSERT INTO partita_fantacalcio(
            punteggio_casa, 
            punteggio_trasferta,
            numero_giornata,
            id_fantasquadra_casa,
            id_fantasquadra_trasferta) 
            VALUES ";
        for($i=0;$i<$ngiornate*($numero_squadre/2);$i++){
            $query.="(NULL, NULL, ?, ?, ?)";
            if($i+1==$ngiornate*($numero_squadre/2)){
                $query.=";";
            } else {
                $query.=",";
            }
        }
        for ($i = 0; $i < $ngiornate; $i++) 
        {
            /* alterna le partite in casa e fuori */
            if (($i % 2) == 0) 
            {
                for ($j = 0; $j < $numero_squadre /2 ; $j++)
                {
                    array_push($array,$i+$giornataIniziale,$trasferta[$j],$casa[$j]);
                }
            }
            else 
            {
                for ($j = 0; $j < $numero_squadre /2 ; $j++) 
                {
                    array_push($array,$i+$giornataIniziale,$casa[$j],$trasferta[$j]);
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
        $query.="COMMIT;";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute($array);
        return $result;
    }

    public static function getPartiteFantacalcio($id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT DISTINCT id_fantasquadra_casa, id_fantasquadra_trasferta, punteggio_casa,punteggio_trasferta,numero_giornata FROM partita_fantacalcio join fantasquadra on partita_fantacalcio.id_fantasquadra_casa=fantasquadra.id_fantasquadra or partita_fantacalcio.id_fantasquadra_trasferta=fantasquadra.id_fantasquadra WHERE id_fantalega=? ORDER BY numero_giornata";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchall();
        if (!empty($results)) {
            foreach($results as $result){
                $partita = array("id_fantasquadra_casa" => $result["id_fantasquadra_casa"], "id_fantasquadra_trasferta" => $result["id_fantasquadra_trasferta"], "punteggio_casa" => $result["punteggio_casa"], "punteggio_trasferta" => $result["punteggio_trasferta"], "numero_giornata"=> $result["numero_giornata"]);
                $list[] = $partita;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getGoals($punteggio,$id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT soglia_goal FROM regolamento WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $result = $stmt->fetch();
        if (!empty($result)) {
            if($punteggio>=66){
                return 1+floor(($punteggio-66)/$result["soglia_goal"]);
            } else {
                return 0;
            }
            
        } else {
            return NULL;
        }
    }

    public static function getFantavoto($prestazione,$id_fantalega, $isPortiere)
    {
        $conn = Database::getConnection();
        $query = "SELECT valore_bonus, descrizione FROM fantalega_bonus join bonus USING(id_bonus) WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $results = $stmt->fetchAll();
        if (!empty($results) && $prestazione!= null) {
            foreach($results as $result){
                $valore_bonus[$result["descrizione"]] = $result["valore_bonus"];
            }
            $fantavoto=$prestazione["voto"];
            if($fantavoto==-1){
                if($prestazione["ammonizioneSN"]== 'S'){
                    return Fantacalcio:: getRegolamento($id_fantalega)["voto_ammonito_SV"];
                } else if($prestazione["espulsioneSN"]== 'S'){
                    return 4; 
                }else{
                    return "SV";
                }
                
            }
            $fantavoto+=$prestazione["goal_azione"]*$valore_bonus["goal segnato"]+$prestazione["goal_rigore"]*$valore_bonus["rigore segnato"]+ 
            $prestazione["rigori_sbagliati"]*$valore_bonus["rigore sbagliato"]+$prestazione["assist"]*$valore_bonus["assist"]+
            $prestazione["autogol"]*$valore_bonus["autogol"]+$prestazione["goal_subiti"]*$valore_bonus["goal subito"]+
            $prestazione["rigori_parati"]*$valore_bonus["rigore parato"];
            if($prestazione["goal_subiti"]== 0 && $isPortiere){
               $fantavoto+=$valore_bonus["portiere imbattuto"]; 
            }
            if($prestazione["goal_decisivo_pareggioSN"]== 'S'){
                $fantavoto+=$valore_bonus["goal decisivo pareggio"]; 

            }if($prestazione["goal_decisivo_vittoriaSN"]== 'S'){
                $fantavoto+=$valore_bonus["goal decisivo vittoria"]; 
            }
            if($prestazione["ammonizioneSN"]== 'S'){
                $fantavoto+=$valore_bonus["ammonizione"];
            }
            if($prestazione["espulsioneSN"]== 'S'){
                $fantavoto+=$valore_bonus["espulsione"];
            }
            return $fantavoto; 
        } else {
            return NULL;
        }
    }

    public static function getCalciatoriFantasquadra($id_fantasquadra){ 
		$conn = Database::getConnection();
		$query = "SELECT * FROM fantasquadra_calciatore join calciatore using (id_calciatore) WHERE id_fantasquadra=? ORDER BY ruolo";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra));
		$results = $stmt->fetchall();
		if (!empty($results)) {
            foreach($results as $result){
                $calciatoreFantasquadra = array("costo_acquisto" => $result["costo_acquisto"], "id_calciatore" => $result["id_calciatore"], "id_fantasquadra" => $result["id_fantasquadra"],
                 "nome" => $result["nome"], "cognome" => $result["cognome"], "valore" => $result["valore"], "ruolo" => $result["ruolo"], "id_squadra_serieA" => $result["id_squadra_serieA"], "prob_giocare" => $result["prob_giocare"],
                 "infortunatoSCN" => $result["infortunatoSCN"], "esteroSN" => $result["esteroSN"], "squalificatoSN" => $result["squalificatoSN"]);
                $list[] = $calciatoreFantasquadra;
            }
            return $list;
        } else {
            return NULL;
        }
	}

    public static function getCreditiFantasquadra($id_fantasquadra) {
        $conn = Database::getConnection();
        $query = "SELECT crediti FROM fantasquadra WHERE id_fantasquadra=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantasquadra));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["crediti"];
        } else {
            return false;
        }
    }

    public static function svincolaCalciatore($id_calciatore, $id_fantasquadra, $costo_acquisto) {
        $conn = Database::getConnection();
        
        $query = "DELETE FROM fantasquadra_calciatore
                    WHERE id_calciatore = ? and  id_fantasquadra = ?;
                    UPDATE fantasquadra SET crediti = ? WHERE id_fantasquadra = ?;";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_calciatore, $id_fantasquadra, (Fantacalcio::getCreditiFantasquadra($id_fantasquadra)+$costo_acquisto), $id_fantasquadra));
        return $result;
    }

    public static function AcquistaCalciatore($id_calciatore, $id_fantasquadra, $costo_acquisto) {
        $conn = Database::getConnection();

        $query = "INSERT INTO fantasquadra_calciatore(
                        id_calciatore,
                        id_fantasquadra,
                        costo_acquisto)
                    VALUES (?,?,?);  
                    UPDATE fantasquadra SET crediti = ? WHERE id_fantasquadra = ?;";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute(array($id_calciatore, $id_fantasquadra, $costo_acquisto ,(Fantacalcio::getCreditiFantasquadra($id_fantasquadra)-$costo_acquisto), $id_fantasquadra));
        return $result;
    }

    public static function getProfiloFantalega($id_fantalega) {
        $conn = Database::getConnection();
        $query = "SELECT nome, logo, anno_fondazione FROM fantalega WHERE id_fantalega=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantalega));
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function getNumeroGiocatoriRuoloFantasquadra($id_fantasquadra) {
        $conn = Database::getConnection();
        $query = "SELECT ruolo from calciatore where id_calciatore in (SELECT id_calciatore FROM fantasquadra_calciatore WHERE id_fantasquadra=?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantasquadra));
        $results = $stmt->fetchAll();
        if (!empty($results)) {
            $numero_portieri=0;
            $numero_difensori=0;
            $numero_centrocampisti=0;
            $numero_attaccanti=0;
            foreach($results as $result){
                if($result["ruolo"]=="Portiere"){
                    $numero_portieri++;
                } else if($result["ruolo"]=="Difensore"){
                    $numero_difensori++;
                } else if($result["ruolo"]=="Centrocampista"){
                    $numero_centrocampisti++;
                } else {
                    $numero_attaccanti++;
                }
            }
            return array("numero_portieri" => $numero_portieri, "numero_difensori" => $numero_difensori, "numero_centrocampisti" => $numero_centrocampisti,
            "numero_attaccanti" => $numero_attaccanti);
        } else {
            return array("numero_portieri" => 0, "numero_difensori" => 0, "numero_centrocampisti" => 0, "numero_attaccanti" => 0);
        }    
    }

    public static function isGiornataInCorso($numero_giornata) {
        $conn = Database::getConnection();
        $query = "SELECT max(data_ora_inizio) as fine,min(data_ora_inizio) as inizio FROM partita_serieA WHERE numero_giornata=? and rinviataSN='N'";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata));
        $result = $stmt->fetch();
        if (!empty($result)) {
            $data_inizio=new DateTime($result["inizio"]);
            $data_fine=new DateTime($result["fine"]);
            $data_fine->add(new DateInterval('PT' . 110 . 'M'));
            if($data_fine>=new DateTime(date('Y-m-d H:i:s')) && $data_inizio<=new DateTime(date('Y-m-d H:i:s'))){ //con new DateTime(date('Y-m-d H:i:s') ottengo la data e ora del computer seguendo il formato Y-m-d H:i:s. Questo è stato fatto per scopo dimostrativo, difatti nell'applicazione reale andrebbero messe la data e ora effettive e non quelle del pc!
                return true; 
              }else{
                  return false; 
              }
        } else {
            return null;
        }
    }

    public static function isGiornataPassata($numero_giornata) {
        $conn = Database::getConnection();
        $query = "SELECT max(data_ora_inizio) as fine FROM partita_serieA WHERE numero_giornata=? and rinviataSN='N'";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata));
        $result = $stmt->fetch();
        if (!empty($result)) {
            $data_fine=new DateTime($result["fine"]);
            $data_fine->add(new DateInterval('PT' . 110 . 'M'));
            if($data_fine<=new DateTime(date('Y-m-d H:i:s'))){ //con new DateTime(date('Y-m-d H:i:s') ottengo la data e ora del computer seguendo il formato Y-m-d H:i:s. Questo è stato fatto per scopo dimostrativo, difatti nell'applicazione reale andrebbero messe la data e ora effettive e non quelle del pc!
                return true; 
              }else{
                  return false; 
              }
        } else {
            return null;
        }
    }

    public static function getPartitaFantacalcioFantasquadra($numero_giornata,$id_fantasquadra,$id_fantalega)
    {
        $conn = Database::getConnection();
        $query = "SELECT * FROM partita_fantacalcio where numero_giornata=? AND (id_fantasquadra_casa=? OR id_fantasquadra_trasferta=?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata,$id_fantasquadra,$id_fantasquadra));
        $result = $stmt->fetch();
        if (!empty($result)) {
                $squadra_casa=Fantacalcio::getNomeStemmaFantasquadra($result["id_fantasquadra_casa"]);
                $squadra_trasferta=Fantacalcio::getNomeStemmaFantasquadra($result["id_fantasquadra_trasferta"]);
                $partita = array("nome_casa" => $squadra_casa["nome"], "stemma_casa" => $squadra_casa["stemma"], "id_fantasquadra_casa" => $result["id_fantasquadra_casa"], "nome_trasferta" => $squadra_trasferta["nome"],
                "stemma_trasferta" => $squadra_trasferta["stemma"], "punteggio_casa" => $result["punteggio_casa"], "punteggio_trasferta" => $result["punteggio_trasferta"], "id_fantasquadra_trasferta" => $result["id_fantasquadra_trasferta"]);
            return $partita;
        } else {
            return NULL;
        }
    }

    public static function isGiornataCalcolata($numero_giornata, $id_fantalega) {
        $conn = Database::getConnection();
        $query = "SELECT punteggio_casa, punteggio_trasferta FROM partita_fantacalcio WHERE numero_giornata=? and (id_fantasquadra_casa IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?) OR id_fantasquadra_trasferta IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?))";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata, $id_fantalega, $id_fantalega));
        $results = $stmt->fetchAll();
        if (!empty($results)) {
            foreach($results as $result) {
                if($result["punteggio_casa"] == NULL || $result["punteggio_trasferta"] == NULL) {
                    return false; 
                }
            }
            return true; 
        }
    }

    public static function getNumeroGiornateCalcolate($id_fantalega){
        $numeroGiornateCalcolate=0;
        for($i=Fantacalcio::getNumeroPrimaGiornata($id_fantalega);$i<=Fantacalcio::getNumeroGiornate();$i++){
            if(Fantacalcio::isGiornataCalcolata($i,$id_fantalega)){
                $numeroGiornateCalcolate++;
            }
        }
        return $numeroGiornateCalcolate;
    }

    public static function getInizioGiornata($numero_giornata, $id_fantalega) {
        $conn = Database::getConnection();
        $query = "SELECT YEAR(min(data_ora_inizio)) as anno, MONTHNAME(min(data_ora_inizio)) as mese, DAY(min(data_ora_inizio)) as giorno, HOUR(min(data_ora_inizio)) as ora, MINUTE (min(data_ora_inizio)) as minuti FROM partita_serieA WHERE numero_giornata=? and rinviataSN='N'";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata));
        $result = $stmt->fetch();
        if (!empty($result)) {
            $query = "SELECT tempo_termine_formazione FROM regolamento WHERE id_fantalega=?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($id_fantalega));
            $result2 = $stmt->fetch();
            $result["ora"]=$result["ora"]-floor($result2["tempo_termine_formazione"]/60);
            $result["minuti"]=($result["minuti"])-($result2["tempo_termine_formazione"]-floor($result2["tempo_termine_formazione"]/60)*60);
            if($result["minuti"]<0) {
                $result["minuti"]+=60;
                $result["ora"]--;
            } 
            return $result["mese"].' '.$result["giorno"].', '.$result["anno"].' '.$result["ora"].':'.$result["minuti"].':00';
        } else {
            return null;
        }
    }

    public static function getModuloFormazione($id_fantasquadra, $numero_giornata){
		$conn = Database::getConnection();
		$query = "SELECT id_modulo FROM formazione WHERE id_fantasquadra=? and numero_giornata=? ";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra,$numero_giornata));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result["id_modulo"];
		} else {
			return NULL;
		}
	}

    public static function getCalciatoriFormazione($id_fantasquadra, $numero_giornata){
        $conn = Database::getConnection();
		$query = "SELECT id_calciatore FROM formazione_calciatore WHERE id_fantasquadra=? and numero_giornata=? ORDER BY ordine";
    
        $stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra,$numero_giornata));
        $results = $stmt->fetchAll();
		if (!empty($results)) {
            foreach($results as $result){
                $calciatore = array("id_calciatore" => $result["id_calciatore"]);
                $list[] = $calciatore;
            }
            return $list;
		} else {
			return NULL;
		}

    }
   
    public static function  getPartitaFantacalcio($id_fantasquadra_casa,  $id_fantasquadra_trasferta, $numero_giornata){
		$conn = Database::getConnection();
		$query = "SELECT punteggio_casa, punteggio_trasferta FROM partita_fantacalcio WHERE id_fantasquadra_casa=? and id_fantasquadra_trasferta=? and numero_giornata=?  ";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra_casa,$id_fantasquadra_trasferta,$numero_giornata));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return $result;
		} else {
			return null;
		}
	}

    public static function getFantallenatore($id_fantallenatore) {
        $conn = Database::getConnection();
        $query = "SELECT username, email FROM Fantallenatore where id_fantallenatore=?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id_fantallenatore));
        $result = $stmt->fetch();
        if (!empty($result)) {
			return $result;
		} else {
			return null;
		}
    }

    public static function getDatiFantaquadra($id_fantasquadra){
		$conn = Database::getConnection();
		$query = "SELECT * FROM fantasquadra join Fantallenatore USING(id_fantallenatore) WHERE id_fantasquadra=?";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra));
		$result = $stmt->fetch();
		if (!empty($result)) {
            return array("id_fantasquadra" => $result["id_fantasquadra"], "id_fantallenatore" => $result["id_fantallenatore"], "username" => $result["username"], "email" => $result["email"], "nome" => $result["nome"], "crediti" => $result["crediti"], "vittorie" => $result["vittorie"], "pareggi" => $result["pareggi"], "sconfitte" => $result["sconfitte"], "goal_fatti" => $result["goal_fatti"], "goal_subiti" => $result["goal_subiti"], "punteggio_totale" => $result["punteggio_totale"], "stemma" => $result["stemma"]);
		} else {
			return NULL;
		}
	}

    public static function inserisciFormazione($id_fantasquadra, $numero_giornata, $id_modulo, $portieri, $difensori, $centrocampisti, $attaccanti)
    {
        $conn = Database::getConnection();
        $query = "START TRANSACTION;
            INSERT INTO formazione (
            numero_giornata, 
            id_fantasquadra,
            id_modulo)
            VALUES (?,?,?);";
        for($i=1;$i<=21;$i++){
            $query.="INSERT INTO formazione_calciatore (
                ordine, 
                numero_giornata,
                id_fantasquadra,
                id_calciatore)
                VALUES (".$i.",?,?,?);";
        }
        $query.="COMMIT;";
        $stmt = $conn->prepare($query);
        $array=array($numero_giornata, $id_fantasquadra, $id_modulo, $numero_giornata, $id_fantasquadra, $portieri[0]);
        $numeri_modulo=Fantacalcio::getModulo($id_modulo);
        for($i=0;$i<$numeri_modulo["numero_difensori"];$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$difensori[$i]);
        }
        for($i=0;$i<$numeri_modulo["numero_centrocampisti"];$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$centrocampisti[$i]);
        }
        for($i=0;$i<$numeri_modulo["numero_attaccanti"];$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$attaccanti[$i]);
        }
        array_push($array,$numero_giornata,$id_fantasquadra,$portieri[1]);
        for($i=$numeri_modulo["numero_difensori"];$i<$numeri_modulo["numero_difensori"]+3;$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$difensori[$i]);
        }
        for($i=$numeri_modulo["numero_centrocampisti"];$i<$numeri_modulo["numero_centrocampisti"]+3;$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$centrocampisti[$i]);
        }
        for($i=$numeri_modulo["numero_attaccanti"];$i<$numeri_modulo["numero_attaccanti"]+3;$i++){
            array_push($array,$numero_giornata,$id_fantasquadra,$attaccanti[$i]);
        }
        $result = $stmt->execute($array);
        return $result;
    }

    public static function isFormazioneInserita($id_fantasquadra, $numero_giornata){
		$conn = Database::getConnection();
		$query = "SELECT id_modulo FROM formazione WHERE id_fantasquadra=? and numero_giornata=? ";
		$stmt = $conn->prepare($query);
		$stmt->execute(array($id_fantasquadra,$numero_giornata));
		$result = $stmt->fetch();
		if (!empty($result)) {
			return true;
		} else {
			return false;
		}
	}

    public static function calcolaGiornata($numero_giornata, $id_fantalega) {
        $conn = Database::getConnection();
        $query = "SELECT * FROM partita_fantacalcio WHERE numero_giornata=? and (id_fantasquadra_casa IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?) OR id_fantasquadra_trasferta IN(SELECT id_fantasquadra FROM fantasquadra WHERE id_fantalega=?))";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($numero_giornata, $id_fantalega, $id_fantalega));
        $results = $stmt->fetchAll();
        if (!empty($results)) {
            $query = "SELECT punteggio_formazione_schierataN,soglia_goal FROM regolamento WHERE id_fantalega=?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($id_fantalega));
            $regolamento=$stmt->fetch();
            $punteggio_formazione_schierataN = $regolamento["punteggio_formazione_schierataN"];
            $soglia_goal = $regolamento["soglia_goal"];
            foreach($results as $result){
                $query = "SELECT id_modulo FROM formazione WHERE numero_giornata=? and id_fantasquadra=?";
                $stmt = $conn->prepare($query);
                $stmt->execute(array($numero_giornata,$result["id_fantasquadra_casa"]));
                $id_modulo_casa = $stmt->fetch()["id_modulo"];
                $stmt = $conn->prepare($query);
                $stmt->execute(array($numero_giornata,$result["id_fantasquadra_trasferta"]));
                $id_modulo_trasferta = $stmt->fetch()["id_modulo"];
                if($id_modulo_casa!=null && $id_modulo_trasferta!=null){
                    $numeri_modulo_casa=Fantacalcio::getModulo($id_modulo_casa);
                    $calciatori_casa=Fantacalcio::getCalciatoriFormazione($result["id_fantasquadra_casa"],$numero_giornata);
                    $punteggio_casa=0;
                    $cambi_casa=0;
                    $indice_panchina_difensori=12;
                    $indice_panchina_centrocampisti=15;
                    $indice_panchina_attaccanti=18;
                    for($j=0;$j<11;$j++){
                        $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_casa[$j]["id_calciatore"]);
                        if($prestazione==null || Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)=="SV"){
                            if($j==0){
                                $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_casa[11]["id_calciatore"]);
                                if($prestazione!=null && Fantacalcio::getFantavoto($prestazione,$id_fantalega,true)!="SV"){
                                    $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,true);
                                    $cambi_casa++;
                                }
                            } else if($j<=$numeri_modulo_casa["numero_difensori"] && $cambi_casa<3){
                                for(;$indice_panchina_difensori<15;$indice_panchina_difensori++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_casa[$indice_panchina_difensori]["id_calciatore"]);
                                    if($prestazione!=null && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_casa++;
                                        $indice_panchina_difensori++;
                                        break;
                                    }
                                }
                            } else if($j<=$numeri_modulo_casa["numero_centrocampisti"]+$numeri_modulo_casa["numero_difensori"] && $cambi_casa<3){
                                for(;$indice_panchina_centrocampisti<18;$indice_panchina_centrocampisti++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_casa[$indice_panchina_centrocampisti]["id_calciatore"]);
                                    if($prestazione!=null && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_casa++;
                                        $indice_panchina_centrocampisti++;
                                        break;
                                    }
                                }
                            } else if($cambi_casa<3){
                                for(;$indice_panchina_attaccanti<21;$indice_panchina_attaccanti++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_casa[$indice_panchina_attaccanti]["id_calciatore"]);
                                    if($prestazione!=null && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_casa++;
                                        $indice_panchina_attaccanti++;
                                        break;
                                    }
                                }
                            }
                        } else {
                            if($j==0){
                                $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,true);
                            } else {
                                $punteggio_casa+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                            }
                        }
                    }
                    $numeri_modulo_trasferta=Fantacalcio::getModulo($id_modulo_trasferta);
                    $calciatori_trasferta=Fantacalcio::getCalciatoriFormazione($result["id_fantasquadra_trasferta"],$numero_giornata);
                    $punteggio_trasferta=0;
                    $cambi_trasferta=0;
                    $indice_panchina_difensori=12;
                    $indice_panchina_centrocampisti=15;
                    $indice_panchina_attaccanti=18;
                    for($j=0;$j<11;$j++){
                        $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_trasferta[$j]["id_calciatore"]);
                        if($prestazione==null || Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)=="SV"){
                            if($j==0){
                                $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_trasferta[11]["id_calciatore"]);
                                if($prestazione!=null  && Fantacalcio::getFantavoto($prestazione,$id_fantalega,true)!="SV"){
                                    $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,true);
                                    $cambi_trasferta++;
                                }
                            } else if($j<=$numeri_modulo_trasferta["numero_difensori"] && $cambi_trasferta<3){
                                for(;$indice_panchina_difensori<15;$indice_panchina_difensori++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_trasferta[$indice_panchina_difensori]["id_calciatore"]);
                                    if($prestazione!=null  && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_trasferta++;
                                        $indice_panchina_difensori++;
                                        break;
                                    }
                                }
                            } else if($j<=$numeri_modulo_trasferta["numero_centrocampisti"]+$numeri_modulo_trasferta["numero_difensori"] && $cambi_trasferta<3){
                                for(;$indice_panchina_centrocampisti<18;$indice_panchina_centrocampisti++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_trasferta[$indice_panchina_centrocampisti]["id_calciatore"]);
                                    if($prestazione!=null  && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_trasferta++;
                                        $indice_panchina_centrocampisti++;
                                        break;
                                    }
                                }
                            } else if($cambi_trasferta<3){
                                for(;$indice_panchina_attaccanti<21;$indice_panchina_attaccanti++){
                                    $prestazione=Fantacalcio::getPrestazione($numero_giornata,$calciatori_trasferta[$indice_panchina_attaccanti]["id_calciatore"]);
                                    if($prestazione!=null  && Fantacalcio::getFantavoto($prestazione,$id_fantalega,false)!="SV"){
                                        $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                                        $cambi_trasferta++;
                                        $indice_panchina_attaccanti++;
                                        break;
                                    }
                                }
                            }
                        } else {
                            if($j==0){
                                $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,true);
                            } else {
                                $punteggio_trasferta+=Fantacalcio::getFantavoto($prestazione,$id_fantalega,false);
                            }
                        }
                    }
                    $goal_casa=Fantacalcio::getGoals($punteggio_casa,$id_fantalega);
                    $goal_trasferta=Fantacalcio::getGoals($punteggio_trasferta,$id_fantalega);
                    $query = "UPDATE partita_fantacalcio SET punteggio_trasferta = ?, punteggio_casa=? WHERE id_fantasquadra_casa=? and id_fantasquadra_trasferta=? and numero_giornata=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_trasferta,$punteggio_casa,$result["id_fantasquadra_casa"],$result["id_fantasquadra_trasferta"],$numero_giornata));
                    if($goal_casa>$goal_trasferta){
                        $query = "UPDATE fantasquadra SET vittorie = vittorie+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_casa,$goal_trasferta,$punteggio_casa,$result["id_fantasquadra_casa"]));
                        $query = "UPDATE fantasquadra SET sconfitte = sconfitte+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_trasferta,$goal_casa,$punteggio_trasferta,$result["id_fantasquadra_trasferta"]));
                    } else if($goal_casa<$goal_trasferta){
                        $query = "UPDATE fantasquadra SET sconfitte = sconfitte+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_casa,$goal_trasferta,$punteggio_casa,$result["id_fantasquadra_casa"]));
                        $query = "UPDATE fantasquadra SET vittorie = vittorie+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_trasferta,$goal_casa,$punteggio_trasferta,$result["id_fantasquadra_trasferta"]));
                    } else {
                        $query = "UPDATE fantasquadra SET pareggi = pareggi+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_casa,$goal_trasferta,$punteggio_casa,$result["id_fantasquadra_casa"]));
                        $query = "UPDATE fantasquadra SET pareggi = pareggi+1, goal_fatti=goal_fatti+?, goal_subiti=goal_subiti+?, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(array($goal_trasferta,$goal_casa,$punteggio_trasferta,$result["id_fantasquadra_trasferta"]));
                    }
                } else if($id_modulo_casa==null && $id_modulo_trasferta!=null){
                    $query = "UPDATE partita_fantacalcio SET punteggio_trasferta = ?, punteggio_casa=? WHERE id_fantasquadra_casa=? and id_fantasquadra_trasferta=? and numero_giornata=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array(66+$soglia_goal*2,$punteggio_formazione_schierataN,$result["id_fantasquadra_casa"],$result["id_fantasquadra_trasferta"],$numero_giornata));
                    $query = "UPDATE fantasquadra SET vittorie = vittorie+1, goal_fatti=goal_fatti+3, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array(66+$soglia_goal*2,$result["id_fantasquadra_trasferta"]));
                    $query = "UPDATE fantasquadra SET sconfitte = sconfitte+1, goal_subiti=goal_subiti+3, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_formazione_schierataN,$result["id_fantasquadra_casa"]));
                } else if($id_modulo_casa!=null && $id_modulo_trasferta==null){
                    $query = "UPDATE partita_fantacalcio SET punteggio_casa = ?, punteggio_trasferta=? WHERE id_fantasquadra_casa=? and id_fantasquadra_trasferta=? and numero_giornata=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array(66+$soglia_goal*2,$punteggio_formazione_schierataN,$result["id_fantasquadra_casa"],$result["id_fantasquadra_trasferta"],$numero_giornata));
                    $query = "UPDATE fantasquadra SET vittorie = vittorie+1, goal_fatti=goal_fatti+3, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array(66+$soglia_goal*2,$result["id_fantasquadra_casa"]));
                    $query = "UPDATE fantasquadra SET sconfitte = sconfitte+1, goal_subiti=goal_subiti+3, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_formazione_schierataN,$result["id_fantasquadra_trasferta"]));
                } else {
                    $query = "UPDATE partita_fantacalcio SET punteggio_casa = ?, punteggio_trasferta=? WHERE id_fantasquadra_casa=? and id_fantasquadra_trasferta=? and numero_giornata=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_formazione_schierataN,$punteggio_formazione_schierataN,$result["id_fantasquadra_casa"],$result["id_fantasquadra_trasferta"],$numero_giornata));
                    $query = "UPDATE fantasquadra SET pareggi = pareggi+1, punteggio_totale=punteggio_totale+?  WHERE id_fantasquadra=?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_formazione_schierataN,$result["id_fantasquadra_casa"]));
                    $stmt = $conn->prepare($query);
                    $stmt->execute(array($punteggio_formazione_schierataN,$result["id_fantasquadra_trasferta"]));
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getDatiCalciatore($id_calciatore, $id_fantalega, $isPortiere){
        $conn = Database::getConnection();
		$query = "SELECT * FROM prestazione WHERE id_calciatore=?";
        $stmt = $conn->prepare($query);
		$stmt->execute(array($id_calciatore));
        $results = $stmt->fetchAll();
		if (!empty($results)) {
            $goal=0;
            $goal_rigore=0;
            $ammonizioni=0;
            $espulsioni=0;
            $media_voto=0;
            $media_fantavoto=0;
            $autogol=0;
            $assist=0;
            $goal_subiti=0;
            $rigori_parati=0;
            $numeroPrestazioni=0;
            $portaInviolata=0;
            foreach($results as $result){
                $numeroPrestazioni++;
                $goal+=$result["goal_azione"]+$result["goal_rigore"];
                $goal_rigore+=$result["goal_rigore"];
                $assist+=$result["assist"];
                $rigori_parati+=$result["rigori_parati"];
                $goal_subiti+=$result["goal_subiti"];
                $media_voto+=$result["voto"];
                $rigori_totali=$result["goal_rigore"]+$result["rigori_sbagliati"];
                $media_fantavoto+=Fantacalcio::getFantavoto($result, $id_fantalega, $isPortiere);
                $autogol+=$result["autogol"];
                if($result["ammonizioneSN"]=="S"){
                    $ammonizioni++;
                }
                if($result["espulsioneSN"]=="S"){
                    $espulsioni++;
                }
                if($result["goal_subiti"]==0){
                    $portaInviolata++;
                }
            }
            $media_voto = $media_voto/$numeroPrestazioni;
            $media_fantavoto = $media_fantavoto/$numeroPrestazioni;
            $calciatore = array("numeroPrestazioni" => $numeroPrestazioni, "goal" => $goal, "assist" => $assist, "rigori_parati" => $rigori_parati, 
            "goal_subiti" => $goal_subiti, "media_voto" => $media_voto, "media_fantavoto" => $media_fantavoto, "autogol" => $autogol, "ammonizioni" => $ammonizioni, 
            "espulsioni" => $espulsioni, "portaInviolata" => $portaInviolata, "goal_rigore" => $goal_rigore, "rigori_totali" => $rigori_totali);
            return $calciatore;
		} else {
			return NULL;
		}

    }
}
    