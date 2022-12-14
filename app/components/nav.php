<script>
async function logout() {
    await fetch('http://localhost/api/user/logout', {
        method: "POST",
    }).then((res) => {
        window.location.href = "http://localhost";
    }).catch((res) => console.log(res));
}
</script>
<nav class="fixed top-0 w-full z-50" style="backdrop-filter: blur(20px);">
    <div class="flex flex-row justify-between px-4 py-6">
        <a href="/">
            <h1 class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight">Social</h1>
        </a>
        <div class="flex flex-row">
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    Login
                </span>
            </a><a href="/sign-up"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Signup
                </span>
            </a><?php else : ?>
            <a href="/new-post"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    New Post
                </span>
            </a>
            <button type="button" name="logoutBtn" onclick="logout()"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Logout
                </span>
            </button>
            <?php endif; ?>
        </div>
    </div>
</nav>