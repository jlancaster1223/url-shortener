<?php
if($_POST['url']) {
    include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    
    // Parse the url so that it is database safe
    $url = mysqli_real_escape_string($conn, $_POST['url']);

    // Make sure that the link starts with https://
    if(!str_starts_with($url, 'https://') || !str_starts_with($url, 'http://')) {
        $url = 'https://' . $url;
    }
    if(str_starts_with($url, 'http://')) {
        $url = str_replace('http://', 'https://', $url);
    }

    // Check if the url already exists in the database
    $sql = "SELECT * FROM `url_redirects` WHERE `long_url` = '$url'";
    $result = mysqli_query($conn, $sql);

    // If there are no results, add the url to the database
    if(mysqli_num_rows($result) == 0) {
        
        $short_url = generate_short_url();
        $sql = "SELECT * FROM `url_redirects` WHERE `unique_id` = '$short_url'";
        while(mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
            $short_url = generate_short_url();
        }
        
        // if url contains plinkfizz
        if(str_contains($url, 'plinkfizz')) {
            // remove plinkfizz
            $url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        }

        $sql = "INSERT INTO `url_redirects` (`id`, `unique_id`, `long_url`, `date_created`, `origin_ip`) VALUES (NULL, '".$short_url."', '".$url."', CURRENT_TIMESTAMP, '".$_SERVER['REMOTE_ADDR']."');";
        mysqli_query($conn, $sql);

        echo $short_url;
        
    } else {
        
        $row = mysqli_fetch_assoc($result);
        echo $row['unique_id'];
        
    }
}

function generate_short_url() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $short_url = '';
    for ($i = 0; $i < 5; $i++) {
        $short_url .= $characters[rand(0, $charactersLength - 1)];
    }

    return $short_url;
}