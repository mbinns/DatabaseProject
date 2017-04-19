<?php
//Define allowed extensions
$allowedExts = array("gif", "jpeg", "jpg", "png", "mp3", "mp4", "wav", "ogg");

//Grabs file extension by breaking the string into an array
$extension = end(explode(".", $_FILES["file"]["name"]));

//Check the mime type
if (
   ($_FILES["upload"]["type"] == "image/gif")
|| ($_FILES["upload"]["type"] == "image/jpeg")
|| ($_FILES["upload"]["type"] == "image/jpg")
|| ($_FILES["upload"]["type"] == "image/pjpeg")
|| ($_FILES["upload"]["type"] == "image/x-png")
|| ($_FILES["upload"]["type"] == "image/png")
|| ($_FILES["upload"]["type"] == 'audio/x-mpeg-3')
|| ($_FILES["upload"]["type"] == 'audio/mp3')
|| ($_FILES["upload"]["type"] == 'audio/mpeg3')
|| ($_FILES["upload"]["type"] == 'audio/wav')
|| ($_FILES["upload"]["type"] == 'audio/x-wav')
|| ($_FILES["upload"]["type"] == 'audio/ogg')
|| ($_FILES["upload"]["type"] == 'video/ogg')
|| ($_FILES["upload"]["type"] == 'video/mpeg')
|| ($_FILES["upload"]["type"] == 'video/x-mpeg')
|| ($_FILES["upload"]["type"] == 'video/mp4')
)
{
    //If the errors item has any elements then fail out
    if ($_FILES["upload"]["error"] > 0)
    {
        echo "Return Code: " . $_FILES["upload"]["error"] . "<br>";
    }
    else
    {
        //Print out file upload information
        echo "Upload: " . $_FILES["upload"]["name"] . "<br>";
        echo "Type: " . $_FILES["upload"]["type"] . "<br>";
        echo "Size: " . ($_FILES["upload"]["size"] / 1024) . " kB<br>";
        echo "Temp upload: " . $_FILES["upload"]["tmp_name"] . "<br>";

        //Check to see if the file has already been uploaded
        if (file_exists("media/" . $_FILES["upload"]["name"]))
        {
            echo $_FILES["upload"]["name"] . " already exists. ";
        }
        else
        {
            move_uploaded_file($_FILES["upload"]["tmp_name"],
            "media/" . $_FILES["upload"]["name"]);
            // echo "Stored in: " . "upload/" . $_FILES["upload"]["name"];
            $tmp = "media/" . $_FILES["upload"]["name"];
            echo $tmp;
        }
    }
}
else
{
    echo "Invalid type, does not match our signature checker or file is over 1000M";
}
?>
