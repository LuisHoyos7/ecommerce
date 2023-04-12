<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
<style scoped>
.bg-overlay {
    position: relative !important;
    opacity: 0.2 !important;
}
</style>
<template>
    <link rel="stylesheet" href="." />
    <div>
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-4">
                    <div
                        class="authentication-page-content p-4 d-flex align-items-center min-vh-100"
                    >
                        <div class="w-100">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <div>
                                        <div class="text-center">
                                            <div>
                                                <a href="/" class="logo">
                                                    <img
                                                        src="@/assets/images/logo-dark.png"
                                                        height="20"
                                                        alt="logo"
                                                    />
                                                </a>
                                            </div>
                                        </div>

                                        <div class="p-2 mt-5">
                                            <form
                                                class="form-horizontal"
                                                @submit.prevent="submit"
                                            >
                                                <div
                                                    class="form-group auth-form-group-custom mb-4"
                                                >
                                                    <i
                                                        class="ri-user-2-line auti-custom-input-icon"
                                                    ></i>
                                                    <label for="username"
                                                        >Username</label
                                                    >
                                                    <input
                                                        v-model="form.email"
                                                        type="text"
                                                        class="form-control"
                                                        id="username"
                                                        placeholder="Enter username"
                                                    />
                                                </div>

                                                <div
                                                    class="form-group auth-form-group-custom mb-4"
                                                >
                                                    <i
                                                        class="ri-lock-2-line auti-custom-input-icon"
                                                    ></i>
                                                    <label for="userpassword"
                                                        >Password</label
                                                    >
                                                    <input
                                                        v-model="form.password"
                                                        type="password"
                                                        class="form-control"
                                                        id="userpassword"
                                                        placeholder="Enter password"
                                                    />
                                                </div>

                                                <!-- <div
                                                    class="custom-control custom-checkbox"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customControlInline"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="customControlInline"
                                                        >Remember me</label
                                                    >
                                                </div> -->

                                                <div class="mt-4 text-center">
                                                    <button
                                                        class="btn btn-primary w-md waves-effect waves-light"
                                                        type="submit"
                                                    >
                                                        Log In
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="authentication-bg">
                        <div class="bg-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
