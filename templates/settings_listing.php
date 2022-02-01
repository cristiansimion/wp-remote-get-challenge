<?php

use \CWRemote\Lib\Storage;
use \CWRemote\Lib\Tables\SettingsTable;

?>
<div>
    <a href="#"
       class="button btn btn-orange cwremote-fetch-force"><?php _e( 'Refresh data', CWREMOTE_TEXT_DOMAIN ); ?></a>
</div>
<?php
$saved = Storage::get_data_array();

// Don't proceed if we don't have any saved data.
if ( empty( $saved['data'] ) ) {
	return;
}

// Get the data segment
$data  = $saved['data'];
$title = $data['title'];

$screen = \get_current_screen();

// Create the columns definition
$rows    = isset( $data['data']['rows'] ) ? array_values( $data['data']['rows'] ) : [];
$headers = isset( $data['data']['headers'] ) ? array_values( $data['data']['headers'] ) : [];

// Make column headers translatable
$headers = array_map( function ( $item ) {
	return __( $item, CWREMOTE_TEXT_DOMAIN );
}, $headers );

// Set items to the rows
$items = $rows;

// Default message if we didn't get the data we expected
if ( empty( $headers ) || empty( $items ) ) {
	$columns = [ 'no-data' => __( 'No data to show', CWREMOTE_TEXT_DOMAIN ) ];
} else {
	$column_labels  = apply_filters( 'cwremote_settings_listing_labels', $headers );
	$column_offsets = apply_filters( 'cwremote_settings_listing_offsets', ! empty( $rows ) ? array_keys( $rows[0] ) : [] );
	$columns        = array_combine( $column_offsets, $column_labels );
}

$table = new SettingsTable( $screen, $columns, $items );

$table->set_sortable( $columns );
$table->prepare_items();
?>
<div class="row heading">
    <h2><?php _e( $title, CWREMOTE_TEXT_DOMAIN ); ?></h2>
</div>
<?php $table->display(); ?>
