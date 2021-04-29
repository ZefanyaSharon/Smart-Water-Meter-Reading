<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if (!function_exists('menu')) {
	function menu($menus, $current_page='') {
		$menu_new = '';
		foreach((array)$menus as $menu) {
			$page_active = ($current_page === $menu->url ? 'class="active"' : '');
			if (isset($menu->childs) && count($menu->childs) > 0) {
				$menu_new .= '<li ' . $page_active . '>';
				if ($menu->url) {
					// $menu_new = '<a href="' . url('backend/' . $menu->URL) . '">';
					// $menu_new .= '<form action="http://localhost:85/putusan_baru/' . $menu->URL . '" id="form_id_menu" name="form_id_menu" method="POST">';
					// $menu_new .= '<input type="hidden" name="id_menu" id="id_menu" value=' . $menu->ID . ' class="form-control"/>';
					if (stripos($menu->url, 'backend/') !== FALSE)
						$menu_new .= '<a href="' . site_url($menu->url) . '">';
					else
						$menu_new .= '<a href="' . $menu->url . '">';

					$menu_new .= '<i class="fa ' . $menu->nama_icon . '"></i>';
					$menu_new .= '<span class="nav-label">' . $menu->name . '</span>';
					$menu_new .= '<span class="fa arrow"></span>';
					$menu_new .= '</a>';
				// $menu_new .= '</form>';
				} else {
					$menu_new .= '<a href="#">';
					$menu_new .= '<i class="fa ' . $menu->nama_icon . '"></i>';
					$menu_new .= '<span class="nav-label">' . $menu->name . '</span>';
					$menu_new .= '<span class="fa arrow"></span>';
					$menu_new .= '</a>';
				}
				$menu_new .= '<ul class="nav nav-second-level collapse">';
				$menu_new .= menu($menu->childs, $current_page);
				$menu_new .= '</ul>';
				$menu_new .= '</li>';
			} else {
				$menu_new .= '<li ' . $page_active . '>';
				// $menu_new = '<a href="' . url('backend/' . $menu->URL) . '">';
				// $menu_new .= '<form action="http://localhost:85/putusan_baru/'.$menu->URL.'" id="form_menu_arrange" name="form_menu_arrange" method="POST">';
				// $menu_new .= '<input type="hidden" name="id_menu" id="id_menu" value='.$menu->ID.' class="form-control"/>';
				if (stripos($menu->url, 'backend/') !== FALSE)
					$menu_new .= '<a href="' . site_url($menu->url) . '">';
				else
					$menu_new .= '<a href="' . $menu->url . '">';

				$menu_new .= '<i class="fa ' . $menu->nama_icon . '"></i>';
				if (!empty($menu->parent_id)) {
					$menu_new .= $menu->name;
				} else {
					$menu_new .= '<span class="nav-label">' . $menu->name . '</span>';
				}
				$menu_new .= '</a>';
				// $menu_new .= '</form>';
				$menu_new .= '</li>';
			}
			
		}
		
		return $menu_new;
	
	}

}

if (!function_exists('menu_arrange')) {
	function menu_arrange($menus) {
		$menu_new = '';
		// $menu_new .= '<div class="dd" id="nestable2">';
		// $menu_new .= '<ol class="dd-list">';
		foreach ($menus as $menu_idx => $menu) {
			$menu_new .= '<li class="dd-item" data-id="' . $menu->id . '">';
			$menu_new .= '<div class="dd-handle">';
			$menu_new .= '<span class="label label-info"><i class="fa ' . $menu->nama_icon . '"></i></span>' . $menu->name;
			$menu_new .= '</div>';
			if (!empty($menu->childs)) {
				$menu_new .= '<ol class="dd-list">';
				$menu_new .= menu_arrange($menu->childs);
				$menu_new .= '</ol>';
			}
			$menu_new .= '</li>';
		}
		// $menu_new .= '</ol>';
		// $menu_new .= '</div>';
		return $menu_new;
	}
}

