<?php 
if((!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) || !isset($_GET['id'])){
    header("location: /");
    exit;
}
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.addEventListener("DOMContentLoaded", function() {
    getPost();
    var frm = document.getElementById("editForm");

    frm.addEventListener("submit", editPost);
});


function getPost() {
    const params = new URLSearchParams(window.location.search)
    fetch(`${window.location.origin}/api/feed/post?id=${params.get("id")}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (!res.ok) {
            window.location = "/my-posts";
        }
        const post = await res.json();
        document.getElementById('title').value = post?.title;
        document.getElementById('oldImage').src = `data:${post.image_type};base64, ${post.image_data}`
        document.getElementById('description').value = post?.description;
    }).catch((res) => {
        console.log("faulty");
        console.log("error", res);
    })
}

function editPost(e) {
    e.preventDefault();
    const params = new URLSearchParams(window.location.search)

    const formData = new FormData();
    formData.append("post_id", params.get("id"));
    formData.append("title", document.getElementById('title').value);
    formData.append("image", document.getElementById('image').files[0]);
    formData.append("description", document.getElementById('description').value);

    fetch(`${window.location.origin}/api/feed/edit`, {
        method: "POST",
        body: formData
    }).then(async (res) => {
        if (res.ok) {
            //window.location = "/my-posts";
        } else {
            document.getElementById('error').innerHTML = res.statusText;
            document.getElementById('errorWrapper').classList.remove('hidden');
        }
    }).catch((res) => {
        console.log("faulty");
        console.log("error", res);
    })
}
</script>
<header>
    <title>Edit Post - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Edit Post - Social" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://socialdevon.000webhostapp.com/" />
    <meta property="og:image" itemProp="image" content="/og_image.png" />
    <meta property="og:description" content="" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
</header>

<body>
    <div class="">
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="h-[80vh] flex justify-center items-center mt-32">
            <div class="max-w-xl">
                <div
                    class="w-80 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Edit post
                        </h1>
                        <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden"
                            id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p id="error"></p>
                        </div>
                        <form id="editForm" enctype=”multipart/form-data” class="space-y-4 md:space-y-6">
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Title</label>
                                <input maxlength="255" type="text" name="title" id="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Title..." required="">
                            </div>
                            <div>
                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Image</label>
                                <input type="file" name="image" id="image"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Image url...">
                            </div>
                            <img id="oldImage" class="h-24 w-full object-center object-cover bg-white rounded-lg">
                            </img>
                            <div>
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Description</label>
                                <textarea id="description" rows="4" maxlength="500"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Description..."></textarea>
                            </div>
                            <button type="submit"
                                class="border border-white w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>