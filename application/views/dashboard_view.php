<?php $this->load->view('templates/header'); ?>
<?php
$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
$profile_identity_label = 'Identitas';
$profile_program_label = 'Program Studi';
$profile_avatar = 'UBS';

if ($role_slug === 'mahasiswa')
{
	$profile_identity_label = 'NIM';
	$profile_program_label = 'Program Studi';
	$profile_avatar = 'MHS';
}
elseif ($role_slug === 'dosen')
{
	$profile_identity_label = 'NIDN';
	$profile_program_label = 'Prodi';
	$profile_avatar = 'DSN';
}
elseif ($role_slug === 'baak')
{
	$profile_identity_label = 'Unit';
	$profile_program_label = 'Fokus';
	$profile_avatar = 'BAA';
}
elseif ($role_slug === 'admin')
{
	$profile_identity_label = 'Akun';
	$profile_program_label = 'Area';
	$profile_avatar = 'ADM';
}
elseif ($role_slug === 'rektor')
{
	$profile_identity_label = 'Jabatan';
	$profile_program_label = 'Lingkup';
	$profile_avatar = 'REK';
}
elseif ($role_slug === 'wakil-rektor')
{
	$profile_identity_label = 'Jabatan';
	$profile_program_label = 'Lingkup';
	$profile_avatar = 'WR';
}
elseif ($role_slug === 'dekan')
{
	$profile_identity_label = 'Jabatan';
	$profile_program_label = 'Lingkup';
	$profile_avatar = 'DK';
}
elseif ($role_slug === 'wakil-dekan')
{
	$profile_identity_label = 'Jabatan';
	$profile_program_label = 'Lingkup';
	$profile_avatar = 'WD';
}
elseif ($role_slug === 'dekan-kaprodi')
{
	$profile_identity_label = 'Jabatan';
	$profile_program_label = 'Fokus';
	$profile_avatar = 'DK';
}
elseif ($role_slug === 'keuangan')
{
	$profile_identity_label = 'Unit';
	$profile_program_label = 'Fokus';
	$profile_avatar = 'KEU';
}
?>

