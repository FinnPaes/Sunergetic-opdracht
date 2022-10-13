<template>
    <Head>
        <title>Create customer &mdash; Sunergetic</title>
    </Head>
    <Navigation />
    
    <main class="global-wrapper">
        <form class="customer" @submit.prevent="createCustomer()">
            <div><span><i class="fa-solid fa-id-card"></i> First name:</span> <input type="text" v-model="firstname" required></div>
            <div><span><i class="fa-solid fa-id-card"></i> Last name:</span> <input type="text" v-model="lastname" required></div>
            <div><span><i class="fa-solid fa-id-card"></i> Email:</span> <input type="email" v-model="email" required></div>
            <div><span><i class="fa-solid fa-location-dot"></i> Address:</span> <input type="text" v-model="address" required></div>
            <div><span><i class="fa-solid fa-location-dot"></i> Zipcode:</span> <input type="text" v-model="zipcode" required></div>
            <div><span><i class="fa-solid fa-city"></i> City:</span> <input type="text" v-model="city" required></div>
            <div><span><i class="fa-solid fa-phone"></i> Phone:</span> <input type="text" v-model="phone" required></div>

            <button>Create</button>
        </form>
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

.customer div {
    font-size: 1.05rem;
    font-weight: 400;
    line-height: 25px;
    margin-bottom: 20px;
}

.customer div span {
    font-weight: 500;
}

.customer div span svg {
    color: var(--green);
    width: 30px;
}

.customer div input {
    outline: none;
    border: none;
    background-color: var(--white);
    min-width: 500px;
    height: 30px;
    font-size: .9rem;
    font-family: var(--font);
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    margin-left: 10px;
    border-radius: 4px;
    padding: 5px 10px;
}

.customer button {
    border: none;
    outline: none;
    background: none;
    margin-right: 10px;
    border-radius: 4px;
    width: 200px;
    height: 40px;
    color: var(--white);
    font-size: 1rem;
    cursor: pointer;
    transition: .15s ease-in-out;
    background-color: var(--green);
}

.customer button:hover {
    opacity: .8;
}
</style>

<script>
import Navigation from "../Shared/Navigation.vue";
import Swal  from "sweetalert2";

export default {
    // Define the incoming props
    props: ["api_key"],

    // Register components
    components: {
        Navigation
    },
    
    // Define data
    data() {
        return {
            email: "",
            firstname: "",
            lastname: "",
            address: "",
            zipcode: "",
            city: "",
            phone: ""
        }
    },

    // Methods
    methods: {
        // Creating the customer when form is filled
        createCustomer() {
            // Run POST request to API with axios
            window.axios({
                method: "POST",
                url: "https://assignment.sunergetic.nl/api/v1/customers",
                data: {
                    email: this.email,
                    firstname: this.firstname,
                    lastname: this.lastname,
                    address: this.address,
                    zipcode: this.zipcode,
                    city: this.city,
                    phone: this.phone,
                },
                headers: {
                    "Accept": "application/json",
                    "token": this.$props.api_key
                }
            }).then((response) => {
                if (response.data.message == "Customer Created!") {
                    // Create a toast message with Sweet alert 2
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });

                    // Fire the toast message!
                    Toast.fire({
                        icon: 'success',
                        title: 'Customer created!'
                    });

                    // Reload page
                    this.$inertia.visit(window.location.pathname);
                } else {
                    // Another message returned, show error message
                    Swal.fire({
                        title: "Something went wrong",
                        text: "Something went wrong, please try again",
                        icon: "error",
                    })
                }
            })
        }
    }
}
</script>