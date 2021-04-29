<table border="1" cellpadding="8">
	<tr>
		<th>NIS</th>
		<th>Nama</th>
		<th>Jenis Kelamin</th>
		<th>Telepon</th>
		<th>Alamat</th>
	</tr>

    <?php
   
		foreach($users as $row){ // Lakukan looping pada variabel siswa dari controller
			echo "<tr>";
			echo "<td>".$row->username."</td>";
			echo "<td>".$row->email."</td>";
			echo "<td>".$row->jabatan."</td>";
			echo "<td>".$row->level."</td>";
			echo "<td>".$row->first_name."</td>";
			echo "</tr>";
		}
	
	?>
</table>
