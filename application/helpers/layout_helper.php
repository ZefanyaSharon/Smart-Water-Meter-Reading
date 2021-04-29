<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if (!function_exists('layout_list')) {
	function layout_list($data, $type) {
		switch ($type) {
			case 'putusan':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_name) . '">' . $data->pengadilan . '</a>';
				$layout .= kategori_public($data->id_kategori);
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-time color"></i>';
				if ( ! empty($data->tanggal_register)) {
					$layout .= '<strong>Register:</strong>' . date('d-m-Y', strtotime($data->tanggal_register)) .'&#8212;';
				}
				$layout .= '<strong>Putus :</strong>' . date('d-m-Y', strtotime($data->tanggal_putusan)) . '&#8212;';
				$layout .= '<strong>Upload :</strong>' . date('d-m-Y', strtotime($data->created));
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '<a href="' . site_url('direktori/putusan/' . trim($data->id)) . '">Putusan ' . $data->pengadilan . ' Nomor ' . $data->nomor . '</a><br>';
				if(!empty($data->para_pihak)) {
					$layout .= $data->para_pihak;
				} else {
					if(!empty($data->pemohon) && !empty($data->institusi_penuntut)) {
						$layout .= '<strong>Pemohon :</strong>' . $data->pemohon . '<br>';
						$layout .= '<strong>Institusi Penuntut :</strong> ' . $data->institusi_penuntut;
					} else {
						if(!empty($data->pemohon)) {
							$layout .= '<strong>Pemohon :</strong> ' . $data->pemohon;
						} if(!empty($data->institusi_penuntut)) {
							$layout .= '<strong>Institusi Penuntut :</strong> ' . $data->institusi_penuntut;
						}
					}
				}
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'peraturan':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan') . '"> Peraturan <i class="fa fa-angle-double-right"></i> ' . '</a>';$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan/bidang/jenis/' . str_replace(' ','-',$data->jenis)) . '"> ' . $data->jenis . ' <i class="fa fa-angle-double-right"></i> ' . '</a>';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan/bidang/jenis/' . str_replace(' ','-',$data->jenis) . '/tahun/' . $data->tahun) . '">' .$data->tahun. '</a>';
				$layout .= '<br>';
				$layout .= '<a href="' . site_url('peraturan/detail/' . $data->id) . '">' . $data->jenis . ' Nomor ' . $data->nomor . ' Tahun ' . $data->tahun . '</a>';
				$layout .= '<br>';
				$layout .= '<strong> Tentang : </strong>';
				$bp = '<a class="read_more" href="' . site_url('peraturan/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->tentang, $bp);
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li>';
				$layout .= '<i class="icon-folder-open"></i>';
				$layout .= $data->jenis;
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'rumusan_kamar':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('rumusan_kamar') . '"> Rumusan ' . '</a>';
				$layout .= kategori_public($data->id_kategori);
				$layout .= '<br>';
				$layout .= '<a href="' . site_url('rumusan_kamar/detail/' . $data->id) . '">' . $data->no_rk . '</a>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="rumusan_kamar_container">';
				$bp = '<a class="read_more" href="' . site_url('rumusan_kamar/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->rumusan, $bp);
				$layout .= '</div>';
				$layout .= '<strong>Kata Kunci : </strong>' . $data->keyword;
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'restatement':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
					if (isset($data->image)) {
						$layout .= '<img src=' . $data->image . ' alt=""></a>';
					} else {
						$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
					}
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('restatement') . '">' . config_item('jenis_kategori')[$data->jenis_kategori] . '</a>';
				$layout .= kategori_public($data->id_kategori);
				$layout .= '<br>';
				$layout .= '<a href="' . site_url('restatement/detail/' . $data->id) . '">' . $data->judul . '</a>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="restatement_container">';
				$bp = '<a class="read_more" href="' . site_url('restatement/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->ringkasan, $bp);
				$layout .= '</div>';
				$layout .= '<strong>Author :</strong> ';
				foreach ($data->author as $author) {
					$layout .= $author->nama_author . '; ';
				}
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'yurisprudensi':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('yurisprudensi') . '"> Yurisprudensi ' . '</a>';
				$layout .= kategori_public($data->id_kategori);
				$layout .= '<br>';
				$layout .= '<a href="' . site_url('yurisprudensi/detail/' . $data->id) . '">' . $data->no_katalog . '</a>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="yurisprudensi_container">';
				$bp = '<a class="read_more" href="' . site_url('yurisprudensi/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->yurisprudensi, $bp);
				$layout .= '</div>';
				$layout .= '<strong>Kata Kunci : </strong>' . $data->kata_kunci;
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'kaidah':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_name) . '">' . $data->pengadilan . '</a>';
				$layout .= kategori_public($data->id_kategori);
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-time color"></i>';
				if ( ! empty($data->tanggal_register)) {
					$layout .= '<strong>Register:</strong>' . date('d-m-Y', strtotime($data->tanggal_register)) .'&#8212;';
				}
				$layout .= '<strong>Putus :</strong>' . date('d-m-Y', strtotime($data->tanggal_putusan)) . '&#8212;';
				$layout .= '<strong>Upload :</strong>' . date('d-m-Y', strtotime($data->created));
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '<a href="' . site_url('kaidah/detail/' . $data->id) . '"> Putusan Nomor ' . $data->nomor . '</a>';
				$layout .= '<br>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="restatement_container">';
				$bp = '<a class="read_more" href="' . site_url('kaidah_hukum/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->kaidah_hukum, $bp);
				$layout .= '</div>';
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
		}
	}
}

if (!function_exists('layout_list_es')) {
	function layout_list_es($data, $type, $site = NULL) {
		$CI =&get_instance();
		$CI->load->helper('Es');

		switch ($type) {
			case 'putusan':
				$layout = '';
				$layout .= '<div class="spost clearfix record">';
				$layout .= '<div class="entry-c">';
				if ($data->is_pilihan === true){
					$layout .= '<div style="float:right">';
					$layout .= '<i class="i-rounded i-small i-light icon-star" title="Pilihan" style="cursor:default"></i>';
					$layout .= '</div>';
				}
				if ( ! empty($data->pengadilan)) {
					$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_pengadilan) . '">' . $data->pengadilan . '</a>';
				} else {
					if (isset($site))
						$layout .= '<a style="font-size: 12px;" href="' . site_url($site) . '">' . $data->nama_pengadilan . '</a>';
					else
						$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_pengadilan) . '">' . $data->nama_pengadilan . '</a>';
				}
				if ( ! empty((array) $data->kategori)) {
					if (isset($site))
						$layout .= kategori_public($data->kategori[0]->id, $site);
					else
						$layout .= kategori_public($data->kategori[0]->id);
					}
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li style="font-size: 11px"><i class="icon-time color"></i>';
				if (!empty($data->tanggal_register)) {
					$layout .= '<strong>Register :</strong> ' . date('d-m-Y', strtotime($data->tanggal_register)) . '&#8212;';
				}
				$layout .= '<strong>Putus :</strong> ' . date('d-m-Y', strtotime($data->tanggal_putusan)) . '&#8212;';
				$layout .= '<strong>Upload :</strong> ' . date('d-m-Y', strtotime($data->created));
				$layout .= '</li>';
				if ($data->is_bht === true) {
					$layout .= '<li style="font-size: 11px;>';
					$layout .= '<i class="icon-check" style="color:green;"></i> <strong style="color:green;">Berkekuatan Hukum Tetap</strong>';
					$layout .= '</li>';
				}
				$layout .= '</ul>';
				if ( ! empty($data->pengadilan)) {
					$layout .= '<strong><a href="' . site_url('direktori/putusan/' . trim($data->id)) . '">Putusan ' . $data->pengadilan . ' Nomor ' . $data->nomor . '</a></strong><br>';
				} else {
					$layout .= '<strong><a href="' . site_url('direktori/putusan/' . trim($data->id)) . '">Putusan ' . $data->nama_pengadilan . ' Nomor ' . $data->nomor . '</a></strong><br>';
				}
				if(!empty($data->para_pihak)) {
					$layout .= '<div style="font-size: 12px">' . $data->para_pihak .'</div>';
				} else {
					if(!empty($data->pemohon) && !empty($data->institusi_penuntut)) {
						$layout .= '<div style="font-size: 12px">';
						$layout .= '<strong>Pemohon :</strong> ' . $data->pemohon . '<br>';
						$layout .= '<strong>Institusi Penuntut :</strong> ' . $data->institusi_penuntut;
						$layout .= '</div>';
					} else {
						if(!empty($data->pemohon)) {
							$layout .= '<div style="font-size: 12px">';
							$layout .= '<strong>Pemohon :</strong> ' . $data->pemohon;
							$layout .= '</div>';

						} if(!empty($data->institusi_penuntut)) {
							$layout .= '<div style="font-size: 12px">';
							$layout .= '<strong>Institusi Penuntut :</strong> ' . $data->institusi_penuntut;
							$layout .= '</div>';
						}
					}
				}
				if ( ! empty((array) $data->kategori)) {
					if ($data->kategori[0]->parent_url_name !== 'perdata-agama' &&
						strpos($data->kategori[0]->url_name, 'kesusilaan') === false &&
						$data->kategori[0]->url_name !== 'anak') {

						$terdakwa = '';
						if (isset($data->identitas)) {
							foreach($data->identitas as $identitas) {
								$terdakwa .= $identitas->nama . ', ';
							}
						}
					}
				}
				$layout .= ! empty($terdakwa) ? '<br>' .rtrim($terdakwa, ', ') : '';
				if (isset($data->resultHighlight)) {
					foreach ($data->resultHighlight as $highlight) {
						$layout .= '<blockquote style="font-size: 12px; margin-left: 30px">';
							$layout .= $highlight;
						$layout .= '</blockquote>';
					}
				}
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'peraturan':
				$layout = '';
				$layout .= '<div class="spost clearfix record">';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan') . '"> Peraturan <i class="fa fa-angle-double-right"></i> ' . '</a>';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan/bidang/jenis/' . str_replace(' ','-',$data->jenis_peraturan)) . '"> ' . $data->jenis_peraturan . ' <i class="fa fa-angle-double-right"></i> ' . '</a>';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('peraturan/bidang/jenis/' . str_replace(' ','-',$data->jenis_peraturan) . '/tahun/' . $data->tahun_peraturan) . '">' .$data->tahun_peraturan. '</a>';
				$layout .= '<br>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li style="font-size: 13px;">';
				$layout .= '<i class="icon-folder-open"></i>';
				$layout .= $data->jenis_peraturan;
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '<strong><a href="' . site_url('peraturan/detail/' . $data->id) . '">' . $data->jenis_peraturan . ' Nomor ' . $data->nomor . ' Tahun ' . $data->tahun_peraturan . '</a></strong>';
				$layout .= '<br>';
				$layout .= '<div style="font-size: 12px">';
				$layout .= '<strong> Tentang : </strong>';
				$bp = '<a class="read_more" href="' . site_url('peraturan/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->tentang_peraturan, $bp);
				$layout .= '</div>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'rumusan_kamar':
				$layout = '';
				$layout .= '<div class="spost clearfix record">';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('rumusan_kamar') . '"> Rumusan ' . '</a>';
				$layout .= kategori_public($data->rk_id_kategori);
				$layout .= '<div style="font-size: 12px">';
					foreach ($data->keywords  as $key => $val_key) {
						$layout .= '<strong>Kata Kunci : </strong>' . $val_key->keyword;
					}
				$layout .= '</div>';
				$layout .= '<strong><a href="' . site_url('rumusan_kamar/detail/' . $data->id) . '">' . $data->nomor . '</a></strong>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="rumusan_kamar_container">';
				$bp = '<a class="read_more" href="' . site_url('rumusan_kamar/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->rk_rumusan, $bp);
				$layout .= '</div>';
				$layout .= '</li>';
				$layout .= '<li>';
				if (isset($data->resultHighlight)) {
					foreach ($data->resultHighlight as $highlight) {
						$layout .= '<blockquote style="font-size: 12px; margin-left: 30px">';
							$layout .=	$highlight;
						$layout .= '</blockquote>';
					}
				}
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'restatement':
				$layout = '';
				$layout .= '<div class="spost clearfix record">';
				$layout .= '<div class="entry-image">';
				if (isset($data->image)) {
					$layout .= '<img src=' . $data->image . ' alt=""></a>';
				} else {
					$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				}
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('restatement') . '">' . ucwords(strtolower($data->jenis_doc)) . '</a>';
				$layout .= kategori_public($data->rs_id_kategori);
				$layout .= '<div style="font-size: 12px;">';
				$layout .= '<strong>Author :</strong> ';
				foreach ($data->rs_authors as $author) {
					$layout .= $author->nama . '; ';
				}
				$layout .= '</div>';
				$layout .= '<strong><a href="' . site_url('restatement/detail/' . $data->id) . '">' . $data->rs_judul . '</a></strong>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="restatement_container">';
				$bp = '<a class="read_more" href="' . site_url('restatement/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->rs_ringkasan, $bp);
				$layout .= '</div>';
				$layout .= '</li>';
				$layout .= '<li>';
				if (isset($data->resultHighlight)){
					foreach ($data->resultHighlight as $highlight) {
						$layout .= '<blockquote style="font-size: 12px; margin-left: 30px">';
							$layout .=	$highlight;
						$layout .= '</blockquote>';
					}
				}
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'yurisprudensi':
				$layout = '';
				$layout .= '<div class="spost clearfix record">';
				$layout .= '<div class="entry-c">';
				$layout .= '<a style="font-size: 12px;" href="' . site_url('yurisprudensi') . '"> Yurisprudensi ' . '</a>';
				$layout .= kategori_public($data->yr_id_kategori);
				$layout .= '<div style="font-size: 12px">';
					foreach ($data->keywords  as $key => $val_key) {
						$layout .= '<strong>Kata Kunci : </strong>' . $val_key->keyword;
					}
				$layout .= '</div>';
				$layout .= '<strong><a href="' . site_url('yurisprudensi/detail/' . $data->id) . '">' . $data->nomor . '</a></strong>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="yurisprudensi_container">';
				$bp = '<a class="read_more" href="' . site_url('yurisprudensi/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->yr_yurisprudensi, $bp);
				$layout .= '</div>';
				$layout .= '</li>';
				$layout .= '<li>';
				if (isset($data->resultHighlight)){
					foreach ($data->resultHighlight as $highlight) {
						$layout .= '<blockquote style="font-size: 12px; margin-left: 30px">';
							$layout .=	$highlight;
						$layout .= '</blockquote>';
					}
				}
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
			case 'kaidah':
				$layout = '';
				$layout .= '<div class="spost clearfix">';
				$layout .= '<div class="entry-image">';
				$layout .= '<img class="rounded-circle" src=' . base_url('public/frontend/images/doc-48-green.png') . ' alt=""></a>';
				$layout .= '</div>';
				$layout .= '<div class="entry-c">';
				if ( ! empty($data->pengadilan)) {
					$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_pengadilan) . '">' . $data->pengadilan . '</a>';
				} else {
					$layout .= '<a style="font-size: 12px;" href="' . site_url('pengadilan/profil/pengadilan/' . $data->url_pengadilan) . '">' . $data->nama_pengadilan . '</a>';
				}
				if ( ! empty((array) $data->kategori))
					$layout .= kategori_public($data->kategori[0]->id);
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li style="font-size: 11px"><i class="icon-time color"></i>';
				if (!empty($data->tanggal_register)) {
					$layout .= '<strong>Register :</strong> ' . date('d-m-Y', strtotime($data->tanggal_register)) . '&#8212;';
				}
				$layout .= '<strong>Putus :</strong> ' . date('d-m-Y', strtotime($data->tanggal_putusan)) . '&#8212;';
				$layout .= '<strong>Upload :</strong> ' . date('d-m-Y', strtotime($data->created));
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '<strong><a href="' . site_url('kaidah/detail/' . $data->id) . '"> Putusan Nomor ' . $data->nomor . '</a></strong>';
				$layout .= '<br>';
				$layout .= '<ul class="iconlist nobottommargin">';
				$layout .= '<li><i class="icon-quote-left" style="color:green;"></i>';
				$layout .= '<div class="restatement_container">';
				$bp = '<a class="read_more" href="' . site_url('kaidah_hukum/detail/' . $data->id) .'">'. ' ... [Read more]</a>';
				$layout .= string_limit($data->kaidah_hukum, $bp);
				$layout .= '</div>';
				$layout .= '</li>';
				$layout .= '</ul>';
				$layout .= '</div>';
				$layout .= '</div>';

				return $layout;
				break;
		}
	}
}
