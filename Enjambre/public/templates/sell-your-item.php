<?php
    require("scripts/db_connect.php");

        if(isset($_FILES['files']) && isset($_POST['sellBtn']) ){
            $itemTitle = $_POST['itemTitle'];
            $itemPrice = $_POST['itemPrice'];
            $itemQuantity = $_POST['quantity'];
            $itemCondition;
            $itemCategory;
            $listType;
            $itemDescription = $_POST['description'];
            if(isset($_POST['condition'])){$itemCondition = $_POST['condition'];}
            if(isset($_POST['category'])){$itemCategory = $_POST['category'];}
            if(isset($_POST['list-type'])){$listType = $_POST['list-type'];}
            $files =  $_FILES;
            if($files['files']['name'][0] == ''){
                echo "<script>alert('Please select atleast 1 photo')</script>";
            }
            else{
                $path = "../users/Ralph Evan/items/{$itemTitle}/";
                $names = $files['files']['name'];
                $tmpName = $files['files']['tmp_name'];
                $filesArray = array_combine($tmpName, $names);
                
                $bool = addRecord('items', ['user_id', 'item_title', 'item_description', 'item_price', 'item_quantity', 'item_condition'], 
                [1028, $itemTitle, $itemDescription, $itemPrice, $itemQuantity, $itemCondition]);
                $itemId = mysqli_insert_id($db);
                if($bool){
                    foreach($filesArray as $tmpFolder => $image_name){
                    $fileName = $image_name."-".date("Ymd_His");
                    if (!is_dir($path)) {
                        if (!mkdir($path, 0777, true)) {
                            die('Failed to create directory...');
                        }
                    }
                    $response = addRecord('item_images',['item_id','image_path'],[$itemId, $path.$image_name]);
                    if($response){
                        move_uploaded_file($tmpFolder, $path.DIRECTORY_SEPARATOR.$image_name);
                        header('location:index.php');
                    }
                }
                }
                     
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Style-->
    <link rel="stylesheet" href="../stylesheet/output.css">
    <!--ICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                    <a href="index.php"><img class="w-95 h-16" src="../img/logos.png" alt="logo"></a>
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
                        <li class="profileBtn hover:text-orange-500"><a class="cursor-pointer">
                        <?php
                        $query = "select user_first_name from user_details where user_id = 1028";
                        $response = $db->query($query);
                            if($response->num_rows>0){
                                foreach($response as $data){
                                    echo $data['user_first_name'];
                                }
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

                <?php
                $string = "CONCAT(user_first_name,' ', user_last_name) as fullname,user_image";
                 $response = getOneRecord('user_details',$string,'user_id', 1028);
                echo "<div class='px-5 flex border-b-2 border-gray-400'>
                <div>
                  <img src='".$response['user_image']."' alt='profile' class='w-10 h-10 rounded-full mt-2'>
                </div>
                    <div class='mb-5'>
                        <p class='mx-2 mt-2 text-xs font-bold'>".$response['fullname']."</p>
                        <a class='mx-2 text-xs text-blue-700 underline' href='#'>Edit Profile</a>  
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
                <li class="hover:text-orange-500"><a class="text-orange-500" href="#" href="sell-you-item.php">SELL</a></li>
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
                <h3 class="font-bold text-black">Sell</h3>
            </div>
            <div class="border-t-2 border-gray-500">
                <!--image file-->
                <form action="sell-your-item.php" method="POST" enctype="multipart/form-data">
                <div class="flex justify-center items-center my-5 " >
                    <label for="files" class="cursor-pointer">
                        <div class="flex justify-center items-center border-2 border-gray-500 rounded-md flex-col bg-gray-100" style="width: 150px; height: 150px;">
                            <label for="files" class="material-icons cursor-pointer" style="font-size: 40px;">add_a_photo</label>
                            <span class="text-xs">Add Photo</span>
                            <input type="file" name="files[]" id="files" class="hidden" accept="image/png, image/jpeg, image/jpg" multiple="multiple">
                        </div>
                    </label>
                    
                </div>
                    <div id="result" class="flex justify-center">

                    </div>
                    <div class="my-2 mx-5">
                        <button class=""></button>
                    </div>
                <div class="flex md:flex-row flex-col gap-2">
                    <input class="rounded-md pl-2 border-2 border-gray-400"type="text" name="itemTitle" id="itemTitle" placeholder="Title" required>
                    <input class="rounded-md pl-2 border-2 border-gray-400"type="text" name="itemPrice" id="price" placeholder="Price" required>
                    <input class="rounded-md pl-2 border-2 border-gray-400"type="text" name="quantity" id="quantity" placeholder="Quantity" required>
                    
                </div>
                <div class="">
                    <select class="mt-5 rounded-md pl-2 border-2 border-gray-400 mr-2"name="condition" id="condition" required>
                        <option hidden>Condition</option>
                        <option value="like-new">Used - Like New</option>
                        <option value="good">Used - Good</option>
                        <option value="fair">Used - Fair</option>
                    </select>
                    <select class="rounded-md pl-2 border-2 mt-5 border-gray-400"name="category" id="category" required>
                        <option hidden>Categories</option>
                        <option value="Stationery">Stationery</option>
                        <option value="Laboratory Equipment">Laboratory Equipments</option>
                        <option value="Books">Books</option>
                        <option value="Clothing">Clothing</option>
                        
                    </select><br>
                    
                    <select name="list-type" class="mt-5 rounded-md pl-2 border-2 border-gray-400" id="select" onchange="myFunction()" required>
                        <option value="sell">Sell</option>
                        <option value="auction">Auction</option>
                    </select>
                </div>
                <input class="mt-5 rounded-md pl-2 border-2 border-gray-400"type="text" name="description" id="Description" placeholder="Description" required>
                <div id="sell" class="border-t-2 border-gray-500 mt-5 pt-2" style="display:block">
                    <span>Mode of Payment</span>
                    <br>
                    <input type="radio" name="payment" value="Gcash"><span class="ml-2">Gcash</span>
                    <input type="radio" name="payment" value="Meet-up"><span class="ml-2">Meet-up</span>
                    <br>
                    <span>Allow buyer to make an offer?</span><br>
                    <select class="mt-4 rounded-md pl-2 border-2 border-gray-400"name="offer" id="offer">
                        <option value="">No</option>
                        <option value="">Yes</option>
                    </select>
                    <div style="text-align: right;">
                        <button type="submit" name="sellBtn" class="sellBtn w-24 h-10 border-2 border-orange-500 text-white bg-orange-500 rounded-3xl font-bold hover:bg-gray-50 hover:text-orange-500 shadow-lg drop-shadow-lg" id="sellBtn">Sell</button>
                    </div>
                </div>
                <div  id="auction" class="border-t-2 border-gray-500 mt-5 pt-2" style="display: none;">
                    <span>Mode of Payment</span>
                    <br>
                    <input type="radio"><span class="ml-2">Gcash</span>
                    <input type="radio"><span class="ml-2">Meet-up</span>
                    <br>
                    <div class="flex md:flex-row flex-col gap-2">
                        <input class="rounded-md pl-2 border-2 border-gray-400"type="text" placeholder="Date-end">
                        <input class="rounded-md pl-2 border-2 border-gray-400"type="text" placeholder="Time-end">
                        <select class="rounded-md pl-2 border-2 border-gray-400"name="auctionitem" id="auctionitem">
                        <option hidden>Select an option</option>
                        <option value="">Collectible Item</option>
                        <option value="">With Academic Value</option>
                        </select>
                        
                    </div>
                    <div style="text-align: right;">
                        <button type="submit" class="auctionBtn w-24 h-10 border-2 border-orange-500 text-white bg-orange-500 rounded-3xl font-bold hover:bg-gray-50 hover:text-orange-500 mt-2 shadow-lg drop-shadow-lg" id="auctionBtn">Auction</button>
                    </div>
                </div>
                </form>
           </div> 
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
        /*selling function*/
        function myFunction(){
            var select = document.getElementById("select");
            var sellDiv = document.getElementById("sell");
            var auctionDiv = document.getElementById("auction");

            if (select.value === "sell") {
                sellDiv.style.display = "block";
                auctionDiv.style.display = "none";
            } else if (select.value === "auction") {
                sellDiv.style.display = "none";
                auctionDiv.style.display = "block";
            }
        }
        /*Multile file function*/
        document.querySelector('#files').addEventListener("change", (e) =>{
            if(window.File && window.FileReader && window.FileList && window.Blob){
                const files = e.target.files;
                const output = document.querySelector("#result");

                for(let i = 0; i < files.length; i++){
                    if(!files[i].type.match("image")) continue;
                    const picReader = new FileReader();
                    picReader.addEventListener("load", function(event){
                    const picFile = event.target;
                    const div = document.createElement("div")
                    div.innerHTML = `<img class="thumbnail border-2 border-gray-500 rounded-md my-2 w-20 h-20 mr-2" src="${picFile.result}" title="${picFile.name}"/>`;
                    output.appendChild(div);
                    })
                    picReader.readAsDataURL(files[i]);
                }
            }else{
                alert("Your browser does not support the File API")
            }
        })
    </script>
</body>
</html>