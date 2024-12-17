<?php
require 'processes/server/conn.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM admin_notifications ORDER BY id DESC ";
$stmt = $pdo->prepare($query);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notifCount = count($notifications);


$query = "SELECT * FROM admin_notifications WHERE status = 'unread' ORDER BY id DESC LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$notificationsUnread = $stmt->fetchAll(PDO::FETCH_ASSOC);
$notificationCount = count($notificationsUnread);

$query = "SELECT * FROM messages WHERE status = 'unread' AND receiver_id = :user_id ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id); // Fix here
$stmt->execute();
$messagesUnread = $stmt->fetchAll(PDO::FETCH_ASSOC);
$messagesCount = count($messagesUnread);

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
								<h1 class="bi bi-info-circle-fill"></h1>
							</div>

							<div class="col-8">
								<a href="https://<?php echo $notification['link'] ?>">
									<div class="text-dark"><?php echo htmlspecialchars($notification['title']); ?></div>
									<div class="text-muted small mt-1">
										<?php echo htmlspecialchars($notification['description']); ?>
									</div>
									<div class="text-muted small mt-1">
										<?php echo htmlspecialchars($notification['date']); ?>
									</div>
								</a>
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
					<a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#notificationsModal">Show all
						notifications</a>
				</div>
			<?php } ?>
		</div>
	</li>

	<li class="nav-item dropdown">

		<a class="nav-icon dropdown-toggle" href="#" data-bs-toggle="modal" data-bs-target="#messagesModal">
			<div class="position-relative">
				<i class="align-middle" data-feather="message-square"></i>
				<?php
				if ($messagesCount > 0) { ?>
					<span class="indicator"><?php echo $messagesCount; ?></span>
				<?php } ?>
			</div>
		</a>
	</li>

	<script>
		// Function to fetch unread messages count and update the UI
		async function updateUnreadMessagesCount() {
			try {
				const response = await fetch('messaging.php?action=getCount'); // The file that returns the count
				const data = await response.json();
				const unreadCount = data.unreadCount;

				// Update the message count indicator
				const indicator = document.querySelector('.indicator');
				if (unreadCount > 0) {
					indicator.textContent = unreadCount;
					indicator.style.display = 'inline'; // Make sure indicator is visible
				} else {
					indicator.style.display = 'none'; // Hide the indicator if no unread messages
				}
			} catch (error) {
				console.error('Error fetching unread messages count:', error);
			}
		}

		// Periodically update unread message count every 3 seconds
		setInterval(updateUnreadMessagesCount, 2000);

	</script>

	<div class="modal fade" id="messagesModal" tabindex="-1" aria-labelledby="messagesModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle">Messages</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<!-- Modal Body -->
				<div class="modal-body" id="modalBody">
					<!-- Search Bar -->
					<div id="searchSection">
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="userSearch" placeholder="Search users..."
								aria-label="Search users">
							<button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
						</div>

						<!-- Recent Conversations -->
						<div id="recentConversations">
							<h6>Recent Conversations</h6>
							<div class="list-group" id="recentConvoList">
								<!-- Dynamic content will be here -->
							</div>
						</div>

						<!-- Search Results -->
						<div id="searchResults" style="display: none;">
							<h6>Search Results</h6>
							<div class="list-group" id="searchResultList">
								<p class="text-muted text-center">Type to search for users.</p>
							</div>
						</div>
					</div>

					<!-- Conversation Section (Hidden Initially) -->
					<div id="conversationSection" style="display: none;">
						<div id="conversationContent" class="flex-grow-1 overflow-auto p-3"
							style="background-color: #f8f9fa; border-radius: 0.25rem;">
							<p class="text-muted text-center">No messages yet.</p>
						</div>
						<div class="input-group mt-3 sticky-bottom" style="border-radius: 20px;">
							<input type="text" id="messageInput" class="form-control" placeholder="Type a message"
								aria-label="Type a message" style="position: sticky">
							<button class="btn btn-primary" type="button" onclick="sendMessage()">Send</button>
						</div>
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="backButton" style="display: none;"
						onclick="goBackToMessages()">Back</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<style>
		.message-bubble {
			word-wrap: break-word;
			/* Allows long words to break and wrap onto the next line */
			max-width: 80%;
			/* Optional: Limits the width of the message bubble */
		}


		#conversationContent {
			height: 400px;
			/* Or any height you prefer */
			overflow-y: auto;
		}
	</style>




	<script>
		// Safely check if session variables are set
		const userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
		const userType = '<?php echo isset($_SESSION['user_type']) ? $_SESSION['user_type'] : ''; ?>';

		// You can also log these values for debugging purposes
		console.log('userId:', userId);
		console.log('userType:', userType);

		// Now you can use userId and userType in your JavaScript code
		// For example, to perform some action based on these values:
		if (userId === null || userType === '') {
			console.error('User ID or User Type is not properly set.');
		} else {
			// Continue with your application logic
			console.log('User is logged in:', userId, userType);
		}
	</script>


	<script>


		document.getElementById('messagesModal').addEventListener('shown.bs.modal', () => {
			fetchRecentConversations(userId, userType);
		});

		// Search Functionality
		async function searchUsersAcrossApp(query, userType = 'all') {
			try {
				const response = await fetch(`messaging.php?action=search_users&query=${encodeURIComponent(query)}&user_type=${userType}`);
				const data = await response.json();

				if (data.success) {
					return data.data; // Return the list of users
				} else {
					console.error('Search Error:', data.message); // Log the error message
					return [];
				}
			} catch (error) {
				console.error('Request failed', error);
				return [];
			}
		}

		// Handle input search
		document.getElementById('userSearch').addEventListener('input', async function () {
			const query = this.value.trim();
			const recentConversations = document.getElementById('recentConversations');
			const searchResults = document.getElementById('searchResults');
			const resultsContainer = searchResults.querySelector('.list-group');

			if (query.length > 0) {
				recentConversations.style.display = 'none';
				searchResults.style.display = 'block';

				resultsContainer.innerHTML = '<p class="text-muted text-center">Searching...</p>';
				const results = await searchUsersAcrossApp(query);

				resultsContainer.innerHTML = results.length
					? results.map(user => `
					<a href="#" class="list-group-item list-group-item-action" onclick="openConversation(${user.id}, '${user.type}', '${user.name}')">
						<span>${user.name}</span>
					</a>
				`).join('')
					: '<p class="text-muted text-center">No users found.</p>';
			} else {
				recentConversations.style.display = 'block';
				searchResults.style.display = 'none';
			}
		});


		async function fetchRecentConversations(userId, userType) {
			try {
				const response = await fetch(`messaging.php?action=get_recent_conversations&user_id=${userId}&user_type=${userType}`);
				const data = await response.json();

				if (data.success) {
					const recentConvoList = document.getElementById('recentConvoList');
					recentConvoList.innerHTML = '';

					if (data.data.length > 0) {
						const seenUsers = new Set();

						data.data.forEach(convo => {
							const userPair = [Math.min(convo.sender_id, convo.receiver_id), Math.max(convo.sender_id, convo.receiver_id)].join('_');

							if (!seenUsers.has(userPair)) {
								seenUsers.add(userPair);

								const convoItem = document.createElement('a');
								convoItem.classList.add('list-group-item', 'list-group-item-action');
								convoItem.href = '#';
								convoItem.dataset.convoKey = userPair; // Save userPair for later lookup
								convoItem.onclick = (e) => {
									e.preventDefault();

									openConversation(
										(convo.sender_id === userId) ? convo.receiver_id : convo.sender_id,
										(convo.sender_id === userId) ? convo.receiver_type : convo.sender_type,
										(convo.sender_id === userId) ? convo.receiver_name : convo.sender_name
									);

									markMessagesAsRead(convo.sender_id, convo.sender_type, convo.receiver_id, convo.receiver_type);
								};

								convoItem.innerHTML = `
							<strong>${convo.conversation_name}</strong><br />
							${convo.message}<br />
							<small class="text-muted"> - ${new Date(convo.timestamp).toLocaleString()}</small>
						`;

								recentConvoList.appendChild(convoItem);
							}
						});

						// Fetch unread messages and apply badges
						fetchUnreadMessages(userId, userType);
					} else {
						recentConvoList.innerHTML = '<p>No recent conversations.</p>';
					}
				} else {
					console.error('Error fetching conversations:', data.message);
				}
			} catch (error) {
				console.error('Error:', error);
			}
		}

		async function fetchUnreadMessages(userId, userType) {
			try {
				const response = await fetch(`messaging.php?action=get_unread_messages&user_id=${userId}&user_type=${userType}`);
				const rawData = await response.text(); // Get the raw response
				console.log('Raw Response:', rawData);

				const data = JSON.parse(rawData); // Parse the response as JSON
				console.log('Parsed Data:', data);

				if (data.success) {
					// Map of unread messages by conversation for quick lookup
					const unreadMap = data.data.reduce((acc, msg) => {
						const convoKey = [Math.min(msg.sender_id, msg.receiver_id), Math.max(msg.sender_id, msg.receiver_id)].join('_');
						acc[convoKey] = true;
						return acc;
					}, {});

					// Highlight conversations with unread messages
					const recentConvoList = document.getElementById('recentConvoList').children;

					for (const convoItem of recentConvoList) {
						const convoKey = convoItem.dataset.convoKey; // Use the same `userPair` logic as your main function

						if (unreadMap[convoKey]) {
							// Add "New" badge if unread
							if (!convoItem.querySelector('.badge')) {
								convoItem.innerHTML += ' <span class="badge bg-danger">New</span>';
							}
						}
					}
				} else {
					console.error('Error fetching unread messages:', data.message);
				}
			} catch (error) {
				console.error('Error:', error);
			}
		}




		async function markMessagesAsRead(senderId, senderType, receiverId, receiverType) {
			try {
				// Send a request to the server to mark the messages in the conversation as read
				const response = await fetch(`messaging.php?action=mark_messages_as_read&sender_id=${senderId}&sender_type=${senderType}&receiver_id=${receiverId}&receiver_type=${receiverType}`, {
					method: 'GET',
				});

				const data = await response.json();
				if (data.success) {
					console.log('Messages marked as read');
				} else {
					console.error('Failed to mark messages as read');
				}
			} catch (error) {
				console.error('Error marking messages as read:', error);
			}
		}




		async function openConversation(receiverId, receiverType, userName) {
			// Get logged-in user's session values (ensure these values are globally accessible)
			const currentUserId = userId;
			const currentUserType = userType;

			const modalTitle = document.getElementById('modalTitle');
			modalTitle.textContent = `Conversation with ${userName}`;

			// Show or hide sections
			document.getElementById('searchSection').style.display = 'none';
			document.getElementById('conversationSection').style.display = 'block';
			document.getElementById('backButton').style.display = 'inline-block';

			const conversationContent = document.getElementById('conversationContent');
			conversationContent.dataset.userId = receiverId;
			conversationContent.dataset.userType = receiverType;

			// Ensure content refresh when roles change (Clear previous messages if receiver changes)
			if (!conversationContent.innerHTML || conversationContent.dataset.userId !== receiverId) {
				conversationContent.innerHTML = '<p class="text-muted text-center">Loading...</p>';
			}

			// Fetch initial messages for the conversation
			let messages = await fetchConversation(receiverId, receiverType, currentUserId, currentUserType);
			updateConversation(messages, currentUserId, currentUserType, receiverId, receiverType);

			// Mark messages as read when the conversation is opened
			await markMessagesAsRead(receiverId, receiverType, currentUserId, currentUserType);

			// Poll for new messages periodically (every 3 seconds)
			const pollingInterval = setInterval(async () => {
				const newMessages = await fetchConversation(receiverId, receiverType, currentUserId, currentUserType);
				if (newMessages.length > messages.length) {
					messages = newMessages;
					updateConversation(messages, currentUserId, currentUserType, receiverId, receiverType);
				}
			}, 1000);

			// Clear polling when closing modal (before the modal closes)
			document.getElementById('messagesModal').addEventListener('hidden.bs.modal', () => {
				clearInterval(pollingInterval);
			});

			// Helper function to display messages
			function updateConversation(messages, currentUserId, currentUserType, receiverId, receiverType) {
				// Clear existing conversation content
				conversationContent.innerHTML = '';

				// Ensure there are messages to display
				if (!messages || messages.length === 0) {
					conversationContent.innerHTML = '<p class="text-muted text-center">No messages yet.</p>';
				} else {
					messages.forEach(message => {
						const isCurrentUserSender = message.sender_id === currentUserId && message.sender_type === currentUserType;
						const alignment = isCurrentUserSender ? 'end' : 'start';
						const bgColor = isCurrentUserSender ? 'bg-primary text-white' : 'bg-light';
						const messageHtml = `
					<div class="d-flex justify-content-${alignment} mb-2">
						<div class="p-2 rounded message-bubble ${bgColor}">
							${message.message}
						</div>
					</div>`;
						conversationContent.innerHTML += messageHtml;
					});

					// Scroll to bottom
					conversationContent.scrollTo = conversationContent.scrollHeight;
				}
			}

			// Function to mark messages as 'read'
			async function markMessagesAsRead(receiverId, receiverType, currentUserId, currentUserType) {
				console.log(receiverId);
				console.log(receiverType);
				console.log(currentUserId);
				console.log(currentUserType);

				// Corrected URL string using proper template literals
				await fetch(`messaging.php?action=mark_messages_as_read&receiver_id=${receiverId}&receiver_type=${receiverType}&sender_id=${currentUserId}&sender_type=${currentUserType}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
					},
				});
			}
			conversationContent.scrollTop = conversationContent.scrollHeight;
		}




		async function fetchConversation(receiverId, receiverType, senderId, senderType) {
			try {
				const url = `messaging.php?action=get_conversation&receiver_id=${receiverId}&receiver_type=${receiverType}&sender_id=${senderId}&sender_type=${senderType}`;
				const response = await fetch(url);
				const data = await response.json();

				console.log('Fetched Conversation:', data);
				return data.success ? data.data : [];
			} catch (error) {
				console.error('Error fetching conversation:', error);
				return [];
			}
		}


		async function sendMessage() {
			const messageInput = document.getElementById('messageInput');
			const message = messageInput.value.trim();
			const conversationContent = document.getElementById('conversationContent');
			const receiverId = conversationContent.dataset.userId;
			const receiverType = conversationContent.dataset.userType;
			const receiverName = document.getElementById('modalTitle').textContent.replace('Conversation with ', '').trim();

			if (message && receiverId && receiverType) {
				try {
					const response = await fetch('messaging.php?action=send_message', {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({
							message,
							receiver_id: receiverId,
							receiver_type: receiverType,
							receiver_name: receiverName
						})
					});

					const data = await response.json();

					if (data.success) {
						// Create a message block
						const messageHtml = `
					<div class="d-flex justify-content-end mb-2">
						<div class="bg-primary text-white p-2 rounded">${message}</div>
					</div>`;

						// Append message to the conversation
						conversationContent.innerHTML += messageHtml;

						// Clear input field after sending
						messageInput.value = '';

						// Force reflow to ensure smooth scroll to bottom
						conversationContent.scrollTop = conversationContent.scrollHeight;
					} else {
						alert(data.message || 'Failed to send message. Try again.');
					}
				} catch (error) {
					console.error('Error:', error);
					alert('Error sending message. Try again.');
				}
			} else {
				alert('Message, receiver ID, and receiver type are required.');
			}
		}


		// Go Back to Search and Recent Conversations
		function goBackToMessages() {
			const modalTitle = document.getElementById('modalTitle');
			const conversationSection = document.getElementById('conversationSection');
			const searchSection = document.getElementById('searchSection');
			const backButton = document.getElementById('backButton');

			modalTitle.textContent = 'Messages';
			conversationSection.style.display = 'none';
			searchSection.style.display = 'block';
			backButton.style.display = 'none';
		}
	</script>


	<li class="nav-item dropdown">
		<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
			<i class="align-middle" data-feather="settings"></i>
		</a>

		<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
			<span class="text-light">Admin</span>
		</a>
		<div class="dropdown-menu dropdown-menu-end">
			<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#setNotificationsModal">
				View Automatic Settings
			</a>

			<a class="dropdown-item" href="processes/admin/account/logout.php">
				Log out
			</a>
		</div>



	</li>
</ul>

<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="notificationsModalLabel">All Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php foreach ($notifications as $notification): ?>
						<div class="list-group-item list-group-item-action">
							<a href="<?php echo $notification['link'] ?>" style="text-decoration: none">
								<div class="row d-flex justify-content-center align-items-center">
									<div class="col text-center ">
										<h1 class="bi bi-info-circle-fill"></h1>
									</div>
									<div class="col-8">
										<div class="text-dark"><?php echo htmlspecialchars($notification['title']); ?></div>
										<div class="text-muted small mt-1">
											<?php echo htmlspecialchars($notification['description']); ?>
										</div>
										<div class="text-muted small mt-1">
											<?php echo htmlspecialchars($notification['date']); ?>
										</div>
									</div>
									<div class="col-2 text-end">
										<?php if ($notification['status'] == 'unread') { ?>
											<form action="processes/admin/notifications/read.php" method="POST"
												class="d-inline">
												<input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
												<button type="submit" class="btn btn-link p-0">Read</button>
											</form>
										<?php } ?>
										<form action="processes/admin/notifications/delete.php" method="POST"
											class="d-inline">
											<input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
											<button type="submit" class="btn btn-link p-0">Delete</button>
										</form>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" data-bs-toggle="modal"
					data-bs-target="#deleteAllModal">Delete All</button>

				<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#readAllModal">Read
					All</button>

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

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="profileModalLabel">Profile</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Profile content here -->
				<p>Your profile information...</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Notifications Modal -->
<div class="modal fade" id="setNotificationsModal" tabindex="-1" aria-labelledby="setNotificationsModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="setNotificationsModalLabel">Manage Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Manage your notifications individually:</p>
				<ul class="list-group">
					<?php
					// Fetch notifications from your database
					$query = "SELECT * FROM admin_auto_notifications";
					$stmt = $pdo->prepare($query);
					$stmt->execute();
					$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

					// Loop through each notification
					foreach ($notifications as $notification) {
						$status = $notification['status'] === 'false' ? 'disabled' : '';
						$friendlyName = '';

						// Check notification names and assign friendly names
						if ($notification['name'] === 'semester_transition') {
							$friendlyName = 'Semester Transition';
						} elseif ($notification['name'] === 'semester_ending_notice') {
							$friendlyName = 'Semester Ending Notice';
						} elseif ($notification['name'] === 'semester_near_ending') {
							$friendlyName = 'Semester Near Ending';
						} else {
							$friendlyName = htmlspecialchars($notification['name']); // Default to the original name if no match
						}

						echo '
						<li class="list-group-item d-flex justify-content-between align-items-center">
							' . $friendlyName . '
							<form method="POST" action="update_notifications.php" class="d-inline">
								<input type="hidden" name="notif_name" value="' . htmlspecialchars($notification['name']) . '">
								<button type="submit" class="btn btn-sm btn-danger" ' . $status . '>Set to False</button>
							</form>
						</li>';
					}
					?>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" onclick="gotoLink()">Set all to False</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script>

	function gotoLink() {
		window.location.href = "processes/server/reset_notifications.php";
	}

	$(document).ready(function () {
		// Set all notifications to false when button is clicked
		$('#setAllFalse').on('click', function () {
			$.ajax({
				url: 'process_notifications.php', // Change this to your PHP file
				type: 'POST',
				data: {
					action: 'set_all_false'
				},
				success: function (response) {
					alert('All notifications set to false!');
				}
			});
		});

		// Handle setting notifications individually
		$('#setIndividually').on('click', function () {
			$.ajax({
				url: 'process_notifications.php', // Change this to your PHP file
				type: 'POST',
				data: {
					action: 'set_individual'
				},
				success: function (response) {
					alert('Manage notifications individually.');
				}
			});
		});
	});
</script>