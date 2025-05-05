<template>
    <div>
        <div class="mb-4 flex gap-2">
            <input
                v-model="search"
                placeholder="Search..."
                class="border p-2 rounded"
            />
            <button
                @click="fetchData"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Search
            </button>
        </div>

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Joining Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="emp in employees" :key="emp.id">
                    <td>{{ emp.name }}</td>
                    <td>{{ emp.email }}</td>
                    <td>{{ emp.department?.name }}</td>
                    <td>{{ emp.detail?.designation }}</td>
                    <td>{{ emp.detail?.joining_date }}</td>
                    <td class="flex gap-2">
                        <router-link
                            :to="`/employees/edit/${emp.id}`"
                            class="text-blue-600"
                            >✏️</router-link
                        >
                        <button @click="remove(emp.id)" class="text-red-600">
                            🗑
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { getEmployees, deleteEmployee } from "../api/employee.js";

const employees = ref([]);
const search = ref("");

const fetchData = async () => {
    const res = await getEmployees({ search: search.value });
    employees.value = res.data.data;
};

const remove = async (id) => {
    if (confirm("Delete this employee?")) {
        await deleteEmployee(id);
        fetchData();
    }
};

onMounted(fetchData);
</script>
