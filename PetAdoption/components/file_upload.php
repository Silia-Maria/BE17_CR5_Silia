<?php
function file_upload($picture, $source = 'user')
{
    $result = new stdClass();
    $result->fileName = "user.jpg";
    if (isset($_SESSION['adm'])) {
        $result->fileName = "pet.jpg";
    }
    $result->error = 1;
    // collect data from object picture
    $fileName = $picture['name'];
    $fileType = $picture['type'];
    $fileTmpName = $picture['tmp_name'];
    $fileError = $picture['error'];
    $fileSize = $picture['size'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $filesAllowed = ['png', 'jpg', 'jpeg'];
    if ($fileError == 4) {
        $result->ErrorMessage = "No picture was chosen. It can always be updated later.";
        return $result;
    } else {
        if (in_array($fileExtension, $filesAllowed)) {
            if ($fileError == 0) {
                if ($fileSize < 5000000) {
                    $fileNewName = uniqid("") . "." . $fileExtension;
                    if ($source == 'pet') {
                        $destination = "../../pictures/$fileNewName";
                        // because pet create comes from actions in the petfolder
                    } elseif ($source == 'user') {
                        $destination = "pictures/$fileNewName";
                        // user create is same level as pictures
                    }
                    if (move_uploaded_file($fileTmpName, $destination)) {
                        $result->error = 0;
                        $result->fileName = $fileNewName;
                        return $result;
                    } else {
                        $result->ErrorMessage = "There was an error uploading this file.";
                        return $result;
                    }
                } else {
                    $result->ErrorMessage = "This picture is bigger than allowed <br> Please choose a smaller one and update.";
                }
            } else {
                $result->ErrorMessage = "There was an error uploading - $fileError code. Check php documentation";
            }
        } else {
            $result->ErrorMessage = "There was an error uploading - $fileError code. Chech php documentation";
        }
    }
}
