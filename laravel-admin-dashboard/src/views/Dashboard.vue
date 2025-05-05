<template>
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Employee Dashboard</h1>
            <router-link
                to="/employees/create"
                class="bg-blue-600 text-white px-4 py-2 rounded"
                >Add Employee</router-link
            >
        </div>
        <EmployeeTable />
    </div>
</template>

<script setup>
import EmployeeTable from "../components/EmployeeTable.vue";
</script>
