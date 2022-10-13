<template>
    <Head>
        <title>Dashboard &mdash; Sunergetic</title>
    </Head>
    <Navigation />
    
    <main class="global-wrapper">
        <section class="customer-list">
            <!-- Action buttons (create) -->
            <div class="action-buttons">
                <button @click="$inertia.visit('/create')">Create customer</button>
            </div>

            <!-- Table with customers -->
            <table>
                <tr class="top">
                    <th style="width: 80px;">ID</th>
                    <th style="width: 200px;">First name</th>
                    <th style="width: 200px;">Last name</th>
                    <th>E-mail</th>
                    <th style="width: 170px;">Actions</th>
                </tr>
                <tr v-for="(customer, index) in customers" :key="index">
                    <td>#{{ customer.id }}</td>
                    <td>{{ customer.firstname }}</td>
                    <td>{{ customer.lastname }}</td>
                    <td>{{ customer.email }}</td>
                    <td>
                        <!-- View button -->
                        <button class="view" @click="viewCustomer(customer)"><i class="fa-solid fa-eye"></i></button>
                        <!-- Edit -->
                        <button class="edit" @click="editCustomer(customer)"><i class="fa-solid fa-pen-to-square"></i></button>
                        <!-- Delete -->
                        <button class="delete" @click="deleteCustomer(customer)"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <div>
                    <p>Current page: {{ current_page }}/{{ customer_data.pagination.lastPage }}</p>
                </div>

                <div>
                    <button v-for="(item, index) in pagination.lastPage" :key="index" @click="changePage(item)">{{ item }}</button>
                </div>
            </div>
        </section>
    </main>
</template>

<style scoped>
.customer-list {
    width: 100%;
    margin-top: 50px;
}

/* Action buttons (Creation only) */
.action-buttons {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

.action-buttons button {
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

.action-buttons button:hover {
    opacity: .8;
}

table {
    border-collapse: collapse;
    width: 100%;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
}

tr.top {
    border-top: 4px solid var(--green);
    background-color: #e0e0e0;
}

tr {
    background-color: var(--light-grey);
}

tr:nth-child(even) {
    background-color: var(--white);
}

th {
    font-size: 1.3rem;
    font-weight: 500;
}
  
td, th {
    text-align: left;
    padding: 10px;
}

th:last-of-type {
    text-align: right;
}

table tr td button {
    border: none;
    outline: none;
    background: none;
    width: 40px;
    height: 40px;
    margin-right: 10px;
    border-radius: 10px;
    color: var(--white);
    font-size: 1.5rem;
    cursor: pointer;
    transition: .15s ease-in-out;
}

table tr td button:hover {
    opacity: .8;
}

table tr td button:last-of-type {
    margin-right: 0px;
}

table tr td button.view, table tr td button.edit {
    background-color: var(--blue);
}

table tr td button.delete {
    background-color: var(--red);
}

/* Pagination */
.pagination {
    width: 100%;
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
}

.pagination button {
    border: none;
    outline: none;
    background: none;
    width: 40px;
    height: 40px;
    margin-right: 10px;
    border-radius: 10px;
    color: var(--white);
    font-size: 1.5rem;
    cursor: pointer;
    transition: .15s ease-in-out;
    background-color: var(--green);
}

.pagination button:hover {
    opacity: .8;
}

.pagination button:last-of-type {
    margin-right: 0px;
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
            // Data from api
            customers: this.customer_data.data,
            pagination: this.customer_data.pagination,

            // Current page number
            current_page: this.customer_data.pagination.current_page
        }
    },

    methods: {
        // Change the page with a new inertia request
        changePage(page) {
            this.$inertia.visit(`/?page=${page}`);
        },

        // Delete customer button
        deleteCustomer(customer) {
            // Trigger notifaction through sweetalert to ask confirmation
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: `Deleting ${customer.firstname} ${customer.lastname} is irreversible!`,
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Delete user",
                denyButtonText: "Cancel",
                focusConfirm: false,
                focusDeny: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Button clicked on confirm, delete the user
                    window.axios.delete(`https://assignment.sunergetic.nl/api/v1/customers/${customer.id}`, {
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/x-www-form-urlencoded",
                            "token": this.$props.api_key
                        }
                    }).then((response) => {
                        if (response.data.message == "Customer deleted!") {
                            // Create a toast message
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
                                title: 'Customer deleted!'
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
            });
        },

        // View customer page
        viewCustomer(customer) {
            this.$inertia.visit(`/view/${customer.id}`);
        },

        // Edit customer page
        editCustomer(customer) {
            this.$inertia.visit(`/edit/${customer.id}`);
        }
    }

}
</script>
