<?php
session_start();

$idforprof=$_SESSION['id'];
$img_uploaded=false;
$nothing_selected=false;
$newprofilepic="";

if (isset($_POST['uploadbutton'])){
    $file=$_FILES['file'];
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];

    $fileExtension = explode('.',$fileName);
    $fileActualExtension = strtolower(end($fileExtension));

    $allowed=array('jpg','jpeg','png','pdf');

    if (in_array($fileActualExtension,$allowed)){
        if($fileError ===0){
            if($fileSize <1000000){
                $fileNameNew="profile".$idforprof.".".$fileActualExtension;
                $fileDestination='uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
                $stmt=$mysqli->prepare("UPDATE studentsaccounts SET profilepic=? WHERE accountid=?");
                $profilepicname=$fileNameNew;
                $accountid=$_SESSION['id'];
                $stmt->bind_param('si',$profilepicname,$accountid);
                $stmt->execute();
                $img_uploaded=true;
                $newprofilepic=$profilepicname;
                
                
                

            } 

        } 

    } else{
        $nothing_selected=true;
    }

}
?>

<script>
    var img_uploaded,nothing_selected,newprofilepic;
    img_uploaded="<?php echo $img_uploaded;?>";
    nothing_selected="<?php echo $nothing_selected; ?>";
    newprofilepic="<?php echo $newprofilepic; ?>";

    if(img_uploaded==true){
        $("body").prepend("Image uploaded successfully!");
    }
    if(nothing_selected==true){
        $("body").prepend("Select an image!");
    }
</script>