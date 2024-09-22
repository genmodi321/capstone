<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WMSU - CCS | Comprehensive Student Management System</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous">

    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link
      href="external/css/teacher_subjects_grades.css"
      rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32"
      href="external/img/favicon-32x32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet">

  </head>

  <body>
    <div class="container-fluid whole-container">
      <div class="row">

        <div class="col-md-2 sidebar text-center">
          <small id="currentTime"> </small>

          <img src="external/img/ccs_logo-removebg-preview.png"
            class="img-fluid logo space-sm">
          <h4 class="bold">Welcome, Jason!</h4>

          <div class="navigation-links" style="text-align: left;">
            <span><i class="bi bi-house"></i> Home</span>
            <a href="teacher_dashboard.html"><p><i class="bi bi-kanban"></i>
                Index</p></a>
            <hr>
            <span><i class="bi bi-menu-button-wide"></i>
              Management</span>
            <a href="teacher_class_dashboard.html"><p><i
                  class="bi bi-book"></i> Classes
              </p></a>
            <a href="teacher_subject_dashboard.html"><p><i
                  class="bi bi-journals"></i> Subjects
              </p></a>
            <hr>
            <p><i class="bi bi-calendar-event"></i>
              Class
              Management</p>

          </div>
        </div>

        <div class="col">

          <div
            class="container-fluid d-flex navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">
              <img
                src="external/img/ccs_logo-removebg-preview.png"
                class="img-fluid small-logo">
            </a>
            <div class="mx-auto c-white">
              Comprehensive Student Management System
            </div>
            <button class="navbar-toggler" type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"
              id="navbarSupportedContent">
              <div class="ms-auto">
                <span class="ms-auto">
                  <a href
                    class="nav-link-spand position-relative "
                    data-bs-toggle="modal" data-bs-target="#messageModal">

                    <i
                      class="bi bi-chat-dots iconics"></i>
                    <span
                      class="position-absolute 
                                            top-0 start-50 translate-middle p-2 
                                            bg-danger border border-light rounded-circle">

                    </span>
                  </a>
                  <a
                    class="nav-link-span position-relative"><i
                      class="bi bi-bell iconics" data-bs-toggle="modal"
                      data-bs-target="#notificationModal"></i>

                    <span
                      class="position-absolute 
                                            top-0 start-50 translate-middle p-2 
                                            bg-danger border border-light rounded-circle">

                    </span>

                  </a>
                  <a href="index.html"a class="nav-link-span">
                    <button class="btn btn-csms-outline">Logout</button></a>

                </span>

              </div>
            </div>
          </div>

          <div class="container-fluid actual-content">
            <div class="container wd-75">
              <div class="welcome-container">

                <div class="d-flex align-items-center">
                  <h3>Welcome to your Dashboard!

                    <p class="fs-small mt-10">Welcome back!
                      Here's
                      to another day of making a
                      difference in our students'
                      lives.</p>

                    <p class="fs-small mt-10"> <a
                        href="teacher_dashboard.html"
                        class="nav-ham-link">Home</a> /
                      <a
                        href="teacher_subject_dashboard.html"
                        class="nav-ham-link">Subjects</a> / <span
                        class="nav-ham-link">Capstone 1 & Research</span> / 
                        <span
                        class="nav-ham-link">Grades</span></p>
                  </h3>

                  <div class="ms-auto" aria-hidden="true">
                    <img
                      src="external/svgs/undraw_teacher.svg"
                      class=" small-picture img-fluid">
                  </div>
                </div>
              </div>

              <hr>
              <div class="container">
                <h5 class="bold" onclick="goBack()"><i class="bi bi-arrow-left"></i> Back</h5>
              </div>

              <div class="container">
              
            

                <div class="container-fluid activity-container">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-book-fill"></i> Grades </h5>
                       
                      </div>
                   
                    </div>
                 

              
                </div>
