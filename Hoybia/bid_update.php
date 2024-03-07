<?php
    session_start();
    include("db/dbHelper.php");
    $conn = connect();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_SESSION['auction_item_ID'])){
        $auctionItemID = $_SESSION['auction_item_ID'];
        $bid = getMaxRecordValue('bid_amount','bid','Auctioned_Item_ID',$auctionItemID );
        $currentBid = $bid['bid_amount'];
        echo $currentBid;
    }
?>