<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

  function financement_upgrade($nom_meta_base_version, $version_cible){
   
  $maj = array();
  $maj['create'] = array(
  array('maj_tables', array('spip_financements','spip_financements_transactions')),
  );
   
  include_spip('base/upgrade');
  maj_plugin($nom_meta_base_version, $version_cible, $maj);
  }
   
  function financement_vider_tables($nom_meta_base_version) {
  sql_drop_table("spip_financements");
	sql_drop_table("spip_financements_transactions");

  effacer_meta($nom_meta_base_version);
  }
?>
