<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urenregistratie</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
    <form action="submit_hours.php" method="POST" class="space-y-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Datum</label>
            <input type="date" name="date" id="date" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="hours" class="block text-sm font-medium text-gray-700">Aantal uren</label>
            <input type="number" name="hours" id="hours" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>
        <div>
            <label for="employer" class="block text-sm font-medium text-gray-700">Werkgever</label>
            <select id="employer" name="employer" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php
                // Vervang 'user_id' door de daadwerkelijke user_id van de ingelogde gebruiker
                $result = mysqli_query($conn, "SELECT * FROM employers WHERE user_id = 'user_id'");
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="bonus" class="block text-sm font-medium text-gray-700">Toeslagen</label>
            <select id="bonus" name="bonus" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php
                // Vervang 'user_id' door de daadwerkelijke user_id van de ingelogde gebruiker
                $result = mysqli_query($conn, "SELECT * FROM bonuses WHERE user_id = 'user_id'");
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='".$row['id']."'>".$row['description']."</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit
            </button>
        </div>
    </form>
</body>
</html>