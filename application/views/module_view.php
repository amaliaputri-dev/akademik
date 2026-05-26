<?php $this->load->view('templates/header'); ?>

<div class="layout-grid">
	<div>
		<section class="panel hero-panel">
			<div class="panel-body">
				<h2><?php echo htmlspecialchars($module_title, ENT_QUOTES, 'UTF-8'); ?></h2>
				<p><?php echo htmlspecialchars($module_description, ENT_QUOTES, 'UTF-8'); ?></p>
				<div class="hero-actions">
					<a class="btn-light" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
					<a class="btn-outline" href="<?php echo site_url('mahasiswa'); ?>">Data Mahasiswa</a>
					<?php if (!empty($can_create)) : ?>
						<a class="btn-outline" href="<?php echo $cancel_url; ?>">Form Data Baru</a>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<?php if (!empty($success_message)) : ?>
					<div class="alert"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></div>
				<?php endif; ?>

				<?php if (!empty($can_create) || (!empty($can_update) && !empty($selected_record))) : ?>
					<h2 class="section-title"><?php echo !empty($selected_record) ? 'Edit ' . ucfirst($module_label) : 'Tambah ' . ucfirst($module_label); ?></h2>
					<form action="<?php echo $form_action; ?>" method="post">
						<div class="form-grid">
							<?php foreach ($module_fields as $field => $meta) : ?>
								<div class="field-group">
									<label for="<?php echo $field; ?>"><?php echo htmlspecialchars($meta['label'], ENT_QUOTES, 'UTF-8'); ?></label>
									<?php if (!empty($field_options[$field])) : ?>
										<select id="<?php echo $field; ?>" name="<?php echo $field; ?>" required>
											<option value="">Pilih <?php echo htmlspecialchars($meta['label'], ENT_QUOTES, 'UTF-8'); ?></option>
											<?php foreach ($field_options[$field] as $option_value => $option_label) : ?>
												<?php
												$selected_value = !empty($selected_record) && isset($selected_record[$field]) ? (string) $selected_record[$field] : '';
												if ($selected_value === '' && $field === 'mahasiswa_id' && !empty($selected_record['mahasiswa_id'])) {
													$selected_value = (string) $selected_record['mahasiswa_id'];
												}
												$is_selected = $selected_value === (string) $option_value;
												?>
												<option value="<?php echo htmlspecialchars((string) $option_value, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
													<?php echo htmlspecialchars((string) $option_label, ENT_QUOTES, 'UTF-8'); ?>
												</option>
											<?php endforeach; ?>
										</select>
									<?php else : ?>
										<input
											type="<?php echo htmlspecialchars(isset($meta['type']) ? $meta['type'] : 'text', ENT_QUOTES, 'UTF-8'); ?>"
											id="<?php echo $field; ?>"
											name="<?php echo $field; ?>"
											value="<?php echo htmlspecialchars(!empty($selected_record) && isset($selected_record[$field]) ? (string) $selected_record[$field] : '', ENT_QUOTES, 'UTF-8'); ?>"
											<?php echo isset($meta['step']) ? 'step="' . htmlspecialchars($meta['step'], ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
											<?php echo isset($meta['min']) ? 'min="' . htmlspecialchars($meta['min'], ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
											required
										>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="form-actions">
							<button class="btn-light" type="submit"><?php echo !empty($selected_record) ? 'Simpan Perubahan' : 'Tambah Data'; ?></button>
							<?php if (!empty($selected_record)) : ?>
								<a class="btn-outline" href="<?php echo $cancel_url; ?>">Batal Edit</a>
							<?php endif; ?>
						</div>
					</form>
				<?php endif; ?>

				<h2 class="section-title" style="margin-top: 22px;">Data Modul</h2>
				<div class="table-wrap">
					<table>
						<thead>
							<tr>
								<?php foreach ($table_headers as $header) : ?>
									<th><?php echo htmlspecialchars($header, ENT_QUOTES, 'UTF-8'); ?></th>
								<?php endforeach; ?>
								<?php if (!empty($can_update) || !empty($can_delete)) : ?>
									<th>Aksi</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($table_rows)) : ?>
								<?php foreach ($table_rows as $row) : ?>
									<tr>
										<?php foreach ($table_keys as $key) : ?>
											<td><?php echo htmlspecialchars((string) $row[$key], ENT_QUOTES, 'UTF-8'); ?></td>
										<?php endforeach; ?>
										<?php if (!empty($can_update) || !empty($can_delete)) : ?>
											<td>
												<div class="hero-actions" style="margin-top: 0;">
													<?php if (!empty($can_update)) : ?>
														<a class="btn-outline" href="<?php echo site_url('akademik/edit/' . $module_key . '/' . $row['id']); ?>">Edit</a>
													<?php endif; ?>
													<?php if (!empty($can_delete)) : ?>
														<a class="btn-danger" href="<?php echo site_url('akademik/delete/' . $module_key . '/' . $row['id']); ?>" onclick="return confirm('Hapus data ini?');">Hapus</a>
													<?php endif; ?>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="<?php echo count($table_headers) + ((!empty($can_update) || !empty($can_delete)) ? 1 : 0); ?>">Belum ada data pada modul ini.</td>
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
				<h2 class="section-title">Ringkasan Modul</h2>
				<div class="stats-grid">
					<?php foreach ($module_stats as $stat) : ?>
						<div class="stat-card">
							<div class="stat-label"><?php echo htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="stat-value"><?php echo htmlspecialchars((string) $stat['value'], ENT_QUOTES, 'UTF-8'); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Agenda Akademik</h2>
				<div class="mini-list">
					<?php foreach ($calendar_items as $item) : ?>
						<div class="mini-card">
							<strong><?php echo htmlspecialchars($item['tanggal'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<p><?php echo htmlspecialchars($item['agenda'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
