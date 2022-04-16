<?php
// Je vérifie si le formulaire est soumis
if($_SERVER['REQUEST_METHOD'] === "POST"){ 

    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés
        $uploadDir = 'uploads/';
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    // Je récupère l'extension du fichier    
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . uniqid() . '.' .$extension;
    // Les extensions autorisées   
        $authorizedExtensions = ['jpg','png','gif', 'webp'];
    // Le poids max géré par PHP par défaut est de 2M    
        $maxFileSize = 1000000;

    // Je sécurise et effectue mes tests
    if(!isset($_POST['firstname']) || empty($_POST['firstname']))
    {
        echo 'Your firstname is required';
        die();
    }
    if(!isset($_POST['lastname']) || empty($_POST['lastname']))
    {
        echo 'Your lastname is required';
        die();
    }
    if(!isset($_POST['age']) || empty($_POST['age']))
    {
        echo 'Your age is required';
        die();
    }

    /****** Si l'extension est autorisée *************/
    if( (!in_array($extension, $authorizedExtensions)))
    {
        echo 'Please select a file type jpg, png, gif ou webp.';
        die();
    }

    /****** Je vérifie si l'image existe et si le poids est autorisé en octets *************/
    if(file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
        echo 'Your file must be less than 1Mo.';
        die();
    }

    /****** Si je n'ai pas d"erreur alors j'upload *************/
    if (empty($errors))
    {
        $message =  move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        if($message)
        {
            echo "Your file sent successfully!";
        }else{
            echo "Problem with your file, retry please.";
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader un fichier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>

<main class="container">
    <h1 class="text-center mt-5 mb-5">Login form</h1>
    <form action="" method="post" enctype="multipart/form-data">

        <label for="firstname" class="form-label">Firstname : </label>
        <input type="text" name="firstname" id="firstname" class="form-control"/>

        <label for="lastname" class="form-label">Lastname : </label>
        <input type="text" name="lastname" id="lastname" class="form-control"/>

        <label for="age" class="form-label">Age : </label>
        <input type="number" name="age" id="age" class="form-control"/>

        <label for="imageUpload" class="form-label">Upload an image</label>    
        <input type="file" name="avatar" id="imageUpload" class="form-control"/>

        <input class="btn btn-primary btn-lg" type="submit" name="send" value="SEND"></button>

    </form>
</main>
</body>
</html>