<?php
// Get current date or use selected month/year
$current_month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$current_year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Calculate previous and next months for navigation
$prev_month = $current_month == 1 ? 12 : $current_month - 1;
$prev_year = $current_month == 1 ? $current_year - 1 : $current_year;
$next_month = $current_month == 12 ? 1 : $current_month + 1;
$next_year = $current_month == 12 ? $current_year + 1 : $current_year;

// Get first day of month and total days
$first_day = date('N', strtotime("$current_year-$current_month-01"));
$total_days = date('t', strtotime("$current_year-$current_month-01"));
$month_name = date('F', strtotime("$current_year-$current_month-01"));

// Sample inventory data for demonstration
// $inventory_events = [
//     '2025-12-05' => ['type' => 'low_stock', 'count' => 3],
//     '2025-12-10' => ['type' => 'delivery', 'count' => 1],
//     '2025-12-15' => ['type' => 'audit', 'count' => 1],
//     '2025-12-20' => ['type' => 'expiry', 'count' => 5],
//     '2025-12-25' => ['type' => 'holiday', 'count' => 0],
// ];

// Function to get inventory events for a specific date
function getInventoryEvents($date) {
    global $inventory_events;
    return isset($inventory_events[$date]) ? $inventory_events[$date] : null;
}
?>

        <!-- Calendar Navigation -->
        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-xl shadow">
            <a href="?month=<?php echo date('n'); ?>&year=<?php echo date('Y'); ?>" 
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                <i class="fas fa-calendar-day mr-2"></i> Today
            </a>
            
            <div class="flex items-center space-x-4">
                <a href="?month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-chevron-left mr-2"></i> Previous
                </a>
                
                <div class="text-xl font-semibold text-gray-800 px-6 py-2 bg-gray-50 rounded-lg">
                    <?php echo $month_name . ' ' . $current_year; ?>
                </div>
                
                <a href="?month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Next <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
            
            <div class="text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i> <?php echo date('F j, Y'); ?>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Weekday Headers -->
            <div class="grid grid-cols-7 bg-blue-50 border-b">
                <?php
                $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach($weekdays as $day) {
                    echo '<div class="p-4 text-center font-semibold text-blue-700">' . $day . '</div>';
                }
                ?>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7">
                <?php
                // Fill empty cells for days before the first day of month
                for($i = 1; $i < $first_day; $i++) {
                    $prev_date = date('Y-m-d', strtotime("last day of previous month", strtotime("$current_year-$current_month-01")) - (($first_day - $i - 1) * 86400));
                    echo '<div class="calendar-day other-month border p-3" onclick="redirectToInventory(\'' . $prev_date . '\')">';
                    echo '<div class="date-number text-gray-400">' . date('j', strtotime($prev_date)) . '</div>';
                    echo '</div>';
                }

                // Current month days
                $today = date('Y-m-d');
                $today_clicked = false;
                for($day = 1; $day <= $total_days; $day++) {
                    $date = sprintf("%04d-%02d-%02d", $current_year, $current_month, $day);
                    $is_today = ($date == $today);
                    $inventory_event = getInventoryEvents($date);
                    
                    // Add click hint for today's date
                    $click_hint_class = ($is_today && !$today_clicked) ? 'click-hint' : '';
                    $today_clicked = true;
                    
                    echo '<div class="calendar-day border p-3 ' . $click_hint_class . '" onclick="redirectToInventory(\'' . $date . '\')">';
                    
                    if($is_today) {
                        echo '<div class="absolute top-1 left-1 w-2 h-2 bg-blue-600 rounded-full"></div>';
                    }
                    
                    echo '<div class="date-number ' . ($is_today ? 'text-blue-600 font-bold' : 'text-gray-800') . '">' . $day . '</div>';
                    
                    // Add inventory event indicators
                    if($inventory_event) {
                        if($inventory_event['count'] > 0) {
                            echo '<div class="inventory-count">' . $inventory_event['count'] . '</div>';
                        }
                        
                        // Show event type
                        $event_labels = [
                            'low_stock' => 'Low Stock',
                            'delivery' => 'Delivery',
                            'audit' => 'Audit',
                            'expiry' => 'Expiry',
                            'holiday' => 'Holiday'
                        ];
                        
                        $event_label = $event_labels[$inventory_event['type']] ?? 'Event';
                        echo '<div class="mt-2">';
                        echo '<span class="event-indicator ' . str_replace('_', '-', $inventory_event['type']) . '">' . $event_label . '</span>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                    
                    // Start new row on Sundays
                    if(($day + $first_day - 1) % 7 == 0 && $day != $total_days) {
                        echo '</div><div class="grid grid-cols-7">';
                    }
                }

                // Fill remaining cells with next month days
                $remaining_cells = 42 - ($total_days + $first_day - 1);
                for($i = 1; $i <= $remaining_cells; $i++) {
                    $next_date = date('Y-m-d', strtotime("+$i days", strtotime("$current_year-$current_month-$total_days")));
                    echo '<div class="calendar-day other-month border p-3" onclick="redirectToInventory(\'' . $next_date . '\')">';
                    echo '<div class="date-number text-gray-400">' . date('j', strtotime($next_date)) . '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <!-- Quick Inventory Date Selector -->
        <div class="mt-8 bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">
                <i class="fas fa-bolt mr-2"></i> Quick Inventory Dates
            </h3>
            <div class="flex flex-wrap gap-3">
                <?php
                $quick_dates = [
                    'Today' => date('Y-m-d'),
                    'Tomorrow' => date('Y-m-d', strtotime('+1 day')),
                    'Next Week' => date('Y-m-d', strtotime('+7 days')),
                    'Month End' => date('Y-m-t'),
                ];
                
                foreach($quick_dates as $label => $date) {
                    echo '<button onclick="redirectToInventory(\'' . $date . '\')" 
                           class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                           <i class="fas fa-calendar-check mr-2"></i>
                           ' . $label . ' (' . date('M j', strtotime($date)) . ')
                          </button>';
                }
                
                // Add a direct link to today's inventory
                echo '<a href="./inventories.php?date=' . date('Y-m-d') . '" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition ml-auto">
                       <i class="fas fa-warehouse mr-2"></i>
                       View Today\'s Inventory
                      </a>';
                ?>
            </div>
        </div>

        <!-- Loading Indicator (hidden by default) -->
        <div id="loading-indicator" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-8 rounded-xl shadow-2xl text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-lg font-semibold text-gray-800">Loading inventory data...</p>
                <p class="text-gray-600 mt-2">Redirecting to inventories.php</p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script>
        // Function to redirect to inventory page
        function redirectToInventory(date) {
            // Show loading indicator
            document.getElementById('loading-indicator').classList.remove('hidden');
            
            // Add a slight delay to show the loading animation
            setTimeout(function() {
                // Redirect to the inventories.php page with the selected date
                window.location.href = './inventories.php?date=' + date;
            }, 300);
        }
        
        // Add click animation feedback
        document.addEventListener('click', function(e) {
            if (e.target.closest('.calendar-day')) {
                const day = e.target.closest('.calendar-day');
                day.style.transform = 'scale(0.95)';
                day.style.transition = 'transform 0.1s ease';
                
                setTimeout(() => {
                    day.style.transform = '';
                }, 100);
            }
        });
        
        // Add today's date hint on page load
        document.addEventListener('DOMContentLoaded', function() {
            const todayCell = document.querySelector('.click-hint');
            if (todayCell) {
                setTimeout(() => {
                    todayCell.classList.remove('click-hint');
                }, 5000); // Remove animation after 5 seconds
            }
            
            // Auto-focus on calendar for keyboard navigation
            document.body.focus();
        });
        
        // Optional: Keyboard navigation to quickly jump to dates
        document.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 't':
                case 'T':
                    // Press T to go to today's inventory
                    e.preventDefault();
                    redirectToInventory('<?php echo date("Y-m-d"); ?>');
                    break;
                case 'y':
                case 'Y':
                    // Press Y to go to yesterday's inventory
                    e.preventDefault();
                    redirectToInventory('<?php echo date("Y-m-d", strtotime("-1 day")); ?>');
                    break;
                case 'm':
                case 'M':
                    // Press M to go to month end inventory
                    e.preventDefault();
                    redirectToInventory('<?php echo date("Y-m-t"); ?>');
                    break;
            }
        });
        
        // Add a help tooltip for keyboard shortcuts
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Quick keys: T=Today, Y=Yesterday, M=Month End');
        });
    </script>