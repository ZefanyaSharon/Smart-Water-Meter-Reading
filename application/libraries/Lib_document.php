<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//TODO:HAPUS KETIKA EDIT, BIAR GAK NUMPUK

/**
 * Library document management
 *
 * TODO: buat mekanisme clean up orphant files
 */
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Lib_document {
	protected $CI;
	protected $uploaded_file_address;
	protected $document_table;
	protected $document_model;
	protected $additional_path;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('upload');
		$this->db = $this->CI->db;
		$this->document_table = config_item('document_table');
		$this->document_model = config_item('document_model');
		$this->additional_path = '';
	}

	/**
	 * Function untuk upload document file
	 * @param  string $file
	 * @param  array  $data = [
	 *						'id' 		=> $id_document',
	 *						'metadata' 	=> $metadata,
	 *						'field_name'	=> $field_name,
	 *						'file_name'	=> $file_name,
	 *					]
	 * @return object
	 */
	public function upload($file, $custom_data = []) {
		$return = new stdClass();
		$return->id = '';
		$return->file_path = '';
		$return->status = false;
		$return->message = '';

		if (isset($custom_data['id'])) {
			if (isset($custom_data['additional_path']) && ! empty($custom_data['additional_path'])){

				$this->additional_path = $custom_data['additional_path'];
				if ($_FILES[$file]['type'] == 'application/zip') {
					$uploaded = self::get_content_zip($file, $custom_data);
				}
				else
					$uploaded = self::store_file($file, $custom_data);

				if ($uploaded->status === true) {
					// -- save metadata in table dokumen --
					$metadata = self::store_metadata($uploaded, $custom_data);
					if (isset($metadata->id) && !empty($metadata->id)) {
						$custom_data['id_dokumen'] = $metadata->id;
						// -- save file in history direktory and save metadata in table dokumen_history --
						$history = self::saveFileHitory($uploaded, $custom_data);
					}
					$return->id = $metadata->id;
					$return->status = true;
					$return->message = 'Upload file berhasil';
				} else {
					$return->message = $uploaded->message;
				}
			}
		} else {
			self::revert_if_failure();
			$return->message = 'data tidak ditemukan';
		}
		return $return;
	}

	/**
	 * function untuk upload dokumen ke hdd yang berbentuk file
	 * @param string field_name dari inputan
	 * @param string file_name yang akan diupload
	 * @return object data
	*/
	private function store_file($file, $custom_data) {

		$level  = strtoupper($this->CI->session->userdata('level'));
		$result = new stdClass();
		$result->output = [];
		$result->status = false;
		$result->message = '';
		$result->id_dokumen = '';

		$config = [];
		$id_dokumen = guid();
		// -- Set configuration --
		$config['upload_path']   = config_item('document_path') . $this->additional_path . date('Y') . '/' . date('m') . '/' . $custom_data['id_ref']. '/';
		$config['allowed_types'] = isset($custom_data['allowed_type']) ? $custom_data['allowed_type'] : config_item('document_type');
		$config['file_name']	 = $custom_data['id_ref'] . '_' . $id_dokumen;
		if ($level !== 'ADMINISTRATOR') {
			$config['max_size']      = config_item('document_max_size');
		}

		$this->CI->upload->initialize($config);

		// -- create folder when folder not exist--
		if ( ! is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0755, true);

		// -- Uploading process --
		if ($this->CI->upload->do_upload($file)) {
			$result->status        = true;
			$result->output        = $this->CI->upload->data();
			$result->id_dokumen    = $id_dokumen;

			$fileSystem = new Filesystem();

			// -- rename file extension to .dat extension --
			if ($fileSystem->exists($result->output['full_path'])){
				$fileSystem->rename($result->output['full_path'], $config['upload_path'] . $config['file_name'] . '.dat');

				// -- Assign file address to global variable --
				$this->uploaded_file_address = $config['upload_path'] . $config['file_name'] . '.dat';
			}
		} else {
			self::revert_if_failure();
			$result->message = 'File tidak dapat terupload pada sistem.' . $this->CI->upload->display_errors();
		}

		// -- We're done :) --
		return $result;
	}

	/**
	 * Untuk menyimpan metadata dokumen pada database
	 *
	 * @param object $uploaded
	 * @param array $custom_data
	 * @return object
	 */
	public function store_metadata($uploaded, $custom_data, $is_migration = false) {
		$result = new stdClass();
		$result->id = '';
		$result->status = false;

		$model = $this->document_model;
		$this->CI->load->model($model);

		$metadata['id']	           = $uploaded->id_dokumen;
		$metadata['extension'] 	   = str_replace('.', '', $uploaded->output['file_ext']) ;
		if (isset($uploaded->path) && !empty($uploaded->path)) {
			$metadata['path']      = $uploaded->path;
		} else {
			$metadata['path'] 		   = config_item('document_path') . $this->additional_path . date('Y') . '/' . date('m') . '/' . $custom_data['id_ref']. '/';
		}
		$metadata['file_name']     = substr($uploaded->output['file_name'], 0 , (strrpos($uploaded->output['file_name'], ".")));
		$metadata['file_name_ori'] = $uploaded->output['client_name'];
		$metadata['size'] 		   = filesize($metadata['path'] . $metadata['file_name'] . '.dat');

		$metadata['table_name'] 		= $custom_data['table_name'];
		$metadata['id_ref'] 			= $custom_data['id_ref'];
		$metadata['jenis_dokumen'] 		= $custom_data['jenis_dokumen'];
		$metadata['sub_jenis_dokumen']	= $custom_data['sub_jenis_dokumen'];


		$trans = $this->CI->$model->insert($metadata);

		if ($trans) {
			$result->status = true;
			$result->id     = $uploaded->id_dokumen;
			if ( ! $is_migration) {
				if ($custom_data['jenis_dokumen'] == 'restatement' || $custom_data['jenis_dokumen'] == 'yurisprudensi' ||
					$custom_data['jenis_dokumen'] == 'peraturan'   || $custom_data['jenis_dokumen'] == 'rumusan_kamar' ||
					($custom_data['jenis_dokumen'] == 'putusan' && $custom_data['sub_jenis_dokumen'] == 'putusan')) {
						// -- Get old file if exists. This file will be deleted after upload --
						$old_files = $this->get_old_file($uploaded->id_dokumen, $metadata);

						if (count($old_files) > 0) {
							foreach ($old_files as $idx_o => $old_file) {
								// -- delete file fisik dan data di table dokumen --
								$delete_old_file = $this->delete_file($old_file->id);
							}
						}

						// -- If enable rtf_convert then check queue
						if (isset($custom_data['rtf_convert']) && $custom_data['rtf_convert'] == true)
							$this->check_queue($custom_data);
				}
			}
		}
		return $result;
	}

	/**
	 * Untuk revert proses upload jika terjadi masalah
	 *
	 * @return void
	 */
	private function revert_if_failure() {
		$fileSystem = new Filesystem();
		if ($fileSystem->exists($this->uploaded_file_address))
			$fileSystem->remove($this->uploaded_file_address);
	}

	private function saveFileHitory($uploaded, $custom_data) {
		$result = new stdClass();
		$result->message = '';
		$result->status = false;

		$savingPath = config_item('document_history_path') . $this->additional_path  . date('Y') . '/' . date('m') . '/' . $custom_data['id_ref'] . '/';
		$fileName	 = $custom_data['id_ref'] . '_' . $custom_data['id_dokumen'];


		// -- create folder when folder not exist--
		if ( ! is_dir($savingPath))
			mkdir($savingPath, 0755, true);

		$fileSystem = new Filesystem();
		if ($fileSystem->exists($this->uploaded_file_address)){
			$fileSystem->copy($this->uploaded_file_address, $savingPath . $fileName . '.dat', true);
		}

		// -- Uploading process --
		if ($fileSystem->exists($savingPath . $fileName . '.dat')) {
			$metadata['id'] 		        = guid();
			$metadata['table_name'] 		= $custom_data['table_name'];
			$metadata['id_ref'] 			= $custom_data['id_ref'];
			$metadata['id_dokumen'] 	    = $custom_data['id_dokumen'];
			$metadata['extension'] 	        = str_replace('.', '', $uploaded->output['file_ext']) ;
			$metadata['file_name'] 	        = $fileName;
			$metadata['file_name_ori'] 	    = $uploaded->output['client_name'];
			$metadata['size'] 		        = filesize($savingPath . $fileName . '.dat');
			$metadata['jenis_dokumen'] 		= $custom_data['jenis_dokumen'];
			$metadata['sub_jenis_dokumen']	= $custom_data['sub_jenis_dokumen'];
			$metadata['path'] 		        = $savingPath;
			$metadata['created'] 		    = date('Y-m-d H:i:s');
			$metadata['updated'] 		    = date('Y-m-d H:i:s');

			$trans = $this->CI->db->insert('dokumen_history', $metadata);
			if ($trans) {
				$result->message = 'Data history berhasil disimpan';
				$result->status = true;
			} else {
				$result->message = 'Data history gagal disimpan';
			}
		} else {
			$result->message = 'Data history gagal disimpan' . $this->CI->upload->display_errors();
		}


		return $result;
	}

	public function check_queue($custom_data = []) {
		$this->CI->load->library('Lib_pdf');
		$is_rtf = false;
		$is_pdf = false;
		$is_pdf_corrupt = false;
		$is_rtf_corrupt = false;
		$message = NULL;

		$this->db->from('dokumen');
		$this->db->where('id_ref', $custom_data['id_ref']);
		$this->db->where('table_name', 'putusan');
		$this->db->where('jenis_dokumen', 'putusan');
		$this->db->where('sub_jenis_dokumen', 'putusan');
		$t_dokumen = $this->db->get();
		if ($t_dokumen->num_rows() > 0) {
			$dokumens = $t_dokumen->result();
				foreach ($dokumens as $index_dok => $dokumen) {
					$filePath = $dokumen->path . $dokumen->file_name . '.dat';
					if ($dokumen->extension == 'pdf') {
						if (file_exists($filePath)) {
							$statusPdf = $this->CI->lib_pdf->cek_pdf($filePath);
							if ($statusPdf->status == true) {
								$is_pdf = true;
							} else {
								$is_pdf_corrupt = true;
								$message = $statusPdf->message;
							}
						}
						else
							$message = 'File PDF tidak ada';

					}
					if ($dokumen->extension == 'rtf') {
						if (file_exists($filePath)) {
							$cek_rtf = mime_content_type($filePath);
							if ($cek_rtf === 'text/rtf')
								$is_rtf = true;
							else {
								$is_rtf_corrupt = true;
								$message = 'Mime type File upload bukan RTF';
							}
						}
						else
							$message = 'File RTF tidak ditemukan';
					}
				}

				// insert to queue for processing convert pdf khusus jika pdf tidak ada dan ada rtf (setting convert di controller rtf)
				if ($is_pdf == false && $is_rtf == false) {
					$type = 'putusan_empty_pdf_rtf';
				} else if ($is_pdf == false && $is_rtf == true) {
					$type = 'putusan_empty_pdf';
				} else if ($is_pdf == true && $is_rtf == false) {
					$type = 'putusan_empty_rtf';
				} else if ($is_pdf_corrupt == true) {
					$type = 'putusan_corrupt_pdf';
				} else if($is_rtf_corrupt == true) {
					$type = 'putusan_corrupt_rtf'; // -- rtf ada tapi corrupt
				} else if ($is_pdf == true && $is_rtf == true){
					$type = 'putusan_no_problem';
					$message = 'Pengecekan File PDF tidak bermasalah dan File RTF ada, proses konversi diubah menjadi WORKER-COMPLETED dan Sukses.';
				}

				// pengecekan di tabel queue agar tidak double
				$this->db->select('id, type, is_sukses, ref_id, status');
				$this->db->where('"ref_id" = \''. $custom_data['id_ref'] .'\' AND (type = \'putusan_empty_rtf\' OR type = \'putusan_empty_pdf\' OR type = \'putusan_empty_pdf_rtf\' OR type = \'putusan_corrupt_pdf\' OR type = \'putusan_corrupt_rtf\')');
				$check_queue = $this->db->get('queue')->first_row();

				$data_db = [];
				if (!empty($check_queue)){
				// hanya update apabila is sukses 1 dan worker-completed
					if ($check_queue->is_sukses == 1 && $check_queue->status == 'WORKER-COMPLETED' || $type == 'putusan_no_problem') {
						$data_update = [];
						$data_update['id'] = $check_queue->id;
						$data_update['ref_id'] = $check_queue->ref_id;
						$data_update['table'] = 'APP_PUTUSAN.putusan';
						$data_update['type'] = $type;
						$data_update['status'] = 'SERVER-QUEUE';
						$data_update['is_sukses'] = 0;
						if ($type == 'putusan_no_problem'){
							$data_update['status'] = 'WORKER-COMPLETED';
							$data_update['is_sukses'] = 1;
						}
						$data_update['status_keterangan'] =  $message;
						$data_update['metadata'] = $custom_data['metadata'];
						$data_update['updated'] = date('Y-m-d H:i:s');
						$data_db['update'] = $data_update;
					}
			 	} else {
					// Tidak akan insert data apabila sudah ada pdf yang benar dan rtfnya
					if ($type !== 'putusan_no_problem'){
						$data_insert = [];
						$data_insert['id'] = guid();
						$data_insert['ref_id'] = $custom_data['id_ref'];
						$data_insert['table'] = 'APP_PUTUSAN.putusan';
						$data_insert['type'] = $type;
						$data_insert['status'] = 'SERVER-QUEUE';
						$data_insert['is_sukses'] = 0;
						$data_insert['priority'] = 1;
						$data_insert['status_keterangan'] = $message;
						$data_insert['metadata'] = $custom_data['metadata'];
						$data_insert['created'] = date('Y-m-d H:i:s');
						$data_insert['updated'] = date('Y-m-d H:i:s');
						$data_db['insert'] = $data_insert;
					}
				}

			if(isset($data_db['update']) && ! empty($data_db['update'])) {
				$this->db->where('id', $check_queue->id);
				$transaction = $this->db->update('queue', $data_db['update']);
			}
			else if(isset($data_db['insert']) && ! empty($data_db['insert'])) {
				$transaction = $this->CI->db->insert('queue', $data_db['insert']);
			}
		}
	}

	public function get_old_file($id_old_file, $custom_data = []) {
		$result = [];

		if ( ! empty($custom_data)) {
			$this->db->from($this->document_table);
			$this->db->where('id_ref', $custom_data['id_ref']);
			$this->db->where('table_name', $custom_data['table_name']);
			$this->db->where('jenis_dokumen', $custom_data['jenis_dokumen']);
			$this->db->where('sub_jenis_dokumen', $custom_data['sub_jenis_dokumen']);
			if ($custom_data['jenis_dokumen'] == 'putusan' && $custom_data['sub_jenis_dokumen'] == 'putusan')
				$this->db->where('extension', $custom_data['extension']);

			$this->db->where_not_in('id', [$id_old_file]);
			$t_document = $this->db->get();
			if ($t_document->num_rows() > 0) {
				$result = $t_document->result();
			}
		}

		return $result;
	}

	public function get_current_file($param) {
        $result = new stdClass();

        if (isset($param) && ! empty($param)) {
            $this->db->from($this->document_table);
            if (is_array($param)) {
                $this->db->where('id_ref', $param['id_ref']);
                $this->db->where('table_name', $param['table_name']);
                if(isset($param['jenis_dokumen']))
                    $this->db->where('jenis_dokumen', $param['jenis_dokumen']);
                if(isset($param['sub_jenis_dokumen']))
                    $this->db->where('sub_jenis_dokumen', $param['sub_jenis_dokumen']);
                if (isset($param['extension'])) {
                    $this->db->where('extension', $param['extension']);
                }
            }
            else
                $this->db->where('id', $param); // jika variable $param hanya terdapat id_dokumen --
            $t_document = $this->db->get();
            if ($t_document->num_rows() > 0) {
                $result = $t_document->result();
            }
        }

        return $result;
    }

	public function delete_file($id_dokumen, $directory_file = '') {
		$fileSystem = new Filesystem();
		if (empty($directory_file)) {
			$this->db->select('path, file_name, extension');
			$this->db->from($this->document_table);
			$this->db->where('id', $id_dokumen);
			$t_file = $this->db->get();
			if ($t_file->num_rows() > 0) {
				$file = $t_file->first_row();
				$directory_file = $file->path . $file->file_name . '.dat';
			}
		}

		if ($fileSystem->exists($directory_file))
			$fileSystem->remove($directory_file);

		$this->db->where('id', $id_dokumen);
		$trans = $this->db->delete($this->document_table);

		return $trans;
	}

	public function download_file($param = [], $type = 'pdf'){
		$this->CI->load->helper('download');
		$id_dokumen = $param['id_ref'];
		$type = $param['type'];
		$table_name = $param['table_name'];
		$is_fd = isset($param['is_fd']) ? $param['is_fd'] : false;

		$this->db->select('doc.path, doc.extension, doc.id_ref, doc.jenis_dokumen, doc.sub_jenis_dokumen, doc.id, doc.file_name, put.nomor, rk.no_rk, yuris.no_katalog, pera.nomor AS nomor_peraturan, rest.judul');
		$this->db->from('dokumen as doc');
		$this->db->join($table_name .' as '. $table_name .'', ''. $table_name .'.id = doc.id_ref AND doc.table_name = \''.$table_name.'\'', 'LEFT');
		$this->db->join('putusan AS put', 'put.id = doc.id_ref', 'LEFT');
		$this->db->join('rumusan_kamar AS rk', 'rk.id = doc.id_ref', 'LEFT');
		$this->db->join('yurisprudensi AS yuris', 'yuris.id = doc.id_ref', 'LEFT');
		$this->db->join('restatement AS rest', 'rest.id = doc.id_ref', 'LEFT');
		$this->db->join('peraturan AS pera', 'pera.id = doc.id_ref', 'LEFT');
		$this->db->where('doc.id', $id_dokumen);

		if ($type === 'zip')
			$this->db->where('doc.extension', 'pdf');
		else
			$this->db->where('doc.extension', $type);

		$this->db->limit(1);
		$dokumen_ = $this->db->get();

		if ($dokumen_->num_rows() > 0) {
			$doc = $dokumen_->first_row();

			// tambahan source link buat qrcode
			$qrfile = sys_get_temp_dir() . '/' . guid() . '.png';
			if ($table_name == 'putusan') {
				$link_barcode = site_url('direktori/putusan/' . $doc->id_ref);
			}
			else
				$link_barcode = site_url($table_name . '/detail/' .$doc->id_ref);

			include(APPPATH."third_party/phpqrcode/qrlib.php");
			QRcode::png($link_barcode ,$qrfile);

			if ($type === 'zip')
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->nomor)).'_'.date("Ymd").'.pdf' : $table_name.'_'.date("YmdHis").'.pdf';
			elseif (!empty($doc->nomor) && $doc->sub_jenis_dokumen == 'putusan') {
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->nomor)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}
			elseif (!empty($doc->no_rk)) {
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->no_rk)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}
			elseif (!empty($doc->no_katalog)) {
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->no_katalog)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}
			elseif (!empty($doc->nomor_peraturan)) {
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->nomor_peraturan)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}
			elseif ($doc->jenis_dokumen == 'putusan') {
				$file_name = !empty($doc->id) ? $doc->jenis_dokumen.'_'.strtolower(str_replace(' ', '_', $doc->sub_jenis_dokumen)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}
			else {
				$file_name = !empty($doc->id) ? $table_name.'_'.strtolower(str_replace(' ', '_', $doc->judul)).'_'.date("Ymd").'.'.$type : $table_name.'_'.date("YmdHis").'.'.$type;
			}

			$FileDownload =  $doc->path.$doc->file_name.'.dat';

			if (file_exists($FileDownload)) {
				// hanya jika file RTF maka dapat download filenya (bisa di kondisikan / ditambahkan)
				if ($type === 'rtf'){
					$fileSystem = new Filesystem();

					if ($fileSystem->exists($doc->path.$doc->file_name.'.dat')){
						$FileDownload = $doc->path.$doc->file_name.'.'.$type;
						force_download($file_name, file_get_contents($doc->path.$doc->file_name.'.dat'));
					}
				}

				if ($is_fd === true) {
					force_download($FileDownload, null);
				} else
					download_file($FileDownload, $file_name, $type, $qrfile);
			} else {
				$this->CI->session->set_flashdata('failed_download', 'File tidak ada');
			}

		} else {
			$this->CI->session->set_flashdata('failed_download', 'File tidak ada');
		}
	}

	/**
	 * 	function yang return nya akan dikirimkan ke view putusan sebagai dokumen multiple(bootstrap input file)
	 * @param string parameter dari data hasil query mendapatkan file
	 * @return array data
	 */
	public function file_load($params = [], $jenis = 'putusan') {
		$initial = [];
		if (!empty($params)){
			foreach ($params as $idx_dok => $val_dokumen) {
			$path_file = $val_dokumen->path . $val_dokumen->file_name . '.dat';
			if (file_exists($path_file) && (!empty($val_dokumen->path) && !empty($val_dokumen->file_name) && !empty($val_dokumen->extension))) {
				// $download_url = isset($jenis) && ($jenis == 'putusan') ? site_url('direktori/download_file/'.$val_dokumen->id_putusan.'/'.$val_dokumen->extension) : site_url($jenis.'/download_file/'.$val_dokumen->id_putusan.'/'.$val_dokumen->extension. '/' . $val->id_dokumen);

				if($val_dokumen->extension == 'jpg' || $val_dokumen->extension == 'jpeg' ||  $val_dokumen->extension == 'png') {
					$type = pathinfo($path_file, PATHINFO_EXTENSION);
					$data = file_get_contents($path_file);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
					$val_dokumen->files = $base64;
						$initial['preview'][$idx_dok] = '<img src="'.$val_dokumen->files.'" class="kv-preview-data file-preview-image" style="height:120px">';
						$initial['config'][$idx_dok] = [
							'previewAsData' => false,
							'size' => $val_dokumen->size,
							'caption' => $val_dokumen->file_name . '.' . $val_dokumen->extension,
							'url' => site_url('backend/putusan/delete_dokumen/'.$val_dokumen->id_dokumen),
							'key' => $val_dokumen->id_dokumen
						];
					} else if ($val_dokumen->extension == 'pdf') {
						$path_file = base_url($path_file);
						// $initial['preview'][] = "<iframe name=\"myiframe\" id=\"myiframe\" src=\"$path_file\">";
						$initial['preview'][$idx_dok] = $path_file;
						$initial['config'][$idx_dok] = [
							'previewAsData' => true,
							'type' => $val_dokumen->extension,
							'size' => $val_dokumen->size,
							'caption' => $val_dokumen->file_name . '.' . $val_dokumen->extension,
							'url' => site_url('backend/putusan/delete_dokumen/'.$val_dokumen->id_dokumen),
							'key' => $val_dokumen->id_dokumen
						];
					} else {
						$path_file = base_url($path_file);
						$initial['preview'][$idx_dok] = $path_file;
						$initial['config'][$idx_dok] = [
							'previewAsData' => true,
							'type' => 'other',
							'size' => $val_dokumen->size,
							'caption' => $val_dokumen->file_name . '.' . $val_dokumen->extension,
							'url' => site_url('backend/putusan/delete_dokumen/'.$val_dokumen->id_dokumen),
							'key' => $val_dokumen->id_dokumen
						];
					}
					$initial['data'][$idx_dok] = $val_dokumen;
				}
			}
		}
		return $initial;
	}

	/**
	 * Untuk unzipping file yang ada didalam file zip
	 * @param string field_name dari inputan
	 * @param string file_name yang akan diupload
	 * @return object data
	 */
	private function get_content_zip($data, $custom_data) {
		$file = $_FILES[$data]['tmp_name'];
		$zip = new ZipArchive;
		$finder = new Finder();
		$fileSystem = new Filesystem();
		$result = new stdClass();
		$result->output = [];
		$result->status = false;
		$result->message = '';
		$result->id_dokumen = '';

		if ($zip->open($file) === true) {
			$id_dokumen = guid();
			$path_file = sys_get_temp_dir().'\\'.$id_dokumen.'\\';

			$zip->extractTo($path_file);
			$finder->files()->in($path_file);

			foreach ($finder as $file) {
				$file_path = $file->getRealPath();
				$file_name = $file->getRelativePathname();
			}

			$file_size 		= $file_path;
			$file_ext 		= array_values(array_slice(explode('.', $file_name), -1))[0];
			$path_folder 	= config_item('document_path') . $this->additional_path . date('Y') . '/' . date('m') . '/' . $custom_data['id_ref']. '/';
			$path_default 	= config_item('document_path') . $this->additional_path . date('Y') . '/' . date('m') . '/' . $custom_data['id_ref']. '/'.$custom_data['id_ref']. '_' . $id_dokumen;
			$file_mime_type = get_mime_by_extension($file_name);

			if (($file_mime_type == 'text/rtf' && $file_ext == 'rtf') || ($file_mime_type == 'application/pdf' && $file_ext == 'pdf')) {
				$result->status = true;
				$result->id_dokumen = $id_dokumen;

				// -- create folder when folder not exist--
				if ( ! is_dir($path_folder))
					mkdir($path_folder, 0755, true);

				$content = $fileSystem->rename($path_file.$file_name, $path_default.'.dat');

				$result->output['file_name'] 	= $custom_data['id_ref']. '_' . $id_dokumen.'.'.$file_ext;
				$result->output['file_type'] 	= $file_mime_type;
				$result->output['file_path'] 	= $path_folder;
				$result->output['full_path'] 	= $path_default.'.'.$file_ext;
				$result->output['raw_name'] 	= $custom_data['id_ref']. '_' . $id_dokumen;
				$result->output['orig_name'] 	= $custom_data['id_ref']. '_' . $id_dokumen . '.' .$file_ext;
				$result->output['client_name'] 	= $file_name;
				$result->output['file_ext'] 	= '.' .$file_ext;
				$result->output['file_size'] 	= $file_size;
				$result->output['is_image'] 	= false;

				// insert ke queue apabila rtf convert set true
				if (isset($custom_data['rtf_convert']) && $custom_data['rtf_convert'] == true)
					$this->check_queue($custom_data);

			} else {
				$result->message = 'File tidak dapat terupload pada sistem, karena file yang di upload dalam ZIP bukan RTF / PDF';
			}

			// delete folder if exists
			if ($fileSystem->exists($path_file))
				$fileSystem->remove($path_file);

			$zip->close();

		} else {
			$result->message = 'File tidak diketahui';
		}

		return $result;
	}

	public function clean_dokumen($limit = 100, $table_name = 'putusan') {
		$fileSystem = new Filesystem();

		$offset = 0;
		$sql='SELECT *
		FROM "APP_PUTUSAN"."dokumen"
		WHERE "table_name" = \'' . $table_name . '\'
		ORDER BY "created" ASC
				';
		if (!empty($limit)){
			$sql .= " LIMIT $limit";
		}

		$t_dokumen = $this->db->query($sql. ' OFFSET ' . $offset);
		$num_rows = $t_dokumen->num_rows();
		do {
			if ($num_rows > 0) {
				$dokumens = $t_dokumen->result();
				$counter = 0;
				foreach ($dokumens as $k_dok => $dokumen) {
					echo 'counter :' . $counter . "\n";
					if ($dokumen->table_name == 'putusan') {
						$dir = $dokumen->path;
						$file_name = $dokumen->file_name;

						// -- explode file_name with under score(_) untuk mengambil id dokumen saja untuk nama --
						$exploded_file_name = explode('_', $file_name);

						// -- nama file tanpa extension --
						$file_name_no_ext = $exploded_file_name[0];
						// -- nama file dengan extension --
						$file_name_w_ext = $dokumen->file_name . '.' . $dokumen->extension;

						// -- full direktori untuk pengecekan --
						$full_dir = $dir . $file_name_w_ext;


						if (file_exists($full_dir)) {
							$id_dokumen = $dokumen->id;
							$dir_without_config = str_replace(config_item('document_path'), '', $dir);

							// -- replace titik(.) jika ada titik didepan nama file --
							$new_dir = str_replace('.', '', $dir_without_config);

							// --  assign nama direktori baru --
							$new_dir_dokumen = config_item('document_path') . 'putusan/' . $new_dir;

							// -- assign nama file baru tanpa extension --
							$new_file_name = $dokumen->id_ref . '_' . $id_dokumen;

							// -- full direktori baru --
							$new_full_dir = $new_dir_dokumen . $new_file_name . '.dat'; // -- direktori baru --

							// -- create new folder if not exists --
							if ( ! is_dir($new_dir_dokumen))
								mkdir($new_dir_dokumen, 0755, true);

							// -- copy file dari direktori lama ke direktory baru --
							$fileSystem->rename($full_dir, $new_full_dir, true);

							// -- jika copy file berhasil dan file ada --
							if ($fileSystem->exists($new_full_dir)) {
								$data = [
									'file_name' => $new_file_name,
									'path' => $new_dir_dokumen,
									'updated' => date('Y-m-d H:i:s'),
								];

								// -- update data path dan file_name di table dokumen --
								$this->db->where('id', $id_dokumen);
								$trans = $this->db->update('dokumen', $data);
								if ($trans) {
									$history_dir = config_item('document_history_path') . 'putusan/' . $new_dir;
									// -- create new folder if not exists --
									if ( ! is_dir($history_dir))
										mkdir($history_dir, 0755, true);

									$fileSystem->copy($new_full_dir, $history_dir . $new_file_name . '.dat', true);
									if ($fileSystem->exists($history_dir . $new_file_name . '.dat')) {
										$data_history = [
											'id' => guid(),
											'table_name' => $dokumen->table_name,
											'id_ref' => $dokumen->id_ref,
											'id_dokumen' => $dokumen->id,
											'extension' => $dokumen->extension,
											'file_name' => $new_file_name,
											'file_name_ori' => $dokumen->file_name_ori,
											'size' => $dokumen->size,
											'jenis_dokumen' => $dokumen->jenis_dokumen,
											'sub_jenis_dokumen' => $dokumen->sub_jenis_dokumen,
											'path' => $history_dir,
											'created' => date('Y-m-d H:i:s'),
											'updated' => date('Y-m-d H:i:s')
										];
										$this->db->insert('dokumen_history', $data_history);
									}

								}

								$check_dokumens = array_diff(scandir($dir), array('..', '.'));
								if (count($check_dokumens) == 0) {
									$fileSystem->remove($dir);
								}
							}
						}
					}
					$counter++;
				}
			}

			$offset += $limit;
			echo 'Offset : ' . $offset . "\n";
			$t_dokumen = $this->db->query($sql. ' OFFSET ' . $offset);
			$num_rows = $t_dokumen->num_rows();

		} while($limit >= 100 && $num_rows > 0);
	}

	/**
	 * clean_dokumen_history berfungsi untuk mengubah path yang salah ketika pemindahan file dengan struktur baru
	 *
	 * @return void
	 */
	public function clean_dokumen_history($limit = 1) {
		$fileSystem = new Filesystem();
		$offset = 0;

		$this->db->select('*');
		$this->db->from('dokumen_history');
		$this->db->like('path','doc_historyputusan');
		$this->db->limit($limit, $offset);
		$this->db->offset($offset);
		$t_history = $this->db->get();
		$num_rows = $t_history->num_rows();
		do {
			if ($num_rows > 0) {
				$d_histories = $t_history->result();
				$counter = 0;
				foreach ($d_histories as $d_history) {
					$counter++;
					echo 'counter : ' . $counter . "\n";
					// $path_no_config = ltrim($d_history->path, config_item('document_history_path'));
					$new_path = str_replace('var/www/doc_history', config_item('document_history_path'), $d_history->path);
					$old_file_path = $d_history->path . $d_history->file_name . '.dat';
					$new_file_path = $new_path . $d_history->file_name . '.dat';
					if (file_exists($old_file_path)) {
						$fileSystem->rename($old_file_path, $new_file_path, true);
						if (file_exists($new_file_path)) {
							$data = [
								'path' => $new_path
							];

							$this->db->where('id', $d_history->id);
							$trans = $this->db->update('dokumen_history', $data);
							if (!$trans) {
								throw new Exception('Error Processing Request');
							}
						}
					}
				}
			}

			$offset += $limit;
			echo 'Offset : ' . $offset . "\n";
			$this->db->select('*');
			$this->db->from('dokumen_history');
			$this->db->like('path','doc_historyputusan');
			$this->db->limit($limit, $offset);
			$t_history = $this->db->get();
			$num_rows = $t_history->num_rows();

		} while ($limit >= 100 && $num_rows > 0);
	}

	/**
	 * Check broken link di putusan V3
	 *
	 * @return void
	 */
	public function check_broken_link($limit = 100, $created = '', $test = 0) {
		$this->CI->load->library('Lib_pdf');
		$offset = 0;
		$jlh_putusan = 0;
		$data_db = [];
		$metadata = [];
		$output_message = [];
		$queue_table = 'queue';
		$elapsed_time = 0;
		$renew_total_putusan = 10; // per 10%

		if ( ! empty($created))
			$this->db->where('created >=', $created);
		$this->db->from('putusan');
		$total_putusan = $this->db->count_all_results();

		$total_putusan_processed = 0;
		if ( ! empty($created)) {
			$this->db->where('created <', $created);
			$this->db->from('putusan');
			$total_putusan_processed = $this->db->count_all_results();
		}

		$this->CI->benchmark->mark('start1');
		$this->db->select('id, nomor, id_pengadilan, tingkat_proses, created');
		$this->db->from('putusan');
		if ( ! empty($created))
			$this->db->where('created >=', $created);
		$this->db->limit($limit);
		$this->db->order_by('created', 'ASC');

		$t_putusan = $this->db->get();
		$this->CI->benchmark->mark('end1');
		echo 'Query select putusan time : ' . $this->CI->benchmark->elapsed_time('start1', 'end1') . PHP_EOL;
		$num_rows = $t_putusan->num_rows();
		if ($num_rows > 0) {
			do {
				$this->CI->benchmark->mark('start_all');
				$putusans = $t_putusan->result();
				$counter = 0;
				$type = '';
				$metadata = [];
				$output_message = [];

				foreach ($putusans as $k_put => $putusan) {
					$dt = new DateTime($putusan->created);
					$metadata[$putusan->id] = [
						'no_putusan' => $putusan->nomor,
						'id_pengadilan' => $putusan->id_pengadilan,
						'tingkat_proses' => $putusan->tingkat_proses,
						'tahun_created' => $dt->format('Y'),
						'bulan_created' => $dt->format('m')
					];

					$data_id_putusan[] = $putusan->id;

					$counter++;
					$jlh_putusan++;
					$last_created = $putusan->created;

					if ($counter == $num_rows) {
						// $q_dokumen = $this->db->query('SELECT * FROM APP_PUTUSAN."dokumen" WHERE "id_ref" IN (\'' . $id_putusan_implode . '\') AND "jenis_dokumen" = \'putusan\' AND "sub_jenis_dokumen" = \'putusan\'AND "table_name" = \'putusan\'');

						$this->CI->benchmark->mark('start_query_dokumen');
						$this->db->select('id, id_ref, file_name, extension, path');
						$this->db->from('dokumen');
						$this->db->where('table_name', 'putusan');

						// -- Start chunk array $data_id_putusan --
						$this->db->group_start();
						$data_id_putusan_chunk = array_chunk($data_id_putusan, 50);
						foreach($data_id_putusan_chunk as $data_ids)
						{
							$this->db->or_where_in('"id_ref"', $data_ids);
						}
						$this->db->group_end();
						// -- End array chunk --

						$this->db->where('jenis_dokumen', 'putusan');
						$this->db->where('sub_jenis_dokumen', 'putusan');
						$t_dokumen = $this->db->get();

						$this->CI->benchmark->mark('end_query_dokumen');
						$total_dokumen = $t_dokumen->num_rows();
						$output_message[] = 'Query document : ' . $this->CI->benchmark->elapsed_time('start_query_dokumen', 'end_query_dokumen') . '. ' . $total_dokumen . ' docs';

						$data_id_putusan = [];
						$dokumens = [];
						$data_putusan = [];
						$id_putusan_arr = [];

						if ($total_dokumen === 0)
							continue;

						$docs_all = $t_dokumen->result();

						$this->CI->benchmark->mark('start_broken_check_process');
						foreach ($docs_all as $k_docs_all => $doc_all) {
							$dokumens[$doc_all->id_ref][] = $doc_all;
						}

						$message = NULL;
						foreach ($dokumens as $id_putusan => $dok) {
							$is_rtf = false;
							$is_pdf = false;
							$is_pdf_corrupt = false;
							$is_rtf_corrupt = false;
							$is_html = false;
							foreach ($dok as $idx_dok => $dokumen) {
								$filePath = $dokumen->path . $dokumen->file_name . '.dat';
								if ($dokumen->extension == 'pdf') {
									if (file_exists($filePath)) {
										$statusPdf = $this->CI->lib_pdf->check_pdf($filePath);
										if ($statusPdf->status == true) {
											$is_pdf = true;
										} else {
											$is_pdf_corrupt = true;
											$message .= $statusPdf->message . PHP_EOL;
										}
									} else
										$message .= 'File PDF tidak ada' . PHP_EOL;
								} elseif ($dokumen->extension == 'rtf') {
									if (file_exists($filePath)) {
										$cek_rtf = mime_content_type($filePath);
										if ($cek_rtf === 'text/rtf')
											$is_rtf = true;
										else {
											$is_rtf_corrupt = true;
											$message .= 'Mime type File upload bukan RTF' . PHP_EOL;
										}
									} else
										$message .= 'File RTF tidak ada' . PHP_EOL;
								} elseif ($dokumen->extension == 'zip') {
									if (file_exists($filePath)) {
										$statusHtml = $this->check_html($filePath);
										if($statusHtml->status == true) {
											$is_html = true;
										}
									}
								}
							}

							if ($is_pdf == true && $is_rtf == false && $is_pdf_corrupt == false && $is_rtf_corrupt == false) {
								$type = 'putusan_empty_rtf'; // -- rtf tidak ada dan pdf ada
							}
							elseif ($is_rtf == true && $is_pdf == false && $is_pdf_corrupt == false && $is_rtf_corrupt == false) {
								$type = 'putusan_empty_pdf'; // -- pdf tidak ada dan rtf ada -> ini yang diproses converter
							}
							elseif ($is_pdf == false && $is_rtf == false && $is_pdf_corrupt == false && $is_rtf_corrupt == false) {
								$type = 'putusan_empty_pdf_rtf'; // -- pdf tidak ada dan rtf ada -> ini yang diproses converter
							}
							elseif ($is_pdf_corrupt == true) {
								$type = 'putusan_corrupt_pdf'; // -- pdf ada tapi corrupt -> ini yang diproses converter
							}
							elseif ($is_rtf_corrupt == true) {
								$type = 'putusan_corrupt_rtf'; // -- rtf ada tapi corrupt
							}
							elseif ($is_pdf == true && $is_rtf == true && $is_pdf_corrupt == false && $is_rtf_corrupt == false) {
								$type = 'putusan_no_problem'; // -- pdf ada dan rtf ada -> ini tidak di proses converter, dan tidak masuk tabel queue (jika data sudah ada maka di update saja)
								$message = 'Pengecekan File PDF tidak bermasalah dan File RTF ada, proses konversi diubah menjadi WORKER-COMPLETED dan Sukses.';
							}

							$data_putusan[$id_putusan] = array(
								'type' => $type,
								'message' => $message,
								'metadata' => json_encode($metadata[$id_putusan])
							);

							$id_putusan_arr[] = $id_putusan;
						}

						$this->CI->benchmark->mark('end_broken_check_process');
						$output_message[] = 'Broken check : ' . $this->CI->benchmark->elapsed_time('start_broken_check_process', 'end_broken_check_process');

						$this->CI->benchmark->mark('start_query_queue');
						$this->db->select('id, ref_id, is_sukses, status');
						$this->db->where('(type = \'putusan_empty_rtf\' OR type = \'putusan_empty_pdf\' OR type = \'putusan_empty_pdf_rtf\' OR type = \'putusan_corrupt_pdf\' OR type = \'putusan_corrupt_rtf\')');

						$this->db->group_start();
						$data_id_putusan_chunk = array_chunk($id_putusan_arr, 50);
						foreach($data_id_putusan_chunk as $data_ids)
						{
							$this->db->or_where_in('"ref_id"', $data_ids);
						}
						$this->db->group_end();

						$check_queue = $this->db->get($queue_table)->result();
						$this->CI->benchmark->mark('end_query_queue');
						$output_message[] = 'Query queue : ' . $this->CI->benchmark->elapsed_time('start_query_queue', 'end_query_queue');

						$this->CI->benchmark->mark('start_generate_batch');
						$data_queue = [];
						if (isset($check_queue) && ! empty($check_queue)) {
							foreach ($check_queue as $k_queue => $queue_data) {
								$data_queue[$queue_data->ref_id] = $queue_data;
							}
						}
						if (isset($data_putusan) && ! empty($data_putusan)) {
							foreach ($data_putusan as $id_put => $value) {
								if (array_key_exists($id_put, $data_queue)) {
									// hanya update apabila is sukses 1 dan status worker-completed
									if ($data_queue[$id_put]->is_sukses == 1 && $data_queue[$id_put]->status == 'WORKER-COMPLETED' || $value['type'] === 'putusan_no_problem') {
										$data_update = [];
										$data_update['id'] = $data_queue[$id_put]->id;
										$data_update['ref_id'] = $data_queue[$id_put]->ref_id;
										$data_update['table'] = 'APP_PUTUSAN.putusan';
										$data_update['type'] = $value['type'];
										if ($value['type'] == 'putusan_no_problem') {
											$data_update['status'] = 'WORKER-COMPLETED';
											$data_update['is_sukses'] = 1;
										} else {
											$data_update['status'] = 'SERVER-QUEUE';
											$data_update['is_sukses'] = 0;
										}
										$data_update['status_keterangan'] =  $value['message'];
										$data_update['metadata'] = $value['metadata'];
										$data_update['updated'] = date('Y-m-d H:i:s');
										$data_db['update'][] = $data_update;
									}
								} else {
									// Tidak akan insert data apabila sudah ada pdf yang benar dan rtfnya
									if($value['type'] !== 'putusan_no_problem'){
										$data_insert = [];
										$data_insert['id'] = guid();
										$data_insert['ref_id'] = $id_put;
										$data_insert['table'] = 'APP_PUTUSAN.putusan';
										$data_insert['type'] = $value['type'];
										$data_insert['status'] = 'SERVER-QUEUE';
										$data_insert['is_sukses'] = 0;
										$data_insert['status_keterangan'] = $value['message'];
										$data_insert['metadata'] = $value['metadata'];
										$data_insert['created'] = date('Y-m-d H:i:s');
										$data_insert['updated'] = date('Y-m-d H:i:s');
										$data_db['insert'][] = $data_insert;
									}
								}
							}
						}
						$this->CI->benchmark->mark('end_generate_batch');

						$this->CI->benchmark->mark('start_batch_upsert');
						if ($test == 0 && ! empty($data_db)) {
							if (isset($data_db['update']) && ! empty($data_db['update'])) {
								$this->db->update_batch('APP_PUTUSAN.' . $queue_table, $data_db['update'], 'id');
							}
							if (isset($data_db['insert']) && ! empty($data_db['insert'])) {
								$this->db->insert_batch('APP_PUTUSAN.' . $queue_table, $data_db['insert']);
							}
						}
						$this->CI->benchmark->mark('end_batch_upsert');
						$output_message[] = 'Generate batch : ' . $this->CI->benchmark->elapsed_time('start_generate_batch', 'end_generate_batch');
						$output_message[] = 'Upsert queue : ' . $this->CI->benchmark->elapsed_time('start_batch_upsert', 'end_batch_upsert')
							. '. Insert : ' . (isset($data_db['insert'])  && ! empty($data_db['insert']) ? count($data_db['insert']) : 0)
							. ' | Update : ' . (isset($data_db['update']) && ! empty($data_db['update']) ? count($data_db['update']) : 0);
						$data_db = [];
					}
				}

				$offset += $limit;

				$this->CI->benchmark->mark('start_query_putusan');
				$this->db->select('id, nomor, id_pengadilan, tingkat_proses, created');
				$this->db->from('putusan');
				if ( ! empty($created))
					$this->db->where('created >=', $created);
				$this->db->limit($limit, $offset);
				$this->db->order_by('created', 'ASC');
				$t_putusan = $this->db->get();
				$num_rows = $t_putusan->num_rows();
				$this->CI->benchmark->mark('end_query_putusan');
				$output_message[] = 'Query putusan : ' . $this->CI->benchmark->elapsed_time('start_query_putusan', 'end_query_putusan');

				$this->CI->benchmark->mark('end_all');

				$total_time = $this->CI->benchmark->elapsed_time('start_all', 'end_all');
				$elapsed_time += $total_time;
				$output_message[] = 'Elapsed time : ' . second_to_time($elapsed_time);

				$output_message[] = 'Total putusan : ' . $total_putusan;
				$progress_in_percent = (($total_putusan_processed + $jlh_putusan) / ($total_putusan + $total_putusan_processed)) * 100;
				$output_message[] = 'Progress : ' . number_format($progress_in_percent, 2) . '%';
				if ($progress_in_percent >= $renew_total_putusan) {
					if ( ! empty($created))
						$this->db->where('created >=', $created);
					$this->db->from('putusan');
					$total_putusan = $this->db->count_all_results();
					$output_message[] = 'Renew total putusan count';
					$renew_total_putusan = $renew_total_putusan + 10;
				}

				$speed = $elapsed_time / $jlh_putusan;
				$output_message[] = 'Speed : ' . $speed . ' s / putusan';

				$eta_in_sec = ($total_putusan - $jlh_putusan) * $speed;
				$output_message[] = 'ETA : ' . second_to_time($eta_in_sec);

				echo 'processed : ' . $jlh_putusan
					. ' | ' . $total_time
					. ' | ' . number_format(memory_get_usage() / (1024 * 1024), 2) . ' MB'
					. ' | ' . $last_created . PHP_EOL;

				foreach ($output_message as $msg) {
					echo '  -> ' . $msg . PHP_EOL;
				}
				echo PHP_EOL;
			} while ($num_rows > 0);
			// echo "\n Total: $jlh_putusan";
		}
	}

	public function check_html($path) {
		$return = new stdClass();
		$return->status = false;
		$return->message = '';


		return $return;
	}
}