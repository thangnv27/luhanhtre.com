<?php
/**
 * Extension-Boilerplate
 *
 * @link        https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link        https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     demo_importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.3
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_demo_importer' ) ) {

	class ReduxFramework_extension_demo_importer {

		public static $instance;

		static $version = "1.0.3";

		protected $parent;

		private $filesystem = array();

		public $extension_url;

		public $extension_dir;

		public $demo_data_dir;

		public $data_import_files = array();

		public $active_import_id;

		public $active_import;

		/**
		 * Class Constructor
		 *
		 * @since       1.0
		 * @access      public
		 * @return      void
		 */
		public function __construct( $parent ) {

			$this->parent = $parent;

			if ( !is_admin() ) {
				return;
			}

			//Hides importer section if anything but true returned. Way to abort :)
			if ( true !== apply_filters( 'demo_importer_abort', true ) ) {
				return;
			}

			if ( empty( $this->extension_dir ) ) {
				$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
				$this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
				$this->demo_data_dir = apply_filters( "demo_importer_dir_path", $this->extension_dir . 'demo-data/' );
			}

			//Delete saved options of imported demos, for dev/testing purpose
			// delete_option('data_imported_demos');

			$this->getImports();

			$this->field_name = 'demo_importer';

			self::$instance = $this;

			add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
				'overload_field_path'
			) );

			add_action( 'wp_ajax_redux_demo_importer', array(
				$this,
				'ajax_importer'
			) );

			add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/demo_importer_files', array(
				$this,
				'addImportFiles'
			) );

			//Adds Importer section to panel
			$this->add_importer_section();

			include TRAVELWP_THEME_DIR . '/inc/admin/demo_importer/inc/class-demo-importer-progress.php';
			$demo_progress = new demo_importer_Progress( $this->parent );
		}

		/**
		 * Get the demo folders/files
		 * Provided fallback where some host require FTP info
		 *
		 * @return array list of files for demos
		 */
		public function demoFiles() {

			$this->filesystem = $this->parent->filesystem->execute( 'object' );
			$dir_array        = $this->filesystem->dirlist( $this->demo_data_dir, false, true );

			if ( !empty( $dir_array ) && is_array( $dir_array ) ) {

				uksort( $dir_array, 'strcasecmp' );

				return $dir_array;

			} else {

				$dir_array = array();

				$demo_directory = array_diff( scandir( $this->demo_data_dir ), array( '..', '.' ) );

				if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {
					foreach ( $demo_directory as $key => $value ) {
						if ( is_dir( $this->demo_data_dir . $value ) ) {

							$dir_array[$value] = array( 'name' => $value, 'type' => 'd', 'files' => array() );

							$demo_content = array_diff( scandir( $this->demo_data_dir . $value ), array( '..', '.' ) );

							foreach ( $demo_content as $d_key => $d_value ) {
								if ( is_file( $this->demo_data_dir . $value . '/' . $d_value ) ) {
									$dir_array[$value]['files'][$d_value] = array( 'name' => $d_value, 'type' => 'f' );
								}
							}
						}
					}

					uksort( $dir_array, 'strcasecmp' );
				}
			}

			return $dir_array;
		}


		public function getImports() {

			if ( !empty( $this->data_import_files ) ) {
				return $this->data_import_files;
			}

			$imports = $this->demoFiles();

			$imported = get_option( 'data_imported_demos' );

			if ( !empty( $imports ) && is_array( $imports ) ) {
				$x = 1;
				foreach ( $imports as $import ) {
					if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
						continue;
					}

					if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
						$this->data_import_files['data-import-' . $x]              = isset( $this->data_import_files['data-import-' . $x] ) ? $this->data_import_files['data-import-' . $x] : array();
						$this->data_import_files['data-import-' . $x]['directory'] = $import['name'];

						if ( !empty( $imported ) && is_array( $imported ) ) {
							foreach ( $imported as $key => $value ) {
								if ( isset( $value['directory'] ) && $value['directory'] == $import['name'] ) {
									$this->data_import_files['data-import-' . $x]['imported'] = 'imported';
								}
							}
						}

						foreach ( $import['files'] as $file ) {
							switch ( $file['name'] ) {
								case 'content.xml':
									$this->data_import_files['data-import-' . $x]['content_file'] = $file['name'];
									break;
								case 'theme-options.txt':
								case 'theme-options.json':
									$this->data_import_files['data-import-' . $x]['theme_options'] = $file['name'];
									break;
								case 'setting.txt':
									$this->data_import_files['data-import-' . $x]['setting'] = $file['name'];
									break;
 								case 'widgets.json':
								case 'widgets.txt':
									$this->data_import_files['data-import-' . $x]['widgets'] = $file['name'];
									break;
								case 'screen-image.png':
								case 'screen-image.jpg':
								case 'screen-image.gif':
									$this->data_import_files['data-import-' . $x]['image'] = $file['name'];
									break;
							}
						}
					}

					$x ++;
				}
			}
		}

		public function addImportFiles( $data_import_files ) {

			if ( !is_array( $data_import_files ) || empty( $data_import_files ) ) {
				$data_import_files = array();
			}

			$data_import_files = wp_parse_args( $data_import_files, $this->data_import_files );

			return $data_import_files;
		}

		public function ajax_importer() {
			if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_demo_importer" ) ) {
				die( 0 );
			}
			if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->data_import_files ) ) {

				$reimporting = false;

				if ( isset( $_REQUEST['data_import'] ) && $_REQUEST['data_import'] == 're-importing' ) {
					$reimporting = true;
				}

				$this->active_import_id = $_REQUEST['demo_import_id'];

				$this->active_import = array( $this->active_import_id => $this->data_import_files[$this->active_import_id] );

				if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
					include TRAVELWP_THEME_DIR . '/inc/admin/demo_importer/inc/init-installer.php';
					$installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
				} else {
					echo esc_html__( "Demo Already Imported", 'travelwp' );
				}

				die();
			}

			die();
		}

		public static function get_instance() {
			return self::$instance;
		}

		// Forces the use of the embeded field path vs what the core typically would use
		public function overload_field_path( $field ) {
			return dirname( __FILE__ ) . '/inc/field_' . $this->field_name . '.php';
		}

		function add_importer_section() {
			// Checks to see if section was set in config of redux.
			for ( $n = 0; $n <= count( $this->parent->sections ); $n ++ ) {
				if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'demo_importer_section' ) {
					return;
				}
			}

			$demo_importer_label = trim( esc_html( apply_filters( 'demo_importer_label', __( 'Demo Importer', 'travelwp' ) ) ) );

			$demo_importer_label = ( !empty( $demo_importer_label ) ) ? $demo_importer_label : __( 'Demo Importer', 'travelwp' );

			$this->parent->sections[] = array(
				'id'     => 'demo_importer_section',
				'title'  => $demo_importer_label,
				'desc'   => '<p class="description">' . apply_filters( 'demo_importer_description', esc_html__( 'Works best to import on a new install of WordPress', 'travelwp' ) ) . '</p>',
				'icon'   => 'el-icon-website',
				'fields' => array(
					array(
						'id'   => 'demo_demo_importer',
						'type' => 'demo_importer'
					)
				)
			);
		}

	} // class

} // if