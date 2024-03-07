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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div>
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
                        <li class="profileBtn hover:text-orange-500"><a class="cursor-pointer">Ralph</a></li>
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
                        <img src="img/profile.jpg" alt="profile" class="w-10 h-10 rounded-full mt-2">
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
                <li class="hover:text-orange-500"><a href="index.php">HOME</a></li>
                <li class="hover:text-orange-500"><a href="sell.php">SELL</a></li>
                <li class="hover:text-orange-500"><a class="text-orange-500" href="auction.php">AUCTION</a></li>
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
                <h3 class="font-bold text-black">Todays Pick</h3>
            </div>
            <center>
            <div class='grid grid-cols-3 md:grid-cols-6 border-t-2 gap-2 sm:gap-5 md:gap-10 border-gray-500 pt-5'>
            <?php
            $statement = "items.*, (select image_path from item_images where item_id = items.item_id limit 1) as display_image";
            $response = getJoinRecord('items WHERE item_is_auctioned = 1',$statement);
            
            if(!empty($response)){
                foreach($response as $data){
                    $dataAuctionItem = getRecord('auction_item', 'items_id', $data['item_id']);
                    //$_SESSION['Onlick_Auction_Item'] = $dataAuctionItem['Auction_Item_ID'];
                    echo "
                    <div class='pb-5' onclick='bidItem(\"".$dataAuctionItem['Auction_Item_ID']."\")' style='cursor: pointer;'>
                        <div>
                            <img class='md:w-36 md:h-36 sm:w-32 sm:h-32 w-28 h-28 border-2 border-gray-100' src='".$data['display_image']."' alt='".$data['item_title']."'>
                        </div>
                        <div class='flex flex-col ml-2 text-xs'>
                            <span>".$data['item_title']."</span>
                            <span class='font-bold'>".$data['item_price']."</span>
                        </div>
                    </div>";
                }
            }else{
                    echo "<h3>No listing available.</h3>";
            }
            ?>
        </div>
    
        <!--try if col is working-->
        
        <!--footer-->
        <div class="bg-gray-100 h-16 mt-5">

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
        function bidItem(auction_id){
            encodeAuctionItemId = encodeURIComponent(auction_id);
            window.location.href = "bid.php?auction_item_id="+ encodeAuctionItemId;
        }
    </script>
</body>
</html>