if (!function_exists('master_kategori')) {
	function master_kategori($kategori) {
		$kategori_list = '';
		foreach ($kategori as $k_list => $v_list) {
			$label = $v_list->nama_kategori . ( ! empty($v_list->doc_count) ? ' <sup>(' . $v_list->doc_count . ')</sup>' : '');
			if ($v_list->parent_id !== null && empty($v_list->childs)) {
				$kategori_list .= '<li data-jstree="type:css}" id = "' . $v_list->id . '">' . $label . '</li>';
			} else {
				$kategori_list .= '<li class="jstree-close" id = ' . $v_list->id . '>' . $label;
			}
			if (!empty($v_list->childs)) {
				$kategori_list .= '<ul>';
				$kategori_list .= master_kategori($v_list->childs);
				$kategori_list .= '</ul>';
			}
			$kategori_list .= '</li>';
		}
		return $kategori_list;
	}
}

if (!function_exists('breadcrumb')) {
	function breadcrumb($list, $detail = '') {
		$breadcrumb = '';
		$breadcrumb .= '<ol class="breadcrumb">';
		$breadcrumb .= '<i class="fa ' . $list['icon'] . '" style = "margin-right:10px;"></i>';
		foreach ($list['split'] as $breadcrumbItem) {
			$breadcrumb .= '<li class="breadcrumb-item">';
			if (!empty($list['url'][$breadcrumbItem]))
				$breadcrumb .= '<a href="'.base_url($list['url'][$breadcrumbItem]).'">'.$breadcrumbItem.'</a>';
			else
				$breadcrumb .= $breadcrumbItem;
			$breadcrumb .= '</li>';
		}
		$breadcrumb .= '</ol>';

		return $breadcrumb;
	}
}

if (!function_exists('btnSearch')) {
	function btnSearch($id = '') {
		$btn = '';
		$btn .= '<div class="col-sm-12">';
		$btn .= '<div class="input-group">';
		$btn .= '<input type="text" class="form-control" name="inputSearch" id="InputSearch" placeholder="Kata kunci..." style="height:22px"><span class="input-group-append">';
		$btn .= '<button type="button" id="' . $id . '" class="btn btn-primary btn-xs" type="button" >Cari</button></span>';
		$btn .= '</div>';
		$btn .= '</div>';
		return $btn;
	}
}

