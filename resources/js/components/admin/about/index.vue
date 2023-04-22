<script setup>
import Base from "../layouts/base.vue";

import { onMounted, reactive } from "vue";

let form = reactive({
    name: "",
    photo: "",
    email: "",
    phone: "",
    address: "",
    description: "",
    tagline: "",
    cv: "",
    id: "",
});

onMounted(async () => {
    getAbout();
});

const getAbout = async () => {
    try {
        const response = await axios.get("/api/edit_about");
        Object.assign(form, response.data);
        console.log("response", response);
    } catch (e) {
        console.log(e.response.data);
    }
};

const getPhoto = () => {
    let photo = "/img/avatar.jpg";

    console.log("I m trigger");

    if (form.photo) {
        if (form.photo.indexOf("base64") !== -1) {
            photo = form.photo;
        } else {
            photo = "/img/upload" + form.photo;
        }
    }

    return photo;
};

const changePhoto = (e) => {
    let file = e.target.files[0];

    let reader = new FileReader();

    let limit = 1024 * 1024 * 2;
    if (file["size"] > limit) {
        Swal({
            icon: "error",
            title: "oooops...",
            text: "You are uploading a large file",
        });

        return false;
    }

    reader.onloadend = (file) => {
        const newPhoto = {
            photo: reader.result,
        };

        console.log(newPhoto);
        Object.assign(form, newPhoto); // equivalent to reassign
    };

    reader.readAsDataURL(file);
};

const uploadCV = (e) => {
    let file = e.target.files[0];

    let reader = new FileReader();

    let limit = 1024 * 1024 * 2;
    if (file["size"] > limit) {
        Swal({
            icon: "error",
            title: "oooops...",
            text: "You are uploading a large file",
        });

        return false;
    }

    reader.onloadend = (file) => {
        const newCV = {
            cv: reader.result,
        };
        Object.assign(form, newCV); // equivalent to reassign
    };

    reader.readAsDataURL(file);
};

const updateAbout = async () => {
    try {
        const response = await axios.post(`/api/update_about/${form.id}`, form);
        console.log(response);

        toast.fire({
            icon: "success",
            title: "Profile updated successfully",
        });
    } catch (error) {
        console.log(error.response.data);
    }
};
</script>

<template>
    <div>
        <Base />
        <h1>About Page</h1>
        <main class="main">
            <!-- Side Nav Dummy-->
            <div class="main__sideNav"></div>
            <!-- End Side Nav -->
            <!-- Main Content -->
            <div class="main__content">
                <!--==================== ABOUT ====================-->
                <section class="about section" id="about">
                    <form @submit.prevent="updateAbout">
                        <div class="about_container">
                            <div class="titlebar">
                                <div class="titlebar_item">
                                    <h1>About Us</h1>
                                </div>
                                <div class="titlebar_item">
                                    <button
                                        type="submit"
                                        class="btn btn-secondary"
                                    >
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                            <div class="card_wrapper">
                                <div class="wrapper_left">
                                    <div class="card">
                                        <p>Full Name</p>
                                        <input
                                            type="text"
                                            class="input"
                                            v-model="form.name"
                                        />

                                        <p>Email</p>
                                        <input
                                            type="email"
                                            class="input"
                                            v-model="form.email"
                                        />

                                        <p>Phone</p>
                                        <input
                                            type="text"
                                            class="input"
                                            v-model="form.phone"
                                        />

                                        <p>Address</p>
                                        <input
                                            type="text"
                                            class="input"
                                            v-model="form.address"
                                        />

                                        <p>Description</p>
                                        <textarea
                                            cols="10"
                                            rows="5"
                                            v-model="form.description"
                                        ></textarea>
                                    </div>
                                    <div class="card">
                                        <p>Tagline</p>
                                        <input
                                            type="text"
                                            class="input"
                                            v-model="form.tagline"
                                        />
                                    </div>
                                </div>

                                <div class="wrapper_right">
                                    <div class="card">
                                        <div class="avatar_profile">
                                            <img
                                                :src="getPhoto()"
                                                alt=""
                                                class="avatar_profile_img"
                                            />
                                        </div>
                                        <input
                                            type="file"
                                            @change="changePhoto"
                                            id="fileimg"
                                        />
                                    </div>
                                    <div class="card">
                                        <p>CV</p>
                                        <input
                                            type="file"
                                            id="filecv"
                                            @change="uploadCV"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="titlebar">
                                <div class="titlebar_item"></div>
                                <div class="titlebar_item">
                                    <button
                                        type="submit"
                                        class="btn btn-secondary"
                                    >
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
</template>
