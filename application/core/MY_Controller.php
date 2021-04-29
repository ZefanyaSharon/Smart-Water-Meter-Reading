<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	/**
	 * @property string $layout
	 * Variable yang digunakan untuk menentukan layout dari view yang akan ditampilkan.
	 * Ex : backend, frontend
	 */
	public $layout = 'backend';

	/**
	 * @property string $page_title
	 * Variable yang digunakan untuk menampung data judul halaman.
	 * Variable ini akan ditampilkan pada view.
	 */
	public $page_title;

	/**
	 * @property string $controller_name
	 * Variable yang digunakan untuk menampung nama controller.
	 * Diassign di function __construct pada controller masing-masing.
	 */
	public $controller_name;

	/**
	 * @property string $form_name
	 * Filename dari form yang akan digunakan. Ex : form.php, form_rel.php
	 * Penggunaannya tanpa menggunakan EXT ".php"
	 */
	public $form_name = 'form';

	public $view_detail = 'detail';

	public $view_name = 'list';

	public $statistik = false;

	public $statistik_pengadilan = false;

	public $breadcrumb = false;

	public $side_menu = false;

	public $redirect_url_sukses = '';

	public $message = '';

	protected $id_menu = '';

	/**
	 * @property string $form_action
	 * Variable yang digunakan untuk menentukan url / function form action yang akan dieksekusi.
	 * Variable ini digunakan di HTML <form action="<?php echo $form_action ?>">
	 */
	public $form_action;

	/**
	 * @property boolean $_ajax_style
	 * variable global untuk return data dalam bentuk json atau tidak
	 */
	protected $_ajax_style = true;

	/**
	 * @property array $_addition_display
	 * Variable global untuk menampung data tambahan yang akan di parsing ke view
	 */
	protected $_addition_display = [];

	/**
	 * @property array $listAllkategori
	 * Variable global untuk menampung data listAllkategori
	 */
	protected $listAllkategori = [];

	/**
	 * Fungsi yang akan selalu dieksekusi
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->db->save_queries = false;
	}

	/**
	 * Fungsi untuk menampilkan list data
	 * @return void
	 */
	public function index() {
		$data = [];

		// load Breadcrumbs
		$this->load->library('Lib_menu');

		$data['controller_name'] = $this->controller_name;	
		//$data['current_uri'] = $this->router->fetch_directory() . $this->router->fetch_class();
		if ($this->layout == 'backend')
			$data['breadcrumb']     = $this->lib_menu->generate_breadcrumb($this->id_menu);
			
		$data['user']=$this->_addition_display['users'];

			
		if (!empty($this->_addition_display)) {
			$data['baru'] = array_merge($data, $this->_addition_display);
		}
		$content = '';
		$content = $this->load->view($this->layout . '/' . $this->controller_name . '/' . $this->view_name, $data, true);
		$this->_load_layout($content);
	}

	/**
	 * Fungsi yang digunakan untuk memuat halaman yang akan ditampilkan.
	 * View layout yang dipakai tergantung dari @property $layout
	 * @param [in] $page_content HTML view string
	 * @return Codeigniter parser object
	 */
	protected function _load_layout($page_content) {
		$data_layout = [];
		if (config_item('enable_profiler') === true)
			$this->output->enable_profiler(true);
		switch ($this->layout) {
			case 'frontend':
			break;
			case 'backend':
				$data_layout['menus'] = $this->get_menu();
			break;
		}
		$data_layout['first_name']         = $this->session->userdata('first_name');
		$data_layout['last_name']          = $this->session->userdata('last_name');
		$data_layout['page_title']         = $this->page_title;
		$data_layout['flash_message']      = $this->session->flashdata('flash_message');
		$data_layout['flash_message_type'] = $this->session->flashdata('flash_message_type');
		$data_layout['page_content']       = $page_content;
		$data_layout['current_page']       = $this->router->fetch_directory() . $this->router->fetch_class();

		$this->load->library('parser');
		$this->parser->parse('layouts/' . $this->layout . '.php', $data_layout);
	}

	protected function get_menu() {
		return $this->session->userdata('menus');
	}

	/**
	 * Fungsi untuk query list data menggunkan jqgrid
	 * @param [in]
	 * @return json
	 */
	public function get_list() {
		$this->load->library('Lib_jqgrid');
		$results = $this->lib_jqgrid->result();
	
		$results = $this->get_list_formatter($results);
		return $this->result_json($results);
	}

	/**
	 * Untuk format data hasil dari query get_list()
	 *
	 * @param array $results
	 * @return array
	 */
	public function get_list_formatter($results) {
		return $results;
	}

	public function _export($result, $jenis_export, $jenis = '') {
		if (empty($jenis))
			$jenis = 'putusan_ekspor_data';
		if ($jenis_export == 'excel') {
			$this->load->library('Lib_excel');
			$this->lib_excel->export($result, $this->data_list, $jenis);
		} else {
			$this->load->library('Lib_pdf');
			$this->lib_pdf->export($result, $this->data_list, $jenis);
		}
		// return $this->result_json($result);
	}

	/**
	 * Untuk memproses hasil response, jika ajax maka outputnya langsung dijadikan json
	 * @param [in] $response Data yang akan diproses
	 * @return Data PHP atau JSON jika ajax
	 */
	protected function result_json($result) {
		if ($this->_ajax_style === true) {
			$encoded_result = json_encode($result);
			$this->output->set_content_type('application/json')
						 ->set_output($encoded_result);

			/**
			 * Jika response false maka langsung return display saja.
			 * Langsung dikirim ke client dan proses berikutnya tidak dilanjutkan
			 * Contoh jika ada exception (throw) atau error
			 */
			if (isset($result->response) && $result->response === false) {
				$this->output->_display($encoded_result);
			}
		}

		/**
		 * return data dalam bentuk utuh (semula) jika @ref $_ajax_style = FALSE
		 */
		return $result;
	}

	protected function _detail($id='') {
		/**
		 * ini cuma sementara
		 */
		$data_detail  = null;

		if (!empty($id)) {
			/**
			 * Pemanggilan data detail. @ref get_detail($id) yang akan diparsing ke view
			 */
			$data_detail = $this->get_detail($id);
			if (empty($data_detail)) {
				$message = 'Harap diperiksa kembali karena data yang akan dilihat tidak ditemukan';
				$this->flash_message($message, 'WARNING');
				redirect('backend/' . $this->controller_name);
			}
		}

		// load Breadcrumbs
		$this->load->library('Lib_menu');

		/**
		 * Parsing data ke view
		 */
		$data = [
			'controller_name' => $this->controller_name,
			'breadcrumbs'     => $this->lib_menu->generate_breadcrumb($this->id_menu, 'Detail'),
			'data_detail'     => $data_detail,
			'id'              => $id
		];

		/**
		 * Cek additional data parsing ke view
		 */
		if (!empty($this->_addition_display)) {
			$data = array_merge($data, $this->_addition_display);
		}

		/**
		 * Load view dengan lokasi file nama_layout/nama_controller/form
		 */
		$content = $this->load->view($this->layout . '/' . $this->controller_name . '/' . $this->view_detail, $data, true);

		/**
		 *  Parsing ke template layout
		 */
		$this->page_title = 'Detail' . ' - ' . $this->page_title;
		$this->_load_layout($content);
	}

	/**
	 * Proses untuk menampilkan form CRUD
	 * @param [in] get_post data ID (primary key)
	 * @return HTML Form view
	 */
	protected function _form() {
		/**
		 * Pengecekan post id. Jika $id ada isinya maka sebagai edit, dan jika kosong maka sebagai insert
		 */
		$id = $this->input->get_post('id');

		// TODO : Gimana kalau form delete menggunakan form ini juga? Jadi sebelum delete ditampilkan form dan data detailnya

		/**
		 * set upt data umum yang akan di parsing
		 */
		$form_action  = !empty($this->form_action) ? $this->form_action : 'backend/' . $this->controller_name . '/insert';
		$prefix_title = 'Insert';
		$data_detail  = null;

		if (!empty($id)) {
			$form_action  = 'backend/' . $this->controller_name . '/update?id=' . $id;
			$prefix_title = 'Update';

			/**
			 * Pemanggilan data detail. @ref get_detail($id) yang akan diparsing ke view
			 */
			$data_detail = $this->get_detail($id); // FIXME : Harusnya fungsi yang dapat dicustom di child controller - opsi : closure ??
			if (empty($data_detail)) {
				$message = 'Harap diperiksa kembali karena data yang akan diubah tidak ditemukan';
				$this->flash_message($message, 'WARNING');
				redirect('backend/' . $this->controller_name);
			}
		}

		// load Breadcrumbs
		$this->load->library('Lib_menu');

		/**
		 * Parsing data ke view
		 */
		$data = [
			'controller_name' => $this->controller_name,
			'breadcrumbs'     => $this->lib_menu->generate_breadcrumb($this->id_menu, 'Form'),
			'form_action'     => $form_action,
			'data_detail'     => $data_detail,
			'form_attributes' => [
				'id'     => 'form_' . strtolower($this->controller_name),
				'name'   => 'form_' . strtolower($this->controller_name),
				'method' => 'POST',
			],
			'id' => $id
		];

		/**
		 * Cek additional data parsing ke view
		 */
		if (!empty($this->_addition_display)) {
			$data = array_merge($data, $this->_addition_display);
		}

		/**	
		 * Load view dengan lokasi file nama_layout/nama_controller/form
		 */
		$content = $this->load->view($this->layout . '/' . $this->controller_name . '/' . $this->form_name, $data, true);

		/**
		 *  Parsing ke template layout
		 */
		$this->page_title = $prefix_title . ' - ' . $this->page_title;
		$this->_load_layout($content);
	}

	/**
	 * _insert
	 *
	 * @param Array $object
	 * @param Closure $process
	 * @return void
	 */
	protected function _insert($object, $process) {
		$result           = new stdClass();
		$result->response = false;
		$result->message  = '';
		$result->redirect_url_sukses  = '';

		// -- Load Custom Exception Library --
		$this->load->library('Custom_exception');
		$this->custom_exception->_default_callback = function ($exception, $message) {
			$this->crud_exception_handle($message);
		};

		foreach ($this->set_post_field_name() as $model => $post_field_name) {
			$this->$model->post_field_name($post_field_name);
		}

		// -- Rule Validation --
		$this->load->library('form_validation');
		if ($this->input_validation('insert') == false) {
			$result->message = 'Kesalahan pada data yang diinput. Mohon untuk memperbaiki data yang salah.' . validation_errors();
		} else {
			$this->load->helper('Crud');

			// -- Data Assign --
			$data = data_assign($object);

			// -- Data Format --
			$data = data_format($data);

			// -- Call process --
			if (is_callable($process)) {
				$this->db->trans_start();
				$result->response = $process($data);
				$this->db->trans_complete();
				$result->message = $this->message;
				$result->redirect_url_sukses = $this->redirect_url_sukses;
				$this->flash_message('Simpan data berhasil.', 'SUCCESS');
			}
		}
		$this->result_json($result);
	}

	/**
	 * _update
	 *
	 * @param Array $objects
	 * @param Closure $process
	 * @return void
	 */
	protected function _update($objects, $process) {
		$result           = new stdClass();
		$result->response = false;
		$result->message  = '';
		$result->redirect_url_sukses  = '';

		// -- Load Custom Exception Library --
		$this->load->library('Custom_exception');
		$this->custom_exception->_default_callback = function ($exception, $message) {
			$this->crud_exception_handle($message);
		};

		// -- Start the process --
		foreach ($this->set_post_field_name() as $model => $post_field_name) {
			$this->{strtolower($model)}->post_field_name($post_field_name);
		}

		// -- Rule Validation --
		$this->load->library('form_validation');
		if ($this->input_validation('update') == false) {
			$result->message = 'Kesalahan pada data yang diinput. Mohon untuk memodifikasi data yang salah.' . validation_errors();
		} else {
			$this->load->helper('Crud');

			// -- Data Assign --
			$data = data_assign($objects);

			// -- Data Format --
			$data = data_format($data);

			// -- Call process --
			if (is_callable($process)) {
				$this->db->trans_start();

				// -- Get delete detail ID --
				$for_delete = [];
				foreach ($objects as $object) {
					$for_delete[$object] = [];
					$post_delete         = $this->input->post(strtolower('delete_' . substr($object, 0, -6)));
					if (!empty($post_delete)) {
						$for_delete[$object] = array_filter(explode('|', $post_delete), 'strlen');
					}
				}

				// -- Call Process --
				$result->response = $process($data, $for_delete);
				$this->db->trans_complete();
				$result->message = $this->message;
				$result->redirect_url_sukses = $this->redirect_url_sukses;
				$this->flash_message('Ubah data berhasil.', 'SUCCESS');
			}
		}
		$this->result_json($result);
	}

	/**
	 * _delete
	 *
	 * @param Array $object
	 * @param Closure $process
	 * @return void
	 */
	protected function _delete($object, $process) {
		$result           = new stdClass();
		$result->response = false;
		$result->message  = '';

		// -- Load Custom Exception Library --
		$this->load->library('Custom_exception');
		$this->custom_exception->_default_callback = function ($exception, $message) {
			$this->crud_exception_handle($message);
		};

		// -- Rule Validation --
		$this->load->library('form_validation');
		if ($this->input_validation('delete') == false) {
			$result->message = 'Kesalahan pada data yang diinput. Mohon untuk memodifikasi data yang salah.' . validation_errors();
		} else {
			$this->load->helper('Crud');

			// -- Get ID --
			$id = $this->input->post('id');

			// -- Data Assign --
			$data = data_assign($object);

			// -- Data Format --
			$data = data_format($data);

			// -- Call process --
			if (is_callable($process)) {
				$this->db->trans_start();
				$result->response = $process($id, $data);
				$this->db->trans_complete();
				$this->flash_message('Hapus data berhasil.', 'SUCCESS');
			}
		}
		$this->result_json($result);
	}

	/**
	 * Fungsi yang digunakan untuk setting flashmessage yang akan ditampilkan dihalaman
	 * @param [in] $message string Parameter pesan yang akan ditampilkan
	 * @param [in] $type string Parameter type message. Ex : ERROR, WARNING, SUCCESS
	 * @return void
	 */
	public function flash_message($message, $type) {
		$this->session->set_flashdata('flash_message', $message);
		$this->session->set_flashdata('flash_message_type', $type);
	}

	/**
	 * crud_exception_handle
	 * Digunakan untuk menangani exception atau error
	 *
	 * @param mixed $message
	 * @return void
	 */
	protected function crud_exception_handle($message) {
		$result           = new stdClass();
		$result->response = false;
		$result->message  = $message;
		$this->result_json($result);
	}

	// protected function _addition_display($data, $function = '') {
	// 	if (is_callable($function))
	// 		$data = $function($data);
	// 	return $data;
	// }

	protected function es_get_data($where = [], $sort = [], $page = 1, $limit = 0) {
		$this->load->library('Lib_elasticsearch');

		$data = new stdClass();
		$data->total   = 0;
		$data->results = [];
		$data->aggs    = [];
		$data->pagination = [];

		try {

			$filters['filter']['bool']['must'] = [];
			$query_string['must'] = [];

			// -- Tampilkan hanya yang dipublikasi (is_publish == true)
			$isPublishFilter = ['term' => ['is_publish' => true]];
			$filters['filter']['bool']['must'] = array_merge($filters['filter']['bool']['must'], [$isPublishFilter]);

			if ( ! empty($where)) {
				foreach ($where as $wh) {
					$filters['filter']['bool']['must'] = array_merge($filters['filter']['bool']['must'], [$wh]);
				}
			}

			$page   = ($page !== null) ? (int) $page : 1;
			$limit  = (empty($limit) ? config_item('public_limit_per_page') : $limit);
			$offset = ($page * $limit) - $limit;
			$data = $this->lib_elasticsearch->buildQuery(function ($query) use ($limit, $offset, $filters, $sort) {
				// -- Limit --
				$query->limit($offset, $limit);

				$query->aggs([
					'kategori_aggs' => [
						'composite' => [
							'size' => 1000,
							'sources' => [
								'kategori_id' => [
									'terms' => [
										'field' => 'kategori.id'
									]
								]
							]
						]
					],
					// 'pengadilan_aggs' => ['terms' => ['field' => 'id_pengadilan']],
					'pengadilan_aggs' => [
						'composite' => [
							'size' => 1000,
							'sources' => [
								'id_pengadilan' => [
									'terms' => [
										'field' => 'id_pengadilan'
									]
								]
							]
						]
					],
					// 'bulan_upload_aggs' => ['date_histogram' => ['field' => 'created', 'interval' => 'month', 'format' => 'MM']],
					// 'bulan_putusan_aggs' => ['date_histogram' => ['field' => 'tanggal_putusan', 'interval' => 'month', 'format' => 'MM']],
					// 'bulan_register_aggs' => ['date_histogram' => ['field' => 'tanggal_register', 'interval' => 'month', 'format' => 'MM']],
				]);

				if ( ! empty($sort)) {
					foreach ($sort as $sort_field => $sort_method)
						$query->sort($sort_field, $sort_method);
				}

				// -- Set Query --
				$sql['bool'] = [];
				$sql['bool'] = array_merge($sql['bool'], $filters);
				$query->query($sql);

				return $query;
			})->getData(config_item('es_index'));
		} catch (Exception $e) {
			//
		}

		return $data;
	}
}