if (!function_exists('btnStart')) {
	function btnStart($id = 'btnStart', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="' . $id . ' btn btn-primary btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= ' Start';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnRestart')) {
	function btnRestart($id = 'btnRestart', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="' . $id . ' btn btn-warning btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= ' Restart';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnStop')) {
	function btnStop($id = 'btnStop', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="' . $id . ' btn btn-danger btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= ' Stop';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnSwitch')) {
	function btnSwitch($worker, $id = 'btnSwitch', $prop = '') {
		$btn         = '';
		$btn .= '<div class="btn-group" style="margin-right:5px">';
		$btn .= '<button data-toggle="dropdown" id="" class="btn btn-warning btn-xs dropdown-toggle" ' . $prop . '>';
		$btn .= ' Switch <span class="caret">';
		$btn .= '</button>';
		$btn .= '<ul class="dropdown-menu">';
		foreach ($worker as $idx => $workers) {
			$btn .= '<li><a id="' . $id . '" data-id="' . $workers->id . '" class="' . $id . '" href="#">' . $workers->worker . '</a></li>';
		}
		$btn .= '</ul>';		
		$btn .= '</div>';
		return $btn;
	}
}

if (!function_exists('btnNew')) {
	function btnNew($id = 'btnNew', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="btn btn-primary btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-plus"></i>';
		$btn .= ' Tambah';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnEdit')) {
	function btnEdit($id = 'btnEdit', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="btn btn-warning btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-pencil"></i>';
		$btn .= ' Ubah';
		$btn .= '</button>';
		return $btn;
	}
}


if (!function_exists('btnEdits')) {
	function btnEdits($id = '') {
		$btn = '';
		$btn .='<a href="'.site_url('backend/user/form?id=' .$id).'" class="btn btn-sm btn-info fa fa-pencil">Edit</a>';
		//$btn .='<button  class="btn btn-warning btn-sm" href="'.site_url('backend/user/form?id=' . $id).'"> Edit</button>';
		return $btn;
	}
}


if (!function_exists('btnCari')) {
	function btnCari($id = '') {
		$btn = '';
		$btn .= '<div class="col-sm-12">';
		$btn .= '<div class="input-group">';
		$btn .= '<input type="text" class="form-control" name="inputSearch" id="InputSearch" placeholder="Kata kunci..." style="height:22px"><span class="input-group-append">';
		$btn .= '<button type="button" id="' . $id . '" class="btn btn-primary btn-xs" type="button">Cari</button></span>';
		$btn .= '</div>';
		$btn .= '</div>';
		return $btn;
	}
}

if (!function_exists('btnHapus')) {
	function btnHapus($id = '') {
		$btn = '';
		$btn .='<a href="'.site_url('backend/user/deletes/' .$id).'" class="btn btn-sm btn-danger fa fa-trash">Hapus</a>';

		
		return $btn;
	}
}

if (!function_exists('btnDelete')) {
	function btnDelete($id = 'btnDelete', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="' . $id . ' btn btn-danger btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-trash"></i>';
		$btn .= ' Hapus';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnMenuArrange')) {
	function btnMenuArrange($id = 'btnMenuArrange', $prop = '') {
		$btn = '';
		$btn .= '<a href="' . base_url('backend/Menu/menu_arrange') . '"><button id="' . $id . '" class="btn btn-primary btn-xs" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-pencil"></i>';
		$btn .= 'Urutan Menu';
		$btn .= '</button></a>';
		return $btn;
	}
}

if (!function_exists('btnExcel')) {
	function btnExcel($id = 'btnExcel', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="btn btn-primary btn-xs" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-file"></i>';
		$btn .= ' Excel';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnExcelPdf')) {
	function btnExcelPdf($id = 'btnExcelPdf', $prop = '') {
		$btn = '';
		$btn .= '<div class="btn-group" style="margin-right:5px">';
		$btn .= '<button data-toggle="dropdown" id="' . $id . '" class="btn btn-info btn-xs dropdown-toggle" ' . $prop . '>';
		$btn .= '<i class="fa fa-circle-thin"></i>';
		$btn .= ' Ekspor <span class="caret">';
		$btn .= '</button>';
		$btn .= '<ul class="dropdown-menu">';
		$btn .= '<li><a id="toExcel" href="#"><i class="fa fa-file-excel-o"></i> Excel</a></li>';
		$btn .= '<li><a id="toPdf" href="#"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>';
		$btn .= '</ul>';
		$btn .= '</div>';
		return $btn;
	}
}

if (!function_exists('btnBack')) {
	function btnBack($id = 'btnBack', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="btn btn-white btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-angle-double-left"></i>';
		$btn .= ' Kembali';
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('btnSubmit')) {
	function btnSubmit($id = 'btnSubmit', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="btn btn-primary btn-xs" style="margin-right:5px" type="button" ' . $prop . '>';
		$btn .= '<i class="fa fa-check"></i>';
		$btn .= ' Simpan';
		$btn .= '</button>';
		return $btn;
	}
}



if (!function_exists('btnCreate')) {
	function btnCreate($id = '') {
		$btn = '';
		$btn .= ' <form  class="form-user" method="post" action=" site_url(/repos/repos/save/)"> ';
		
        $btn .= ' <div id="app" class="row border-bottom white-bg" style="padding:10px; padding-bottom:170px;"> ';
		$btn .= '	<div class="col-md-12" style="padding-left:20px"> ';
		$btn .= '		<div class="wrapper wrapper-content"> ';
		$btn .= '			<div class="row"> ';
		$btn .= '				<div class="col-md-12"> ';
        $btn .= '                <label class="col-sm-2 control-label">Project Name</label> ';
        $btn .= '                <div class="form-group"> ';
        $btn .= '                <input type="textf" name="project_name" class="form-control" id="name" placeholder="Project Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /> ';
        $btn .= '                <div class="validation"></div> ';
        $btn .= '            </div> ';
		$btn .= '					<div class="form-group"> ';
		$btn .= '						<label class="col-sm-2 control-label">Database</label> ';
		$btn .= '						<div class="form-group"> ';
        $btn .= '                <select name="database"class="form-control" id="exampleFormControlSelect1"> ';
        $btn .= '                    <option disabled selected>Database</option> ';
        $btn .= '                    <option>PostgreSQL</option> ';
        $btn .= '                    <option>MariaDB</option> ';
        $btn .= '                    <option>MySQL</option> ';
        $btn .= '                </select> ';
        $btn .= '            </div> ';
		$btn .= '					</div> ';
        $btn .= '                    <label class="col-sm-2 control-label">Deskripsi</label> ';
		$btn .= '					<div class="form-group"> ';
        $btn .= '                <input type="text" name="deskripsi" class="form-control" id="name" placeholder="Deskripsi" data-rule="minlen:4" data-msg="Please enter at least 4 chars" /> ';
        $btn .= '                <div class="validation"></div> ';
        $btn .= '            </div> ';					
		$btn .= '				</div> ';
		$btn .= '			</div> ';
        $btn .= '            <?php echo form_close() ?> ';
        $btn .= '            <button class="btn btn-primary btn-xs" style="margin-right:5px" type="submit" onclick="cmd()" type="submit"><i class="fa fa-check"></i> Create</button> ';
		$btn .= '		</div> ';
		$btn .= '	</div> ';
		$btn .= '</div> ';

        

        $btn .=' </form>' ;
		return $btn;
	}
}

if (!function_exists('btnLogActivity')) {
	function btnLogActivity($jenis, $id) {
		$btn = '';
		if (Entrust::can('syslog-read') == true) {
			$btn .= '<a href="' . url('backend/log-activity/detail/' . $jenis . '/' . $id) . '" target="_blank"><img src="' . url('images/flat/log.png') . '" width="20" height="20" title="Log Activity"></a>';
		}
		return $btn;
	}
}

if (!function_exists('btn')) {
	function btn($id = 'btn', $class = 'btn btn-primary btn-xs', $icon = 'fa-check', $label = '', $prop = '') {
		$btn = '';
		$btn .= '<button id="' . $id . '" class="' . $class . '" type="button" ' . $prop . '>';
		$btn .= '<i class="fa ' . $icon . '"></i>';
		$btn .= ' ' . $label;
		$btn .= '</button>';
		return $btn;
	}
}

if (!function_exists('str_before')) {
	/**
	 * Return the remainder of a string after a given value.
	 *
	 * @param  string  $subject
	 * @param  string  $search
	 * @return string
	 */
	function str_before($str, $needle) {
		$pos = strpos($str, $needle);

		return ($pos !== false) ? substr($str, 0, $pos) : $str;
	}
}

if (!function_exists('duskStrFilter')) {
	/**
	 * Return filtered string for laravel dusk.
	 *
	 * @param  string  $str
	 * @return string
	 */
	function duskStrFilter($str) {
		return str_replace(["\n", "'"], ['\\n', "\'"], $str);
	}
}

if (!function_exists('formatBytes')) {
	function formatBytes($size, $from = 'Byte', $precision = 2) {
		$startFrom = 0;
		$unit      = ['Byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

		foreach ($unit as $un) {
			if ($un == $from) {
				break;
			}
			$startFrom++;
		}

		for ($i = $startFrom; $size >= 1024 && $i < count($unit) - 1; $i++) {
			$size /= 1024;
		}

		return round($size, $precision) . ' ' . $unit[$i];
	}
}
