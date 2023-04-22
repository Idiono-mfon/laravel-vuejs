<script setup>
import Base from "../layouts/base.vue";
import { onMounted, ref } from "vue";
import axios from "axios";

const skills = ref([]);

const services = ref([]);

const showModal = ref(false);

const hideModal = ref(true);

const form = ref({
    name: "",
    proficiency: "",
    service_id: "",
});

onMounted(async () => {
    getSkills();

    getServices();
});

const getSkills = async () => {
    try {
        let response = await axios.get("/api/get_all_skill");

        console.log(response);

        skills.value = response.data.skills;
    } catch (error) {
        console.log(error.response.data);
    }
};

const getServices = async () => {
    try {
        let response = await axios.get("/api/get_all_service");

        console.log(response);

        services.value = response.data.services;
    } catch (error) {
        console.log(error.response.data);
    }
};

const openModal = () => {
    showModal.value = !showModal.value;
};

const closeModal = () => {
    console.log("I am clicke");
    showModal.value = !hideModal.value;
};
</script>
<template>
    <Base />
    <main class="main">
        <div class="main sideNav"></div>
        <!-- Main Content -->
        <div class="main__content">
            <!--==================== SKILLS ====================-->
            <section class="skills section" id="skills">
                <div class="skills_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Skills</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn" @click="openModal()">
                                New Skill
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

                        <div class="skill_table-heading">
                            <p>Name</p>
                            <p>Proficiency</p>
                            <p>Service</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div v-if="skills.length > 0">
                            <div
                                v-for="skill in skills"
                                :key="skill.id"
                                class="skill_table-items"
                            >
                                <p>{{ skill.name }}</p>
                                <div class="table_skills-bar">
                                    <span
                                        class="table_skills-percentage"
                                        :style="{
                                            width: `${skill.proficiency}%`,
                                        }"
                                    ></span>
                                    <strong>{{ skill.proficiency }}%</strong>
                                </div>
                                <p v-if="skill.service">
                                    {{ skill.service.name }}
                                </p>
                                <div>
                                    <button class="btn-icon success">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn-icon danger">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------- SERVICES MODAL --------------->
                <div class="modal main__modal" :class="{ show: showModal }">
                    <div class="modal__content">
                        <span class="modal__close" @click="closeModal()"
                            >×</span
                        >
                        <h3 class="modal__title">Add Skill</h3>
                        <hr class="modal_line" />
                        <br />
                        <div>
                            <p>Name</p>
                            <input
                                type="text"
                                class="input"
                                v-model="form.name"
                            />

                            <p>Proficiency</p>
                            <input
                                type="text"
                                class="input"
                                v-model="form.proficiency"
                            />

                            <p>Service</p>
                            <select
                                class="inputSelect"
                                name=""
                                v-model="form.service_id"
                                id=""
                            >
                                <option disabled value="">
                                    Select service
                                </option>

                                <option
                                    v-for="item in services"
                                    :key="item.id"
                                    value="{{ item.id }}"
                                >
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <br />
                        <hr class="modal_line" />
                        <div class="model__footer">
                            <button class="btn mr-2" @click="closeModal()">
                                Cancel
                            </button>
                            <button class="btn btn-secondary btn__close--modal">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>
