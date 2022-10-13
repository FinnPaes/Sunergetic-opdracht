<template>
    <Head>
        <title>Edit customer &mdash; Sunergetic</title>
    </Head>
    <Navigation />
    
    <main class="global-wrapper">
        <section class="customer">
            <div><span><i class="fa-solid fa-id-card"></i> First name:</span> <input type="text" v-model="firstname"></div>
            <div><span><i class="fa-solid fa-id-card"></i> Last name:</span> <input type="text" v-model="lastname"></div>
            <div><span><i class="fa-solid fa-id-card"></i> Email:</span> <input type="text" v-model="email"></div>
            <div><span><i class="fa-solid fa-location-dot"></i> Address:</span> <input type="text" v-model="address"></div>
            <div><span><i class="fa-solid fa-location-dot"></i> Zipcode:</span> <input type="text" v-model="zipcode"></div>
            <div><span><i class="fa-solid fa-city"></i> City:</span> <input type="text" v-model="city"></div>
            <div><span><i class="fa-solid fa-phone"></i> Phone:</span> <input type="text" v-model="phone"></div>

            <button @click="saveCustomer()">Save</button>
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
    props: ["api_key", "customer_data"],

    components: {
        Navigation
    },

    data() {
        return {
            email: this.customer_data.email,
            firstname: this.customer_data.firstname,
            lastname: this.customer_data.lastname,
            address: this.customer_data.address,
            zipcode: this.customer_data.zipcode,
            city: this.customer_data.city,
            phone: this.customer_data.phone
        }
    },

    methods: {
        saveCustomer() {
            // In de API staat er iets fout aangegeven, die headers moet je niet doen (content-type en accept) anders werkt het niet!
            window.axios({
                method: "PUT",
                url: `https://assignment.sunergetic.nl/api/v1/customers/${this.customer_data.id}`,
                data: {
                    email: this.email,
                    firstname: this.firstname,
                    lastname: this.lastname,
                    address: this.address,
                    zipcode: this.zipcode,
                    city: this.city,
                    phone: this.phone
                },
                headers: {
                    "token": this.$props.api_key
                }
            }).then((response) => {
                if (response.data.message == "Customer updated!") {
                    // Create a toast message with sweet alert 2
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
                        title: 'Customer data updated!'
                    });
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