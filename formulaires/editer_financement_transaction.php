<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');


function formulaires_editer_financement_transaction_charger_dist($id_financement_transaction='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='',$id_financement){
	$valeurs = formulaires_editer_objet_charger('financement_transaction',$id_financement_transaction,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
  $valeurs['id_financement']= _request('id_financement');
	$valeurs['id_financement_transaction']= _request('id_financement_transaction');
	return $valeurs;
}

/**
 * Identifier le formulaire en faisant abstraction des parametres qui ne representent pas l'objet edite
 */
function formulaires_editer_financement_transaction_identifier_dist($id_financement_transaction='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return serialize(array(intval($id_financement_transaction)));
}

function formulaires_editer_financement_transaction_verifier_dist($id_financement_transaction='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return formulaires_editer_objet_verifier('financement_transaction', $id_financement_transaction);
}

function formulaires_editer_financement_transaction_traiter_dist($id_financement_transaction='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return formulaires_editer_objet_traiter('financement_transaction',$id_financement_transaction,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
}


?>
