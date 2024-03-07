<?php
session_start();
require("db/dbHelper.php");
$conn = connect();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta Name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Style-->
    <link rel="stylesheet" href="./stylesheet/output.css">
    <!--ICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,500,0,0" />
    <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Lexend Tera' rel='stylesheet'>
    <!--EDUSHOP FONTS-->
    <style>
        body{
            font-family: 'Poppins';
        }
        h2{
            font-family:'Lexend Tera';
        }
    </style>
</head>
<body>
    <!--whole-container-->
    <div class="relative">
        <!--Header-->
        <header class="header bg-gray-100 px-2 w-full">
            <nav class="nav flex justify-between items-center">
                <div>
                    <a href="index.php"><img class="w-95 h-16" src="img/logo.png" alt="logo"></a>
                </div>
                <div class="flex items-center gap-4 md:hidden">
                    <button class="showModal fa fa-search cursor-pointer bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-2 rounded-full"style="font-size: 18px;"></button>
                    <button class="mobileNotifBtn fa fa-bell border-2 bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-2 rounded-full" style="font-size: 18px; color: transparent; -webkit-text-stroke: 2px black;"></button>
                    <ion-icon class="menuBtn mr-2 text-3xl cursor-pointer bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-1 rounded-full"Name="menu-outline"></ion-icon>
                </div>
                <div class="nav-links text-xs md:static md:min-h-fit absolute bg-gray-100 min-h-[13vh] left-0 md:w-auto w-full flex items-center px-5 top-[-100%]">
                    <ul class="flex md:flex-row flex-col md:items-center md:gap-2 gap-1 text-center">
                        <li class="hover:text-orange-500"><a class="cursor-pointer">Help</a></li>
                        <span class="hidden md:block">|</span>
                        <li class="webNotifBtn hover:text-orange-500"><a class="cursor-pointer"><i class="fa fa-bell"></i></a></li>
                        <span class="hidden md:block">|</span>
                        <li class="<?php if(isset($_SESSION['authenticated'])) echo "profileBtn";?> hover:text-orange-500"><a class="cursor-pointer" <?php if(!isset($_SESSION['authenticated'])) echo "href='login.php'";?>>
                        <?php
                            if(isset($_SESSION['authenticated'])){
                                if($_SESSION['authenticated']==TRUE){
                                    $user = $_SESSION['auth_user'];
                                    echo $user['user_first_name'];
                                }
                                else{
                                    echo "login";
                                }
                            } else{
                                echo "login";
                            }
                        ?>
                        </a></li>
                    </ul>
                </div>
            </nav>
            <!--Notification-->
            <div class="webNotif bg-gray-100 w-52 h-auto absolute right-1 rounded-md px-4 py-2 hidden">
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-xs" href="#"><span class="font-bold">Borgard</span> sent you an offer</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-xs" href="#"><span class="font-bold">Borgard</span> sent you an offer</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-xs" href="#"><span class="font-bold">Borgard</span> sent you an offer</a>
                </div>
            </div>
            <!--Profile Menu-->
            <div class="webMenu px-4 py-2 bg-gray-100 w-52 h-auto absolute right-1 rounded-md hidden">
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="profile.php"><span class="mr-2 mt-2"><ion-icon Name="person-circle-outline"></ion-icon></span>My profile</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon Name="list-circle-outline"></ion-icon></span>Listing</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon Name="eye-outline"></ion-icon></span>Watchlist</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon Name="log-out-outline"></ion-icon></span>Logout</a>
                </div>
            </div>
            <!--Search Modal-->
            <div class="modal h-screen w-[%100] ml-10 mr-10 pt-5 hidden">
                <button class="cancelBtn font-bold ml-3 mr-5 md:mr-10  hover:text-gray-400 absolute md:right-5 right-0">Cancel</button>
                <center>
                    <input class="w-[70%] md:w-96 rounded-full pl-2 border-2 border-gray-400" type="text" Name="s" id="s" placeholder="Search">
                    <br><br>
                    <span class="text-gray-500">Popular Search Items</span>
                </center>     
            </div>
            <div class="showMenu h-screen w-full hidden">
                <div class="px-5 pt-5 ">
                    <h1 class="font-bold">Menu</h1>
                </div>
                <?php
                if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == TRUE ){
                    $userInfo = $_SESSION['auth_user'];
                }
                 $response = getRecord('user_details','user_id',$userInfo['user_id']);

                echo "<div class='px-5 flex border-b-2 border-gray-400'>
                <div>
                  <img src='".$response['user_image']."' alt='profile' class='w-10 h-10 rounded-full mt-2'>
                </div>
                    <div class='mb-5'>
                        <p class='mx-2 mt-2 text-xs font-bold'>".$response['user_first_name']." ".$response['user_last_name']."</p>
                        <a class='mx-2 text-xs text-blue-700 underline' href='profile.php'>View Profile</a>
                    </div>
                </div>";
                ?>

                <div class="grid grid-cols-2 sm:grid-cols-3 px-5 py-3 gap-2 border-b-2">
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Listing</a><br>
                        <span><i class="fa fa-address-book-o"></i></span>
                    </div>
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Favorites</a><br>
                        <span><i class="fa fa-heart"></i></span>
                    </div>
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Watchist</a><br>
                        <span><i class="fa fa-eye"></i></span>
                    </div>
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Listing</a>
                    </div>
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Listing</a>
                    </div>
                    <div class="border-2 border-white rounded-md w-40 h-20 bg-white text-center justify-center pt-2 shadow-lg drop-shadow-lg">
                        <a class="font-bold"href="#">Listing</a>
                    </div>
                </div>
                <form>
                    <div class="mt-5">
                        <button class="w-full border-2 border-gray-600 bg-gray-600 text-white rounded-xl font-bold cursor-pointer" Name="logoutBtn" id="logoutBtn">Logout</button>
                    </div>
                </form>

            </div>
        </header>

        <!--Menu Option-->
        <div class="text-center font-bold text-3xl py-2">
            <h2>EDUSHOP</h2>
        </div>
        <div class="py-2" >

           <nav class="flex justify-center">
            <ul class="flex md:gap-40 gap-10 font-bold">
                <li class="hover:text-orange-500"><a class="text-orange-500" href="index.php">HOME</a></li>
                <li class="hover:text-orange-500"><a href="sell.php">SELL</a></li>
                <li class="hover:text-orange-500"><a href="auction.php">AUCTION</a></li>
            </ul>
           </nav>
           <style>
           </style>
            <div class="hidden md:block float-end mr-4">
                <button class="webSearchBtn border-2 border-gray-500 p-1 w-36 rounded-full font-bold text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-800 hover:border-gray-800"><span class="fa fa-search mr-1"></span>Search</button>
                <button class="fa fa-heart mr-4 border-2 bg-white border-white hover:border-gray-200 hover:bg-gray-200 p-2 rounded-full" style="font-size: 20px; color: transparent; -webkit-text-stroke: 2px black;"></button>
            </div>
        </div>

        <!--Main-->
        <br><br>
        
        <div class="main md:ml-32 md:mr-32 ml-5 mr-5">
            <div class="py-3">
                <h3 class="font-bold text-black">My Profile</h3>
            </div>
            <div class="border-t-2 border-gray-500">
                <center>
                    <?php
                    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == TRUE ){
                        $userInfo = $_SESSION['auth_user'];
                        $response = getRecord('user_details','user_id',$userInfo['user_id']);
                    
                    //Profile picture display from database
                   echo "
                    <div class='py-2 relative w-32 h-32'>
                    <img class='profilePic w-32 h-32 rounded-full border-2 border-gray-500' src='".$response['user_image']."' alt='profile'>
                    <label for='inputFile' title='Change profile picture' class='fa fa-camera cursor-pointer absolute text-gray-100 bg-gray-500 p-2 rounded-full' style='bottom:0; right:5px;font-size: 15px;'></label>
                    <input type='file' id='inputFile' class='inputFile hidden' accept='image/png, image/jpeg, image/jpg'>
                    </div></center>
                    <div class='flex justify-center my-3 py-2'>
                    <p class='font-bold'>".$response['user_first_name']." ".$response['user_last_name']."</p>
                    </div>
                    ";
                    //Edit Profile Part
                    echo "
                    <div class='bg-gray-200 rounded-md'>
                    <ul class='flex justify-center md:justify-start lg:justify-start sm:justify-center gap-5 font-semibold text-sm'>
                        <li class='about hover:bg-gray-400 rounded-md cursor-pointer px-3 py-2'>About</li>
                        <li class='listing hover:bg-gray-400 rounded-md cursor-pointer px-3 py-2'>Listing</li>
                        <li class='feedback hover:bg-gray-400 rounded-md cursor-pointer px-3 py-2'>Feedback</li>
                    </ul>
                </div>
                    <!--Edit Profile-->
                    <div class='editProfileDetails bg-gray-200 w-auto md:w-96 lg:w-96 sm:w-96 py-2 mt-3 px-3 shadow-lg drop-shadow-lg rounded-md hidden'>
                        <button class='closeEditProfileDetails text-sm hover:bg-gray-400 rounded-full py-1 px-2'>&#10006;</button>
                        <div class='flex justify-between px-3  py-1 border-b  border-gray-400 text-sm'>
                            <p id='fullname'>".$response['user_first_name']." ".$response['user_last_name']."</p>
                            <span class='nameBtn cursor-pointer text-blue-500 underline hover:text-blue-700'>Edit</span>
                        </div>
                        <div class='flex justify-between px-3 py-1 border-b border-gray-400 text-sm'>
                            <p id='newAddress'>".$response['user_address']."</p>
                            <span class='addressBtn cursor-pointer text-blue-500 underline hover:text-blue-700'>Edit</span>
                        </div>
                        <div class='flex justify-between px-3 py-1 border-b border-gray-400 text-sm'>
                        ";
                        if($response['user_contact_number']==NULL){
                                echo "None";
                            }else
                            {echo "<p id='newNumber'>".$response['user_contact_number']."</p>";}
                        echo "
                            <span class='mobileBtn cursor-pointer text-blue-500 underline hover:text-blue-700'>Edit</span>
                        </div>
                        <div class='flex justify-between px-3 py-1 border-b border-gray-400 text-sm'>
                            <p>".$response['user_email']."</p>
                            <span class='emailBtn cursor-pointer text-blue-500 underline hover:text-blue-700'>Edit</span>
                        </div>
                        <div class='flex justify-between px-3 py-1 border- border-gray-400 text-sm'>
                            <p>Password</p>
                            <span class='passwordBtn cursor-pointer hover:text-orange-500'>&#10095;</span>
                        </div>
                    </div>
                    ";
                //Show details
                echo "
                <div class='profileDetails bg-gray-200 w-auto md:w-96 lg:w-96 sm:w-96 py-2 mt-3 px-3 shadow-lg drop-shadow-lg rounded-md'>
                    <div class='flex justify-between px-3  py-1 border-b  border-gray-400 text-sm'>
                        <p class='text-sm'>
                        <span class='fa fa-home mr-2' style='font-size: 22px;'></span>
                        ".$response['user_address']."
                    </p>
                    </div>
                    <div class='flex justify-between px-3  py-1 border-b  border-gray-400 text-sm'>
                        <p class='text-sm'>
                        <span class='fa fa-envelope mr-2' style='font-size: 16px;'></span>
                        ".$response['user_email']."
                        </p>
                    </div>
                    ";
                    if($response['user_acadachievement_is_authenticated']!=NULL){
                        echo "
                        <p class='text-sm'>
                        <span class='fa fa-check-circle mr-2 text-blue-500' style='font-size: 20px;'></span>Verified Top Notcher
                    </p>
                    <button class='editProfileBtn w-full bg-blue-500 text-white font-bold rounded-md mt-3 hover:bg-blue-700'>Edit Profile</button>
                    </div>";
                    }
                    else{
                        echo "
                        <button class='editProfileBtn w-full bg-blue-500 text-white font-bold rounded-md mt-3 hover:bg-blue-700'>Edit Profile</button>
                        </div>
                        ";
                    }
                    }
                    else{
                        header("Location: login.php");
                    } 
                    ?>
            <!--Show Listing-->
            <div class="showListing hidden mx-5">
                <div class="flex justify-center mt-3">
                    <button name = "sellButton" class="listSellBtn border-2 border-gray-500 rounded-l-3xl px-5 w-28 py-1 font-bold bg-gray-200 hover:bg-gray-500 hover:text-white">Sell</button>
                    <button class="listAuctionBtn border-2 border-gray-500 rounded-r-3xl px-5 w-28 py-1 font-bold bg-gray-200 hover:bg-gray-500 hover:text-white">Auction</button>
                </div>
                <!--Sell-->
                <?php
                if(isset($_POST['sellButton'])){
                    echo "<script>alert('Hello')</script>";
                }
                ?>
                <div class="listSell my-3 px-10 grid md:grid-cols-2 lg:grid-cols-2 grid-cols-1 gap-1">
                    <div class="w-fit h-fit bg-gray-200 p-2 rounded-md shadow-lg drop-shadow-lg pr-5">
                        <div class="flex">
                            <div class="">
                                <img src="img/laptop.png" alt="" class="w-20 h-20 md:w-28 md:h-28 my-2 md:mx-5 border-2 border-gray-300">
                            </div>
                            <div class="text-xs md:text-sm font-bold ml-1 mt-2">
                                <p>HP Laptop</p>
                                <p><span class="">₱</span>10,000.00</p>
                                <p class="text-xs">1pc.</p>
                                <br>
                                <p class="sellEditListBtn font-normal text-blue-500 underline cursor-pointer">Edit</p>
                            </div>
                            <div class="flex flex-col ml-5 md:ml-20">
                                <button class="text-xs md:text-base border-2 border-orange-500 px-2 py-1 rounded-2xl bg-orange-500 text-white font-bold shadow-lg drop-shadow-lg mt-2 hover:bg-orange-700 hover:border-orange-700">Boost</button>
                                <button class="text-xs md:text-base border-blue-500 text-white bg-blue-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-blue-700 hover:border-blue-700 ">Auction</button>
                                <button class="text-xs md:text-base border-red-500 text-red-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-red-500 hover:border-red-500 hover:text-white">Remove</button>
                                
                            </div>
                        </div>
                    </div>
                    <div class="w-fit h-fit bg-gray-200 p-2 rounded-md shadow-lg drop-shadow-lg pr-5">
                        <div class="flex">
                            <div class="">
                                <img src="img/laptop.png" alt="" class="w-20 h-20 md:w-28 md:h-28 my-2 md:mx-5 border-2 border-gray-300">
                            </div>
                            <div class="text-xs md:text-sm font-bold ml-1 mt-2">
                                <p>HP Laptop</p>
                                <p><span class="">₱</span>10,000.00</p>
                                <p class="text-xs">1pc.</p>
                                <br>
                                <p class="font-normal text-blue-500 underline cursor-pointer">Edit</p>
                            </div>
                            <div class="flex flex-col ml-5 md:ml-20">
                                <button class="text-xs md:text-base border-2 border-orange-500 px-2 py-1 rounded-2xl bg-orange-500 text-white font-bold shadow-lg drop-shadow-lg mt-2 hover:bg-orange-700 hover:border-orange-700">Boost</button>
                                <button class="text-xs md:text-base border-blue-500 text-white bg-blue-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-blue-700 hover:border-blue-700 ">Auction</button>
                                <button class="text-xs md:text-base border-red-500 text-red-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-red-500 hover:border-red-500 hover:text-white">Remove</button>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <!--Auction-->
                <div class="listAuction my-3 px-10 grid md:grid-cols-2 lg:grid-cols-2 grid-cols-1 gap-1 hidden">
                    <div class="w-fit h-fit bg-gray-200 p-2 rounded-md shadow-lg drop-shadow-lg pr-5">
                        <div class="flex">
                            <div class="">
                                <img src="img/laptop.png" alt="" class="w-20 h-20 md:w-28 md:h-28 my-2 md:mx-5 border-2 border-gray-300">
                            </div>
                            <div class="text-xs md:text-sm font-bold ml-1 mt-2">
                                <p>HP Laptop</p>
                                <p><span class="">₱</span>10,000.00</p>
                                <p class="text-xs">1pc.</p>
                                <br>
                                <p class="editlist font-normal text-blue-500 underline cursor-pointer">Edit</p>
                            </div>
                            <div class="flex flex-col ml-5 md:ml-20">
                                <button class="text-xs md:text-base border-red-500 text-red-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-red-500 hover:border-red-500 hover:text-white">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="w-fit h-fit bg-gray-200 p-2 rounded-md shadow-lg drop-shadow-lg pr-5">
                        <div class="flex">
                            <div class="">
                                <img src="img/laptop.png" alt="" class="w-20 h-20 md:w-28 md:h-28 my-2 md:mx-5 border-2 border-gray-300">
                            </div>
                            <div class="text-xs md:text-sm font-bold ml-1 mt-2">
                                <p>HP Laptop</p>
                                <p><span class="">₱</span>10,000.00</p>
                                <p class="text-xs">1pc.</p>
                                <br>
                                <p class="font-normal text-blue-500 underline cursor-pointer">Edit</p>
                            </div>
                            <div class="flex flex-col ml-5 md:ml-20">
                                <button class="text-xs md:text-base border-red-500 text-red-500 font-bold rounded-2xl border-2 px-2 py-1 drop-shadow-lg shadow-lg mt-1 hover:bg-red-500 hover:border-red-500 hover:text-white">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--try if col is working-->
        
        <!--footer-->
        <div class="bg-gray-100 h-16 mt-5">

        </div>
        <!--EDIT NAME-->
        <div class="editName w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden" style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg md:w-96 sm:w-96 lg:w-96 w-full absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="nameClose float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="font-bold mb-5 mt-5">Name</h3>
                <span class="nameError hidden text-sm text-red-600">To update your name, please fill in all the required fields.</span>
                <p class="text-sm font-semibold">First Name</p>
                <input type="text" id="fnameChange" placeholder="First Name" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <p class="text-sm font-semibold mt-2">Middle Name</p>
                <input type="text" id ="mnameChange" placeholder="Middle Name" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <p class="text-sm font-semibold mt-2">Last Name</p>
                <input type="text" id = "lnameChange" placeholder="Last Name" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <button class="changeBtn bg-orange-500 text-white font-bold px-3 py-1 float-end mt-5 rounded-lg hover:bg-orange-700">Change</button>
            </div>
            <div class="messageName w-fit h-fit bg-gray-100 absolute top-1/3 left-2/4 px-3 py-2 border-2 border-gray-500 rounded-md hidden" style="transform: translate(-50%,-50%);">
                <p class="pName">Are you sure you want to change it?</p>
                    <div class="nameSuccessMsg hidden">
                        <button class="float-end nameSuccessBtn px-2 py-1 hover:bg-gray-400 rounded-full">&#10006;</button><br>
                        <div class="flex flex-col justify-center items-center">
                            <span class="fa fa-check-circle text-green-500 ml-6" style="font-size: 40px;"></span>
                        </div>
                        <p class="text-sm font-bold">Change Successfully</p>
                    </div>
                
                <div class="nameBtns flex justify-center gap-1 mt-2">
                    <button class="noName bg-red-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-red-700">No</button>
                    <button class="yesName bg-green-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-green-700">Yes</button>
                </div>
                
            </div>
        </div>



        <!--EDIT ADDRESS-->
        <div class="editAddress w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden" style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg md:w-96 sm:w-96 lg:w-96 w-full absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="addressClose float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="mb-5 mt-5 font-bold">Address</h3>
                <span class="addressError hidden text-sm text-red-600">To proceed, please fill in required fields.</span>
                <input type="text" id="addressChange" placeholder="Enter new address" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <button class="addressChangeBtn bg-orange-500 text-white font-bold px-3 py-1 float-end mt-5 rounded-lg hover:bg-orange-700">Change</button>
            </div>
            <div class="messageAddress w-fit h-fit bg-gray-100 absolute top-1/3 left-2/4 px-3 py-2 border-2 border-gray-500 rounded-md hidden" style="transform: translate(-50%,-50%);">
                <p class="pAddress">Are you sure you want to change it?</p>
                    <div class="addressSuccessMsg hidden">
                        <button class="float-end addressSuccessBtn px-2 py-1 hover:bg-gray-400 rounded-full">&#10006;</button><br>
                        <div class="flex flex-col justify-center items-center">
                            <span class="fa fa-check-circle text-green-500 ml-6" style="font-size: 40px;"></span>
                        </div>
                        <p class="text-sm font-bold">Change Successfully</p>
                    </div>
                
                <div class="addressBtns flex justify-center gap-1 mt-2">
                    <button class="noAddress bg-red-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-red-700">No</button>
                    <button class="yesAddress bg-green-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-green-700">Yes</button>
                </div>
                
            </div>
        </div>
        <!--Edit Mobile No.-->
        <div class="editMobile w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden" style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg md:w-96 sm:w-96 lg:w-96 w-full absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="mobileClose float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="mb-5 mt-5 font-bold">Mobile Number</h3>
                <span class="mobileError hidden text-sm text-red-600"></span>
                <input type="tel" pattern="[0-9]{10}" id="numberChange" placeholder="Enter new mobile number" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full" required>
                <button class="mobileChangeBtn shadow-lg drop-shadow-lg bg-orange-500 text-white font-bold px-3 py-1 float-end mt-5 rounded-lg hover:bg-orange-700">Change</button>
            </div>
            <div class="messageMobile w-fit h-fit bg-gray-100 absolute top-1/3 left-2/4 px-3 py-2 border-2 border-gray-500 rounded-md hidden" style="transform: translate(-50%,-50%);">
                <p class="pMobile">Are you sure you want to change it?</p>
                    <div class="mobileSuccessMsg hidden">
                        <button class="float-end mobileSuccessBtn px-2 py-1 hover:bg-gray-400 rounded-full">&#10006;</button><br>
                        <div class="flex flex-col justify-center items-center">
                            <span class="fa fa-check-circle text-green-500 ml-6" style="font-size: 40px;"></span>
                        </div>
                        <p class="text-sm font-bold">Change Successfully</p>
                    </div>
                <div class="mobileBtns flex justify-center gap-1 mt-2">
                    <button class="noMobile bg-red-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-red-700">No</button>
                    <button class="yesMobile bg-green-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-green-700">Yes</button>
                </div>
                
            </div>
        </div>
        <!--EDIT EMAIL-->
        <div class="editEmail w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden" style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg md:w-96 sm:w-96 lg:w-96 w-full absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="emailClose float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="mb-5 mt-5 font-bold">Email Address</h3>
                <input type="text" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <button class="emailChangeBtn shadow-lg drop-shadow-lg bg-orange-500 text-white font-bold px-3 py-1 float-end mt-5 rounded-lg hover:bg-orange-700">Change</button>
            </div>
            <div class="messageEmail w-fit h-fit bg-gray-100 absolute top-1/3 left-2/4 px-3 py-2 border-2 border-gray-500 rounded-md hidden" style="transform: translate(-50%,-50%);">
                <p class="pEmail">Are you sure you want to change it?</p>
                    <div class="emailSuccessMsg hidden">
                        <button class="float-end emailSuccessBtn px-2 py-1 hover:bg-gray-400 rounded-full">&#10006;</button><br>
                        <div class="flex flex-col justify-center items-center">
                            <span class="fa fa-check-circle text-green-500 ml-6" style="font-size: 40px;"></span>
                        </div>
                        <p class="text-sm font-bold">Change Successfully</p>
                    </div>
                <div class="emailBtns flex justify-center gap-1 mt-2">
                    <button class="noEmail bg-red-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-red-700">No</button>
                    <button class="yesEmail bg-green-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-green-700">Yes</button>
                </div>
                
            </div>
        </div>
        <!--Edit Password-->
        <div class="editPassword w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden" style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg md:w-96 sm:w-96 lg:w-96 w-full absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="passwordClose float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="font-bold mb-5 mt-5">Change Password</h3>
                <p class="text-sm font-semibold">Current Password</p>
                <input type="password" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <p class="text-sm font-semibold mt-2">New Password</p>
                <input type="password" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <p class="text-sm font-semibold mt-2">Confirm Password</p>
                <input type="password" class="border-2 border-gray-500 rounded-md text-sm px-2 py-1 w-full">
                <button class="passwordChangeBtn shadow-lg drop-shadow-lg bg-orange-500 text-white font-bold px-3 py-1 float-end mt-5 rounded-lg hover:bg-orange-700">Change</button>
            </div>
            <div class="messagePassword w-fit h-fit bg-gray-100 absolute top-1/3 left-2/4 px-3 py-2 border-2 border-gray-500 rounded-md hidden" style="transform: translate(-50%,-50%);">
                <p class="pPassword">Are you sure you want to change it?</p>
                    <div class="passwordSuccessMsg hidden">
                        <button class="float-end passwordSuccessBtn px-2 py-1 hover:bg-gray-400 rounded-full">&#10006;</button><br>
                        <div class="flex flex-col justify-center items-center">
                            <span class="fa fa-check-circle text-green-500 ml-6" style="font-size: 40px;"></span>
                        </div>
                        <p class="text-sm font-bold">Change Successfully</p>
                    </div>
                
                <div class="passwordBtns flex justify-center gap-1 mt-2">
                    <button class="noPassword bg-red-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-red-700">No</button>
                    <button class="yesPassword bg-green-500 shadow-lg drop-shadow-lg py-1 px-2 text-white font-bold rounded-md w-20 hover:bg-green-700">Yes</button>
                </div>
                
            </div>
        </div>
        <!--Edit List-->
        <div class="sellEditList w-full h-full bg-gray-400 bg-opacity-50 absolute top-2/4 left-2/4 hidden " style="transform: translate(-50%,-50%);">
            <div class="bg-gray-100 pt-2 pb-8 px-5 rounded-md shadow-lg drop-shadow-lg  w-full absolute top-2/4 left-2/4 md:w-fit lg:w-fit" style="transform: translate(-50%,-50%);">
                <button class="closeListSell float-end py-1 px-2 hover:bg-gray-400 rounded-full">&#10006;</button>
                <h3 class="font-bold mb-5 mt-5">Edit List</h3>
                <div class="flex justify-center">
                    <img src="img/laptop.png" alt="" class="w-28 h-28 md:w-40 md:h-40 lg:w-40 lg:h-40">
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-3 md:grid-cols-3 gap-3 border-t border-gray-500 pt-2">
                    <div>
                        <p class="text-xs font-thin">Title</p>
                        <input type="text" class="border-2 border-gray-500 rounded-md w-40 lg:w-40 md:w-40 text-sm pl-1">
                    </div>
                    <div>
                        <p class="text-xs font-thin">Price</p>
                        <input type="text" class="border-2 border-gray-500 rounded-md w-40 text-sm pl-1">
                    </div>
                    <div>
                        <p class="text-xs font-thin">Quantity</p>
                        <input type="number" class="border-2 border-gray-500 rounded-md w-40 text-sm pl-1">
                    </div>
                    <div>
                        <p class="text-xs font-thin">Condition</p>
                        <select class="border-2 border-gray-500 rounded-md w-40 text-sm">
                            <option hidden>Condition</option>
                            <option value="prelovedbnew">Preloved - Brand New</option>
                            <option value="likenew">Used - Like New</option>
                            <option value="good">Used - Good</option>
                            <option value="fair">Used - Fair</option>
                            </select>
                    </div>
                    <div>
                        <p class="text-xs font-thin">Categories</p>
                        <select class="border-2 border-gray-500 rounded-md w-40 text-sm">
                        <option hidden>Categories</option>
                        <option value="">Stationery</option>
                        <option value="">Labaratory Equipments</option>
                        <option value="">Books</option>
                        <option value="">Clothing</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xs font-thin">Description</p>
                    <textarea class="w-52 text-xs border-2 border-gray-500 px-2" rows="4" cols="30"></textarea>
                </div>
                <button class="bg-blue-500 px-3 py-1 rounded-md font-bold text-white float-end mt-2">Save</button>
            </div>
        </div>
    </div>
    
        
    <!--JavaScripts-->
    <script>
        /**const navLinks = document.querySelector('.nav-links')
        function menu(e){
            e.Name = e.Name === 'menu' ? 'close' : 'menu'
            navLinks.classList.toggle('top-[8%]')
        }*/
        
        const nav = document.querySelector('.nav')
        const modal = document.querySelector('.modal')
        const showModal = document.querySelector('.showModal')
        const menuBtn = document.querySelector('.menuBtn')
        const showMenu = document.querySelector('.showMenu')
        const main = document.querySelector('.main')

        showModal.addEventListener('click',function(){
            nav.classList.add('hidden')
            modal.classList.remove('hidden')
        })
        const cancelBtn = document.querySelector('.cancelBtn')
        cancelBtn.addEventListener('click',function(){
            nav.classList.remove('hidden')
            modal.classList.add('hidden')
            showMenu.classList.add('hidden')

        })
        
        menuBtn.addEventListener('click',function(){
            showMenu.classList.toggle('hidden')
            main.classList.toggle('block')
        })

        const profileBtn = document.querySelector('.profileBtn')
        const webMenu = document.querySelector('.webMenu')
        profileBtn.addEventListener('click',function(){
            webMenu.classList.toggle('hidden')
            webNotif.classList.add('hidden')
        })
        /*profile pic*/
        const profilePic = document.querySelector('.profilePic')
        const inputFile = document.querySelector('.inputFile')
        inputFile.onchange = function(){
            profilePic.src = URL.createObjectURL(inputFile.files[0])
        }
        const webNotifBtn = document.querySelector('.webNotifBtn')
        const webNotif = document.querySelector('.webNotif')
        webNotifBtn.addEventListener('click',function(){
            webNotif.classList.toggle('hidden')
            webMenu.classList.add('hidden')
        })
        const mobileNotifBtn = document.querySelector('.mobileNotifBtn')
        mobileNotifBtn.addEventListener('click',function(){
            webNotif.classList.toggle('hidden')
        })
        const webSearchBtn = document.querySelector('.webSearchBtn')
        webSearchBtn.addEventListener('click',function(){
            modal.classList.remove('hidden')
        })
        const nameBtn = document.querySelector('.nameBtn')
        const editName = document.querySelector('.editName')

        nameBtn.addEventListener('click',function(){
            editName.classList.remove('hidden')
        })
        const nameClose = document.querySelector('.nameClose')
        nameClose.addEventListener('click',function(){
            editName.classList.add('hidden')
        })
        const editProfileBtn = document.querySelector('.editProfileBtn')
        const editProfileDetails = document.querySelector('.editProfileDetails')
        const profileDetails = document.querySelector('.profileDetails')
        editProfileBtn.addEventListener('click',function(){
            editProfileDetails.classList.remove('hidden')
            profileDetails.classList.add('hidden')

        })
        const fname = document.getElementById('fnameChange');
        const mname = document.getElementById('mnameChange');
        const lname = document.getElementById('lnameChange');
        const nameError = document.querySelector('.nameError');
        const changeBtn = document.querySelector('.changeBtn');
        const messageName = document.querySelector('.messageName');
        changeBtn.addEventListener('click',function(){
        if(fname.value.trim() == ''){
            nameError.classList.remove('hidden');
            fname.style.border = '1px solid red';
            mname.style.border = '1px solid red';
            lname.style.border = '1px solid red';
        }
        else if(lname.value.trim()==''){
            nameError.classList.remove('hidden');
            lname.style.border = '1px solid red';
        }
        else{
            messageName.classList.remove('hidden')
        }
        setTimeout(function() {
                nameError.classList.add('hidden');
                fname.style.border = '';
                mname.style.border = '';
                lname.style.border = '';
                }, 3000);
        })
        const noName = document.querySelector('.noName')
        noName.addEventListener('click',function(){
            messageName.classList.add('hidden')
        })
        const yesName = document.querySelector('.yesName')
        const nameSuccessMsg = document.querySelector('.nameSuccessMsg')
        const pName = document.querySelector('.pName')
        const nameBtns = document.querySelector('.nameBtns')

        //Process for name change

        yesName.addEventListener('click',function(){
            const fullname = document.getElementById('fullname');
            const fname = document.getElementById('fnameChange').value;
            const mname = document.getElementById('mnameChange').value;
            const lname = document.getElementById('lnameChange').value;
            let data = {
                "updateType": 'NameChange',
                "fname": fname,
                "mname": mname,
                "lname": lname
            };

            fetch('edit-name.php',{
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if(data.success){
                    fullname.textContent = fname + ' ' + lname;
                    nameSuccessMsg.classList.remove('hidden')
                    pName.classList.add('hidden')
                    nameBtns.classList.add('hidden') 
                }
                else{
                    console.log(data)
                }
                setTimeout(function() {
                nameSuccessMsg.classList.add('hidden');
                editName.classList.add('hidden')
                }, 1500);
            })
        })
        const nameSuccessBtn = document.querySelector('.nameSuccessBtn')
        nameSuccessBtn.addEventListener('click',function(){
            editName.classList.add('hidden')
            messageName.classList.add('hidden')
        })
        const closeEditProfileDetails = document.querySelector('.closeEditProfileDetails')
        closeEditProfileDetails.addEventListener('click',function(){
            editProfileDetails.classList.add('hidden')
            profileDetails.classList.remove('hidden')
        })
        /*EDIT ADDRESS*/
        const addressBtn = document.querySelector('.addressBtn')
        const editAddress = document.querySelector('.editAddress')
        addressBtn.addEventListener('click',function(){
            editAddress.classList.remove('hidden')
        })
        
        const addressChangeBtn = document.querySelector('.addressChangeBtn')
        const messageAddress = document.querySelector('.messageAddress')
        addressChangeBtn.addEventListener('click',function(){
            const newAddress = document.getElementById('addressChange');
            const addressError = document.querySelector('.addressError');
            if(newAddress.value.trim() == ''){
            addressError.classList.remove('hidden');
            newAddress.style.border = '1px solid red';
        }
        else{
            messageAddress.classList.remove('hidden')
        }
        setTimeout(function() {
                addressError.classList.add('hidden');
                newAddress.style.border = '';
                }, 3000);
        })
        const noAddress = document.querySelector('.noAddress')
        noAddress.addEventListener('click',function(){
            messageAddress.classList.add('hidden')
        })
        const addressClose = document.querySelector('.addressClose')
        addressClose.addEventListener('click',function(){
            editAddress.classList.add('hidden')
        })
        const yesAddress = document.querySelector('.yesAddress')
        const addressSuccessMsg = document.querySelector('.addressSuccessMsg')
        const pAddress = document.querySelector('.pAddress')
        const addressBtns = document.querySelector('.addressBtns') 
        yesAddress.addEventListener('click',function(){
            const addressChange = document.getElementById('addressChange').value;
            const newAddress = document.getElementById('newAddress');
            let data = {
                "updateType": 'changeAddress',
                "newAddress": addressChange
            };

            fetch('edit-name.php',{
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if(data.success){
                    addressSuccessMsg.classList.remove('hidden')
                    pAddress.classList.add('hidden')
                    addressBtns.classList.add('hidden')
                    newAddress.textContent = addressChange;               
                }
                else{
                    console.log(data)
                }
                setTimeout(function() {
                addressSuccessMsg.classList.add('hidden');
                editAddress.classList.add('hidden')
                }, 1500); 
            })
        })
        const addressSuccessBtn = document.querySelector('.addressSuccessBtn')
        addressSuccessBtn.addEventListener('click',function(){
            editAddress.classList.add('hidden')
            messageAddress.classList.add('hidden')
        })
        /*Mobile Edit*/
        const mobileBtn = document.querySelector('.mobileBtn')
        const editMobile = document.querySelector('.editMobile')
        mobileBtn.addEventListener('click',function(){
            editMobile.classList.remove('hidden')
        })
        
        const mobileChangeBtn = document.querySelector('.mobileChangeBtn')
        const messageMobile = document.querySelector('.messageMobile')
        mobileChangeBtn.addEventListener('click',function(){
            const newNumber = document.getElementById('numberChange');
            const mobileError = document.querySelector('.mobileError');
            if(newNumber.value.trim() == ''){
            mobileError.classList.remove('hidden');
            mobileError.textContent = 'To proceed, please fill in required fields.';
            newNumber.style.border = '1px solid red';
        }
        else if(!/^[0-9]+$/.test(newNumber.value.trim())){
            mobileError.classList.remove('hidden');
            mobileError.textContent = 'To proceed, please enter valid phone number.';
            newNumber.style.border = '1px solid red';
        }
        else{
            messageMobile.classList.remove('hidden')
        }
        setTimeout(function() {
                mobileError.classList.add('hidden');
                newNumber.style.border = '';
                }, 3000);
        })
        const noMobile = document.querySelector('.noMobile')
        noMobile.addEventListener('click',function(){
            messageMobile.classList.add('hidden')
        })
        const mobileClose = document.querySelector('.mobileClose')
        mobileClose.addEventListener('click',function(){
            editMobile.classList.add('hidden')
        })
        const yesMobile = document.querySelector('.yesMobile')
        const mobileSuccessMsg = document.querySelector('.mobileSuccessMsg')
        const pMobile = document.querySelector('.pMobile')
        const mobileBtns = document.querySelector('.mobileBtns') 
        yesMobile.addEventListener('click',function(){
            const mobileChange = document.getElementById('numberChange').value;
            const newNumber = document.getElementById('newNumber');
            let data = {
                "updateType": 'changeNumber',
                "newNumber": mobileChange
            };

            fetch('edit-name.php',{
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if(data.success){
                    mobileSuccessMsg.classList.remove('hidden')
                    pMobile.classList.add('hidden')
                    mobileBtns.classList.add('hidden')
                    newNumber.textContent = mobileChange;               
                }
                else{
                    console.log(data)
                }
                setTimeout(function() {
                mobileSuccessMsg.classList.add('hidden');
                editMobile.classList.add('hidden')
                }, 1500); 
            })
        })
        const mobileSuccessBtn = document.querySelector('.mobileSuccessBtn')
        mobileSuccessBtn.addEventListener('click',function(){
            editMobile.classList.add('hidden')
            messageMobile.classList.add('hidden')
        })
        /*Edit Email*/
        const emailBtn = document.querySelector('.emailBtn')
        const editEmail = document.querySelector('.editEmail')
        emailBtn.addEventListener('click',function(){
            editEmail.classList.remove('hidden')
        })
        
        const emailChangeBtn = document.querySelector('.emailChangeBtn')
        const messageEmail = document.querySelector('.messageEmail')
        emailChangeBtn.addEventListener('click',function(){
            messageEmail.classList.remove('hidden')
        })
        const noEmail = document.querySelector('.noEmail')
        noEmail.addEventListener('click',function(){
            messageEmail.classList.add('hidden')
        })
        const emailClose = document.querySelector('.emailClose')
        emailClose.addEventListener('click',function(){
            editEmail.classList.add('hidden')
        })
        const yesEmail = document.querySelector('.yesEmail')
        const emailSuccessMsg = document.querySelector('.emailSuccessMsg')
        const pEmail = document.querySelector('.pEmail')
        const emailBtns = document.querySelector('.emailBtns') 
        yesEmail.addEventListener('click',function(){
            emailSuccessMsg.classList.remove('hidden')
            pEmail.classList.add('hidden')
            emailBtns.classList.add('hidden')
        })
        const emailSuccessBtn = document.querySelector('.emailSuccessBtn')
        emailSuccessBtn.addEventListener('click',function(){
            editEmail.classList.add('hidden')
            messageEmail.classList.add('hidden')
        })
        /*EDIT PASSWORD*/
        const passwordBtn = document.querySelector('.passwordBtn')
        const editPassword = document.querySelector('.editPassword')
        passwordBtn.addEventListener('click',function(){
            editPassword.classList.remove('hidden')
        })
        
        const passwordChangeBtn = document.querySelector('.passwordChangeBtn')
        const messagePassword = document.querySelector('.messagePassword')
        passwordChangeBtn.addEventListener('click',function(){
            messagePassword.classList.remove('hidden')
        })
        const noPassword = document.querySelector('.noPassword')
        noPassword.addEventListener('click',function(){
            messagePassword.classList.add('hidden')
        })
        const passwordClose = document.querySelector('.passwordClose')
        passwordClose.addEventListener('click',function(){
            editPassword.classList.add('hidden')
        })
        const yesPassword = document.querySelector('.yesPassword')
        const passwordSuccessMsg = document.querySelector('.passwordSuccessMsg')
        const pPassword = document.querySelector('.pPassword')
        const passwordBtns = document.querySelector('.passwordBtns') 
        yesPassword.addEventListener('click',function(){
            passwordSuccessMsg.classList.remove('hidden')
            pPassword.classList.add('hidden')
            passwordBtns.classList.add('hidden')
        })
        const passwordSuccessBtn = document.querySelector('.passwordSuccessBtn')
        passwordSuccessBtn.addEventListener('click',function(){
            editPassword.classList.add('hidden')
            messagePassword.classList.add('hidden')
        })

        /*Listing*/
        const listing = document.querySelector('.listing')
        const showListing = document.querySelector('.showListing')
        listing.addEventListener('click',function(){
            showListing.classList.remove('hidden')
            profileDetails.classList.add('hidden')
        })
        const about = document.querySelector('.about')
        about.addEventListener('click',function(){
            showListing.classList.add('hidden')
            profileDetails.classList.remove('hidden')
        })
        const listAuctionBtn = document.querySelector('.listAuctionBtn')
        const listSellBtn = document.querySelector('.listSellBtn')
        const listAuction = document.querySelector('.listAuction')
        const listSell = document.querySelector('.listSell')

        listAuctionBtn.addEventListener('click',function(){
            listSell.classList.add('hidden')
            listAuction.classList.remove('hidden')
        })
        listSellBtn.addEventListener('click',function(){
            listSell.classList.remove('hidden')
            listAuction.classList.add('hidden')
        })
        const sellEditListBtn = document.querySelector('.sellEditListBtn')
        const sellEditList = document.querySelector('.sellEditList')
        sellEditListBtn.addEventListener('click',function(){
            sellEditList.classList.remove('hidden')
        })
        const closeListSell = document.querySelector('.closeListSell')
        closeListSell.addEventListener('click',function(){
            sellEditList.classList.add('hidden')
        })
    </script>
</body>
</html>