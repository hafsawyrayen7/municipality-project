<?php
include_once '../Controller/CRUD.php';
require_once '../DB/dbHelper.php';
include_once 'validateData.php';
include_once 'userData.php';

if (isset($_SESSION['login_user'])) {

    if (isset($_POST['submit'])) {

        $target_dir = "../Documents/";

        $errorSubject = "";
        $errorDescription = "";
        $crud = new crud();

        $subject = $crud->escape_string($_POST['type']);
        $description = $crud->escape_string($_POST['description']);

        if ($subject == 1) {
            $subject = "Water or Electricity Permit";
            $target_dir .= "Water or Electricity Permit/";
            if ($_FILES['project']['type'] != "application/pdf") {
                header('Location:../View/createrequest.php?type=wrong');
                exit();
            }
        } elseif ($subject == 2) {
            $subject = "Building Permit";
            $target_dir .= "Building Permit/";
            if ($_FILES['project']['type'] != "application/pdf" ) {
                header('Location:../View/createrequest.php?type=wrong');
                exit();
            }
        }

        if (strlen($subject) > 0 && strlen($description) > 0) {

            if ($_SESSION['user_type'] == 1) {


                $documents = "";
                if ($subject == "Water or Electricity Permit") {
                    if (move_uploaded_file($_FILES['project']['tmp_name'], $target_dir . basename($_FILES['project']['name']))) {
                        $documents = basename($_FILES['project']['name']);
                    } else {
                        echo "doc upload failed";
                        exit();
                    }
                } else if ($subject == "Building Permit") {
                    if (move_uploaded_file($_FILES['project']['tmp_name'], $target_dir . basename($_FILES['project']['name'])) ) {
                        $documents = basename($_FILES['project']['name']) ;
                    } else {
                        echo "doc upload failed";
                        exit();
                    }
                }

                $query = "INSERT INTO request SET 
                            citizen_id ='" . $_SESSION['login_user'] . "',
                            admin_id = '0',
                            documents='$documents',
                            type = '$subject',
                            status='Pending',
                            description ='$description',
                            date = NOW()";

                $execute = $crud->execute($query);
                if ($execute) {
                    header("Location:../View/showrequests.php");
                } else {
                    header("Location:../View/createrequest.php?case=wrong");
                }
            } elseif ($_SESSION['user_type'] == 2) {

                $documents = "";
                if ($subject == "Water or Electricity Permit") {
                    if (move_uploaded_file($_FILES['project']['tmp_name'], $target_dir . basename($_FILES['project']['name']))) {
                        $documents = basename($_FILES['project']['name']);
                    } else {
                        echo "doc upload failed";
                        exit();
                    }
                } else if ($subject == "Building Permit") {
                    if (move_uploaded_file($_FILES['project']['tmp_name'], $target_dir . basename($_FILES['project']['name'])) ) {
                        $documents = basename($_FILES['project']['name']);
                    } else {
                        echo "doc upload failed";
                        exit();
                    }
                }

                $query = "INSERT INTO request SET 
                            citizen_id ='0',
                            admin_id = '" . $_SESSION['login_user'] . "',
                            documents='$documents',
                            type = '$subject',
                            status='Pending',
                            description ='$description',
                            date = NOW()";

                $execute = $crud->execute($query);
                if ($execute) {
                    header("Location:../View/showrequests.php");
                } else {
                    header("Location:../View/createrequest.php");
                }
            }
        } else {

            header("Location:../View/createrequest.php?case=wrong");
        }
    }
} else {

    header("Location:logout.php");
}
?>
