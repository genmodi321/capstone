<?php
require 'processes/server/conn.php';

$query = "SELECT * FROM admin_notifications ORDER BY date DESC LIMIT 4 ";
$stmt = $pdo->prepare($query);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notifCount  =count($notifications);


$query = "SELECT * FROM admin_notifications WHERE status = 'unread' ORDER BY date DESC LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$notificationsUnread = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notificationCount = count($notificationsUnread);

?>


<ul class="navbar-nav navbar-align">
<li class="nav-item dropdown">
    <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
        <div class="position-relative">
            <i class="align-middle" data-feather="bell"></i>

            <?php if ($notificationCount > 0) { ?>
                <span class="indicator"><?php echo $notificationCount; ?></span>
            <?php } ?>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
        <div class="dropdown-menu-header">
            <?php if ($notificationCount > 0) { ?>
                <?php echo $notificationCount; ?> New Notifications
                <div class="dropdown-item text-center">
                    <button id="readAll" class="btn btn-link">Read All</button>
                    <button id="deleteAll" class="btn btn-link text-danger">Delete All</button>
                </div>
            <?php } else { ?>
                <?php echo "No new notifications" ?>
            <?php } ?>
        </div>
        <div class="list-group">
            <?php foreach ($notificationsUnread as $notification): ?>
                <div class="list-group-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-2">
                            <h1 class="<?php echo htmlspecialchars($notification['icon']); ?>"></h1>
                        </div>
                        <div class="col-8">
                            <div class="text-dark"><?php echo htmlspecialchars($notification['title']); ?></div>
                            <div class="text-muted small mt-1"><?php echo htmlspecialchars($notification['description']); ?></div>
                            <div class="text-muted small mt-1"><?php echo htmlspecialchars($notification['date']); ?></div>
                        </div>
                        <div class="col-2 text-end">
                            <form action="processes/admin/notifications/read.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
                                <button type="submit" class="btn btn-link p-0">Read</button>
                            </form>
                            <form action="processes/admin/notifications/delete.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
                                <button type="submit" class="btn btn-link text-danger p-0">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($notifCount > 0) { ?>
        <div class="dropdown-menu-footer">
            <a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#notificationsModal">Show all notifications</a>
        </div>
        <?php } ?>
    </div>
</li>



	<li class="nav-item dropdown">
		<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
			<div class="position-relative">
				<i class="align-middle" data-feather="message-square"></i>
			</div>
		</a>
		<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
			<div class="dropdown-menu-header">
				<div class="position-relative">
					4 New Messages
				</div>
			</div>
			<div class="list-group">
				<a href="#" class="list-group-item">
					<div class="row g-0 align-items-center">
						<div class="col-2">
							<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
						</div>
						<div class="col-10 ps-2">
							<div class="text-dark">Vanessa Tucker</div>
							<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
							<div class="text-muted small mt-1">15m ago</div>
						</div>
					</div>
				</a>
				<a href="#" class="list-group-item">
					<div class="row g-0 align-items-center">
						<div class="col-2">
							<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
						</div>
						<div class="col-10 ps-2">
							<div class="text-dark">William Harris</div>
							<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
							<div class="text-muted small mt-1">2h ago</div>
						</div>
					</div>
				</a>
				<a href="#" class="list-group-item">
					<div class="row g-0 align-items-center">
						<div class="col-2">
							<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
						</div>
						<div class="col-10 ps-2">
							<div class="text-dark">Christina Mason</div>
							<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
							<div class="text-muted small mt-1">4h ago</div>
						</div>
					</div>
				</a>
				<a href="#" class="list-group-item">
					<div class="row g-0 align-items-center">
						<div class="col-2">
							<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
						</div>
						<div class="col-10 ps-2">
							<div class="text-dark">Sharon Lessman</div>
							<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
							<div class="text-muted small mt-1">5h ago</div>
						</div>
					</div>
				</a>
			</div>
			<div class="dropdown-menu-footer">
				<a href="#" class="text-muted">Show all messages</a>
			</div>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
			<i class="align-middle" data-feather="settings"></i>
		</a>

		<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
			<span class="text-light">Admin</span>
		</a>
		<div class="dropdown-menu dropdown-menu-end">
			<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
			<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
			<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Log out</a>
		</div>
	</li>
</ul>

<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="notificationsModalLabel">All Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php foreach ($notifications as $notification): ?>
						<div class="list-group-item list-group-item-action">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="<?php echo htmlspecialchars($notification['icon']); ?>"></i>
								</div>
								<div class="col-8">
									<div class="text-dark"><?php echo htmlspecialchars($notification['title']); ?></div>
									<div class="text-muted small mt-1"><?php echo htmlspecialchars($notification['description']); ?></div>
									<div class="text-muted small mt-1"><?php echo htmlspecialchars($notification['date']); ?></div>
								</div>
								<div class="col-2 text-end">
								<?php if ($notification['status'] == 'unread') {?>
									<form action="processes/admin/notifications/read.php" method="POST" class="d-inline">
										<input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
										<button type="submit" class="btn btn-link p-0">Read</button>
									</form>
								<?php } ?>
									<form action="processes/admin/notifications/delete.php" method="POST" class="d-inline">
										<input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
										<button type="submit" class="btn btn-link p-0">Delete</button>
									</form>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal">Delete All</button>
				<?php if ($notification['status'] == 'unread') {?>
				<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#readAllModal">Read All</button>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<!-- Delete All Confirmation Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteAllModalLabel">Delete All Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to delete all notifications?
			</div>
			<div class="modal-footer">
				<form action="processes/admin/notifications/delete_all.php" method="POST">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Delete All</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Read All Confirmation Modal -->
<div class="modal fade" id="readAllModal" tabindex="-1" aria-labelledby="readAllModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="readAllModalLabel">Read All Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to mark all notifications as read?
			</div>
			<div class="modal-footer">
				<form action="processes/admin/notifications/read_all.php" method="POST">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-info">Read All</button>
				</form>
			</div>
		</div>
	</div>
</div>