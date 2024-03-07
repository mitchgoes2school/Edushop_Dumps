<?php
session_start();

require("db/dbHelper.php");
$conn = connect();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset( $_SESSION['auth_user'])){ $currentUser = $_SESSION['auth_user']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy item</title>
    <!--Style-->
    <link rel="stylesheet" href="./stylesheet/output.css">
    <!--ICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Lexend Tera' rel='stylesheet'>
    <!--EDUSHOP FONTS-->
    <style>
        body, html {
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
        h2{
            font-family:'Lexend Tera';
        }
        .header {
            flex-shrink: 0;
        }

        .main {
            flex-grow: 1;
        }
        .slide > img {
            display: block;
        }
        .slide {
            opacity: 0;
            transform: translate(-50%,-50%);
            transition: 200ms opacity ease-in-out;
            transition-delay: 200ms;   
        }
        .slide[data-active] {
            opacity: 1;
            z-index: 1;
            transition-delay: 0ms;
        }
        .orderSummary{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
    </style>
</head>
<body class="max-h-full w-full">
    <!--whole-container-->
    <div class="containerClass max-h-full w-full">
        <!--Header-->
        <header class="header bg-gray-100 px-2 w-full">
            <nav class="nav flex justify-between items-center">
                <div>
                    <img class="w-95 h-10" src="img/logo.png" alt="logo">
                </div>
                <div class="flex items-center gap-4 md:hidden">
                    <button class="showModal fa fa-search cursor-pointer bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-2 rounded-full"style="font-size: 18px;"></button>
                    <button class="mobileNotifBtn fa fa-bell border-2 bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-2 rounded-full" style="font-size: 18px; color: transparent; -webkit-text-stroke: 2px black;"></button>
                    <ion-icon class="menuBtn mr-2 text-3xl cursor-pointer bg-gray-100 border-gray-100 hover:border-gray-200 hover:bg-gray-200 p-1 rounded-full"name="menu-outline"></ion-icon>
                </div>
                <div class="nav-links text-xs md:static md:min-h-fit absolute bg-gray-100 min-h-[13vh] left-0 md:w-auto w-full flex items-center px-5 top-[-100%]">
                    <ul class="flex md:flex-row flex-col md:items-center md:gap-2 gap-1 text-center">
                        <li class="hover:text-orange-500"><a class="cursor-pointer">Help</a></li>
                        <span class="hidden md:block">|</span>
                        <li class="webNotifBtn hover:text-orange-500"><a class="cursor-pointer"><i class="fa fa-bell"></i></a></li>
                        <span class="hidden md:block">|</span>
                        <li class=" <?php if(isset($_SESSION['authenticated'])) echo "profileBtn";?> hover:text-orange-500"><a class="cursor-pointer" <?php if(!isset($_SESSION['authenticated'])) echo "href='login.php'";?>>
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
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon name="person-circle-outline"></ion-icon></span>My profile</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon name="list-circle-outline"></ion-icon></span>Listing</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon name="eye-outline"></ion-icon></span>Watchlist</a>
                </div>
                <div class="bg-transparent hover:bg-gray-300 px-2 rounded-md">
                    <a class="text-sm" href="#"><span class="mr-2 mt-2"><ion-icon name="log-in-outline"></ion-icon></span>Logout</a>
                </div>
            </div>
            <!--Search Modal-->
            <div class="modal h-screen w-[%100] ml-10 mr-10 pt-5 hidden">
                <button class="cancelBtn font-bold ml-3 mr-5 md:mr-10  hover:text-gray-400 absolute md:right-5 right-0">Cancel</button>
                <center>
                    <input class="w-[70%] md:w-96 rounded-full pl-2 border-2 border-gray-400" type="text" name="s" id="s" placeholder="Search">
                    <br><br>
                    <span class="text-gray-500">Popular Search Items</span>
                </center>
               
                
                
            </div>
            <div class="showMenu h-screen w-full hidden">
                <div class="px-5 pt-5 ">
                    <h1 class="font-bold">Menu</h1>
                </div>
                <div class="px-5 flex border-b-2 border-gray-400">
                    <div>
                        <img src="img/laptop.png" alt="profile" class="w-10 h-10 rounded-full mt-2">
                    </div>
                    <div class="mb-5">
                        <p class="mx-2 mt-2 text-xs font-bold">Ralph Evan D. Cabellon</p>
                        <a class="mx-2 text-xs text-blue-700 underline" href="#">Edit Profile</a>
                    </div>
                </div>
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
                <div class="mt-5">
                    <button class="w-full border-2 border-gray-600 bg-gray-600 text-white rounded-xl font-bold cursor-pointer">Logout</button>
                </div>
                

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
                <li class="hover:text-orange-500"><a href="#">AUCTION</a></li>
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
                <h3 class="font-bold text-black">Buy Item</h3>
            </div>
            <div class="border-t-2 border-gray-400">
                <!--container-->
                <?php
                    if(isset($_GET['item_id'])){ $_SESSION['Onlick_Item_id'] =  $_GET['item_id']; }
                    $item_id = $_SESSION['Onlick_Item_id'];
                    $item = getRecord('items','item_id',$item_id);
                    $user_ID = $item['user_id'];
                    $user = getRecord('user_details','user_id',$user_ID);
                    $itemImage = getRecord('item_images','item_id',$item_id);
                ?>
                <div class="mx-10 grid md:grid-cols-2 grid-cols-1 mt-5 gap-2">
                    <div class="border-0 border-gray-400 shadow-lg drop-shadow-lg flex justify-center items-center" >
                            <div class="">
                                <img class="imgBtn w-52 h-52 hover:w-60 hover:h-60 cursor-pointer"src="<?php echo $itemImage['image_path']?>" alt="">
                            </div>
                    </div>
                    
                    <div class="px-5 py-5 border-2 border-gray-400 shadow-lg drop-shadow-lg">
                        <div class="grid md:grid-cols-2 grid-cols-1 border-b-2 border-gray-400 mb-2">
                            <div>
                                
                                <h2 class="font-bold"><?php echo $item['item_title']?></h2>
                                <p class="font-bold"><?php echo '₱'. $item['item_price']?></p> 
                                <p class="text-xs"><?php echo $item['item_quantity'].' pcs'?></p>
                                <p class="text-xs"><?php echo $item['item_condition']?></p>
                                <p class="text-xs font-bold"><?php echo $item['item_description']?></p>
                                
                                <!-- <p class="text-xs mb-2">Need Cash for my tuition fee.</p> -->
                            </div>
                            <button class="reportBtn top-1 right-1 absolute"><i class="fa fa-flag text-red-600 mr-2" style="font-size: 20px;"></i></button>
                            <div class=" border-gray-600 mb-5 p-2 shadow-md shadow-gray-500/10">
                            
                                <center>
                                    <input class="pl-2 border-2 border-gray-600 w-full rounded-md"type="text" placeholder="Amount">
                                    <button class="font-bold border-2 border-orange-500 text-orange-500 w-full rounded-md mt-2 hover:text-white hover:bg-orange-400">Make Offer</button><br>
                                    <form method='POST' action="buy.php">
                                    <?php
                                        $disabled = '';
                                        if(isset($_SESSION['auth_user'])){
                                            $fave = getMultipleRecord('favorites', ['User_ID', 'Items_ID'], [$currentUser['user_id'], $item_id]);
                                            if(count($fave) > 0){
                                                $disabled = 'disabled';
                                            }
                                            else{
                                                $disabled = '';
                                            }
                                        }
                                    ?>
                                    <button name="faveBtn" class="font-bold border-2 border-orange-500 text-orange-500 w-full rounded-md mt-2 hover:text-white hover:bg-orange-400" <?php echo $disabled; ?> >Add to Favorites</button><br>
                                    <?php
                                        if(isset($_POST['faveBtn']) && isset($_SESSION['auth_user'])){
                                            addRecord('favorites', ['User_ID', 'Items_ID'], [$currentUser['user_id'], $item_id]);
                                        }
                                    ?>
                                    </form>
                                    <button class="buyNow font-bold border-2 border-orange-600 bg-orange-500 text-white w-full rounded-md mt-2  hover:bg-orange-400">Buy Now</button>
                                </center>
                            </div>
                        </div>
                        <button class="reporUsertBtn float-end"><i class="fa fa-flag text-red-600 mr-2" style="font-size: 20px;"></i></button>
                        <p class="text-xs font-bold">Seller's Information</p>
                        <p><?php echo $user['user_first_name'].' '.$user['user_last_name']?></p>
                        <p class="text-xs"><?php echo $user['user_contact_number']?></p>
                        <p class="text-xs"><?php echo $user['user_address']?></p>
                    </div>
                    
                </div>
               
                
                
            </div>
            
        </div>
         <!--Order summary-->
         <div class="orderSummary bg-opacity-50 bg-gray-200 w-full h-full flex items-center justify-center hidden">
                    
            <div class="h-96 w-80 bg-white py-2 px-4 text-gray-900 border-2 border-gray-100 rounded-md shadow-lg drop-shadow-lg">
                <button class="orderClose float-end px-2 py-1 hover:bg-gray-300 rounded-full">&#10006;</button><br>
                <div class=" grid grid-cols-2 gap-1">
                    <div class="flex justify-center">
                        <img src="img/laptop.png" class="h-40 w-40" alt="">
                    </div>
                    <div class="pl-2 pt-3">
                        <p class="font-bold">Laptop</p>
                        <p class="text-sm my-1">Price: <span class="font-bold">₱20,000.00</span></p>
                        <p class="text-xs">Quantity: <span class="font-bold">1 pc</span></p>
                        <p class="text-xs my-1">MOP: <span class="font-bold">Meet-Up</span></p>
                    </div>
                </div>
                <div class="my-5">
                    <p class="text-sm">Order ID: #<span class="font-bold">100000</span></p>
                    <p class="text-sm">Total: <span class="font-bold">₱20,000.00</span></p>
                </div>
                <div class="mt-20 mb-4">
                    <button class="font-bold border-2 border-orange-500 bg-orange-500 w-full text-white rounded-md">Proceed</button>
                </div>
            </div>
        </div>
    
        <!--try if col is working-->
        
        <!--footer-->
        <div class="bg-gray-100 h-16 mt-5">

        </div>
        <div class="reportDialog h-full w-full hidden bg-gray-500 bg-opacity-40 absolute top-2/4 left-2/4 " style="transform: translate(-50%,-50%);">
            <div class=" bg-gray-100 h-fit w-fit px-5 pb-5 border-2 border-gray-400 drop-shadow-lg shadow-lg rounded-md absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="closeReport float-end text-base  px-3 py-1 text-gray-500 hover:bg-gray-200 rounded-full mt-2">&#10006;</button>
                <div class="flex flex-col items-center justify-center mt-10 mb-3 mx-4">
                    <p class="text-base font-bold ">Why do you want to report this item?</p>
                </div>
                <form method='POST' action='buy.php'>
                    <input name="reportReason" type="textarea" class="w-full h-20 p-2 border-gray-400 border-2 rounded-md">
                    <button name="reportBtn" class="bg-red-500 hover:bg-red-700 mt-2 py-1 px-3 text-white font-bold float-end rounded-md">Report</button>
                    <?php
                        if(isset($_POST['reportBtn']) && isset($_SESSION['auth_user'])){
                            $reportReason = $_POST['reportReason'];
                            $reportDate = date("Y-m-d H:i:s");
                            $reporterID = $currentUser['user_id'];
                            $reportItem = addRecord('report_item', ['User_ID', 'Reported_Item_ID','report_item_reason', 'report_item_date_created'], [$reporterID, $item_id, $reportReason, $reportDate]);
                        }
                    ?>
                </form>
            </div>
        </div>
        <div class="reportUserDialog h-full w-full hidden bg-gray-500 bg-opacity-40 absolute top-2/4 left-2/4 " style="transform: translate(-50%,-50%);">
            <div class=" bg-gray-100 h-fit w-fit px-5 pb-5 border-2 border-gray-400 drop-shadow-lg shadow-lg rounded-md absolute top-2/4 left-2/4" style="transform: translate(-50%,-50%);">
                <button class="closeReportUser float-end text-base  px-3 py-1 text-gray-500 hover:bg-gray-200 rounded-full mt-2">&#10006;</button>
                <div class="flex flex-col items-center justify-center mt-10 mb-3 mx-4">
                    <p class="text-base font-bold ">Why do you want to report this user?</p>
                </div>
                <form method='POST' action='bid.php'>
                    <input name="reportUserReason" type="textarea" class="w-full h-20 p-2 border-gray-400 border-2 rounded-md">
                    <button name="reportUserBtn" class="bg-red-500 hover:bg-red-700 mt-2 py-1 px-3 text-white font-bold float-end rounded-md">Report</button>
                    <?php
                        if(isset($_POST['reportUserBtn']) && isset($_SESSION['auth_user'])){
                            $reportUserReason = $_POST['reportUserReason'];
                            $reportUserDate = date("Y-m-d H:i:s");
                            $reporterID = $currentUser['user_id'];
                            $reportedUserID = $user_ID;
                            $reportUserItem = addRecord('report_user', ['User_ID', 'reported_user_ID','report_user_reason', 'report_user_date_created'], [$reporterID, $reportedUserID, $reportUserReason, $reportUserDate]);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <div class="showImg w-full h-screen bg-white p-5 flex justify-center items-center relative hidden">
        <button class="closeBtn absolute right-10 top-10 text-2xl  px-3 py-1 text-gray-500 hover:bg-gray-200 rounded-full">&#10006;</button>
        <div class="w-full md:h-60 h-32 bg-black bg-opacity-10 flex justify-center items-center relative " data-carousel>
            <button class="prev absolute left-10 text-3xl text-gray-400 py-1 px-4 hover:bg-gray-200 rounded-full" data-carousel-button="prev">&#10094;</button>
            <button class="next absolute right-10 text-3xl text-gray-400 py-1 px-4 hover:bg-gray-200 rounded-full" data-carousel-button="next">&#10095;</button>
            <ul data-slides>
            <?php
            $statement = "items.*, (select image_path from item_images where item_id = $item_id) as display_image";
            $response = getJoinRecord('items',$statement);
            if(!empty($response)){
                foreach($response as $data){
                    echo "
                    <li class='slide absolute md:top-1/2 md:right-[30%]' data-active>
                        <img class='md:w-60 md:h-60 h-32 w-32' src='".$data['display_image']."' alt='".$data['item_title']."'>
                    </li>";
                }
            }
            ?>
            </ul>
            
        </div>
    </div>
    <!--JavaScripts-->
    <script>
        /**const navLinks = document.querySelector('.nav-links')
        function menu(e){
            e.name = e.name === 'menu' ? 'close' : 'menu'
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

        const buttons = document.querySelectorAll("[data-carousel-button]")

        buttons.forEach(button => {
        button.addEventListener("click", () => {
            const offset = button.dataset.carouselButton === "next" ? 1 : -1
            const slides = button
            .closest("[data-carousel]")
            .querySelector("[data-slides]")

            const activeSlide = slides.querySelector("[data-active]")
            let newIndex = [...slides.children].indexOf(activeSlide) + offset
            if (newIndex < 0) newIndex = slides.children.length - 1
            if (newIndex >= slides.children.length) newIndex = 0

            slides.children[newIndex].dataset.active = true
            delete activeSlide.dataset.active
        })
        })
        const reportBtn = document.querySelector('.reportBtn')
        const reportDialog = document.querySelector('.reportDialog')
        reportBtn.addEventListener('click',function(){
            reportDialog.classList.remove('hidden')
        })
        const closeReport =document.querySelector('.closeReport')
        closeReport.addEventListener('click',function(){
            reportDialog.classList.add('hidden')
        })
        const reporUsertBtn = document.querySelector('.reporUsertBtn')
        const reportUserDialog = document.querySelector('.reportUserDialog')
        reporUsertBtn.addEventListener('click',function(){
            reportUserDialog.classList.remove('hidden')
        })
        const closeReportUser =document.querySelector('.closeReportUser')
        closeReportUser.addEventListener('click',function(){
            reportUserDialog.classList.add('hidden')
        })

        const imgBtn = document.querySelector('.imgBtn')
        const showImg = document.querySelector('.showImg')
        const containerClass = document.querySelector('.containerClass')

        imgBtn.addEventListener('click',function(){
            showImg.classList.remove('hidden')
            containerClass.classList.add('hidden')
        })
        const closeBtn = document.querySelector('.closeBtn')
        closeBtn.addEventListener('click',function(){
            showImg.classList.add('hidden')
            containerClass.classList.remove('hidden')
        })
        const orderSummary = document.querySelector('.orderSummary')
        const orderClose = document.querySelector('.orderClose')

        orderClose.addEventListener('click',function(){
            orderSummary.classList.add('hidden')
            main.classList.remove('hidden')
        })
        const buyNow = document.querySelector('.buyNow')
        buyNow.addEventListener('click', function(){
            orderSummary.classList.remove('hidden')
            main.classList.add('hidden')
        })
    </script>
</body>
</html>