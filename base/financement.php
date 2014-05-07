<?php
/**
 * Plugin Financement Participatif
 * Copyleft 2014 Jean-Emmanuel Doucet
 * Licence Art Libre
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


function financement_declarer_tables_interfaces($interfaces) {
	$interfaces['table_des_tables']['financements'] = 'financements';
	$interfaces['table_des_tables']['financements_transactions'] = 'financements_transactions';

	return $interfaces;
}

function financement_declarer_tables_objets_sql($tables) {

	$tables['spip_financements'] = array(
		'type' => "financement",
		'principale' => "oui",
		'field'=> array(
			"id_financement"      => "bigint(21) NOT NULL",
			"type"							 => "text NOT NULL DEFAULT ''",
			"titre"              => "text NOT NULL DEFAULT ''",
			"date_debut"         => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"date_echeance"      => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"montant_demande"    => "DECIMAL(18,4) NOT NULL DEFAULT ''",
			"montant_minimum"		 => "DECIMAL(18,4) NOT NULL DEFAULT ''",
			"email"							 => "text NOT NULL DEFAULT ''",
			"date_spip"          => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
		),
		'key' => array(
			"PRIMARY KEY" => "id_financement"
		),
		'titre' => "titre AS titre, '' AS lang",
		'date' => "date_spip",
		'champs_editables'  => array("type", 'titre', 'email', 'date_debut', 'date_echeance', 'montant_demande', 'montant_minimum'),
		'champs_versionnes' => array(),
		'rechercher_champs' => array(),
		'tables_jointures'  => array()
	);
	
	$tables['spip_financements_transactions'] = array(
		'type' => "financement_transaction",
		'principale' => "oui",
		'field' => array(
			"id_financement_transaction" => "bigint(21) NOT NULL",
			"id_financement" => "bigint(21) NOT NULL default 0",
			"id_paypal" => "bigint(21) NOT NULL default 0",
			"email"              => "text NOT NULL DEFAULT ''",
			"prenom"             => "text NOT NULL DEFAULT ''",
			"nom"                => "text NOT NULL DEFAULT ''",
			"adresse" 					=> "text NOT NULL DEFAULT ''",
			"montant"        => "DECIMAL(18,4) NOT NULL DEFAULT ''",
			"date"               => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"date_spip"          => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'"
		),
		'key' => array(
			"PRIMARY KEY" => "id_financement_transaction",
			"KEY id_financement" => "id_financement"
		),
		'titre' => "montant AS titre, '' AS lang",
		'date' => "date_spip",
		'champs_editables'  => array('id_financement', 'email', 'prenom', 'nom', 'montant', 'date', 'adresse'),
		'champs_versionnes' => array(),
		'rechercher_champs' => array(),
		'tables_jointures'  => array()
	);

	return $tables;
}



?>
