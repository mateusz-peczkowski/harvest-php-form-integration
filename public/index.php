<?php require __DIR__ . '/helpers.php'; ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="bg-gray-900 min-h-screen flex flex-col items-center justify-center text-center text-white pt-10 pb-10 px-14">
    <h1 class="text-4xl font-bold">Harvest API integration</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-14 | mt-14">
        <div>
            <h3 class="text-xl">Duplicate entries</h3>
            
            <form action="actions/duplicate-entries.php" method="POST" class="flex flex-col mt-8">
                <div class="text-left mb-1 w-full">
                    <label for="de-from" class="block mb-1 text-sm font-medium">From</label>
                    <input id="de-from" type="date" name="from" class="py-2 px-4 bg-gray-800 text-white rounded-md focus:outline-none mb-4 w-full" required/>
                </div>

                <div class="text-left mb-1">
                    <label for="de-to" class="block mb-1 text-sm font-medium">To</label>
                    <textarea id="de-to" name="to" placeholder="dd/mm/yyyy, dd/mm/yyyy" rows="4" class="py-2 px-4 bg-gray-800 text-white rounded-md focus:outline-none mb-4 resize-y w-full" required></textarea>
                </div>
                
                <div class="flex items-center mb-4">
                    <input id="dup-entr-include-hours" type="checkbox" name="include_hours" value="on" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="dup-entr-include-hours" class="ms-2 text-sm font-medium">Include hours</label>
                </div>
                
                <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded-md hover:bg-blue-600 focus:outline-none">Send</button>
            </form>
        </div>

        <div>
            <h3 class="text-xl">Set Hours</h3>
            
            <form action="actions/set-hours-for-entries.php" method="POST" class="flex flex-col mt-8">
                <div class="text-left mb-1">
                    <label for="shfe-from" class="block mb-1 text-sm font-medium">From</label>
                    <input id="shfe-from" type="date" name="from" class="py-2 px-4 bg-gray-800 text-white rounded-md focus:outline-none mb-4 w-full" required/>
                </div>

                <div class="text-left mb-2">
                    <label for="shfe-to" class="block mb-1 text-sm font-medium">To</label>
                    <input id="shfe-to" type="date" name="to" class="py-2 px-4 bg-gray-800 text-white rounded-md focus:outline-none mb-4 w-full" required/>
                </div>
                
                <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded-md hover:bg-blue-600 focus:outline-none">Send</button>
            </form>
        </div>
        
        <div>
            <h3 class="text-xl">Delete entries</h3>
            <form action="actions/delete-day-entries.php" method="POST" class="flex flex-col mt-8">
                <div class="text-left mb-2">
                    <label for="dde-date" class="block mb-1 text-sm font-medium">From</label>
                    <input id="dde-date" type="date" name="date" class="py-2 px-4 bg-gray-800 text-white rounded-md focus:outline-none mb-4 w-full" required/>
                </div>
                
                <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded-md hover:bg-blue-600 focus:outline-none">Send</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>