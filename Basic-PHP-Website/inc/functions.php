<?php

function getItemHtml($id, $item) {
    $output = "<li>
        <a href='details.php?id=" . $id . "'>
            <img src={$item['img']} alt='{$item['title']}'>
            <p>View Details</p>
        </a>
    </li>";

    return $output;
}

function getCategoriesItems($catalog, $category) {
    $output = array();

    foreach($catalog as $id => $item){
        if ($category == null OR strtolower($category) === strtolower($item["category"])) {
            $sort = $item["title"];
            $sort = ltrim($sort, "The ");
            $sort = ltrim($sort, "A ");
            $sort = ltrim($sort, "An ");
            $output[$id] = $sort;
        }
    }

    asort($output);
    return array_keys($output);
}

function getOptionsList($array, $type) {
    foreach ($array as $key => $value) {
        echo "<optgroup label='".$key."'>\n";
        foreach ($value as $name) {
            echo "\t<option value='".$name."'";
            if (isset($type) && $type == $name) {
                echo " selected";
            }
            echo ">$name</option>\n";
        }
        echo "</optgroup>\n\n";
    }
}

function sendEmail($mail, $name, $email, $category, $title, $format, $genre, $year, $details) {
    $emailBody = "<html>
        <body>
            <div style='font-size:16px;
                        font-family:Tahoma,Arial,Helvetica,Verdana,sans-serif;
                        color:#333;'>
                <div>
                    <img src='http://www.download-free-wallpaper.com/img85/cimqpfjpnwftuuvgyyqt.jpg' alt='Logo' width='105px' height='100px'>
                    <h2 style='display:inline-block;vertical-align:top;margin-left:30px;'>
                        Personal Media <br> Library
                    </h2>
                </div>
                <div style='font-size:16px;
                            font-family:Tahoma,Arial,Helvetica,Verdana,sans-serif;
                            color:#333;
                            border-left:5px solid #B30606;
                            padding:0 0 0 20px;'>
                <p>
                    <b style='color:#B30606;'>Name</b>: ".$name."
                </p>
                <p>
                    <b style='color:#B30606;'>Email</b>: ".$email."
                </p>
                <p>
                    <b style='color:#B30606;'>Suggested Item</b>:<br>
                    <div style='padding-left:30px'>
                        <b style='color:#B30606;'>Category</b>: ".$category."<br>
                        <b style='color:#B30606;'>Title</b>: ".$title."<br>
                        <b style='color:#B30606;'>Format</b>: ".$format."<br>
                        <b style='color:#B30606;'>Genre</b>: ".$genre."<br>
                        <b style='color:#B30606;'>Year</b>: ".$year."<br>
                        <b style='color:#B30606;'>Details</b>: ".$details."
                    </div>
                </p>
                </div>
            </div>
        </body>
    </html>";

    $mail->setFrom($email, $name);
    $mail->addAddress('sergey@localhost', 'New suggestion from Personal Media Library');     // Add a recipient

    $mail->isHTML(true); // Set email format to HTML

    $mail->Subject = 'Personal Media Library Suggestion from ' . $name;
    $mail->Body    = $emailBody;

    if($mail->send()) {
        header("location:suggest.php?status=thanks");
        exit;
    }
}
