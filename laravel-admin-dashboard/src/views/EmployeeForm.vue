<template>
    <div class="p-4 max-w-xl mx-auto">
        <h2 class="text-xl mb-4">{{ id ? "Edit" : "Create" }} Employee</h2>
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <input
                v-model="form.name"
                placeholder="Name"
                class="w-full p-2 border rounded"
            />
            <input
                v-model="form.email"
                placeholder="Email"
                class="w-full p-2 border rounded"
            />
            <input
                v-model="form.designation"
                placeholder="Designation"
                class="w-full p-2 border rounded"
            />
            <input
                type="date"
                v-model="form.joining_date"
                class="w-full p-2 border rounded"
            />
            <input
                v-model="form.department_id"
                placeholder="Department ID"
                class="w-full p-2 border rounded"
            />
            <button class="bg-green-600 text-white px-4 py-2 rounded">
                {{ id ? "Update" : "Create" }}
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import {
    getEmployee,
    createEmployee,
    updateEmployee,
} from "../api/employee.js";

const route = useRoute();
const router = useRouter();
const id = route.params.id;

const form = ref({
    name: "",
    email: "",
    designation: "",
    joining_date: "",
    department_id: "",
});

onMounted(async () => {
    if (id) {
        const res = await getEmployee(id);
        Object.assign(form.value, {
            ...res.data,
            designation: res.data.detail?.designation || "",
            joining_date: res.data.detail?.joining_date || "",
            department_id: res.data.department_id || "",
        });
    }
});

const handleSubmit = async () => {
    if (id) {
        await updateEmployee(id, form.value);
    } else {
        await createEmployee(form.value);
    }
    router.push("/");
};
</script>
