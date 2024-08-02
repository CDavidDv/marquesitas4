<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();

const sucursales = ref(props.sucursales || []);
const error = ref('');

// Formularios para editar y crear sucursales
const editForms = ref(sucursales.value.map(sucursal => ({
    ...sucursal,
    email: sucursal.user ? sucursal.user.email : '',
    password: '',
    isEditing: false
})));

const newSucursal = ref({
    nombre: '',
    direccion: '',
    email: '',
    password: ''
});

// Métodos para manejar la edición, creación y eliminación
const toggleEdit = (index) => {
    editForms.value[index].isEditing = !editForms.value[index].isEditing;
};

const updateSucursal = (index) => {
    const sucursal = editForms.value[index];
    router.put(`/sucursales/${sucursal.id}`, {
        nombre: sucursal.nombre,
        direccion: sucursal.direccion,
        email: sucursal.email,
        password: sucursal.password
    }, {
        onSuccess: () => {
            sucursal.isEditing = false;
            console.log('Sucursal y usuario actualizados con éxito');
        },
        onError: (errors) => {
            console.error('Error al actualizar la sucursal y usuario:', errors);
        }
    });
};

const addSucursal = () => {
    if (
        newSucursal.value.direccion.trim() == '' ||
        newSucursal.value.email.trim() == '' ||
        newSucursal.value.nombre.trim() == '' ||
        newSucursal.value.password.trim() == ''
    ) {
        error.value = 'Debe llenar todos los campos.';
        return;
    }

    const { nombre, direccion, email, password } = newSucursal.value;

    // Crear un nuevo objeto de sucursal
    const nuevaSucursalData = {
        nombre,
        direccion,
        email,
        password,
        isEditing: false  // Inicialmente no está en modo edición
    };

    // Limpiar los campos de entrada
    newSucursal.value = {
        nombre: '',
        direccion: '',
        email: '',
        password: ''
    };

    // Limpiar el mensaje de error
    error.value = '';

    // Enviar la solicitud al servidor para almacenar la sucursal
    router.post(route('sucursales.store'), nuevaSucursalData, {
        onSuccess: (response) => {
            console.log('Sucursal creada con éxito:', response.props);
            
            // Aquí se actualiza el estado local con los datos de la respuesta
            if (response.props && response.props.sucursales) {
                sucursales.value = response.props.sucursales; // Actualiza todas las sucursales
                editForms.value = sucursales.value.map(sucursal => ({
                    ...sucursal,
                    email: sucursal.user ? sucursal.user.email : '',
                    password: '',
                    isEditing: false
                }));
                
                console.log('Sucursales actualizadas con los datos del servidor');
            } else {
                console.error('Datos de la respuesta no están en el formato esperado');
            }
        },
        onError: (errors) => {
            console.error('Error al crear la sucursal:', errors);
            // En caso de error, podrías eliminar la sucursal que agregaste localmente
            editForms.value.pop();
        }
    });
};

const deleteSucursal = (index) => {
    const sucursal = editForms.value[index];
    if (confirm(`¿Estás seguro de que deseas eliminar la sucursal ${sucursal.nombre}?`)) {
        router.delete(route('sucursales.destroy', sucursal.id), {
            onSuccess: () => {
                // Actualiza el estado local después de eliminar la sucursal
                sucursales.value = sucursales.value.filter((_, i) => i !== index);
                editForms.value.splice(index, 1);
                console.log('Sucursal y usuario eliminados con éxito');
            },
            onError: (errors) => {
                console.error('Error al eliminar la sucursal y usuario:', errors);
            }
        });
    }
};
</script>

<template>
    <AppLayout title="Tablero">
        <div class="py-4">
            <div class="max-w mx-auto sm:px-2 lg:px-4">
                <div class="overflow-hidden sm:rounded-lg">
                    <div v-if="$page.props.auth.user.sucursal_id == 0">
                        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                            <h2 class="text-2xl text-gray-500 font-bold mb-5">Sucursales</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div v-for="(sucursal, index) in editForms" :key="index" class="mb-4 shadow-xl bg-gray-100 p-4 rounded">
                                    <div class="flex flex-col overflow-x-scroll">
                                        <div v-if="sucursal.isEditing" class="flex flex-col">
                                            <input v-model="sucursal.nombre" class="mb-2 p-2 border rounded" placeholder="Nombre">
                                            <input v-model="sucursal.direccion" class="mb-2 p-2 border rounded" placeholder="Dirección">
                                            <input v-model="sucursal.email" class="mb-2 p-2 border rounded" placeholder="Usuario">
                                            <input v-model="sucursal.password" type="password" class="mb-2 p-2 border rounded" placeholder="Contraseña">
                                            <div>
                                                <button @click="updateSucursal(index)" class="bg-blue-500 m-1 text-white px-2 py-1 rounded">Guardar</button>
                                                <button @click="toggleEdit(index)" class="bg-gray-500 text-white px-2 py-1 rounded">Cancelar</button>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <p>Nombre: {{ sucursal.nombre }}</p>
                                            <p>Dirección: {{ sucursal.direccion }}</p>
                                            <p>Usuario: {{ sucursal.email }}</p>
                                            <button @click="toggleEdit(index)" class="bg-orange-500 m-1 text-white px-2 py-1 rounded">Editar</button>
                                            <button @click="deleteSucursal(index)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="text-2xl text-gray-500 font-bold mb-5">Añadir Nueva Sucursal</h2>
                            <div class="bg-gray-100 p-4 rounded shadow-md overflow-y-scroll">
                                <div class="flex flex-col md:flex-row gap-3">
                                    <input v-model="newSucursal.nombre" class="mb-2 p-2 border rounded" placeholder="Nombre">
                                    <input v-model="newSucursal.direccion" class="mb-2 p-2 border rounded" placeholder="Dirección">
                                    <input v-model="newSucursal.email" class="mb-2 p-2 border rounded" placeholder="Usuario">
                                    <input v-model="newSucursal.password" type="password" class="mb-2 p-2 border rounded" placeholder="Contraseña">
                                </div>
                                <div>
                                    <div v-if="error" class="text-red-500 font-bold">{{ error }}</div>
                                    <button @click="addSucursal" class="bg-green-500 text-white px-4 py-2 rounded">Añadir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
