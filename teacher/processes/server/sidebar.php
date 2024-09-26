<style>
    .sidebar-container {
        background-color: #415D43;
        transition: width 0.3s ease;
        width: 250px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: sticky;
        justify-content: center;
        top: 0;
        height: 100vh;
        z-index: 100;
    }

    .sidebar-container.collapsed {
        width: 0;
    }

    .sidebar-content {
        padding: 15px;
    }

    .sidebar-container.collapsed .sidebar-content {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .sidebar-container .sidebar-content {
        opacity: 1;
        transition: opacity 0.2s ease;
    }
</style>

<div class="sidebar-container" id="sidebarContainer">
    <div class="sidebar-content text-center">
        <small class="c-white" id="currentTime"> </small>

        <img src="external/img/ccs_logo-removebg-preview.png" class="img-fluid logo space-sm" data-bs-toggle="modal" data-bs-target="#profilePictureModal">
        <h4 class="bold c-white ">Welcome, Teacher</h4>

        <div class="navigation-links" style="text-align: left;">

            <a href="teacher_dashboard.php">
                <p><i class="bi bi-kanban"></i> Home</p>
            </a>
            <hr>
      
            <a href="teacher_class_dashboard.php">
                <p><i
                        class="bi bi-book"></i> Classes
                </p>
            </a>
            <a href="teacher_subject_dashboard.php">
                <p><i
                        class="bi bi-journals"></i> Subjects
                </p>
            </a>
            <hr>
            <p><i class="bi bi-calendar-event"></i>
                Class
                Management</p>
        </div>
    </div>
</div>

<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="profilePictureLabel">Change Profile Picture</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profilePictureForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="profilePictureInput" class="form-label">Upload New Profile Picture</label>
            <input type="file" class="form-control" id="profilePictureInput" accept="image/*">
          </div>
          <div id="preview" class="text-center mb-3">
            <img id="profilePreview" src="#" alt="Profile Preview" class="img-thumbnail" style="max-width: 150px; display: none;">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveProfilePicture">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script> 
    document.getElementById('profilePictureInput').addEventListener('change', function(event) {
    const preview = document.getElementById('profilePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

</script>
