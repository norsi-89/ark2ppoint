<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
<button class=" text-white text-lg p-2" onclick="location.href='index.php'">
    back
</button>
    <div class="container py-2">
        <h1 class="text-3xl font-bold text-center mb-4">earn point</h1>

        <p class="text-center mt-8 anim ">Your Points: <span id="points" class="font-bold">0</span></p>


        <div id="list-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- List items will be dynamically added here -->
        </div>
    </div>

    <script>
        // Sample data
        const items = [
            { name: "15 point", img: "ca1.jpg", link: "https://instagram.com" },
            { name: "15 point", img: "ca2.jpg", link: "https://twitter.com" },
            { name: "15 point", img: "bb.jpg", link: "https://instagram.com" },
            { name: "15 point", img: "bb1.jpg", link: "https://twitter.com" },
            { name: "15 point", img: "bb2.jpg", link: "https://instagram.com" },
            { name: "15 point", img: "bb3.jpg", link: "https://twitter.com" },
            { name: "15 point", img: "bb4.jpg", link: "https://instagram.com" },
            { name: "15 point", img: "bb5.jpg", link: "https://twitter.com" },
            { name: "15 point", img: "ca3.jpg", link: "https://instagram.com" },
            { name: "15 point", img: "bb6.jpg", link: "https://twitter.com" },
        ];

        // Initialize points
        let points = 0;
        let lastClicked = null;

        // Render items
        const container = document.getElementById('list-container');

        items.forEach((item, index) => {
            const card = document.createElement('div');
            card.className = 'glass p-2 text-center';

            card.innerHTML = `
                <img src="${item.img}" alt="${item.name}" class="w-full h-40 object-cover rounded-md mb-4 cursor-pointer" onclick="handleClick(${index})">
                <h2 class="text-lg font-semibold">${item.name}</h2>
            `;

            container.appendChild(card);
        });

        // Handle click
        function handleClick(index) {
            const now = new Date().getTime();
            if (!lastClicked || now - lastClicked >= 24 * 60 * 60 * 1000) {
                window.open(items[index].link, '_blank');
                points += 15;
                lastClicked = now;
                document.getElementById('points').textContent = points;
                
            } else {
                alert('You need to wait 24 hours to click another link.');
            }
        }
    </script>
</body>
</html>




