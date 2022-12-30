<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
function likeUnlikePost(postId) {
    fetch('http://localhost/api/feed/like-unlike-post', {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify({
            post_id: postId?.id,
        })
    }).then(async (res) => {
        //const data = await res.json();
        window.location.reload();
    }).catch((res) => console.log("error", res));
}
</script>

<head>
    <link rel="stylesheet" href="../../styles/globals.css">
    <link />
</head>

<body>
    <div class="min-h-screen">
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="flex justify-center mt-32">
            <div class="w-full px-2 sm:max-w-4xl sm:columns-2 gap-8">
                <?php foreach($data as $item) : ?>
                <div class="bg-teal-600/10 rounded-lg overflow-hidden relative mb-12 shadow-md">
                    <div class="absolute top-0 left-0 w-full p-2 pb-4 bg-gradient-to-b from-gray-800 to-transparent">
                        <h2 class="text-white font-extrabold text-2xl"><?= $item->user->username ?></h2>
                    </div>
                    <img class="h-80 w-full object-center object-cover bg-white" src="<?= $item->image_url ?>">
                    </img>
                    <div class="relative">
                        <div class="p-4">
                            <div class="flex items-center justify-center absolute top-2 right-2">
                                <p class="text-teal-800"><?= $item->likes ?></p><button id="<?= $item->id ?>"
                                    class="w-6 h-6 " onclick="likeUnlikePost(this)"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="<?= "w-6 h-6 text-teal-800 cursor-pointer ". ($item->liked ? "fill-teal-800 hover:fill-white" : "hover:fill-teal-800") ?>">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg></button>
                            </div>
                            <h2 class="text-teal-800 font-bold text-xl"><?= $item->title ?></h2>
                            <p><?= $item->description ?></p>
                        </div>
                        <p class="border-t border-gray-400 text-sm px-4 py-1">
                            <?= date("d-m-Y", strtotime($item->created_at)) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>