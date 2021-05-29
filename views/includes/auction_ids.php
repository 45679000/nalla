<?php
function loadAuction(){
            for($i = 0; $i<53; $i++){
                $auction_id = date("Y").'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
                print '<option value="'.$auction_id.'">'.$auction_id.'</option>';
            }
        }

        function loadAuctionArray(){
            for($i = 0; $i<53; $i++){
                $auction_id = date("Y").'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
                $auctions[$auction_id] = $auction_id;
            }
            return $auctions;
        }
?>