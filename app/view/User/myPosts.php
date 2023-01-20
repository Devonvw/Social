<?php 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: /");
    exit;
}
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.onload = getMyPosts();

function deletePost(id) {
    if (!confirm("Are you sure you want to delete this post?")) return;
    fetch(`${window.location.origin}/api/feed?id=${id}`, {
        method: "DELETE",
    }).then(async (res) => {
        if (res.ok) {
            getMyPosts();
        } else {
            document.getElementById('error').innerHTML = res.statusText;
            document.getElementById('errorWrapper').classList.remove('hidden');
        }
    }).catch((res) => {
        console.log("faulty");
        console.log("error", res);
    })
}

function getMyPosts() {
    fetch(`${window.location.origin}/api/user/my-posts`, {
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            var feedHTML = "";

            data?.forEach((post => feedHTML += `<div class="bg-teal-600/20 rounded-lg overflow-hidden relative mb-12 shadow-md">
                    <div class="absolute top-0 left-0 w-full p-2 pb-4 bg-gradient-to-b from-gray-800 to-transparent flex justify-between">
                        <h2 class="text-white font-extrabold text-2xl">${post.user.username}</h2>
                        <div class="flex gap-x-1"><a class="flex items-center" href="/edit-post?id=${post.id}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white hover:scale-110 cursor-pointer">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
</svg>
</a>
<button class="flex items-center" onclick="deletePost(${post.id})"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600/80 hover:scale-110 cursor-pointer">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
</svg></button></div>

                    </div>
                    <img class="h-80 w-full object-center object-cover bg-white" src="${`data:${post.image_type};base64, ${post.image_data}`}">
                    </img>
                    <div class="relative">
                        <div class="p-4">
                            <div class="flex items-center justify-center absolute top-2 right-2">
                                <p class="text-teal-800 mr-1">${post.likes}</p><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="${"w-6 h-6 text-teal-800" + (post.liked ? "fill-teal-800" : "") }">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                            </div>
                            <h2 class="text-teal-800 font-bold text-xl">${post.title}</h2>
                            <p>${post.description}</p>

                        </div>
                        <div class="border-t border-gray-400 px-4 py-1 text-sm">
                            <h6 class="text-base font-semibold">
                                ${post.comments[0] ? post.comments.length : 0} comments
                            </h6>
                            <div class=" max-h-20 overflow-y-auto">
                                ${post.comments[0] ? `<div class="mt-1">
                                    ${post.comments?.map((comment) => 
                                        `<div class="flex gap-x-2">
                                            <p class="font-medium">${comment.username}: </p>
                                            <p>${comment.comment}</p>
                                        </div>`).join('')}
                                </div>` : ''}
                            </div>
                        </div>

                        <p class="border-t border-gray-400 text-xs px-4 py-1">
                            ${new Date(post.created_at).toLocaleDateString()}</p>
                    </div>
                </div>`))

            document.getElementById("posts").innerHTML = feedHTML;
        }
    }).catch((res) => console.log("error", res));
}
</script>
<header>
    <title>My Posts - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="My Posts - Social" />
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
        <div class="flex justify-center mt-32">
            <div class="w-full px-2 sm:max-w-4xl sm:columns-2 gap-8 mb-10" id="posts">
                <!-- Posts -->
            </div>
        </div>
    </div>
</body>

</html>