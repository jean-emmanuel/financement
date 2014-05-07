<?php
  if (!defined('_ECRIRE_INC_VERSION')) return;
  function autoriser_financement_transaction_voir_dist($faire, $type, $id, $qui, $opt) {
    return autoriser('modifier', 'financement_transaction', $id, $qui, $opt);
  }
  function autoriser_financement_transaction_modifier_dist($faire, $type, $id, $qui, $opt) {
    return in_array($qui['statut'], array('0minirezo'));
  }
  function autoriser_financement_voir_dist($faire, $type, $id, $qui, $opt) {
    return autoriser('modifier', 'financement', $id, $qui, $opt);
  }
  function autoriser_financement_modifier_dist($faire, $type, $id, $qui, $opt) {
    return in_array($qui['statut'], array('0minirezo'));
  }
?>
