<?php
 
  if (!defined("_ECRIRE_INC_VERSION")) return;
   
  function action_supprimer_financement_transaction_dist() {
  $securiser_action = charger_fonction('securiser_action', 'inc');
  $arg = $securiser_action();
   
  if (!preg_match(",^(\d+)$,", $arg, $r)) {
  spip_log("action_supprimer_financement_transaction_dist $arg pas compris");
  } else {
  action_supprimer_financement_transaction_post($r[1]);
  }
  }
   
  function action_supprimer_financement_transaction_post($id_financement_transaction) {
  sql_delete("spip_financements_transactions", "id_financement_transaction=" . sql_quote($id_financement_transaction));
   
  include_spip('inc/invalideur');
  suivre_invalideur("id='id_financement_transaction/$id_financement_transaction'");
  }
?>
