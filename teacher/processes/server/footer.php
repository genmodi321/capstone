
<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        document.getElementById('sidebarContainer').classList.toggle('collapsed');
      });


const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function getTime()
        {
            const now = new Date();
            const newTime = now.toLocaleString();
            console.log(newTime);
            document.querySelector("#currentTime").textContent = "The current date and time is: " + newTime;
        }
      
        setInterval(getTime, 100);

          // Function to send the message
  document.getElementById('messageForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get the message from the textarea
    var messageText = document.getElementById('messageInput').value;

    // If the message is not empty, append it to the chat
    if (messageText.trim() !== '') {
      var chatBody = document.getElementById('chatBody');

      // Create the new message element
      var newMessage = document.createElement('div');
      newMessage.className = 'row receiver'; // Set it as a sender message
      newMessage.innerHTML = `
      
            <div class="col">
              <div class="message">
                 <span>${messageText}</span>
              </div>
              <i class="bi bi-person"></i>
            </div>
      
      
      `;

      // Append the new message to the chat body
      chatBody.appendChild(newMessage);

      // Clear the textarea
      document.getElementById('messageInput').value = '';

      // Scroll to the bottom of the chat
      chatBody.scrollTop = chatBody.scrollHeight;

    }
  });

    </script>

  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
