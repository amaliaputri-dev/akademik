<?php $this->load->view('templates/header'); ?>

<div class="layout-grid">
	<div>
		<section class="panel hero-panel">
			<div class="panel-body">
				<h2>Manajemen Data Mahasiswa</h2>
				<p>
					Modul ini dipakai untuk memantau identitas akademik mahasiswa, status aktif,
					sebaran jurusan, dan kesiapan layanan semester seperti KRS, jadwal, serta nilai.
				</p>
				<div class="hero-actions">
					<a class="btn-light" href="<?php echo site_url('dashboard'); ?>">Kembali ke Dashboard</a>
					<a class="btn-outline" href="<?php echo site_url('akademik/krs'); ?>">Lihat KRS</a>
					<?php if (!empty($can_create)) : ?>
						<a class="btn-outline" href="<?php echo site_url('mahasiswa'); ?>">Form Data Baru</a>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<?php if (!empty($success_message)) : ?>
					<div class="alert"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></div>
				<?php endif; ?>

				<?php if (!empty($can_create) || (!empty($can_update) && !empty($selected_mahasiswa))) : ?>
					<h2 class="section-title"><?php echo !empty($selected_mahasiswa) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa'; ?></h2>
					<form action="<?php echo $form_action; ?>" method="post">
						<div class="form-grid">
							<div class="field-group">
								<label for="nim">NIM</label>
								<input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars(!empty($selected_mahasiswa) ? $selected_mahasiswa['nim'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
							<div class="field-group">
								<label for="nama">Nama</label>
								<input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars(!empty($selected_mahasiswa) ? $selected_mahasiswa['nama'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
							<div class="field-group">
								<label for="jurusan">Jurusan</label>
								<select id="jurusan" name="jurusan" required>
									<option value="">Pilih jurusan</option>
									<?php foreach ($jurusan_list as $jurusan) : ?>
										<?php $is_selected = !empty($selected_mahasiswa) && $selected_mahasiswa['jurusan'] === $jurusan['nama_jurusan']; ?>
										<option value="<?php echo htmlspecialchars($jurusan['nama_jurusan'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars($jurusan['kode_jurusan'] . ' - ' . $jurusan['nama_jurusan'] . (!empty($jurusan['nama_fakultas']) ? ' (' . $jurusan['nama_fakultas'] . ')' : ''), ENT_QUOTES, 'UTF-8'); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-actions">
							<button class="btn-light" type="submit"><?php echo !empty($selected_mahasiswa) ? 'Simpan Perubahan' : 'Tambah Mahasiswa'; ?></button>
							<?php if (!empty($selected_mahasiswa)) : ?>
								<a class="btn-outline" href="<?php echo $cancel_url; ?>">Batal Edit</a>
							<?php endif; ?>
						</div>
					</form>
				<?php endif; ?>

				<h2 class="section-title" style="margin-top: 22px;">Daftar Mahasiswa</h2>
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>No</th>
								<th>NIM</th>
								<th>Nama</th>
								<th>Jurusan</th>
								<th>Status</th>
								<?php if (!empty($can_update) || !empty($can_delete)) : ?>
									<th>Aksi</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($mahasiswa)) : ?>
								<?php $no = 1; ?>
								<?php foreach ($mahasiswa as $row) : ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo htmlspecialchars($row['nim'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($row['jurusan'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><span class="status-pill">Aktif</span></td>
										<?php if (!empty($can_update) || !empty($can_delete)) : ?>
											<td>
												<div class="hero-actions" style="margin-top: 0;">
													<?php if (!empty($can_update)) : ?>
														<a class="btn-outline" href="<?php echo site_url('mahasiswa/edit/' . $row['id']); ?>">Edit</a>
													<?php endif; ?>
													<?php if (!empty($can_delete)) : ?>
														<a class="btn-danger" href="<?php echo site_url('mahasiswa/delete/' . $row['id']); ?>" onclick="return confirm('Hapus data mahasiswa ini?');">Hapus</a>
													<?php endif; ?>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="<?php echo (!empty($can_update) || !empty($can_delete)) ? '6' : '5'; ?>">Belum ada data mahasiswa.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>

	<div>
		<section class="panel">
			<div class="panel-body">
				<h2 class="section-title">Statistik Mahasiswa</h2>
					<div class="stats-grid">
						<div class="stat-card">
						<div class="stat-label">Total Mahasiswa</div>
						<div class="stat-value"><?php echo (int) $total_mahasiswa; ?></div>
						<div class="stat-note">Jumlah mahasiswa aktif yang tercatat di sistem.</div>
					</div>
						<div class="stat-card">
							<div class="stat-label">Total Jurusan</div>
							<div class="stat-value"><?php echo (int) $total_jurusan; ?></div>
							<div class="stat-note">Program studi yang saat ini memiliki mahasiswa aktif.</div>
						</div>
						<div class="stat-card">
							<div class="stat-label">Total Fakultas</div>
							<div class="stat-value"><?php echo (int) $total_fakultas; ?></div>
							<div class="stat-note">Master fakultas untuk pengelompokan jurusan dan role pimpinan.</div>
						</div>
					</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<?php if (!empty($can_create_jurusan) || (!empty($can_update_jurusan) && !empty($selected_jurusan))) : ?>
					<h2 class="section-title">Kelola Jurusan</h2>
					<form action="<?php echo $jurusan_form_action; ?>" method="post">
						<div class="form-grid">
							<div class="field-group">
								<label for="kode_jurusan">Kode Jurusan</label>
								<input type="text" id="kode_jurusan" name="kode_jurusan" value="<?php echo htmlspecialchars(!empty($selected_jurusan) ? $selected_jurusan['kode_jurusan'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
							<div class="field-group">
								<label for="nama_jurusan">Nama Jurusan</label>
								<input type="text" id="nama_jurusan" name="nama_jurusan" value="<?php echo htmlspecialchars(!empty($selected_jurusan) ? $selected_jurusan['nama_jurusan'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
							<div class="field-group">
								<label for="fakultas_id">Fakultas</label>
								<select id="fakultas_id" name="fakultas_id" required>
									<option value="">Pilih fakultas</option>
									<?php foreach ($fakultas_list as $fakultas) : ?>
										<?php $jurusan_selected = !empty($selected_jurusan) && (int) $selected_jurusan['fakultas_id'] === (int) $fakultas['id']; ?>
										<option value="<?php echo (int) $fakultas['id']; ?>" <?php echo $jurusan_selected ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars($fakultas['kode_fakultas'] . ' - ' . $fakultas['nama_fakultas'], ENT_QUOTES, 'UTF-8'); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-actions">
							<button class="btn-light" type="submit"><?php echo !empty($selected_jurusan) ? 'Simpan Jurusan' : 'Tambah Jurusan'; ?></button>
							<?php if (!empty($selected_jurusan)) : ?>
								<a class="btn-outline" href="<?php echo $cancel_url; ?>">Batal Edit</a>
							<?php endif; ?>
						</div>
					</form>
				<?php endif; ?>

				<h2 class="section-title" style="margin-top: 22px;">Daftar Jurusan</h2>
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Jurusan</th>
								<th>Fakultas</th>
								<?php if (!empty($can_update_jurusan) || !empty($can_delete_jurusan)) : ?>
									<th>Aksi</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($jurusan_list)) : ?>
								<?php $jurusan_no = 1; ?>
								<?php foreach ($jurusan_list as $jurusan) : ?>
									<tr>
										<td><?php echo $jurusan_no++; ?></td>
										<td><?php echo htmlspecialchars($jurusan['kode_jurusan'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($jurusan['nama_jurusan'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars(!empty($jurusan['nama_fakultas']) ? $jurusan['nama_fakultas'] : '-', ENT_QUOTES, 'UTF-8'); ?></td>
										<?php if (!empty($can_update_jurusan) || !empty($can_delete_jurusan)) : ?>
											<td>
												<div class="hero-actions" style="margin-top: 0;">
													<?php if (!empty($can_update_jurusan)) : ?>
														<a class="btn-outline" href="<?php echo site_url('mahasiswa/edit_jurusan/' . $jurusan['id']); ?>">Edit</a>
													<?php endif; ?>
													<?php if (!empty($can_delete_jurusan)) : ?>
														<a class="btn-danger" href="<?php echo site_url('mahasiswa/delete_jurusan/' . $jurusan['id']); ?>" onclick="return confirm('Hapus data jurusan ini?');">Hapus</a>
													<?php endif; ?>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="<?php echo (!empty($can_update_jurusan) || !empty($can_delete_jurusan)) ? '5' : '4'; ?>">Belum ada data jurusan.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<?php if (!empty($can_create_fakultas) || (!empty($can_update_fakultas) && !empty($selected_fakultas))) : ?>
					<h2 class="section-title" style="margin-top: 22px;">Kelola Fakultas</h2>
					<form action="<?php echo $fakultas_form_action; ?>" method="post">
						<div class="form-grid">
							<div class="field-group">
								<label for="kode_fakultas">Kode Fakultas</label>
								<input type="text" id="kode_fakultas" name="kode_fakultas" value="<?php echo htmlspecialchars(!empty($selected_fakultas) ? $selected_fakultas['kode_fakultas'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
							<div class="field-group">
								<label for="nama_fakultas">Nama Fakultas</label>
								<input type="text" id="nama_fakultas" name="nama_fakultas" value="<?php echo htmlspecialchars(!empty($selected_fakultas) ? $selected_fakultas['nama_fakultas'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
							</div>
						</div>
						<div class="form-actions">
							<button class="btn-light" type="submit"><?php echo !empty($selected_fakultas) ? 'Simpan Fakultas' : 'Tambah Fakultas'; ?></button>
							<?php if (!empty($selected_fakultas)) : ?>
								<a class="btn-outline" href="<?php echo $cancel_url; ?>">Batal Edit</a>
							<?php endif; ?>
						</div>
					</form>
				<?php endif; ?>

				<h2 class="section-title" style="margin-top: 22px;">Daftar Fakultas</h2>
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Fakultas</th>
								<?php if (!empty($can_update_fakultas) || !empty($can_delete_fakultas)) : ?>
									<th>Aksi</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($fakultas_list)) : ?>
								<?php $fakultas_no = 1; ?>
								<?php foreach ($fakultas_list as $fakultas) : ?>
									<tr>
										<td><?php echo $fakultas_no++; ?></td>
										<td><?php echo htmlspecialchars($fakultas['kode_fakultas'], ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($fakultas['nama_fakultas'], ENT_QUOTES, 'UTF-8'); ?></td>
										<?php if (!empty($can_update_fakultas) || !empty($can_delete_fakultas)) : ?>
											<td>
												<div class="hero-actions" style="margin-top: 0;">
													<?php if (!empty($can_update_fakultas)) : ?>
														<a class="btn-outline" href="<?php echo site_url('mahasiswa/edit_fakultas/' . $fakultas['id']); ?>">Edit</a>
													<?php endif; ?>
													<?php if (!empty($can_delete_fakultas)) : ?>
														<a class="btn-danger" href="<?php echo site_url('mahasiswa/delete_fakultas/' . $fakultas['id']); ?>" onclick="return confirm('Hapus data fakultas ini?');">Hapus</a>
													<?php endif; ?>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="<?php echo (!empty($can_update_fakultas) || !empty($can_delete_fakultas)) ? '4' : '3'; ?>">Belum ada data fakultas.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<h2 class="section-title">Aksi Cepat</h2>
				<div class="mini-list">
					<div class="mini-card">
						<strong>Sinkronisasi KRS</strong>
						<p>Hubungkan data mahasiswa ke pengambilan mata kuliah semester berjalan.</p>
					</div>
					<div class="mini-card">
						<strong>Monitoring Dosen Wali</strong>
						<p>Pantau mahasiswa yang masih menunggu proses perwalian.</p>
					</div>
					<div class="mini-card">
						<strong>Publikasi Nilai</strong>
						<p>Siapkan jalur distribusi KHS berdasarkan NIM dan kelas aktif.</p>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
