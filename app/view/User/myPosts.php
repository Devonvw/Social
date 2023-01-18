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

function getMyPosts() {
    fetch(`${window.location.origin}/api/user/my-posts`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            var feedHTML = "";

            data?.forEach((post => feedHTML += `<div class="bg-teal-600/20 rounded-lg overflow-hidden relative mb-12 shadow-md">
                    <div class="absolute top-0 left-0 w-full p-2 pb-4 bg-gradient-to-b from-gray-800 to-transparent flex justify-between">
                        <h2 class="text-white font-extrabold text-2xl">${post.user.username}</h2>
                        <a href="/edit-post?id=${post.id}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600/80 hover:scale-110 cursor-pointer">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
</svg></a>

                    </div>
                    <img class="h-80 w-full object-center object-cover bg-white" src="${post.image_url}">
                    </img>
                    <div class="relative">
                        <div class="p-4">
                            <div class="flex items-center justify-center absolute top-2 right-2">
                                <p class="text-teal-800 mr-1">${post.likes}</p><button id="${post.id}"
                                    class="w-6 h-6 " onclick="likeUnlikePost(this)"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="${"w-6 h-6 text-teal-800 cursor-pointer " + (post.liked ? "fill-teal-800 hover:fill-white" : "hover:fill-teal-800") }">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg></button>
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
                            <div class="flex items-center gap-x-2 mt-2"><input maxlength="255" type="text"
                                    name="comment${post.id}" id="comment${post.id}"
                                    class="bg-transparent w-full text-gray-900 sm:text-sm rounded-lg block pl-0 p-2 focus:border-0 focus:ring-0 focus:outline-0"
                                    placeholder="Comment....." required=""><button id="${post.id}"
                                    class="w-6 h-6 " onclick="addComment(this)"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg></button></div>
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