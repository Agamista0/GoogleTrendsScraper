<?php
require_once('connect.php');

$limit = $_GET['limit'];
$offset = $_GET['offset'];

$sql = "SELECT * , TIMESTAMPDIFF(HOUR, period , CURRENT_TIMESTAMP) AS period FROM `google_trends`.`queries` WHERE char_length(`Change`) > 4  ORDER BY RAND(),`period` DESC LIMIT $limit OFFSET $offset ;" ;

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
                    } else {
                        echo "No data found";
                    }
                    
                    $connection->close();
                    ?> 