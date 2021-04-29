<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if (!function_exists('navigation_breadcrumb')) {
	function navigation_breadcrumb($data) {
		$layout = '';
		$layout .= '<style>
						.breadcrumb {
							position: static !important;
							width: auto !important;
							top: 0 !important;
							left: 0 !important;
							right: 0 !important;
							margin: 0 !important;
							background-color: transparent !important;
							padding: 0 !important;
							font-size: 12px;
						}
					</style>';
		$layout .= '<section id="page-title" style = "margin-bottom : 10px">';
		$layout .= '<div class="container clearfix">';
		$layout .= '<ol class="breadcrumb">';
		$layout .= '<li class="breadcrumb-item"><a href="' . site_url('beranda') . '">Beranda</a></li>';
		$layout .= '<li class="breadcrumb-item"><a href="' . site_url(strtolower(str_replace(' ', '_', $data['title']))) . '">' . $data['title'] . '</a></li>';

		if ( ! empty( $data['pengadilan']))
			$layout .= '<li class="breadcrumb-item"><a href="' . site_url('pengadilan/profil/pengadilan/'.$data['pengadilan']) . '">' . strtoupper(trim(str_replace('-', ' ', $data['pengadilan']))) . '</a></li>';

		// For breadcrumb direktori,yuris,restatement,rumusan kamar
		if (isset($data['list_kategori']) && !empty($data['list_kategori'])) {
			foreach ($data['list_kategori'] as $list_kategori) {
				if($list_kategori['jenis_kategori'] == 'PTS') {
					$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/jenis/' . $list_kategori['url_name']).'"> '.$list_kategori['nama_kategori'].' </a>';
				} else if ($list_kategori['jenis_kategori'] == 'RK') {
					$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/kategori/' . $list_kategori['url_name']).'"> '.$list_kategori['nama_kategori'].' </a>';
				} else if ($list_kategori['jenis_kategori'] == 'YURIS') {
					$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/kategori/' . $list_kategori['url_name']).'"> '.$list_kategori['nama_kategori'].' </a>';
				} else if ($list_kategori['jenis_kategori'] == 'RST') {
					$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/jenis/' . $list_kategori['url_name']).'"> '.$list_kategori['nama_kategori'].' </a>';
				}
			}
			if (!empty($list_kategori['nama_kategori'])) {
				$layout .= '</ol>';
				$layout .= '<h1>' . $list_kategori['nama_kategori'] . '</h1>';
			}
		}
		// For breadcrumb periode direktori
		if (isset($data['currentYear']) && !empty($data['currentYear'])) {
			if ($data['periode'] == 'putus') {
				$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'].$data['periode']).'">Tahun Putus</a></li>';
			} else if ($data['periode'] == 'regis') {
				$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'].$data['periode']).'">Tahun Register</a></li>';
			} else if ($data['periode'] == 'upload') {
				$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'].$data['periode']).'">Tahun Upload</a></li>';
			}

			$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['currentUriWithoutMonth']).'"> '.$data['currentYear'].' </a></li>';

			if (isset($data['bulan']) && ! empty($data['bulan'])) {
				$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['currentUriWithoutMonth'] . '/bulan/' . $data['bulan']) . '"> '.config_item('months')[$data['bulan']].' </a></li>';
				$layout .= '</ol>';
			}

			$layout .= '</ol>';
		}
		// for breadcrumb jenis peraturan
		if (isset($data['list_jenis']) && empty($data['list_tahun'])) {
			$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/jenis/' . $data['list_jenis']).'"> '.$data['list_jenis'].' </a></li>';
			$layout .= '</ol>';
			$layout .= '<h1>' . $data['list_jenis'] . '</h1>';
		}
		// for breadcrumb tahun peraturan
		if(!empty($data['list_tahun'])) {
			$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/jenis/' . $data['list_jenis']).'"> '.$data['list_jenis'].' </a></li>';
			$layout .= '<li class="breadcrumb-item"></i> <a href="'.site_url($data['site'] . '/jenis/' . $data['list_jenis']. '/tahun/' . $data['list_tahun']) . '"> '.$data['list_tahun'].' </a></li>';
			$layout .= '</ol>';
			$layout .= '<h1>' . $data['list_jenis'] . '</h1>';
		}
		$layout .= '</ol>';
		if (empty($data['periode']) && empty($data['jenis']) && empty($data['list_kategori']) && empty( $data['pengadilan'])) {
			$layout .= '<h1>' . $data['title'] . '</h1>';
		}
		if ( ! empty( $data['pengadilan']))
			$layout .= '<h1>' . trim(str_replace('-', ' ', $data['pengadilan'])) . '</h1>';

		if(!empty($data['jenis'])) {
			if ($data['jenis'] == 'putus') {
				$layout .= '<h1> TAHUN PUTUS </h1>';
			} else if ($data['jenis'] == 'regis') {
				$layout .= '<h1> TAHUN REGISTER </h1>';
			} else if ($data['jenis'] == 'upload') {
				$layout .= '<h1> TAHUN UPLOAD </h1>';
			}
		}

		if (isset($data['periode']) && empty($data['bulan'])) {
			if ($data['periode'] == 'putus') {
				$layout .= '<h1> PUTUSAN YANG DI PUTUS TAHUN ' . $data['currentYear'] . '</h1>';
			} else if ($data['periode'] == 'regis') {
				$layout .= '<h1> PUTUSAN YANG DI REGISTER TAHUN ' . $data['currentYear'] . '</h1>';
			} else if ($data['periode'] == 'upload') {
				$layout .= '<h1> PUTUSAN YANG DI UPLOAD TAHUN ' . $data['currentYear'] . '</h1>';
			}
		}

		if (isset($data['bulan']) && ! empty($data['bulan'])) {
			if ($data['periode'] == 'putus') {
				$layout .= '<h1> PUTUSAN YANG DI PUTUS ' . config_item('months')[$data['bulan']] . ' ' . $data['currentYear'] . '</h1>';
			} else if ($data['periode'] == 'regis') {
				$layout .= '<h1> PUTUSAN YANG DI REGISTER ' . config_item('months')[$data['bulan']] . ' ' . $data['currentYear'] . '</h1>';
			} else if ($data['periode'] == 'upload') {
				$layout .= '<h1> PUTUSAN YANG DI UPLOAD ' . config_item('months')[$data['bulan']] . ' ' . $data['currentYear'] . '</h1>';
			}
		}
		$layout .= '</div>';
		$layout .= '</section>';

		return $layout;
	}
}