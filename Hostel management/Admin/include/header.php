<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            background: #F5F5F5;
        }

        .heading {
            height: 70px;
            padding-left: 30px;
            display: flex;
  justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            background: #D9D9D9;
            color: #4F8CBF;
            font-size: 26px;
            font-family: Lato;
            font-weight: 700;
        }

        .logout-section {
           margin-right: 30px;
           background-color: transparent;
        }
        .logout-section :hover{
            background: #5c5b5b;
        }

        .logout-section a{
            text-decoration: none;
            padding: 10px;
            color: #4F8CBF;
            font-size: 24px;
            font-family: Lato;
            font-weight: 700;
            background: #4e4e4e;


           

        }
    </style>
</head>

<body>
    <div class="login">
        <nav class="navbar">
            <div class="heading">Hostel Management System <div class="logout-section"><a href="logout.php">
                           Logout</a></div>
            </div>

        </nav>
    </div>

</body>

</html>