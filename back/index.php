<?php

define("SITE_ADDR", "http://localhost/engine/search_engine");

include("./include.php");

$site_title = 'Simple Search Engine';

?>
<html>

<head>

    <title><?php echo $site_title; ?></title>

    <style>

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            overflow-x: hidden;
        }

        #wrapper {
            width: 80%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        #parallax-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #4e54c8, #8f94fb, #4e54c8, #8f94fb);
            background-size: 400% 400%;
            animation: gradient 15s infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        #top_header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        #logo h1 a {
            color: black; 
            text-decoration: none;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        
        input[type="text"] {
            padding: 10px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }


        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        .search-result {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
            font-weight: bold; 
            text-align: left; 


        .search-result h3 {
            margin-bottom: 10px;
        }

    </style>

</head>

<body>

    <div id="parallax-bg"></div>

    <div id="wrapper">

        <div id="top_header">

            <div id="logo">
                <h1><a href="http://google.com">Official Dealer</a></h1>
            </div>

        </div>

        <div id="main" class="shadow-box">

            <div id="content">

                <form action="" method="GET" name="">

                    <input type="text" name="k" placeholder="Search for something">

                    <input type="submit" name="" value="Search">

                </form>

                <?php

                if (isset($_GET['k']) && $_GET['k'] != '') {

                    $k = trim($_GET['k']);

                    $keywords = strpos($k, ',') !== false ? explode(',', $k) : explode(' ', $k);

                    $query_string = "SELECT * FROM search_engine WHERE ";

                    $display_words = "";

                    foreach ($keywords as $word) {

                        $query_string .= " keywords LIKE '%" . trim($word) . "%' OR ";

                        $display_words .= trim($word) . " ";
                    }

                    $query_string = rtrim($query_string, "OR ");

                    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

                    $query = mysqli_query($conn, $query_string);

                    $result_count = mysqli_num_rows($query);

                    if ($result_count > 0) {

                        echo '<br /><div class="right"><b><u>' . $result_count . '</u></b> Result Found </div>';

                        echo 'Your Search For : <i>' . $display_words . '</i> <hr /><br/> ';

                        while ($row = mysqli_fetch_assoc($query)) {

                            echo '<div class="search-result">

                                    <h3><a href="' . $row['url'] . '">' . $row['title'] . '</a></h3>
                                    
                                    <p>Price: ₹' . number_format($row['price'], 2) . '</p>

                                    <p>Rating: ' . $row['rating'] . '</p>

                                </div>';
                        }

                    } else {
                        echo 'No Results Found  😥 !!...';
                    }
                } else {
                    echo ' ';
                }
                ?>

            </div>

        </div>

        <div id="footer"></div>

    </div>

</body>

</html>