<hr>
                <div class="container-fluid student-container">
                    
                  <div
                    class="container-fluid bordered-none align-middle student-container-individual" data-bs-toggle="modal" data-bs-target="#actModal1">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-mortarboard-fill"></i> Leonard Aquino
                        </h5>
                        <div class="ms-auto">
                       1.75
                        </div>
                    </div>           
                  </div>

                  <div
                    class="container-fluid bordered-none align-middle student-container-individual">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-mortarboard-fill"></i> John Abrajano
                        </h5>
                        <div class="ms-auto">
                        2.75
                        </div>
                    </div>      
                  </div>

                  <div
                    class="container-fluid bordered-none align-middle student-container-individual">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-mortarboard-fill"></i> Nifled Sespene
                        </h5>
                        <div class="ms-auto">
                         2.50
                        </div>
                    </div>      
                  </div>

                  <div
                    class="container-fluid bordered-none align-middle student-container-individual">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-mortarboard-fill"></i> Jason Catadman
                        </h5>
                        <div class="ms-auto">
                      1.00
                        </div>
                    </div>      
                  </div>

                  <div
                    class="container-fluid bordered-none align-middle student-container-individual">
                    <div class="d-flex align-items-center">
                        <h5><i class="bi bi-mortarboard-fill"></i> Jason Catadman
                        </h5>
                        <div class="ms-auto">
                     1.00
                        </div>
                    </div>      
                  </div>

                  <div
                  class="container-fluid bordered-none align-middle student-container-individual">
                  <div class="d-flex align-items-center">
                      <h5><i class="bi bi-mortarboard-fill"></i> Jason Catadman
                      </h5>
                      <div class="ms-auto">
                       1.00
                      </div>
                  </div>      
                </div>

                  

                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>

  </body>

  <div class="modal fade" id="notificationModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5"
            id="exampleModalLabel">Notifications</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="d-flex align-items-center">
            <span>Notifications</span>
            <div class=" ms-auto" aria-hidden="true"><a href
                class="nav-ham-link"> View All</a> | <a href
                class="nav-ham-link"> Read All</a></div>
          </div>

          <br>

          <div class="row ">
            <div class="col-sm-2 text-center">
              <h1><i class="bi bi-bell-fill"></i></h1>
            </div>
            <div class="col">
              <h5>You have received a new notification!</h5>
              <p>Test notification!</p>
            </div>
          </div>

          <br>

          <div class="row ">
            <div class="col-sm-2 text-center">
              <h1><i class="bi bi-bell-fill"></i></h1>
            </div>
            <div class="col">
              <h5>You have received a new notification!</h5>
              <p>Test notification!</p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="messageModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Chats</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row msg align-items-center"
            data-bs-target="#actualMessageModal" data-bs-toggle="modal">
            <div class="col-sm-3 text-center"
              style="border-right: 1px solid black;">
              <h1><i class="bi bi-person-fill"></i></h1>
              <span>Jason Catadman</span>
            </div>
            <div class="col">
              <p><em>You: Sure sir Catadman. I will work on that right
                  now.</em></p>
            </div>
          </div>

          <br>

          <div class="row unread msg align-items-center">
            <div class="col-sm-3 text-center"
              style="border-right: 1px solid black;">
              <h1><i class="bi bi-person-fill"></i></h1>
              <span>Ceed Lorenzo</span>
            </div>
            <div class="col">
              <p><em>Lorenzo: Good afternoon sir, ask ko lang if available
                  po
                  si...</em></p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="actualMessageModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Chats</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body" id="chatBody">
          <div class="time text-center grey">
            2:09 PM - 8/11/2024
          </div>
          <br>
          <div class="row sender">
            <div class="col">
              <i class="bi bi-person-fill"></i>
              <div class="message">
                <span>Hi, this is Jason Catadman. I'd like to switch from
                  Web
                  Technologies to Software Engineering, thanks!</span>
              </div>
            </div>
          </div>
          <br>
          <div class="row receiver">
            <div class="col">
              <div class="message">
                <span>Sure sir Catadman. I will work on that right
                  now.</span>
              </div>
              <i class="bi bi-person"></i>
            </div>
          </div>
          <br>
        </div>

        <div class="modal-footer">
          <form id="messageForm">
            <div class="d-flex align-items-center">
              <textarea id="messageInput" cols="45"></textarea>
              <div class="ms-auto" aria-hidden="true"
                style="margin-left: 10px">
                <input type="submit" value="Send">
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <div class="modal fade" id="actModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Leonard Aquino's Work Output</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <form>
            <h5>
                <label for="grade-select">Select Grade:</label>
                <br>      <br>
                <select id="grade-select" class="form-group">
                  <option value="1.00">1.00</option>
                  <option value="1.25">1.25</option>
                  <option value="1.50">1.50</option>
                  <option value="1.75">1.75</option>
                  <option value="2.00">2.00</option>
                  <option value="2.25">2.25</option>
                  <option value="2.50">2.50</option>
                  <option value="2.75">2.75</option>
                  <option value="3.00">3.00</option>
                  <option value="4.00">4.00</option>
                  <option value="5.00">5.00</option>
                  <option value="INC">INC</option>
                  <option value="UW">UW</option>
                </select>
            
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-csms"><i class="bi bi-save-fill"></i> Save changes</button>
       </form>

        </div>
      </div>
    </div>
  </div>






  <script>




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

  <script>


  $(document).ready(function() {
      $('#class').DataTable();
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

  <script>
        
   
    function print(divId) {
        var divToPrint = document.getElementById(divId).innerHTML;
        var iframe = document.createElement('iframe');

        iframe.style.position = 'relative';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';

        document.body.appendChild(iframe);

        

        var doc = iframe.contentDocument || iframe.contentWindow.document;

        var link = doc.createElement('link');
    link.href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css";
    link.rel = "stylesheet";
    link.integrity = "sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH";
    link.crossOrigin = "anonymous";

        var style = doc.createElement('style');
        style.textContent = 'table, td, tr, thead { border: 1px solid black; border-collapse: collapse; } td, th { padding: 8px; }';
        doc.head.appendChild(style);

        doc.body.innerHTML = divToPrint;

        iframe.contentWindow.focus();
        iframe.contentWindow.print();

        document.body.removeChild(iframe);
    }

  

    document.getElementById("toggleButton").addEventListener("click", function() {
        var eyeIcon = document.getElementById("eyeIcon");
        var toggleText = document.getElementById("toggleText");

        if (eyeIcon.style.display === "none") {
            eyeIcon.style.display = "inline";
            toggleText.style.display = "none";
        } else {
            eyeIcon.style.display = "none";
            toggleText.style.display = "inline";
        }
    });

    document.getElementById("toggleButton2").addEventListener("click", function() {
        var eyeIcon2 = document.getElementById("eyeIcon2");
        var toggleText2 = document.getElementById("toggleText2");

        if (eyeIcon2.style.display === "none") {
            eyeIcon2.style.display = "inline";
            toggleText2.style.display = "none";
        } else {
            eyeIcon2.style.display = "none";
            toggleText2.style.display = "inline";
        }
    });
</script>

<script>
    function redirect(){
      window.location.href = "teacher_class_management_editable.html";
    }

    function gotoPeople(){
      window.location.href = "teacher_subject_management.html"
    }

    function gotoActivity(){
      window.location.href = "teacher_subject_management_activity_dashboard.html";
    }

    function goToGrades(){
      window.location.href = "teacher_subject_grades.html";
    }

    function goToLectures(){
      window.location.href = "teacher_subject_lectures.html";
    }

    function goBack(){
      window.location.href = "teacher_subject_dashboard.html";
    }

</script>

</html>