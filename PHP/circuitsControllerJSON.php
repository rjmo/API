<?php
 require_once("../BD/connexion.php");
 $tab=array();

 function lister(){
    global $tab,$connexion;
    $requete="SELECT * FROM circuit";
  
    try{
        $listeCircuits=mysqli_query($connexion,$requete);
        $tab[0]="OK";
        $i=1;
        while($ligne=mysqli_fetch_object($listeCircuits)){
               $tab[$i]=array();
               $tab[$i]['nomCircuit']=$ligne->nomCircuit;
               $tab[$i]['descriptionCourteCircuit']=$ligne->descriptionCourteCircuit;
               $tab[$i]['descriptionLongueCircuit']=$ligne->descriptionLongueCircuit;
               $tab[$i]['infoGeneraleCircuit']=$ligne->infoGeneraleCircuit;
               $tab[$i]['datePremierJourCircuit']=$ligne->datePremierJourCircuit;
               $tab[$i]['prixRegulierCircuit']=$ligne->prixRegulierCircuit;
               $tab[$i]['detailVersement']=$ligne->detailVersement;
               $i++;
            
        }
    }catch (Exception $e){
        $tab[0]="NOK";
    }finally {
       echo json_encode($tab);
       
    }
}

 $action=$_POST['action'];
 switch($action){

	case "lister":
		lister();
		break;

 }
 mysqli_close($connexion);