<style>
	.home-grid {
		display: grid;
		grid-template-columns: minmax(0, 1.85fr) minmax(310px, 0.9fr);
		gap: 22px;
		max-width: 1320px;
		margin: 22px auto 0;
	}

	.home-stack {
		display: grid;
		gap: 22px;
	}

	.section-head {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		align-items: center;
		gap: 12px;
		margin-bottom: 18px;
	}

	.section-head h2 {
		margin: 0;
		font-size: 1rem;
		font-weight: 800;
		color: #082e57;
	}

	.section-head p {
		margin: 6px 0 0;
		color: var(--muted);
	}

	.date-chip {
		padding: 10px 14px;
		border-radius: 999px;
		background: #f5f8fd;
		border: 1px solid var(--border);
		color: #4c617c;
		font-weight: 700;
	}

	.schedule-day {
		padding: 12px 16px;
		border-radius: 10px;
		background: #f5f5f5;
		color: #466381;
		font-weight: 700;
		margin-bottom: 20px;
	}

	.schedule-list {
		display: grid;
		gap: 18px;
	}

	.schedule-card {
		padding: 18px 18px 16px;
		border: 1px solid var(--border);
		border-radius: 16px;
		background: #fff;
		box-shadow: 0 8px 20px rgba(16, 37, 66, 0.04);
	}

	.schedule-title {
		margin: 0 0 18px;
		font-size: 0.98rem;
		font-weight: 800;
		color: #0a2a4c;
	}

	.schedule-body {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 220px;
		gap: 18px;
		align-items: start;
	}

	.schedule-meta {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 14px 18px;
	}

	.meta-item {
		display: flex;
		gap: 10px;
		align-items: flex-start;
		color: #213f62;
	}

	.meta-icon {
		width: 22px;
		height: 22px;
		border-radius: 8px;
		background: #edf4fd;
		color: var(--primary);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 0.72rem;
		font-weight: 900;
		flex: 0 0 22px;
		margin-top: 1px;
	}

	.meta-item span {
		line-height: 1.55;
	}

	.outline-button {
		display: inline-flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
		padding: 12px 16px;
		border-radius: 10px;
		border: 1px solid var(--accent);
		color: var(--primary);
		text-decoration: none;
		font-weight: 700;
		background: #fff;
	}

	.side-card {
		padding: 22px;
		border-radius: 16px;
		border: 1px solid var(--border);
		background: #fff;
		box-shadow: var(--shadow);
	}

	.profile-card {
		display: grid;
		grid-template-columns: 98px minmax(0, 1fr);
		gap: 16px;
		align-items: center;
	}

	.owl-avatar,
	.bill-illustration {
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 18px;
		background: #f4f8ff;
		color: var(--primary);
		font-size: 2rem;
		font-weight: 900;
	}

	.owl-avatar {
		min-height: 86px;
	}

	.bill-illustration {
		min-height: 160px;
		margin-bottom: 16px;
	}

	.side-card h3 {
		margin: 0 0 6px;
		font-size: 1rem;
		color: #062b53;
	}

	.side-card p {
		margin: 0;
		color: var(--muted);
		line-height: 1.7;
	}

	.profile-meta {
		margin-top: 10px;
		display: grid;
		gap: 6px;
		font-size: 0.92rem;
		color: #4f6684;
	}

	.side-section-title {
		margin: 10px 0 12px;
		font-size: 0.98rem;
		font-weight: 800;
		color: #082e57;
	}

	.kpi-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 12px;
		margin-top: 16px;
	}

	.kpi-card {
		padding: 14px;
		border-radius: 14px;
		border: 1px solid var(--border);
		background: #fff;
	}

	.kpi-card small {
		display: block;
		margin-bottom: 8px;
		font-size: 0.78rem;
		font-weight: 800;
		letter-spacing: 0.04em;
		text-transform: uppercase;
	}

	.kpi-card strong {
		display: block;
		font-size: 1.35rem;
		line-height: 1.1;
		color: #082e57;
	}

	.kpi-blue {
		background: #f4f8ff;
	}

	.kpi-gold {
		background: #fff8ea;
	}

	.kpi-green {
		background: #eefbf3;
	}

	.kpi-slate {
		background: #f5f7fb;
	}

	.calendar-shell {
		padding: 16px;
		border-radius: 14px;
		border: 1px solid var(--border);
		background: #fff;
	}

	.calendar-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 1rem;
		font-weight: 800;
		color: #415d80;
		margin-bottom: 14px;
	}

	.calendar-nav {
		color: #9ab0cb;
		font-size: 1.6rem;
		line-height: 1;
	}

	.event-list {
		display: grid;
		gap: 10px;
	}

	.event-item {
		padding: 12px 14px;
		border-radius: 12px;
		background: #f8fbff;
		border: 1px solid #e4edf7;
	}

	.event-item strong {
		display: block;
		margin-bottom: 4px;
		color: #0c3764;
	}

	.event-item span {
		color: var(--muted);
		font-size: 0.92rem;
	}

	.shortcut-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
		gap: 16px;
	}

	.shortcut-card {
		padding: 16px;
		border-radius: 14px;
		border: 1px solid var(--border);
		background: #fff;
	}

	.shortcut-card strong {
		display: block;
		margin-bottom: 8px;
		color: #0a2d54;
	}

	.shortcut-card p {
		margin: 0 0 12px;
		color: var(--muted);
		line-height: 1.65;
	}

	.shortcut-card a {
		color: var(--primary);
		font-weight: 700;
		text-decoration: none;
	}

	.feature-table-note {
		margin-top: 14px;
		color: var(--muted);
		font-size: 0.92rem;
	}

	@media (max-width: 980px) {
		.home-grid {
			grid-template-columns: 1fr;
		}

		.schedule-body {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 720px) {
		.schedule-meta {
			grid-template-columns: 1fr;
		}

		.profile-card {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="home-grid">
	<div class="home-stack">
		<section class="panel">
			<div class="panel-body">
				<div class="section-head">
					<div>
						<h2><?php echo htmlspecialchars($today_schedule['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
						<p><?php echo htmlspecialchars($today_schedule['total_text'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
					<div class="date-chip"><?php echo htmlspecialchars($today_schedule['date_label'], ENT_QUOTES, 'UTF-8'); ?></div>
				</div>

				<div class="schedule-day"><?php echo htmlspecialchars($today_schedule['date_label'], ENT_QUOTES, 'UTF-8'); ?></div>

				<div class="schedule-list">
					<?php if (isset($today_schedule['panel_type']) && $today_schedule['panel_type'] === 'operations') : ?>
						<?php foreach ($today_schedule['items'] as $item) : ?>
							<div class="schedule-card">
								<h3 class="schedule-title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
								<p style="margin: 0; color: var(--muted); line-height: 1.7;"><?php echo htmlspecialchars($item['meta'], ENT_QUOTES, 'UTF-8'); ?></p>
							</div>
						<?php endforeach; ?>
						<div class="schedule-card">
							<a class="outline-button" href="<?php echo $today_schedule['action_url']; ?>">
								<?php echo htmlspecialchars($today_schedule['action_label'], ENT_QUOTES, 'UTF-8'); ?>
								<span>&#9662;</span>
							</a>
						</div>
					<?php elseif (!empty($today_schedule['items'])) : ?>
						<?php foreach ($today_schedule['items'] as $item) : ?>
							<div class="schedule-card">
								<h3 class="schedule-title"><?php echo htmlspecialchars($item['course'], ENT_QUOTES, 'UTF-8'); ?></h3>
								<div class="schedule-body">
									<div class="schedule-meta">
										<div class="meta-item">
											<div class="meta-icon">JM</div>
											<span><?php echo htmlspecialchars($item['time'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
										<div class="meta-item">
											<div class="meta-icon">SK</div>
											<span><?php echo htmlspecialchars($item['sks'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
										<div class="meta-item">
											<div class="meta-icon">DS</div>
											<span><?php echo htmlspecialchars($item['lecturer'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
										<div class="meta-item">
											<div class="meta-icon">PR</div>
											<span><?php echo htmlspecialchars($item['meeting'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
										<div class="meta-item">
											<div class="meta-icon">RG</div>
											<span><?php echo htmlspecialchars($item['room'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
										<div class="meta-item">
											<div class="meta-icon">HD</div>
											<span><?php echo htmlspecialchars($item['attendance'], ENT_QUOTES, 'UTF-8'); ?></span>
										</div>
									</div>
									<div>
										<a class="outline-button" href="<?php echo $today_schedule['action_url']; ?>">
											<?php echo htmlspecialchars($today_schedule['action_label'], ENT_QUOTES, 'UTF-8'); ?>
											<span>&#9662;</span>
										</a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="schedule-card">
							<h3 class="schedule-title">Belum ada jadwal</h3>
							<p style="margin: 0 0 16px; color: var(--muted); line-height: 1.7;">Jadwal untuk role ini belum tersedia pada semester aktif.</p>
							<a class="outline-button" href="<?php echo $today_schedule['action_url']; ?>">
								<?php echo htmlspecialchars($today_schedule['action_label'], ENT_QUOTES, 'UTF-8'); ?>
								<span>&#9662;</span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="panel">
			<div class="panel-body">
				<div class="section-head">
					<div>
						<h2><?php echo htmlspecialchars($dashboard_context['service_title'], ENT_QUOTES, 'UTF-8'); ?></h2>
						<p><?php echo htmlspecialchars($dashboard_context['service_description'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>
				<div class="shortcut-grid">
					<?php foreach ($quick_menus as $menu) : ?>
						<div class="shortcut-card">
							<strong><?php echo htmlspecialchars($menu['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<p><?php echo htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8'); ?></p>
							<a href="<?php echo $menu['url']; ?>">Buka fitur</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>

	<div class="home-stack">
		<section class="side-card">
			<div class="profile-card">
				<div class="owl-avatar"><?php echo htmlspecialchars($profile_avatar, ENT_QUOTES, 'UTF-8'); ?></div>
				<div>
					<h3><?php echo htmlspecialchars($student_snapshot['greeting'], ENT_QUOTES, 'UTF-8'); ?></h3>
					<p><?php echo htmlspecialchars($student_snapshot['summary'], ENT_QUOTES, 'UTF-8'); ?> <a href="<?php echo htmlspecialchars($student_snapshot['detail_url'], ENT_QUOTES, 'UTF-8'); ?>" style="color: var(--primary); text-decoration: none; font-weight: 700;"><?php echo htmlspecialchars($student_snapshot['detail_label'], ENT_QUOTES, 'UTF-8'); ?></a></p>
					<div class="profile-meta">
						<div><strong>Nama:</strong> <?php echo htmlspecialchars($student_snapshot['name'], ENT_QUOTES, 'UTF-8'); ?></div>
						<div><strong>Role:</strong> <?php echo htmlspecialchars($student_snapshot['role'], ENT_QUOTES, 'UTF-8'); ?></div>
						<div><strong>Identitas:</strong> <?php echo htmlspecialchars($student_snapshot['identity'], ENT_QUOTES, 'UTF-8'); ?></div>
						<?php if (!empty($student_snapshot['nim']) && $student_snapshot['nim'] !== '-') : ?>
							<div><strong><?php echo htmlspecialchars($profile_identity_label, ENT_QUOTES, 'UTF-8'); ?>:</strong> <?php echo htmlspecialchars($student_snapshot['nim'], ENT_QUOTES, 'UTF-8'); ?></div>
						<?php endif; ?>
						<?php if (!empty($student_snapshot['program']) && $student_snapshot['program'] !== '-') : ?>
							<div><strong><?php echo htmlspecialchars($profile_program_label, ENT_QUOTES, 'UTF-8'); ?>:</strong> <?php echo htmlspecialchars($student_snapshot['program'], ENT_QUOTES, 'UTF-8'); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if (!empty($role_kpis)) : ?>
				<div class="kpi-grid">
					<?php foreach ($role_kpis as $kpi) : ?>
						<div class="kpi-card kpi-<?php echo htmlspecialchars($kpi['tone'], ENT_QUOTES, 'UTF-8'); ?>">
							<small><?php echo htmlspecialchars($kpi['label'], ENT_QUOTES, 'UTF-8'); ?></small>
							<strong><?php echo htmlspecialchars($kpi['value'], ENT_QUOTES, 'UTF-8'); ?></strong>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>

		<div>
			<div class="side-section-title"><?php echo htmlspecialchars($dashboard_context['side_title'], ENT_QUOTES, 'UTF-8'); ?></div>
			<section class="side-card">
				<div class="bill-illustration"><?php echo htmlspecialchars($dashboard_context['side_icon'], ENT_QUOTES, 'UTF-8'); ?></div>
				<h3 style="text-align: center;"><?php echo htmlspecialchars($billing_summary['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
				<p style="text-align: center;"><?php echo htmlspecialchars($billing_summary['message'], ENT_QUOTES, 'UTF-8'); ?></p>
			</section>
		</div>

		<div>
			<div class="side-section-title">Kalender Akademik</div>
			<section class="side-card">
				<div class="calendar-shell">
					<div class="calendar-header">
						<span class="calendar-nav">&#8249;</span>
						<span><?php echo htmlspecialchars($mini_calendar['month'], ENT_QUOTES, 'UTF-8'); ?></span>
						<span class="calendar-nav">&#8250;</span>
					</div>
					<div class="event-list">
						<?php foreach ($mini_calendar['events'] as $event) : ?>
							<div class="event-item">
								<strong><?php echo htmlspecialchars($event['date'], ENT_QUOTES, 'UTF-8'); ?></strong>
								<span><?php echo htmlspecialchars($event['text'], ENT_QUOTES, 'UTF-8'); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		</div>

		<div>
			<div class="side-section-title">Pengumuman</div>
			<section class="side-card">
				<div class="event-list">
					<?php foreach ($announcements as $announcement) : ?>
						<div class="event-item">
							<strong><?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
							<span><?php echo htmlspecialchars($announcement['content'], ENT_QUOTES, 'UTF-8'); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
