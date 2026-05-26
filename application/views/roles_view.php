<?php $this->load->view('templates/header'); ?>

<div class="layout-grid">
	<div>
		<section class="panel hero-panel">
			<div class="panel-body">
				<h1>Role Pengelola Kampus</h1>
				<p>
					Setiap role di SIAKAD ini punya sudut pandang kerja yang berbeda. Struktur ini membantu dashboard,
					hak akses, dan layanan akademik terasa lebih realistis seperti portal kampus yang benar-benar dipakai.
				</p>
				<div class="hero-actions">
					<a class="btn-light" href="<?php echo site_url('roles/detail/rektor'); ?>">Lihat Role Rektor</a>
					<a class="btn-outline" href="<?php echo site_url('roles/detail/baak'); ?>">Lihat Role BAAK</a>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Daftar Role</h2>
				<div class="role-grid">
					<?php foreach ($roles as $role) : ?>
						<div class="role-card">
							<span class="role-meta"><?php echo htmlspecialchars($role['level'], ENT_QUOTES, 'UTF-8'); ?></span>
							<strong><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<p><?php echo htmlspecialchars($role['focus'], ENT_QUOTES, 'UTF-8'); ?></p>
							<div class="mini-list" style="margin-top: 12px;">
								<?php foreach (array_slice($role['features'], 0, 2) as $feature) : ?>
									<div class="status-pill"><?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?></div>
								<?php endforeach; ?>
							</div>
							<a class="link-arrow" href="<?php echo site_url('roles/detail/' . $role['slug']); ?>">Buka dashboard role</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Matriks Hak Akses</h2>
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<th>Fitur</th>
								<?php foreach ($feature_matrix['columns'] as $column) : ?>
									<th><?php echo htmlspecialchars($column, ENT_QUOTES, 'UTF-8'); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($feature_matrix['rows'] as $row) : ?>
								<tr>
									<td><?php echo htmlspecialchars($row['feature'], ENT_QUOTES, 'UTF-8'); ?></td>
									<?php foreach (array_keys($feature_matrix['columns']) as $key) : ?>
										<td><?php echo htmlspecialchars($row[$key], ENT_QUOTES, 'UTF-8'); ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>

	<div>
		<section class="panel">
			<div class="panel-body">
				<h2 class="section-title">Ringkasan Organisasi</h2>
				<div class="stats-grid">
					<div class="stat-card">
						<div class="stat-label">Jumlah Role</div>
						<div class="stat-value"><?php echo (int) $total_roles; ?></div>
						<div class="stat-note">Mencakup admin, pimpinan, administrasi, pengajar, dan pengguna akhir.</div>
					</div>
					<div class="stat-card">
						<div class="stat-label">Mahasiswa Tercatat</div>
						<div class="stat-value"><?php echo (int) $total_mahasiswa; ?></div>
						<div class="stat-note">Objek layanan utama yang memerlukan kolaborasi lintas role.</div>
					</div>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Kenapa Role Ditambah</h2>
				<div class="mini-list">
					<div class="mini-card">
						<strong>Rektor dan Wakil Rektor</strong>
						<p>Perlu dashboard strategis, bukan sekadar melihat data tabel operasional.</p>
					</div>
					<div class="mini-card">
						<strong>BAAK dan Keuangan</strong>
						<p>Dua unit ini biasanya paling sibuk di proses semester, jadi wajib punya fitur sendiri.</p>
					</div>
					<div class="mini-card">
						<strong>Dekan / Kaprodi</strong>
						<p>Supaya kontrol kurikulum, dosen pengampu, dan kelas tidak dicampur dengan tugas admin pusat.</p>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
