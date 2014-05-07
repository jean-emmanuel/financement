<?php

require "ipn.class.php";

$p = new ipn_class;
$p->testing=false;

if ($p->validate_ipn()) {
	if($p->ipn_data['payment_status']=='Completed')
	{
	
		//Charger SPIP (du plugin Transaction, merci à Arnault Pachot, Emmanuel Nurit !)
		if (!defined('_ECRIRE_INC_VERSION')) {
				    // recherche du loader SPIP.
				    $deep = 2;
				    $lanceur ='ecrire/inc_version.php';
				    $include = '../../'.$lanceur;
				    while (!defined('_ECRIRE_INC_VERSION') && $deep++ < 6) { 
				          // attention a pas descendre trop loin tout de meme !
				            // plugins/zone/stable/nom/version/tests/ maximum cherche
				            $include = '../' . $include;
				            if (file_exists($include)) {
				                    chdir(dirname(dirname($include)));
				                    require $lanceur;
				            }
				    }       
		}
		if (!defined('_ECRIRE_INC_VERSION')) {
				    die("<strong>Echec :</strong> SPIP ne peut pas etre demarr&eacute;.<br />
				            Vous utilisez certainement un lien symbolique dans votre r&eacute;pertoire plugins.");
		}
		include_spip('base/abstract_sql');	
		
		
		// On chope les données	
		$quantity = "";
		if ($p->ipn_data['quantity1']>1) {
	    $quantity = $p->ipn_data['quantity1'] . " exemplaires\n" ;
	  } elseif ($p->ipn_data['quantity1']==1)  {
	    $quantity = "1 exemplaire\n" ;
	  }
		$amount = $p->ipn_data['mc_gross'];
		$id_paypal = $p->ipn_data['txn_id'];
		$email = $p->ipn_data['payer_email'];
		$prenom = $p->ipn_data['first_name'];
		$nom = $p->ipn_data['last_name'];
		$adresse =  $quantity . $p->ipn_data['address_name'] . "\n" . $p->ipn_data['address_street'] . "\n" . $p->ipn_data['address_zip'] . "\n" . $p->ipn_data['address_city'] . "\n" . $p->ipn_data['address_country'] . "\n" . $p->ipn_data['address_state'];
		$id_financement = $_GET['id_financement'];
		$date= date("Y-m-d H:i:s");
		
		
		
		// On popule !
		
		 sql_insertq('spip_financements_transactions', array(
		 'id_financement' => $id_financement,
		 'montant' => $amount,
		 'id_paypal' => $id_paypal,
		 'email' => $email,
		 'prenom' => $prenom,
		 'nom' => $nom,
		 'adresse' => $adresse,
		 'date' => $date,
		 ), 'id_paypal=' . $id_paypal);
	
	}
}
?>
