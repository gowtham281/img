<?php

    define("SITE_ADDR", "http://localhost/tutorials/search_engine");

    include("./include.php");
    
    $site_title = 'Simple Search Engine';

?>
<html>

<head>

    <title><?php echo $site_title; ?></title>

    <style>

        body{
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
            background-color: whitesmoke;
        }
      


        #wrapper {
            width: 80%;
            background-color:whitesmoke;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
        #top_header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        #logo h1 a {
            color: #333;
            text-decoration: none;
        }
        
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 12px 30px;
            border-radius: 5px;
            border: none;
            background-color: blue;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: bright blue;
        }
        
        .result-info {
            margin-bottom: 15px;
            font-style: italic;
        }
        table.search {
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table.search td {
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }
        table.search td a {
            color: #4285f4;
            text-decoration: none;
        }
        table.search td a:hover {
            text-decoration: underline;
        }
        .no-result {
            text-align: center;
            font-weight: bold;
            color: #777;
            font-size: 18px;
        }
    </style>

</head>

<body>

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

                     if(isset($_GET['k']) && $_GET['k'] != '') {

                        $k = trim($_GET['k']);

                        $query_string = "SELECT * FROM search_engine WHERE ";

                        $display_words = "";

                        $keywords = explode(' ', $k);

                        foreach($keywords as $word) {

                            $query_string .= " keywords LIKE '%" . $word . "%' OR ";

                            $display_words .= $word . " ";
                        }

                        $query_string = substr($query_string, 0, strlen($query_string) - 3);

                        $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                        
                        $query = mysqli_query($conn, $query_string);

                        $result_count = mysqli_num_rows($query);


                        if($result_count > 0) {
                            echo '<br /><div class="right"><b><u>' . $result_count . '</u></b> Result Found </div>';

                            echo 'Your Search For : <i>' . $display_words . '</i> <hr /><br/> ';

                            echo '<table class="search">';

                            while($row = mysqli_fetch_assoc($query)) {
                                echo '<tr>
                                        <td><h3><a href="' . $row['url'] . '">' . $row['title'] . '</a></h3></td>
                                      </tr>';
                            }

                            echo '</table>';

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
