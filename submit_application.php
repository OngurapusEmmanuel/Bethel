<?php
// submit_application.php

// Include the database connection configuration
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $cover_letter = mysqli_real_escape_string($conn, $_POST['cover_letter']);

    // Handle file upload (resume)
    $resume = $_FILES['resume'];

    // Check if the resume file was uploaded without errors
    if ($resume['error'] == 0) {
        $resume_name = $resume['name'];
        $resume_tmp_name = $resume['tmp_name'];
        $resume_size = $resume['size'];
        $resume_ext = pathinfo($resume_name, PATHINFO_EXTENSION);
        
        // Set allowed file types (PDF)
        $allowed_exts = ['pdf'];
        if (in_array(strtolower($resume_ext), $allowed_exts)) {
            // Define the upload directory
            $upload_dir = "uploads/resumes/";

            // Generate a unique name for the file
            $resume_new_name = uniqid('', true) . '.' . $resume_ext;
            $resume_upload_path = $upload_dir . $resume_new_name;

            // Move the uploaded file to the server directory
            if (move_uploaded_file($resume_tmp_name, $resume_upload_path)) {
                // Insert form data into the database
                $sql = "INSERT INTO vacancy_applications (Name, Email, Phone, Education, Position, Coverletter, Resume)
                        VALUES ('$full_name', '$email', '$phone', '$education', '$position', '$cover_letter', '$resume_upload_path')";

                if ($conn->query($sql) === TRUE) {
                    echo "Application Submitted Successfully";
//                     echo "<script>
//     alert('Application submitted successfully!');
    
// </script>";"
                    // header("Location:submit");
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Error uploading resume file.";
            }
        } else {
            echo "Invalid file type. Only PDF files are allowed.";
        }
    } else {
        echo "Error uploading resume file.";
    }}
    ?>
// Close the database connection