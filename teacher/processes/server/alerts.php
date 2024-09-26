<?php


if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'STAFF_CREATE_ACC_ERROR') {
    echo "
    <script>
        Swal.fire({
            title: 'Error Creating Account!',
            text: 'There was an error creating the account. Please try again.',
            icon: 'error'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'STAFF_CREATE_ACC_SUCCESFUL') {
    echo "
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Account created successfully!',
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'STAFF_ACCOUNT_EXISTS') {
    echo "
    <script>
        Swal.fire({
            title: 'Warning!',
            text: 'An account with this email already exists. Please use a different email.',
            icon: 'warning'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'STAFF_LOGGED_IN_SUCCESS') {
    echo "
    <script>
        Swal.fire({
            title: 'Warning!',
            text: 'An account with this email already exists. Please use a different email.',
            icon: 'warning'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'STAFF_INVALID_LOGIN') {
    echo "
    <script>
        Swal.fire({
            title: 'Warning!',
            text: 'The account has been logged in with invalid credentials, please try again!',
            icon: 'warning'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'TEACHER_NOT_LOGGED_IN') {
    echo "
    <script>
        Swal.fire({
            title: 'Warning!',
            text: 'Please login first to view the needed details and documents!',
            icon: 'error'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'TEACHER_LOGIN_SUCCESFUL') {
    echo "
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'You have succesfully logged in your account!',
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
}
?>

<?php
if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'ASSESSMENT_ADD_SUCCESS') {
    echo "
    <script>
        Swal.fire({
            title: 'Assessment addition success!',
            text: 'You have succesfully added a new assessment!',
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'ASSESSMENT_ADD_ERROR') {
    echo "
    <script>
        Swal.fire({
            title: 'Assessment addition error!',
            text: 'There was something wrong with adding the assessment, please try again!',
            icon: 'error'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'ASSESSMENT_FILE_HANDING_ERROR') {
    echo "
    <script>
        Swal.fire({
            title: 'Assessment file handling error!',
            text: 'Please make sure your file extensions are the following: (.jpg, .jpeg, .pdf, .docx, .xlsx, .mp4, .mpeg) ',
            icon: 'error'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} elseif (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 'ASSESSMENT_FILE_PATHING_ERROR') {
    echo "
    <script>
        Swal.fire({
            title: 'Assessment file pathing error!',
            text: 'Make sure the path to your uploads exists. Please check if uploads folder exist at the root directory',
            icon: 'error'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
}
?>

<?php
if (isset($_SESSION['STATUS'])) {
    if ($_SESSION['STATUS'] == 'ASSESSMENT_NAME_EXISTS_ERROR') {
        echo "
        <script>
            Swal.fire({
                title: 'Warning!',
                text: 'An assessment with this name already exists for the same subject and type.',
                icon: 'warning'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'ASSESSMENT_FILE_PATHING_ERROR') {
        echo "
        <script>
            Swal.fire({
                title: 'Assessment file pathing error!',
                text: 'Make sure the path to your uploads exists. Please check if the uploads folder exists in the root directory.',
                icon: 'error'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'ASSESSMENT_FILE_HANDLING_ERROR') {
        echo "
        <script>
            Swal.fire({
                title: 'Assessment file handling error!',
                text: 'Please make sure your file extensions are the following: (.jpg, .jpeg, .pdf, .docx, .xlsx, .mp4, .mpeg).',
                icon: 'error'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'ASSESSMENT_UPDATE_SUCCESS') {
        echo "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Assessment details updated successfully!',
                icon: 'success'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'ASSESSMENT_UPDATE_ERROR') {
        echo "
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'There was an error updating the assessment details. Please try again.',
                icon: 'error'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'ASSESSMENT_DELETE_SUCCESS') {
        echo "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Assessment has deleted successfully!',
                icon: 'success'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } 
}


?>


<?php
if (isset($_SESSION['STATUS'])) {
    if ($_SESSION['STATUS'] == 'NEW_DATE_ADDED') {
        echo "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'You have added a new date for attendance!',
                icon: 'success'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    } elseif ($_SESSION['STATUS'] == 'DATE_ALREADY_EXISTS') {
        echo "
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'The date already exists, you can only view for now!',
                icon: 'error'
            });
        </script>
        ";
        unset($_SESSION['STATUS']);
    }  elseif ($_SESSION['STATUS'] == 'ATTENDANCE_SUCCESFUL') {
    echo "
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'The student has been marked present for the specified date!',
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
}elseif ($_SESSION['STATUS'] == 'SUCCESSFUL_LOG_OUT') {
    echo "
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'You have been logged out!',
            icon: 'success'
        });
    </script>
    ";
    unset($_SESSION['STATUS']);
} 
}

?>
