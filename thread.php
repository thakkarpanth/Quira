<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Quira</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php include 'partials/_header.php'; ?>
    <?php
          $id = $_GET['threadid'] ;
          
          $sql = "SELECT * FROM `threads` WHERE thread_id =$id";
          #echo "<h3>$sql</h3>";
          $result = mysqli_query($conn , $sql);
          
           while($row = mysqli_fetch_assoc($result))
           {
                $title  = $row['thread_title'];
                $desc  = $row['thread_desc'];
                $noresult = false ; 
                $thread_user_id = $row['thread_user_id'];

                $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
                $result2 = mysqli_query($conn , $sql2);
                $row2 = mysqli_fetch_assoc($result2) ; 
                $posted_by = $row2['user_email'];
            }


    ?>

    <?php 
        $method = $_SERVER['REQUEST_METHOD'];
         
        if($method == 'POST')
        {
            //insert thread into db 
            $showAlert = false ; 
            $comment = $_POST['comment'];
            $comment = str_replace("<"  , "&lt;" , $comment);
            
            $comment = str_replace(">" ,  "&gt;" , $comment);

            $sno = $_POST['sno'];
            
            $sql = "INSERT INTO `comments` (  `comment_content`, `thread_id`, `comment_by`, `comment_time`)
                     VALUES ( '$comment', '$id', '$sno', current_timestamp());";

             $result = mysqli_query($conn , $sql );
             $showAlert = true  ;
             if($showAlert)
             {
                 echo '
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added! 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

             }
             
        }
    
    
    ?>


    <div class="container my-4">

        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer coding forum for sharing knowledge with each other.No Spam / Advertising /
                Self-promote in the forums. ...
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times. </p>

            <p>Posted by : <em><?php echo $posted_by; ?></em></p>
        </div>


        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){


        
        echo '<h1 class="py-2">Post a comment</h1>
        <form action=" ' .  $_SERVER['REQUEST_URI'] . ' " method="post">



        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            <input type = "hidden" name = "sno" value = " ' . $_SESSION["sno"] . ' ">
        
            </div>

        <button type="submit" class="btn btn-success">Post Comment </button>
        </form>

        ';
        }
        else{
        echo ' <div class="container">
            <h1 class="py-2">Post a comment</h1>

            <p class="lead">You are not logged in. Please login to post a comment.</p>
        </div>' ;
        }
        ?>



        <div class="container">
            <h1 class="py-2">Discussions</h1>
            <?php
            $id = $_GET['threadid'] ;

            $sql = "SELECT * FROM `comments` WHERE thread_id =$id";
            #echo "<h3>$sql</h3>";
            $result = mysqli_query($conn , $sql);

            $noresult = true;
            while($row = mysqli_fetch_assoc($result))
            {

            $noresult = false ;
            $content = $row['comment_content'];
            $id = $row['comment_id'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];


            $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id' ";
            $result2 = mysqli_query($conn , $sql2);

            $row2 = mysqli_fetch_assoc($result2);
            






            echo'<div class="media my-3">
                
                <img class="mr-3" src="img/download.png" width="40px" alt="Generic placeholder image">
                <div class="media-body">
                <p class = "font-weight-bold my-0" > ' . $row2['user_email'] . '   ' . $comment_time . '</p>
                    ' . $content . '
                </div>
            </div>';
            }








            if($noresult)
            {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">No Commments Found</h1>
                    <p class="lead">Be the first person to comment</p>
                </div>
            </div>';
            }
            ?>







        </div>



    </div>
    <p class="my-3"></p>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

<?php include 'partials/_footer.php'; ?>

</html>