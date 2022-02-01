<?php

namespace CWRemote\Lib;

class Template {

	static $data;

	/**
	 * @param array $data : [data => '', 'timestamp' => '']
	 *
	 * @return array $data
	 */
	static function set_data( $data ) {
		self::$data = $data['data'];

		return self::$data;
	}

	/**
	 * @param string $template : Template file name in the templates folder
	 */
	static function load( $template ) {
		include CWREMOTE_TEMPLATE . $template . '.php';
	}

	/**
	 * Renders headers for the table
	 *
	 * @param $headers
	 */
	static function render_table_header( $headers ) {

		// Return empty if no headers provided
		if ( empty( $headers ) ) {
			return;
		}
		?>
        <thead>
		<?php foreach ( $headers as $header ): ?>
            <th><?php _e( $header, CWREMOTE_TEXT_DOMAIN ); ?></th>
		<?php endforeach; ?>
        </thead>
		<?php
	}

	/**
	 * Renders row for the table
	 *
	 * @param $row
	 */
	static function render_row( $row ) {
		// Return empty if no data was provided
		if ( empty( $row ) ) {
			return;
		}

		// Loop through the items
		foreach ( $row as $column_key => $column_value ): ?>
			<?php
			if ( strstr( $column_key, 'date' ) ) {
				$column_value = apply_filters( 'cwremote_date_format', date( 'Y-m-d H:i:s', $column_value ), $column_value );
			}
			?>
            <td class="col-<?php echo $column_key ?>"><?php echo $column_value; ?></td>
		<?php endforeach;
	}
}