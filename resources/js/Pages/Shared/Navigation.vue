<template>
    <nav>
        <div class="wrapper">
            <!-- Left -->
            <div class="left">
                <Link href="/"><Logo width="200" height="40" /></Link>
            </div>

            <!-- Right -->
            <div></div>
        </div>
    </nav>
</template>

<style scoped>
nav {
    width: 100%;
    background-color: var(--white);
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
}

nav .wrapper {
    margin: auto;
    width: 100%;
    max-width: 1500px;
    padding: 15px;
}

</style>

<script>
// Import the logo component
import Logo from "../Shared/Logo.vue";

export default {
    // Register components
    components: {
        Logo
    }
}
</script>