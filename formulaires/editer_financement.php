<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
 
include_spip('inc/actions');
include_spip('inc/editer');
 
 
function formulaires_editer_financement_charger_dist($id_financement='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
$valeurs = formulaires_editer_objet_charger('financement',$id_financement,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
return $valeurs;
}
 
/**
 * Identifier le formulaire en faisant abstraction des parametres qui ne representent pas l'objet edite
 */
function formulaires_editer_financement_identifier_dist($id_financement='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
return serialize(array(intval($id_financement)));
}
 
function formulaires_editer_financement_verifier_dist($id_financement='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
return formulaires_editer_objet_verifier('financement', $id_financement);
}
 
function formulaires_editer_financement_traiter_dist($id_financement='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
return formulaires_editer_objet_traiter('financement',$id_financement,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
}

?>

