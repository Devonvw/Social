<script src="https://cdn.tailwindcss.com"></script>
<html>
<?php 
//require_once "conf/config.php";
//include 'controller/sign-up.php' ?>

<body>
    <div class="">
        <?php include 'components/nav.php' ?>
        <div class="h-[80vh] flex justify-center items-center mt-32">
            <div class="max-w-xl">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Create a post
                        </h1>
                        <form class="space-y-4 md:space-y-6" method="post">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description</label>
                            <textarea id="message" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Description..."></textarea>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>