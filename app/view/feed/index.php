<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.onload = getFeed();

function likeUnlikePost(postId) {
    const loggedIn = "<?php echo isset($_SESSION["loggedin"]); ?>"

    if (!loggedIn) {
        alert("Login or signup to like this post.");
        return;
    }

    fetch(`${window.location.origin}/api/feed/like-unlike-post`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify({
            post_id: postId?.id,
        })
    }).then(async (res) => {
        getFeed();
    }).catch((res) => {});
}

function getFeed() {
    fetch(`${window.location.origin}/api/feed`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            var loggedIn = false;
            try {
                loggedIn = "<?php echo isset($_SESSION["loggedin"]); ?>"
            } catch (e) {}
            console.log(loggedIn ? "ja" : "nee");

            var feedHTML = "";

            data?.forEach((post => feedHTML += `<div class="bg-teal-600/20 rounded-lg overflow-hidden relative mb-12 shadow-md">
                    <div class="absolute top-0 left-0 w-full p-2 pb-4 bg-gradient-to-b from-gray-800 to-transparent">
                        <h2 class="text-white font-extrabold text-2xl">${post.user.username}</h2>
                    </div>
                    <img class="h-80 w-full object-center object-cover bg-white" src="${`data:${post.image_type};base64, ${post.image_data}`}">
                    </img>
                    <div class="relative">
                        <div class="p-4">
                            <div class="flex items-center justify-center absolute top-4 right-4">
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
                                ${post.comments[0] ? post.comments.length : 0} comment(s)
                            </h6>
                            <div class="max-h-[4.75rem] overflow-y-auto">
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
                                        class="w-6 h-6 hover:fill-teal-800">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg></button></div>
                        </div>

                        <p class="border-t border-gray-400 text-xs px-4 py-1">
                            ${new Date(post.created_at).toLocaleString()}</p>
                    </div>
                </div>`))

            document.getElementById("posts").innerHTML = feedHTML;
        }
    }).catch((res) => {});
}

function addComment(postId) {
    const loggedIn = "<?php echo isset($_SESSION["loggedin"]); ?>"

    if (!loggedIn) {
        alert("Login or signup to comment on this post.");
        return;
    }

    if (!document.getElementById(`comment${postId?.id}`).value) return;

    fetch(`${window.location.origin}/api/feed/add-comment`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify({
            comment: document.getElementById(`comment${postId?.id}`).value,
            post_id: postId?.id,
        })
    }).then(async (res) => {
        getFeed();
    }).catch((res) => {});
}
</script>
<header>
    <title>Home - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Home - Social" />
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

<head>
    <link rel="stylesheet" href="../../styles/globals.css">
    <link />
</head>

<body>
    <div class="min-h-screen">
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="flex justify-center mt-32">
            <div class="w-full px-2 sm:max-w-xl flex flex-col gap-4 mb-10" id="posts">
                <!-- Posts -->
            </div>
        </div>
    </div>
</body>

</html>