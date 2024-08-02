<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import CrearPedido from '@/Components/crear_pedidos/recuadroCrearPedido.vue';
import { ref, onMounted } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    bebidas: {
        type: Object,
        required: true
    },
    ingredientes: {
        type: Object,
        required: true
    },
    ordens: {
        type: Object,
        required: true
    },
    categorias: {
        type: Object ,
        required: true
    },
})

const error = ref(null);


const editarPedido = (id, estado) => {
  const pedido = {
    id: id,
    estado: estado
  };

  router.put(`/ordens/${id}`, pedido, {
    onSuccess: () => {
      error.value = null;
      console.log('Estado del pedido actualizado con éxito');
    },
    onError: (errors) => {
      console.error('Error al actualizar el estado del pedido:', errors);
    }
  });
};

const findCategoriaNombre = (itemId) => {
    for (let categoria of props.categorias) {
        const item = categoria.items.find(item => item.id === itemId);
        if (item) {
            return categoria.nombre;
        }
    }
    return 'Categoría no encontrada';
}
</script>

<template>
    <div>
        <div class=" lg:px-4  border-gray-200 ">
            <div v-if="ordens.length > 0" class="bg-white shadow-lg text-gray-500 leading-relaxed border p-8 rounded-3xl">                <!-- Primer pedido -->
                <div class="flex flex-col">
                    <div class="flex w-full justify-between items-center mb-2">
                        
                        <p class="text-xl font-bold text-gray-700">Pedido de {{ ordens[0].nombre_comprador }}</p>
                        <p class="text-xl font-semibold text-gray-900">Estado: {{ ordens[0].estado }}</p>
                    </div>
                    <div class="grid grid-cols-12 gap-5 ">

                    
                        <!-- Marquesitas -->
                         
                        <div class="col-span-6">
                            <div v-if="ordens[0].marquesitas.length > 0" class="mb-4">
                                <h4 class="text-md font-medium">Marquesitas</h4>
                                <ul class="w-full mt-2 grid grid-cols-12 gap-3">
                                    <li v-for="(marquesita, index) in ordens[0].marquesitas" :key="marquesita.id" class=" col-span-6">
                                        <div class="flex justify-between w-full bg-gray-100 p-2 rounded-md">
                                            <p class=" font-semibold">Marquesita {{ index + 1 }}</p>
                                            <p class="font-semibold ">Suma: ${{ marquesita.precio_marquesita * marquesita.cantidad }}</p>
                                        </div>
                                        <div v-if="marquesita.ingredientes.length > 0" class=" mt-2 ml-5">
                                            <div class="flex justify-between">
                                                <p class="text-sm">
                                                    Cantidad: {{ marquesita.cantidad }}
                                                </p>
                                                <p class=" text-sm">
                                                    Precio: ${{ marquesita.precio_marquesita }}
                                                </p>
                                            </div>
                                            <ul class="">
                                                <h5 class="text-sm font-medium">Ingredientes</h5>
                                                <li class="px-3 text-sm" v-for="ingrediente in marquesita.ingredientes" :key="ingrediente.id">
                                                    {{ ingrediente.nombre }} - ${{ ingrediente.precio }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div v-else class="ml-5 mt-2 flex flex-col">
                                            <div class="flex justify-between">
                                                <p class="text-sm">Cantidad: {{ marquesita.cantidad }} </p>
                                                <p class="text-sm ">Individual: ${{ marquesita.precio_marquesita }}</p>
                                            </div>
                                            <p class="text-sm font-semibold ">Simples - $40.0</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div v-else class="mb-4">
                                <p class="text-sm text-gray-500">No tiene marquesitas.</p>
                            </div>
                        </div>
                        <!-- Bebidas -->
                        <div class="col-span-6">
                            <div v-if="ordens[0].bebidas.length > 0" class="mb-4">
                                <h4 class="text-md font-medium">Bebidas</h4>
                                <ul class="w-full mt-2 grid grid-cols-12 gap-3">
                                    <li v-for="bebida in ordens[0].bebidas" :key="bebida.id" class="mb-2 bg-gray-50 p-2 rounded-md col-span-6">
                                        <div class="flex justify-between">
                                            <p class="text-sm">{{ bebida.nombre }}</p>
                                            <p class=" font-bold">Suma: ${{ bebida.precio * bebida.cantidad }}</p>
                                        </div>
                                        <div class="flex justify-between pl-5">
                                            <p class="text-sm">Cantidad: {{ bebida.cantidad }}</p>
                                            <p class="text-sm">Precio: ${{ bebida.precio }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div v-else class="mb-4">
                                <p class="text-sm text-gray-500">No tiene bebidas.</p>
                            </div>
                            
                        </div>
                        <div v-if="ordens[0].orden_items.length" class="col-span-12">
                            <div v-for="item in ordens[0].orden_items" :key="item.id" class="ml-4">
                                <p class="text-md font-medium text-gray-700">
                                    {{ findCategoriaNombre(item.item_id) }}: {{ item.nombre }} - Cantidad: {{ item.cantidad }} - Precio: {{ item.precio_unitario }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right col-span-2 ">
                            <p class="text-2xl font-semibold text-gray-950">Total: ${{ ordens[0].total }}</p>
                            <div v-if="ordens[0].metodo !== 'Efectivo'">
                                <p class=" text-gray-600">Pago con {{ ordens[0].metodo }}</p>
                            </div>
                            <div v-else>
                                <p class=" text-gray-600">Recibido: ${{ ordens[0].pago }}</p>
                                <p class=" text-gray-600">Cambio: ${{ ordens[0].cambio }}</p>
                            </div>
                            <div class="flex gap-3 justify-end  ">
                                <span @click="editarPedido(ordens[0].id, 'Cancelado')" class="cursor-pointer px-2 py-1 rounded-xl text-white bg-red-500 hover:bg-red-600">Cancelar</span>
                                <span @click="editarPedido(ordens[0].id, 'Entregado')" class="cursor-pointer px-2 py-1 rounded-xl text-white bg-green-500 hover:bg-green-600">Entregar</span>
                            </div>
                        </div>
                </div>
            </div>
            <div v-else class="bg-white shadow-lg  leading-relaxed border text-gray-400 px-8 py-3 rounded-3xl">
                Sin pedidos recientes 
            </div>
        </div>

        <div class="bg-gray-100/10 bg-opacity-25   flex flex-col-reverse row-span-12  gap-4 md:flex-row lg:gap-4 p-2 lg:py-8 lg:px-4">
            
            <div class=" bg-white  shadow-lg md:w-4/12 lg:w-4/12 col-span-5 rounded-3xl  border p-3  max-h-[60rem] overflow-scroll custom-scrollbar ">
                
                <ul >
                    <div v-if="ordens.length > 1">

                        <li class="px-4 border-b border-gray-400 pb-4" v-for="orden in ordens.slice(1)" :key="orden.id">
                            <div class="flex flex-col">
                                <div class="flex justify-between pt-4 w-full">
                                    <p class="text-lg font-semibold textce mx-auto">Pedido de {{ orden.nombre_comprador }}</p>
                                </div>
                                <div>
                                    <!-- Marquesitas -->
                                    
                                    <div v-if="orden.orden_items">
                                        <div v-for="item in orden.orden_items" :key="item.id" class="ml-4">
                                            <p class="text-md font-medium text-gray-700">
                                                {{ findCategoriaNombre(item.item_id) }}: {{ item.nombre }} - Cantidad: {{ item.cantidad }} - Precio: {{ item.precio_unitario }}
                                            </p>
                                        </div>
                                    </div>
                                <div v-if="orden.marquesitas.length > 0" class="mb-4">
                                    <h4 class="text-md font-medium">Marquesitas</h4>
                                    <ul class="w-full mt-2">
                                        <li v-for="(marquesita, index) in orden.marquesitas" :key="marquesita.id" class="mb-2">
                                            <div class="flex justify-between w-full bg-gray-100 p-2 rounded-md">
                                                <p class=" font-semibold">Marquesita {{ index + 1 }}</p>
                                                <p class="font-bold ">Suma: ${{ marquesita.precio_marquesita * marquesita.cantidad }}</p>
                                            </div>
                                            <div v-if="marquesita.ingredientes.length > 0" class=" mt-2 ml-5">
                                                <div class="flex justify-between">
                                                    <p class="text-sm">
                                                        Cantidad: {{ marquesita.cantidad }}
                                                    </p>
                                                    <p class="font-bold">
                                                        Individual: ${{ marquesita.precio_marquesita }}
                                                    </p>
                                                </div>
                                                <ul class="">
                                                    <h5 class="text-sm font-medium">Ingredientes</h5>
                                                    <li class="px-3 text-sm" v-for="ingrediente in marquesita.ingredientes" :key="ingrediente.id">
                                                        {{ ingrediente.nombre }} - ${{ ingrediente.precio }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div v-else class="ml-5 mt-2 flex flex-col">
                                                <div class="flex justify-between">
                                                    <p class="text-sm">Cantidad: {{ marquesita.cantidad }} </p>
                                                    <p class="font-sm">Individual: ${{ marquesita.precio_marquesita }}</p>
                                                </div>
                                                <p class="text-sm font-semibold ">Simples - $40.0</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-else class="mb-4">
                                    <p class="text-sm text-gray-500">No tiene marquesitas.</p>
                                </div>
                            </div>
                            <!-- Bebidas -->
                            <div>
                                <div v-if="orden.bebidas.length > 0" class="mb-4">
                                    <h4 class="text-md font-medium">Bebidas</h4>
                                    <ul class="w-full mt-2">
                                        <li v-for="bebida in orden.bebidas" :key="bebida.id" class="mb-2 bg-gray-50 p-2 rounded-md">
                                            <div class="flex justify-between">
                                                <p class=" font-bold ">{{ bebida.nombre }}</p>
                                                <p class=" font-bold">Suma: ${{ bebida.precio * bebida.cantidad }}</p>
                                            </div>
                                            <div class="flex justify-between pl-5">
                                                <p class="text-sm">Cantidad: {{ bebida.cantidad }}</p>
                                                <p class="text-sm">Precio: ${{ bebida.precio }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-else class="mb-4">
                                    <p class="text-sm text-gray-500">No tiene bebidas.</p>
                                </div>
                                <div class="text-right flex flex-col justify-end items-end">
                                    <p class=" font-semibold text-gray-800">Estado: {{ orden.estado }}</p>
                                    <p class="text-2xl  font-semibold">Total: ${{ orden.total }}</p>
                                    <div v-if="orden.metodo !== 'Efectivo'">
                                        <p class=" text-gray-600">Pago con {{ orden.metodo }}</p>
                                    </div>
                                    <div v-else>
                                        <p class=" text-gray-600">Recibido: ${{ orden.pago }}</p>
                                        <p class=" text-gray-600">Cambio: ${{ orden.cambio }}</p>
                                    </div>
                                    
                                    <div class="gap-3 flex">
                                        <span @click="editarPedido(orden.id, 'Cancelado')" class="cursor-pointer px-2 py-1 rounded-xl text-white bg-red-500 hover:bg-red-600">Cancelar</span>
                                        <span @click="editarPedido(orden.id, 'Entregado')" class="cursor-pointer px-2 py-1 rounded-xl text-white bg-green-500 hover:bg-green-600">Entregar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    </div>
                    <div v-else>
                        <p class="text-gray-400 py-2 px-auto text-center">
                            Sin pedidos en cola
                        </p>
                    </div>
                </ul>

            </div>
            
            <div class=" border p-3 bg-white md:w-8/12 lg:w-8/12 col-span-7 rounded-3xl shadow-xl">
                <CrearPedido :bebidas="bebidas" :ingredientes="ingredientes" :categorias="categorias" />
            </div>
        </div>
    </div>
</template>


<style>
.custom-scrollbar {
    overflow-x: hidden;
    /* Oculta el scroll horizontal */
    overflow-y: auto;
    /* Permite el scroll vertical */
}

.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Para Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
}
</style>