<?php

use \CWRemote\Lib\Storage;

?>
<div class="cwremote-settings-header">
    <img src="<?php echo CWREMOTE_IMGS; ?>logo.svg" alt="CWRemote"/>
</div>
<div id="cwremote-settings">
    <div class="settings-page-title">
		<?php
		$default_tab = apply_filters( 'cwremote_settings_dashboard_default_tab', 'listing' );

		/**
		 * Tabs to show
         * Use the hook for additional tabs to be added
		 */
		$tabs        = apply_filters( 'cwremote_settings_dashboard_tabs', [
			'listing' => __( 'Listing', CWREMOTE_TEXT_DOMAIN ),
			'about'   => __( 'About', CWREMOTE_TEXT_DOMAIN )
		] );

		/**
         * Templates to use
         * Use the hook for additional templates to be added
         */
		$templates   = apply_filters( 'cwremote_settings_dashboard_tabs_template', [
			'listing' => 'settings_listing',
			'about'   => 'settings_about'
		] );

		$current_tab = ( isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] && in_array( $_REQUEST['tab'], array_keys( $tabs ) ) ) ? Storage::sanitize_data( $_REQUEST['tab'] ) : $default_tab;

		foreach ( $tabs as $tab_slug => $tab_label ): ?>
            <a href="?page=<?php echo $_REQUEST['page']; ?>&tab=<?php echo $tab_slug; ?>"
               class="tab <?php echo ( $current_tab == $tab_slug ) ? 'active' : ''; ?>"><?php echo $tab_label; ?></a>
		<?php endforeach; ?>
    </div>
    <div class="page-content">
		<?php
		require_once( CWREMOTE_TEMPLATE . $templates[ $current_tab ] . '.php' );
		?>
    </div>
</div>