<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
defineProps({
    user: {
        type: Object,
    },
});
const routeProfile = () => {
    window.location.href = "/profile";
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <header class="pl-9 pr-9 pt-6 pb-1">
                        <h2 class="text-lg font-medium text-gray-900">
                            Usuarios
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Lista todos los usuarios del sistema con sus
                            roles...
                        </p>
                    </header>
                    <div class="pl-9 pr-9">
                        <DataTable
                            :value="user"
                            paginator
                            :rows="5"
                            tableStyle="min-width: 50rem"
                            class="p-datatable-sm"
                        >
                            <Column field="id" header="Identificador"></Column>
                            <Column field="name" header="Nombre"></Column>
                            <Column field="email" header="Correo"></Column>
                            <Column field="" header="Acciones">
                                <template #body="slotProps">
                                    <PrimaryButton @click="routeProfile"
                                        >Editar</PrimaryButton
                                    >
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
