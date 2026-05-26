<?php $this->load->view('templates/header'); ?>

<div class="layout-grid">
	<div>
		<section class="panel hero-panel">
			<div class="panel-body">
				<h1><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
				<p><?php echo htmlspecialchars($role['focus'], ENT_QUOTES, 'UTF-8'); ?></p>
				<div class="hero-actions">
					<a class="btn-light" href="<?php echo site_url('roles'); ?>">Semua Role</a>
					<a class="btn-outline" href="<?php echo site_url('dashboard'); ?>">Dashboard Utama</a>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Modul Kerja Role</h2>
				<div class="role-grid">
					<?php foreach ($role['modules'] as $module) : ?>
						<div class="role-card">
							<strong><?php echo htmlspecialchars($module, ENT_QUOTES, 'UTF-8'); ?></strong>
							<p>Disiapkan sebagai area kerja utama untuk role <?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?>.</p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Alur Kerja Inti</h2>
				<div class="timeline">
					<?php foreach ($role['workflows'] as $workflow) : ?>
						<div class="timeline-item">
							<strong><?php echo htmlspecialchars($workflow['step'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<span>Pelaksana: <?php echo htmlspecialchars($workflow['owner'], ENT_QUOTES, 'UTF-8'); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>

	<div>
		<section class="panel">
			<div class="panel-body">
				<h2 class="section-title">Ringkasan Role</h2>
				<div class="stats-grid">
					<?php foreach ($role['summary_stats'] as $stat) : ?>
						<div class="stat-card">
							<div class="stat-label"><?php echo htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="stat-value"><?php echo htmlspecialchars((string) $stat['value'], ENT_QUOTES, 'UTF-8'); ?></div>
							<div class="stat-note"><?php echo htmlspecialchars($stat['note'], ENT_QUOTES, 'UTF-8'); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Fitur Utama</h2>
				<div class="mini-list">
					<?php foreach ($role['features'] as $feature) : ?>
						<div class="mini-card">
							<strong><?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?></strong>
							<p>Masuk dalam cakupan kerja role ini pada SIAKAD kampus.</p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="panel" style="margin-top: 22px;">
			<div class="panel-body">
				<h2 class="section-title">Inbox Prioritas</h2>
				<div class="mini-list">
					<?php foreach ($role['inbox'] as $item) : ?>
						<div class="mini-card">
							<strong><?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?></strong>
							<p>Butuh perhatian pada dashboard role untuk menjaga proses akademik tetap lancar.</p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
