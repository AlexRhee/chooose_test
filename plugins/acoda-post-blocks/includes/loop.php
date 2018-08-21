<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

	/**
	 * @param $settings
	 * @param $value
	 *
	 * @since 4.2
	 * @return string
	 */


	/**
	 * @param $param
	 *
	 * @since 4.2
	 * @return string
	 */


	/**
	 * Parses loop settings and creates WP_Query according to manual
	 * @since 4.2
	 * @link http://codex.wordpress.org/Class_Reference/WP_Query
	 */
	class VcAcodaLoopQueryBuilder {

		protected $args = array(
			'post_status' => 'publish', // show only published posts 
		);

		function __construct( $data ) {
			foreach ( $data as $key => $value ) {
				$method = 'parse_' . $key;
				if ( method_exists( $this, $method ) ) {
					$this->$method( $value );
				}
			}
		}

		protected function parse_size( $value ) {
			$this->args['posts_per_page'] = 'All' === $value ? - 1 : (int) $value;
		}

		protected function parse_offset( $value ) {
			$this->args['offset'] = $value;
		}	

		protected function parse_order_by( $value ) {
			$this->args['orderby'] = $value;
		}

		protected function parse_order( $value ) {
			$this->args['order'] = $value;
		}

		protected function parse_post_type( $value ) {
			$this->args['post_type'] = $this->stringToArray( $value );
		}

		protected function parse_authors( $value ) {
			$this->args['author'] = $value;
		}

		protected function parse_categories( $value ) {
			$this->args['cat'] = $value;
		}

		protected function parse_tax_query( $value ) {
			$terms = $this->stringToArray( $value );
			if ( empty( $this->args['tax_query'] ) ) {
				$this->args['tax_query'] = array( 'relation' => 'AND' );
			}
			$negative_term_list = array();
			foreach ( $terms as $term ) {
				if ( (int) $term < 0 ) {
					$negative_term_list[] = abs( $term );
				}
			}

			$not_in = array();
			$in = array();

			$terms = get_terms( VcAcodaLoopSettings::getTaxonomies(),
				array( 'include' => array_map( 'abs', $terms ) ) );
			foreach ( $terms as $t ) {
				if ( in_array( (int) $t->term_id, $negative_term_list ) ) {
					$not_in[ $t->taxonomy ][] = $t->term_id;
				} else {
					$in[ $t->taxonomy ][] = $t->term_id;
				}
			}

			foreach ( $in as $taxonomy => $terms ) {
				$this->args['tax_query'][] = array(
					'field' => 'term_id',
					'taxonomy' => $taxonomy,
					'terms' => $terms,
					'operator' => 'IN',
				);
			}
			foreach ( $not_in as $taxonomy => $terms ) {
				$this->args['tax_query'][] = array(
					'field' => 'term_id',
					'taxonomy' => $taxonomy,
					'terms' => $terms,
					'operator' => 'NOT IN',
				);
			}
		}

		protected function parse_tags( $value ) {
			$in = $not_in = array();
			$tags_ids = $this->stringToArray( $value );
			foreach ( $tags_ids as $tag ) {
				$tag = (int) $tag;
				if ( $tag < 0 ) {
					$not_in[] = abs( $tag );
				} else {
					$in[] = $tag;
				}
			}
			$this->args['tag__in'] = $in;
			$this->args['tag__not_in'] = $not_in;
		}

		protected function parse_by_id( $value ) {
			$in = $not_in = array();
			$ids = $this->stringToArray( $value );
			foreach ( $ids as $id ) {
				$id = (int) $id;
				if ( $id < 0 ) {
					$not_in[] = abs( $id );
				} else {
					$in[] = $id;
				}
			}
			$this->args['post__in'] = $in;
			$this->args['post__not_in'] = $not_in;
		}

		public function excludeId( $id ) {
			if ( ! isset( $this->args['post__not_in'] ) ) {
				$this->args['post__not_in'] = array();
			}
			if ( is_array( $id ) ) {
				$this->args['post__not_in'] = array_merge( $this->args['post__not_in'], $id );
			} else {
				$this->args['post__not_in'][] = $id;
			}
		}

		protected function stringToArray( $value ) {
			$valid_values = array();
			$list = preg_split( '/\,[\s]*/', $value );
			foreach ( $list as $v ) {
				if ( strlen( $v ) > 0 ) {
					$valid_values[] = $v;
				}
			}

			return $valid_values;
		}

		public function build() {
			return array( $this->args, new WP_Query( $this->args ) );
		}
	}


	class VcAcodaLoopSettings {

		protected $content = array();

		protected $parts;

		protected $query_parts = array(
			'size',
			'offset',
			'order_by',
			'order',
			'post_type',
			'authors',
			'categories',
			'tags',
			'tax_query',
			'by_id',
		);

		function __construct( $value, $settings = array() ) {
			$this->parts = array(
				'size' => __( 'Post count', 'js_composer' ),
				'offset',
				'order_by' => __( 'Order by', 'js_composer' ),
				'order' => __( 'Sort order', 'js_composer' ),
				'post_type' => __( 'Post types', 'js_composer' ),
				'authors' => __( 'Author', 'js_composer' ),
				'categories' => __( 'Categories', 'js_composer' ),
				'tags' => __( 'Tags', 'js_composer' ),
				'tax_query' => __( 'Taxonomies', 'js_composer' ),
				'by_id' => __( 'Individual posts/pages', 'js_composer' ),
			);
			$this->settings = $settings;
			// Parse loop string
			$data = $this->parseData( $value );
			foreach ( $this->query_parts as $part ) {
				$value = isset( $data[ $part ] ) ? $data[ $part ] : '';
				$locked = 'true' === $this->getSettings( $part, 'locked' );
				// Predefined value check.
				if ( ! is_null( $this->getSettings( $part, 'value' ) ) && $this->replaceLockedValue( $part )
					 && ( true === $locked || 0 === strlen( (string) $value ) )
				) {
					$value = $this->settings[ $part ]['value'];
				} elseif ( ! is_null( $this->getSettings( $part, 'value' ) ) && ! $this->replaceLockedValue( $part )
						   && ( true === $locked || 0 === strlen( (string) $value ) )
				) {
					$value = implode( ',', array_unique( explode( ',', $value . ',' . $this->settings[ $part ]['value'] ) ) );
				}
				// Find custom method for parsing
				if ( method_exists( $this, 'parse_' . $part ) ) {
					$method = 'parse_' . $part;
					$this->content[ $part ] = $this->$method( $value );
				} else {
					$this->content[ $part ] = $this->parseString( $value );
				}
				// Set locked if value is locked by settings
				if ( $locked ) {
					$this->content[ $part ]['locked'] = true;
				}
				//
				if ( 'true' === $this->getSettings( $part, 'hidden' ) ) {
					$this->content[ $part ]['hidden'] = true;
				}
			}
		}

		protected function replaceLockedValue( $part ) {
			return in_array( $part, array( 'size', 'order_by', 'order' ) );
		}

		public function getLabel( $key ) {
			return isset( $this->parts[ $key ] ) ? $this->parts[ $key ] : $key;
		}

		public function getSettings( $part, $name ) {
			$settings_exists = isset( $this->settings[ $part ] ) && is_array( $this->settings[ $part ] );

			return $settings_exists && isset( $this->settings[ $part ][ $name ] ) ? $this->settings[ $part ][ $name ] : null;
		}

		public function parseString( $value ) {
			return array( 'value' => $value );
		}

		protected function parseDropDown( $value, $options = array() ) {
			return array( 'value' => $value, 'options' => $options );
		}

		protected function parseMultiSelect( $value, $options = array() ) {
			return array( 'value' => explode( ',', $value ), 'options' => $options );
		}

		public function parse_order_by( $value ) {
			return $this->parseDropDown( $value, array(
				array( 'date', __( 'Date', 'js_composer' ) ),
				'ID',
				array( 'author', __( 'Author', 'js_composer' ) ),
				array( 'title', __( 'Title', 'js_composer' ) ),
				array( 'modified', __( 'Modified', 'js_composer' ) ),
				array( 'rand', __( 'Random', 'js_composer' ) ),
				array( 'comment_count', __( 'Comment count', 'js_composer' ) ),
				array( 'menu_order', __( 'Menu order', 'js_composer' ) ),
			) );
		}

		public function parse_order( $value ) {
			return $this->parseDropDown( $value, array(
				array( 'ASC', __( 'Ascending', 'js_composer' ) ),
				array( 'DESC', __( 'Descending', 'js_composer' ) ),
			) );
		}

		public function parse_post_type( $value ) {
			$options = array();
			$args = array(
				'public' => true,
			);
			$post_types = get_post_types( $args );
			foreach ( $post_types as $post_type ) {
				if ( 'attachment' !== $post_type ) {
					$options[] = $post_type;
				}
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function parse_authors( $value ) {
			$options = $not_in = array();
			if ( empty( $value ) ) {
				return $this->parseMultiSelect( $value, $options );
			}
			$list = explode( ',', $value );
			foreach ( $list as $id ) {
				if ( (int) $id < 0 ) {
					$not_in[] = abs( $id );
				}
			}
			$users = get_users( array( 'include' => array_map( 'abs', $list ) ) );
			foreach ( $users as $user ) {
				$options[] = array(
					'value' => (string) $user->ID,
					'name' => $user->data->user_nicename,
					'action' => in_array( (int) $user->ID, $not_in ) ? '-' : '+',
				);
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function parse_categories( $value ) {
			$options = $not_in = array();
			if ( empty( $value ) ) {
				return $this->parseMultiSelect( $value, $options );
			}
			$list = explode( ',', $value );
			foreach ( $list as $id ) {
				if ( (int) $id < 0 ) {
					$not_in[] = abs( $id );
				}
			}
			$list = get_categories( array( 'include' => array_map( 'abs', $list ) ) );
			foreach ( $list as $obj ) {
				$options[] = array(
					'value' => (string) $obj->cat_ID,
					'name' => $obj->cat_name,
					'action' => in_array( (int) $obj->cat_ID, $not_in ) ? '-' : '+',
				);
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function parse_tags( $value ) {
			$options = $not_in = array();
			if ( empty( $value ) ) {
				return $this->parseMultiSelect( $value, $options );
			}
			$list = explode( ',', $value );
			foreach ( $list as $id ) {
				if ( (int) $id < 0 ) {
					$not_in[] = abs( $id );
				}
			}
			$list = get_tags( array( 'include' => array_map( 'abs', $list ) ) );
			foreach ( $list as $obj ) {
				$options[] = array(
					'value' => (string) $obj->term_id,
					'name' => $obj->name,
					'action' => in_array( (int) $obj->term_id, $not_in ) ? '-' : '+',
				);
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function parse_tax_query( $value ) {
			$options = $not_in = array();
			if ( empty( $value ) ) {
				return $this->parseMultiSelect( $value, $options );
			}
			$list = explode( ',', $value );
			foreach ( $list as $id ) {
				if ( (int) $id < 0 ) {
					$not_in[] = abs( $id );
				}
			}
			$list = get_terms( self::getTaxonomies(), array( 'include' => array_map( 'abs', $list ) ) );
			foreach ( $list as $obj ) {
				$options[] = array(
					'value' => (string) $obj->term_id,
					'name' => $obj->name,
					'action' => in_array( (int) $obj->term_id, $not_in ) ? '-' : '+',
				);
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function parse_by_id( $value ) {
			$options = $not_in = array();
			if ( empty( $value ) ) {
				return $this->parseMultiSelect( $value, $options );
			}
			$list = explode( ',', $value );
			foreach ( $list as $id ) {
				if ( (int) $id < 0 ) {
					$not_in[] = abs( $id );
				}
			}
			$list = get_posts( array( 'post_type' => 'any', 'include' => array_map( 'abs', $list ) ) );

			foreach ( $list as $obj ) {
				$options[] = array(
					'value' => (string) $obj->ID,
					'name' => $obj->post_title,
					'action' => in_array( (int) $obj->ID, $not_in ) ? '-' : '+',
				);
			}

			return $this->parseMultiSelect( $value, $options );
		}

		public function render() {
			echo json_encode( $this->content );
		}

		public function getContent() {
			return $this->content;
		}

		public static function getTaxonomies() {
			$taxonomy_exclude = (array) apply_filters( 'get_categories_taxonomy', 'category' );
			$taxonomy_exclude[] = 'post_tag';
			$taxonomies = array();
			foreach ( get_taxonomies() as $taxonomy ) {
				if ( ! in_array( $taxonomy, $taxonomy_exclude ) ) {
					$taxonomies[] = $taxonomy;
				}
			}

			return $taxonomies;
		}

		public static function buildDefault( $settings ) {
			if ( ! isset( $settings['settings'] ) || ! is_array( $settings['settings'] ) ) {
				return '';
			}
			$value = '';
			foreach ( $settings['settings'] as $key => $val ) {
				//if ( isset( $val['value'] ) ) {
					$value .= ( empty( $value ) ? '' : '|' ) . $key . ':' . $val['value'];
				//}
			}

			return $value;
		}

		public static function buildWpQuery( $query, $exclude_id = false ) {

			$data = self::parseData( $query );
			$query_builder = new VcAcodaLoopQueryBuilder( $data );
			if ( $exclude_id ) {
				$query_builder->excludeId( $exclude_id );
			}

			return $query_builder->build();
		}

		public static function parseData( $value ) {
			$data = array();
			$values_pairs = preg_split( '/\|/', $value );
			foreach ( $values_pairs as $pair ) {
				//if ( ! empty( $pair ) ) {
					list( $key, $value ) = preg_split( '/\:/', $pair );
					$data[ $key ] = $value;
				//}
			}

			return $data;
		}
	}

	function vc_acoda_build_loop_query( $query, $exclude_id = false ) {
		return VcAcodaLoopSettings::buildWpQuery( $query, $exclude_id );
	}