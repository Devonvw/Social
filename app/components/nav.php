<script>
window.onload = () => {
    const burger = document.getElementById("burger");
    const close = document.getElementById("close");
    const mobileNav = document.getElementById("mobileNav");

    burger?.addEventListener("click", () => {
        console.log("burger");
        document.body.classList.add("overflow-hidden", "h-screen");
        mobileNav?.classList.remove("translate-x-full");
        mobileNav?.classList.add("translate-x-0");
    });

    close?.addEventListener("click", () => {
        document.body.classList.remove("overflow-hidden", "h-screen");
        mobileNav?.classList.remove("translate-x-0");
        mobileNav?.classList.add("translate-x-full");
    })
}


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
        <div class="hidden md:flex flex-row text-xs sm:text-base">
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    Login
                </span>
            </a><a href="/sign-up"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Signup
                </span>
            </a><?php else : ?>
            <a href="/new-post"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    New Post
                </span>
            </a>
            <a href="/my-posts"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    My Posts
                </span>
            </a>
            <button type="button" name="logoutBtn" onclick="logout()"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Logout
                </span>
            </button>
            <?php endif; ?>
        </div>
        <button id="burger"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="cursor-pointer h-10 w-10 md:hidden top-1/4 text-teal-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg></button>
    </div>
</nav>
<nav id="mobileNav"
    class="backdrop-blur-2xl bg-white/50 translate-x-full fixed top-0 right-0 flex flex-col h-full nav-shadow overflow-y-hidden nav-mobile opacity-100 transition-all duration-200 w-screen z-[100]">
    <div class="px-4 py-6 h-full flex flex-col items-center">
        <div class="w-full flex">
            <a href="/">
                <h1 class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight">Social</h1>
            </a>
            <button id="close" class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="cursor-pointer h-10 w-10 ml-auto text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
        </div>
        <div class="flex flex-col text-xs sm:text-base my-auto">
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    Login
                </span>
            </a><a href="/sign-up"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Signup
                </span>
            </a><?php else : ?>
            <a href="/new-post"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    New Post
                </span>
            </a>
            <a href="/my-posts"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    My Posts
                </span>
            </a>
            <button type="button" name="logoutBtn" onclick="logout()"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative x-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Logout
                </span>
            </button>
            <?php endif; ?>
        </div>
        <div class="text-white font-chivo text-[13px] mt-8">
            ©Social 2023
        </div>
    </div>
</nav>