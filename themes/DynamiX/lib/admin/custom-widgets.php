<?php
/*
acoda Editor Widget 
Based on the ** WP Editor Widget Plugin ** by David M&aring;rtensson, Odd Alice
Find the original plugin at - https://github.com/feedmeastraycat/wp-editor-widget
*/

class acoda_Editor_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$widget_ops = apply_filters(
			'acoda_editor_widget_ops',
			array(
				'classname' 	=> 'acoda_Editor_Widget',
				'description' 	=> esc_html__( 'Arbitrary text, HTML or rich text through the standard WordPress visual editor.', 'dynamix' ),
			)
		);

		parent::__construct(
			'acoda_Editor_Widget',
			esc_html__( 'Rich Text Editor', 'dynamix' ),
			$widget_ops
		);

	} // END __construct()

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title			= apply_filters( 'acoda_editor_widget_title', $instance['title'] );
		$output_title	= apply_filters( 'acoda_editor_widget_output_title', $instance['output_title'] );
		$content		= apply_filters( 'acoda_editor_widget_content', $instance['content'] );

		echo $before_widget;

		if ( $output_title == "1" && !empty($title) ) {
			echo $before_title . $title . $after_title;
		}

		echo $content;

		echo $after_widget;

	} // END widget()

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset($instance['title']) ) {
			$title = $instance['title'];
		}
		else {
			$title = esc_html__( 'New title', 'dynamix' );
		}

		if ( isset($instance['content']) ) {
			$content = $instance['content'];
		}
		else {
			$content = "";
		}

		$output_title = ( isset($instance['output_title']) && $instance['output_title'] == "1" ? true : false );
		?>
		<input type="hidden" id="<?php echo esc_attr( $this->get_field_id('content') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" value="<?php echo esc_attr($content); ?>">
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'dynamix' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<a href="javascript:acodaEditorWidget.showEditor('<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>');" class="button"><?php esc_html_e( 'Edit content', 'dynamix' ) ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('output_title') ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('output_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('output_title') ); ?>" value="1" <?php esc_attr( checked($output_title, true) ); ?>> <?php esc_html_e( 'Output title', 'dynamix' ); ?>
			</label>
		</p>
		<?php

	} // END form()

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title']			= ( !empty($new_instance['title']) ? strip_tags( $new_instance['title']) : '' );
		$instance['content']		= ( !empty($new_instance['content']) ? $new_instance['content'] : '' );
		$instance['output_title']	= ( isset($new_instance['output_title']) && $new_instance['output_title'] == "1" ? 1 : 0 );

		do_action( 'acoda_editor_widget_update', $new_instance, $instance );

 	 	return apply_filters( 'acoda_editor_widget_update_instance', $instance, $new_instance );

	} // END update()

} // END class WP_Editor_Widget

class acodaEditorWidget {

	/**
	 * @var string
	 */
	const VERSION = "1.0";

	/**
	 * Action: init
	 */
	public function __construct() {

		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'load-widgets.php', array( $this, 'load_admin_assets' ) );
		add_action( 'load-customize.php', array( $this, 'load_admin_assets' ) );
		add_action( 'widgets_admin_page', array( $this, 'output_acoda_editor_widget_html' ), 100 );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'output_acoda_editor_widget_html' ), 1 );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ), 2 );
		
		add_filter( 'acoda_editor_widget_content', 'wptexturize' );
		add_filter( 'acoda_editor_widget_content', 'convert_smilies' );
		add_filter( 'acoda_editor_widget_content', 'convert_chars' );
		add_filter( 'acoda_editor_widget_content', 'wpautop' );
		add_filter( 'acoda_editor_widget_content', 'shortcode_unautop' );
		add_filter( 'acoda_editor_widget_content', 'do_shortcode', 11 );

	} // END __construct()

	/**
	 * Action: load-widgets.php
	 * Action: load-customize.php
	 */
	public function load_admin_assets() 
	{
		wp_enqueue_script( 'acoda-editor-widget-js', get_template_directory_uri() . '/lib/admin/js/editor-widget.js', array( 'jquery' ), self::VERSION );
		wp_enqueue_style( 'acoda-editor-widget-css', get_template_directory_uri() . '/lib/admin/css/editor-widget.css', array(), self::VERSION );

	} // END load_admin_assets()
	
	/**
	 * Action: widgets_admin_page
	 * Action: customize_controls_print_footer_scripts
	 */
	public function output_acoda_editor_widget_html() {
		
		?>
		<div id="acoda-editor-widget-container" style="display: none;">
			<a class="close" href="javascript:acodaEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', 'dynamix' ); ?>"><span class="icon"></span></a>
			<div class="editor">
				<?php
				$settings = array(
					'textarea_rows' => 20,
				);
				wp_editor( '', 'acodaeditorwidget', $settings );
				?>
				<p>
					<a href="javascript:acodaEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php esc_html_e( 'Save and close', 'dynamix' ); ?></a>
				</p>
			</div>
		</div>
		<div id="acoda-editor-widget-backdrop" style="display: none;"></div>
		<?php
		
	} // END output_acoda_editor_widget_html
	
	/**
	 * Action: customize_controls_print_footer_scripts
	 */
	public function customize_controls_print_footer_scripts() {
	
		// Because of https://core.trac.wordpress.org/ticket/27853
		// Which was fixed in 3.9.1 so we only need this on earlier versions
		$wp_version = get_bloginfo( 'version' );
		if ( version_compare( $wp_version, '3.9.1', '<' ) && class_exists( '_WP_Editors' ) ) {
			_WP_Editors::enqueue_scripts();
		}
		
	} // END customize_controls_print_footer_scripts

	/**
	 * Action: widgets_init
	 */
	public function widgets_init() {

		register_widget( 'acoda_Editor_Widget' );

	} // END widgets_init()

} // END class acodaEditorWidget

$acoda_editor_widget = new acodaEditorWidget;