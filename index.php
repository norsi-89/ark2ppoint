<?php
// index.php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_to_cart') {
        $product_id = $_POST['product_id'];
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 0;
        }
        $_SESSION['cart'][$product_id]++;
        echo json_encode(['success' => true, 'count' => array_sum($_SESSION['cart'])]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-animate {
            transition: transform 0.1s;
        }
        .btn-animate:active {
            transform: scale(0.95);
        }
    </style>

</head>
<body class="w-full bg-gray-900">

<div class="">
<img src="pngwing.com.png" class=" flex justify-center items-center text-center w-40 h-30> p-4">

<div class="flex justify-center items-center text-red-500 text-center rounded-md p-2 text-2xl">
           <span class="text-sm p-2"> point</span> <span id="cart-count"><?= array_sum($_SESSION['cart']) ?></span>
        </div>
        <br><br>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-1">
            <?php
            $products = [
                ['id' => 1, 'name' => 'lightning wyvern', 'price' => 250, 'image' => 'ca1.jpg'],
                ['id' => 2, 'name' => 'hydra', 'price' => 190, 'image' => 'ca2.jpg'],
                ['id' => 3, 'name' => 'behemoth', 'price' => 290, 'image' => 'ca3.jpg'],
                ['id' => 4, 'name' => 'ember', 'price' => 380, 'image' => 'dragon1.jpeg'],
                
            ];

            foreach ($products as $product): ?>
                <div class="bg-white backdrop-blur-lg rounded-lg shadow-md text-sm">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full object-cover mb-2">
                    <h2 class="text-xl font-semibold mb-2 p-1 text-center"><?= $product['name'] ?></h2>
                    <div class="flex space-x-4 btn-animate text-red-500 rounded-md text  text-md shadow-sm">
                    <p class="text-gray-600 pl-2 text-sm">P <?= number_format($product['price'], 2) ?></p>
                    <button 
                        class="btn-animate text-red-500 rounded-md text  text-md shadow-sm"
                        onclick="addToCart(<?= $product['id'] ?>)">
                        add point
                    </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        
    </div>

    <script>
        function addToCart(productId) {
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add_to_cart&product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    <?php
    include 'profile.php';
    ?>
     <div class="fixed bottom-0 left-0 w-full backdrop-blur-md shadow-lg ">
        <div class="flex justify-around items-center py-3">
            <!-- Search Icon -->
            <button class="flex flex-col items-center text-gray-700 hover:text-blue-500 " onclick="location.href='home.php'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="text-xs">Search</span>
            </button>

            <!-- Profile Icon -->
            <button class="flex flex-col items-center text-gray-700 hover:text-blue-500" onclick="location.href='menu.php'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1119.805 5.12M12 7a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
                <span class="text-xs">chance</span>
            </button>

            <!-- Money Icon -->
          

            <!-- Task Icon -->
            <button class="flex flex-col items-center text-gray-700 hover:text-blue-500" onclick="location.href='task.php'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m1-4H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2z" />
                </svg>
                <span class="text-xs">Tasks</span>
            </button>
            <button class="flex flex-col items-center text-gray-700 hover:text-blue-500" onclick="location.href='search.php'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.105 0 2 .895 2 2v4c0 1.105-.895 2-2 2s-2-.895-2-2v-4c0-1.105.895-2 2-2zm-6 8h12a2 2 0 012 2v2H4v-2a2 2 0 012-2z" />
                </svg>
                <span class="text-xs">account</span>
            </button>
        </div>
</body>
</html>