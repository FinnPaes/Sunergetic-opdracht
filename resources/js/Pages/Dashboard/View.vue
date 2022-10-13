<template>
    <Head>
        <title>View customer &mdash; Sunergetic</title>
    </Head>
    <Navigation />
    
    <main class="global-wrapper">
        <section class="customer">
            <p><span><i class="fa-solid fa-hashtag"></i> ID:</span> {{ customer_data.id }}</p>
            <p><span><i class="fa-solid fa-id-card"></i> Name:</span> {{ customer_data.firstname }} {{ customer_data.lastname }}</p>
            <p><span><i class="fa-solid fa-at"></i> Email:</span> {{ customer_data.email }}</p>
            <p><span><i class="fa-solid fa-location-dot"></i> Address:</span> {{ customer_data.address }}</p>
            <p><span><i class="fa-solid fa-location-dot"></i> Zipcode:</span> {{ customer_data.zipcode }}</p>
            <p><span><i class="fa-solid fa-city"></i> City:</span> {{ customer_data.city }}</p>
            <p><span><i class="fa-solid fa-phone"></i> Phone:</span> {{ customer_data.phone }}</p>
            <p><span><i class="fa-regular fa-calendar-days"></i> Creation:</span> {{ customer_data.created_at }}</p>
            <p><span><i class="fa-regular fa-calendar-days"></i> Last update:</span> {{ customer_data.updated_at }}</p>
        </section>
    </main>
</template>

<style scoped>
.customer {
    width: 100%;
    margin-top: 50px;
    background-color: var(--white);
    padding: 15px;
    border-radius: 5px;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
}

.customer p {
    font-size: 1.05rem;
    font-weight: 400;
    line-height: 30px;
}

.customer p span {
    font-weight: 500;
}

.customer p span svg {
    color: var(--green);
    width: 30px;
}
</style>

<script>
import Navigation from "../Shared/Navigation.vue";

export default {
    props: ["api_key", "customer_data"],

    components: {
        Navigation
    }
}
</script>