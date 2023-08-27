<?php
session_start();
require_once('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,400;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Trends</title>
    <link rel="shortcut icon" type="image/x-icon" href="css/google-trends-logo-freelogovectors.net_.webp">
</head>
<body>
    <div class="container">
        <div class="refresh">
            <button  class="refresh-button" onClick="window.location.reload(true)" ><i class="fa fa-refresh" aria-hidden="true"></i>
                REFRESH REAL TIME GROWING KEYWORDS</button>
            <p> refresh your realtime topics to see up to date data
            </p>
        </div>
        <div class="box">
            <div class="data">
                <div class="more-data">
                    <div class="lines">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <button class="more-data-btn" >More Data</button>
                </div>
                <button class="data-btn-first data-btn">GROWING KEYWORD <img src="css/up-down.png"
                        class="data-icon"></button>
                <button class="data-btn-secondary data-btn">ACTIONS</button>
                <button class="data-btn-secondary data-btn">ASSINGED</button>
                <button class="data-btn-secondary data-btn">MY TOPIC <img src="css/up-down.png" class="data-icon"></button>
                <button class="data-btn-secondary data-btn">CHANGE</button>
                <button class="data-btn-secondary data-btn">TAG <img src="css/up-down.png" class="data-icon"></button>
                <button class="data-btn-secondary data-btn">PERIOD <img src="css/up-down.png" class="data-icon"></button>
                <button class="data-btn-secondary data-btn">COUNTRY <img src="css/up-down.png" class="data-icon"></button>
            </div>
            <div class="content-container">
                  <?php
                    $limit = 12;
                    $offset = 0; 
                    $sql = "SELECT * , TIMESTAMPDIFF(HOUR, period , CURRENT_TIMESTAMP) AS period FROM `google_trends`.`queries` WHERE char_length(`Change`) > 4  ORDER BY RAND() ,`period` DESC LIMIT $limit OFFSET $offset ;" ;
                    $result = $connection->query($sql);
                    
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo ' <div class="content-row content-row1">
                                    <div class="keyword-container">
                                        <p>' . $row["GrowingKayword"] . '</p>
                                        <i class="fa-brands fa-google"></i>
                                        <i class="fa-solid fa-arrow-trend-up"></i>
                                    </div>
                                    <div class="actions-container">
                                        <a href=""><i class="fa-solid fa-file-circle-plus"></i></a>
                                        <a href=""><i class="fa-solid fa-file-arrow-down"></i></a>
                                        <a href=""><i class="fa-solid fa-folder-plus"></i></a>
                                    </div>
                                    <div class="select-container">
                                        <img src="css/user.png" class="user-img" alt="">
                                        <p>Select</p>
                                    </div>
                                    <div class="topic-container">
                                        <i class="fa-solid fa-chevron-down"></i>
                                        <p>' .$row["my_topic"]. '</p>
                                    </div>
                                    <div class="change-container">
                                        <button class="change-button">
                                            <i class="fa-solid fa-arrow-up"></i>
                                            +'.$row["Change"].'%
                                        </button>
                                    </div>
                                    <div class="tag-container">
                                        <button class="tag-button">
                                        '.$row["tag"].'
                                        </button>
                                    </div>
                                    <div class="period-container">
                                        <p>'.($row["period"]+1).'h</p>
                                    </div>
                                    <div class="country-container">
                                        <p>'.$row["countries"].'</p>
                                    </div>
                                </div>
                            ';
                        }
                        $offset +=$limit ;
                    } else {
                        echo "No data found";
                    }
                    $connection->close();
                    ?> 
                </div>
        
</body>

<script>
    var limit = <?php echo $limit; ?>;
    var offset = <?php echo $offset; ?>; 
    
    document.querySelector('.more-data-btn').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_more.php?limit=' + limit + '&offset=' + offset, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                var dataContainer = document.querySelector('.content-container');
                dataContainer.insertAdjacentHTML('beforeend', response);
                offset += <?php echo $limit; ?>; // Retrieve the initial limit value from your PHP code
            }
        };
        xhr.send();
    });
</script>

</html>