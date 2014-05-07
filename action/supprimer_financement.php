<?php
 
  if (!defined("_ECRIRE_INC_VERSION")) return;
   
  function action_supprimer_financement_dist() {
  $securiser_action = charger_fonction('securiser_action', 'inc');
  $arg = $securiser_action();
   
  if (!preg_match(",^(\d+)$,", $arg, $r)) {
  spip_log("action_supprimer_financement_dist $arg pas compris");
  } else {
  action_supprimer_financement_post($r[1]);
  }
  }
   
  function action_supprimer_financement_post($id_financement) {
  sql_delete("spip_financements", "id_financement=" . sql_quote($id_financement));
   
  include_spip('inc/invalideur');
  suivre_invalideur("id='id_financement/$id_financement'");
  }
?>
