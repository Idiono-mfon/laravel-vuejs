<script setup>
import Base from "../layouts/base.vue";

import { onMounted, ref } from "vue";

let services = ref([]);

const showModal = ref(false);

const hideModal = ref(true);

const editMode = ref(false);

const form = ref({
    name: "",
    description: "",
    icon: "",
});

onMounted(async () => {
    getServices();
});

const getServices = async () => {
    try {
        const response = await axios.get("/api/get_all_service");
        console.log("response", response);
        services.value = response.data.services;
    } catch (error) {
        console.log(error.response.data);
    }
};

const openModal = () => {
    showModal.value = !showModal.value;
};

const closeModal = () => {
    showModal.value = !hideModal.value;
};
const createService = async () => {
    try {
        await axios.post("/api/create_service", form.value);
        getServices();
        closeModal();
        form.value = {};
        toast.fire({
            icon: "success",
            title: "Service add Successfully",
        });
    } catch (error) {
        console.log(error.response.data);
    }
};

const editModal = (service) => {
    editMode.value = true;
    showModal.value = !showModal.value;
    form.value = service;
};
const updateService = async () => {
    try {
        await axios.post("/api/update_service/" + form.value.id, form.value);
        getServices();
        closeModal();
        toast.fire({
            icon: "success",
            title: "Service update successfully",
        });
    } catch (error) {
        console.log(error.response.data);
    }
};

const deleteService = (id) => {
    Swal.fire({
        title: "Are you sure ?",
        text: "You can't go back",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it !",
    }).then((result) => {
        if (result.value) {
            axios.delete("/api/delete_service/" + id);

            Swal.fire("Delete", "Service delete sucessfully");

            getServices();
        }
    });
};
</script>
<template>
    <Base />

    <main class="main">
        <div class="main sideNav"></div>
        <!-- Main Content -->
        <div class="main_content">
            <!--==================== SERVICES ====================-->
            <section class="services section" id="services">
                <div class="services_container mt">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Services</h1>
                        </div>
                        <div class="titlebar_item">
                            <div
                                class="btn btn__open--modal"
                                @click="openModal()"
                            >
                                New Service
                            </div>
                        </div>
                    </div>

                    <div class="table">
                        <div class="table_filter">
                            <span class="table_filter-Btn">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p
                                            class="table_filter-link table_filter-link--active"
                                        >
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select
                                    class="table_search-select"
                                    name=""
                                    id=""
                                >
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i
                                    class="table_search-input--icon fas fa-search"
                                ></i>
                                <input
                                    class="table_search--input"
                                    type="text"
                                    placeholder="Search Service"
                                />
                            </div>
                        </div>

                        <div class="service_table-heading">
                            <p>Title</p>
                            <p>Icon</p>
                            <p>Description</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div v-if="services.length > 0">
                            <div
                                v-for="item in services"
                                :key="item.id"
                                class="service_table-items"
                            >
                                <p>{{ item.name }}</p>
                                <button class="service_table-icon">
                                    <!-- fas fa-pencil-alt -->
                                    <i class="{{ item.icon }}"></i>
                                </button>
                                <p>
                                    {{ item.description }}
                                </p>
                                <div>
                                    <button
                                        class="btn-icon success"
                                        @click="editModal(item)"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button
                                        class="btn-icon danger"
                                        @click="deleteService(item.id)"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- item 2 -->
                        <!-- <div class="service_table-items">
                            <p>Backend Developer</p>
                            <button class="service_table-icon">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <p>
                                Sapiente odit ut ipsam neque dolorum et.
                                Officiis error dicta pariatur quidem. Saepe
                                dignissimos et at error dolores asperiores.
                                Earum id sed ratione ducimus enim voluptate
                                praesentium.
                            </p>
                            <div>
                                <button class="btn-icon success">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-------------- SERVICES MODAL --------------->
                <div class="modal main__modal" :class="{ show: showModal }">
                    <div class="modal__content">
                        <span
                            class="modal__close btn__close--modal"
                            @click="closeModal()"
                            >×</span
                        >
                        <h3 class="modal__title" v-show="!editMode">
                            Add Service
                        </h3>
                        <h3 class="modal__title" v-show="editMode">
                            Edit Service
                        </h3>
                        <hr class="modal_line" />
                        <br />
                        <form @submit.prevent="createService()">
                            <div>
                                <p>Service Name</p>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    class="input"
                                />

                                <p>Icon Class</p>
                                <input
                                    type="text"
                                    v-model="form.icon"
                                    class="input"
                                />
                                <span style="color: #006fbb"
                                    >Find your suitable icon: Font Awesome</span
                                >

                                <p>Description</p>
                                <textarea
                                    cols="10"
                                    v-model="form.description"
                                    rows="5"
                                ></textarea>
                            </div>
                        </form>
                        <br />
                        <hr class="modal_line" />
                        <div class="model__footer">
                            <button
                                class="btn mr-2 btn__close--modal"
                                @click="closeModal()"
                            >
                                Cancel
                            </button>
                            <button
                                @click="
                                    {
                                        {
                                            !editMode
                                                ? createService()
                                                : updateService();
                                        }
                                    }
                                "
                                type="submit"
                                class="btn btn-secondary btn__close--modal"
                            >
                                {{ !editMode ? "Save" : "Update" }}
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<style scoped>
.mt {
    margin-top: 100px;
}
</style>
