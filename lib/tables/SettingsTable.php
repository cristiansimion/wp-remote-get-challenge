<?php

namespace CWRemote\Lib\Tables;

class SettingsTable extends \WP_List_Table {
	public $_screen;
	public $_columns;
	public $_sort_columns;
	public $_sortable;

	public $items;
	public $totalitems;

	function __construct( $screen, $columns, $items, $ajax = true ) {
		if ( is_string( $screen ) ) {
			$screen = \convert_to_screen( $screen );
		}

		$this->_screen = $screen;
		$this->items   = $items;

		if ( ! empty( $columns ) ) {
			$this->_columns = $columns;
		}

		$singular_name = __( 'settings_list', CWREMOTE_TEXT_DOMAIN );

		parent::__construct(
			[
				'singular' => $singular_name,
				'plural'   => "{$singular_name}s",
				'ajax'     => $ajax
			]
		);
	}

	public function set_sortable( $columns ) {
		$this->_sort_columns = $columns;
	}

	public function get_columns() {
		return $this->_columns;
	}

	public function prepare_items() {
		$user_id = \get_current_user_id();
		$screen  = \get_current_screen();

		if ( isset( $screen ) && is_object( $screen ) ) {
			$option = $screen->get_option( 'per_page', 'option' );

			$per_page = get_user_meta( $user_id, $option, true );
			$per_page = ! empty( $per_page ) && ! is_array( $per_page ) ? $per_page : 10;
		} else {
			$per_page = ! empty( $_GET['perpage'] ) ? esc_sql( $_GET['perpage'] ) : 10;
		}

		$this->totalitems = count( $this->items );
		$total_pages      = ceil( $this->totalitems / $per_page );

		$this->set_pagination_args( [
			"total_items" => $this->totalitems,
			"total_pages" => $total_pages,
			"per_page"    => $per_page
		] );

		if ( isset( $screen ) && is_object( $screen ) ) {
			$this->_column_headers = $this->get_column_info();
		}
	}

	public function get_column_info() {
		$columns = $this->_columns;
		$hidden  = \get_hidden_columns( $this->_screen );

		$sortable     = $this->get_sortable_columns();
		$primary_sort = 'col_id';

		return [ $columns, $hidden, $sortable, $primary_sort ];
	}

	public function get_sortable_columns() {
		$prefix   = 'col_';
		$sortable = [];

		if ( empty( $sortable ) ) {
			return [];
		}

		foreach ( $this->_sort_columns as $column ) {
			$sortable[ $prefix . $column ] = [ $column, true ];
		}

		return $sortable;
	}

	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case "date":
				return date( 'Y-m-d H:i:s', $item[ $column_name ] );
			default:
				return $item[ $column_name ];
		}
	}

	function no_items() {
		_e( "Please fetch data first.", CWREMOTE_TEXT_DOMAIN );
	}

	public function get_items() {
		return $this->items;
	}
}