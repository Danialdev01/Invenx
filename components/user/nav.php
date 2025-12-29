<!-- Side Navigation -->
<div class="sidenav bg-white shadow-sm z-10">
    <div style='padding:1.1rem' class="">
        <div class="flex items-center">
            <center>
                <img class="h-10" src="<?php echo $location_index?>/src/assets/images/logo/logo-banner.png" alt="logo">
            </center>
            <!-- <i class="fas fa-utensils text-primary-600 text-3xl mr-2"></i> -->
            <!-- <span class="text-xl font-bold text-gray-900">Resipi<span class="text-primary-600">Sihat</span></span> -->
        </div>
    </div>

    <?php 

        function setActive($folder_name){
            $current_path = $_SERVER['PHP_SELF'];
            
            // Extract the part after /user/
            if (preg_match('#/user/([^/]*)#', $current_path, $matches)) {
                $current_folder = $matches[1];
            } else {
                $current_folder = ''; // We're in user root
            }
            
            if ($current_folder === $folder_name) {
                echo 'active';
            }
            else {
                echo $current_folder;
            }
        }

    ?>
    
    <div class="py-4">
        <div class="px-2 text-xs uppercase text-gray-500 font-semibold mb-2 pl-5">Main Menu</div>
        <a href="<?php echo $location_index?>/user/" class="<?php setActive('index.php'); ?> nav-link flex items-center py-3 px-5 text-gray-700">
            <i class="fas fa-home text-gray-500 mr-3 w-5 text-center"></i>
            Dashboard
        </a>
        <a href="<?php echo $location_index?>/user/inventories/" class="<?php setActive('inventories'); ?> nav-link flex items-center py-3 px-5 text-gray-700">
            <i class="fas fa-book text-gray-500 mr-3 w-5 text-center"></i>
            Past Inventories
        </a>
        <a href="<?php echo $location_index?>/user/items/" class="<?php setActive('items'); ?> nav-link flex items-center py-3 px-5 text-gray-700">
            <i class="fas fa-carrot text-gray-500 mr-3 w-5 text-center"></i>
            Items
        </a>
        
        
        <div class="px-2 text-xs uppercase text-gray-500 font-semibold mb-2 mt-6 pl-5">Setting</div>
        <form clas="w-full" action="<?php echo $location_index?>/backend/user.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token?>">
            
            <button type="submit" name="signout" class="w-full nav-link flex items-center py-3 px-5 text-gray-700">
                <i class="fas fa-sign-out-alt text-gray-500 mr-3 w-5 text-center"></i>
                Log Out
            </button>
        </form>
    </div>
    
</div>