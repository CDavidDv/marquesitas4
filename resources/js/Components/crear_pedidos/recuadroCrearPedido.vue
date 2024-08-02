<script setup>
import { useForm, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    bebidas: {
        type: Object,
        required: true
    },
    ingredientes: {
        type: Object,
        required: true
    },
    categorias: {
        type: Object,
        required: true,
    }
});

const marquesitas = ref([]);
const bebidasSelection = ref([]);
const categoriasSelection = ref({});  // To store selected items for each category
const sumaTotal = ref(0.0);
const error = ref(null);
const selection = ref([]);
const sumaIndividual = ref(40.0);
const metodoPago = ref('Efectivo');
const nombreComprador = ref('');
const searchQueryIngredients = ref('');
const searchQueryBebidas = ref('');
const pago = ref(0);
const cambio = ref(0);

const computedCambio = computed(() => {
    return pago.value > sumaTotal.value ? (pago.value - sumaTotal.value).toFixed(2) : 0;
});

watch(pago, (newValue) => {
    if (newValue > sumaTotal.value) {
        cambio.value = computedCambio.value;
    } else {
        cambio.value = 0;
    }
});

const filteredIngredients = computed(() => {
    return props.ingredientes.filter(ingrediente =>
        ingrediente.nombre.toLowerCase().includes(searchQueryIngredients.value.toLowerCase())
    );
});

const filteredBebidas = computed(() => {
    return props.bebidas.filter(bebida =>
        bebida.nombre.toLowerCase().includes(searchQueryBebidas.value.toLowerCase())
    );
});

const clearSearchIngredients = () => {
    searchQueryIngredients.value = '';
};

const clearSearchBebidas = () => {
    searchQueryBebidas.value = '';
};

const getIngredientsKey = (ingredientes) => {
    return ingredientes.map(ing => ing.id).sort().join('-');
};

const handleAddToSelection = (ingrediente) => {
    selection.value.push(ingrediente);
    sumaIndividual.value += parseFloat(ingrediente.precio);
};

const handleRemoveSelection = (id) => {
    const index = selection.value.findIndex(item => item.id === id);
    if (index !== -1) {
        sumaIndividual.value -= parseFloat(selection.value[index].precio);
        selection.value.splice(index, 1);
    }
};

const handleAddToSelectionMarquesa = () => {
    const ingredientsKey = getIngredientsKey(selection.value);
    const existingMarquesita = marquesitas.value.find(m => getIngredientsKey(m.ingredientes) === ingredientsKey);

    if (existingMarquesita) {
        existingMarquesita.cantidad++;
    } else {
        marquesitas.value.push({
            ingredientes: [...selection.value],
            precio: sumaIndividual.value,
            cantidad: 1
        });
    }

    sumaTotal.value += sumaIndividual.value;
    selection.value = [];
    sumaIndividual.value = 40.0;
};

const handleRemoveMarquesita = (index) => {
    sumaTotal.value -= marquesitas.value[index].precio * marquesitas.value[index].cantidad;
    marquesitas.value.splice(index, 1);
};

const handleAddBebida = (bebida) => {
    const existingBebida = bebidasSelection.value.find(b => b.id === bebida.id);

    if (existingBebida) {
        existingBebida.cantidad++;
    } else {
        bebidasSelection.value.push({
            ...bebida,
            cantidad: 1
        });
    }

    sumaTotal.value += parseFloat(bebida.precio);
};

const handleRemoveBebida = (id) => {
    const index = bebidasSelection.value.findIndex(item => item.id === id);
    if (index !== -1) {
        sumaTotal.value -= parseFloat(bebidasSelection.value[index].precio) * bebidasSelection.value[index].cantidad;
        bebidasSelection.value.splice(index, 1);
    }
};

const handleAddOneItem = (index) => {
    marquesitas.value[index].cantidad++;
    sumaTotal.value += marquesitas.value[index].precio;
};

const handleRemoveOneItem = (index) => {
    if (marquesitas.value[index].cantidad > 1) {
        marquesitas.value[index].cantidad--;
        sumaTotal.value -= marquesitas.value[index].precio;
    } else {
        handleRemoveMarquesita(index);
    }
};

const handleAddOneItemBebida = (index) => {
    bebidasSelection.value[index].cantidad++;
    sumaTotal.value += parseFloat(bebidasSelection.value[index].precio);
};

const handleRemoveOneItemBebida = (index) => {
    if (bebidasSelection.value[index].cantidad > 1) {
        bebidasSelection.value[index].cantidad--;
        sumaTotal.value -= parseFloat(bebidasSelection.value[index].precio);
    } else {
        handleRemoveBebida(bebidasSelection.value[index].id);
    }
};

const handleAddCategoriaItem = (categoria, item) => {
    if (!categoriasSelection.value[categoria.id]) {
        categoriasSelection.value[categoria.id] = [];
    }
    const existingItem = categoriasSelection.value[categoria.id].find(i => i.id === item.id);
    if (existingItem) {
        existingItem.cantidad++;
    } else {
        categoriasSelection.value[categoria.id].push({
            ...item,
            cantidad: 1
        });
    }

    sumaTotal.value += parseFloat(item.precio);
};

const handleRemoveCategoriaItem = (categoria, itemId) => {
    const categoryItems = categoriasSelection.value[categoria.id];
    if (!categoryItems) return;

    const index = categoryItems.findIndex(item => item.id === itemId);
    if (index !== -1) {
        sumaTotal.value -= parseFloat(categoryItems[index].precio) * categoryItems[index].cantidad;
        categoryItems.splice(index, 1);
    }
};

const handleAddOneCategoriaItem = (categoria, index) => {
    categoriasSelection.value[categoria.id][index].cantidad++;
    sumaTotal.value += parseFloat(categoriasSelection.value[categoria.id][index].precio);
};

const handleRemoveOneCategoriaItem = (categoria, index) => {
    const categoryItems = categoriasSelection.value[categoria.id];
    if (!categoryItems) return;

    if (categoryItems[index].cantidad > 1) {
        categoryItems[index].cantidad--;
        sumaTotal.value -= parseFloat(categoryItems[index].precio);
    } else {
        handleRemoveCategoriaItem(categoria, categoryItems[index].id);
    }
};

const pedido = ref({
    marquesitas: [],
    bebidas: [],
    categorias: [],
    total: 0.0,
    metodo: String
});

const enviarPedido = () => {
    if (pago.value < sumaTotal.value && metodoPago.value === 'Efectivo') {
        error.value = 'Debe agregar un pago mayor al total de la cuenta.';
        return;
    }

    if (marquesitas.value.length === 0 && bebidasSelection.value.length === 0 && Object.keys(categoriasSelection.value).length === 0 ) {
        error.value = 'Debe agregar al menos una marquesita, bebida o ítem de categoría al pedido.';
        return;
    }

    if (!nombreComprador.value.trim()) {
        error.value = 'El nombre del comprador es requerido.';
        return;
    }

    const pedido = {
        nombre_comprador: nombreComprador.value === '' ? 'Usuario' : nombreComprador.value,
        estado: 'Pagado',
        metodo: metodoPago.value,
        total: sumaTotal.value,
        pago: metodoPago.value === 'Efectivo' ? pago.value : 0,
        cambio: metodoPago.value === 'Efectivo' ? parseFloat(cambio.value) : 0,
        marquesitas: marquesitas.value.map(marquesita => ({
            precio: marquesita.precio,
            ingredientes: marquesita.ingredientes.map(ingrediente => ingrediente.id),
            cantidad: marquesita.cantidad
        })),
        bebidas: bebidasSelection.value.map(bebida => ({
            id: bebida.id,
            nombre: bebida.nombre,
            precio: bebida.precio,
            cantidad: bebida.cantidad
        })),
        categorias: Object.keys(categoriasSelection.value).map(categoriaId => ({
            id: categoriaId,
            items: categoriasSelection.value[categoriaId].map(item => ({
                id: item.id,
                nombre: item.nombre,
                precio: item.precio,
                cantidad: item.cantidad
            }))
        })),
    };
    console.log(pedido)

    router.post('/ordens', pedido, {
        onSuccess: () => {
            error.value = null;

            marquesitas.value = [];
            bebidasSelection.value = [];
            categoriasSelection.value = {};
            sumaTotal.value = 0.0;
            error.value = null;
            selection.value = [];
            sumaIndividual.value = 40.0;
            metodoPago.value = 'Efectivo';
            nombreComprador.value = '';
            pago.value = 0;
            cambio.value = 0;
        },
        onError: (errors) => {
            console.error('Error al enviar el pedido:', errors);
        }
    });
};
</script>



<template>
    <div class="flex flex-col p-4">
        <div class="flex justify-between flex-col sm:flex-row">
            <h1 class="text-2xl uppercase font-bold text-sky-800/90 mb-4">Crear pedido</h1>
            <input
                class="border border-gray-300 rounded-lg p-1 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                type="text" v-model="nombreComprador" placeholder="Nombre del comprador">
        </div>

        <div class="border flex md:flex-row p-4 gap-8 divide-x md:divide-gray-550 flex-col">
            <!-- Sección de Marquesitas y Bebidas -->
            <div class="flex flex-col flex-1 gap-4">
                <!-- Marquesitas -->
                <div class="flex flex-col">
                    <h2 class="font-bold text-lg">Marquesitas</h2>
                    <div class="flex justify-between flex-col sm:flex-row sm:items-center">
                        <h3 class="text-sm w-8/12">Ingredientes</h3>
                        <div
                            class="border sm:w-7/12 border-gray-500 text-gray-500 rounded-md overflow-hidden flex w-full mr-3">
                            <input type="text" v-model="searchQueryIngredients"
                                class="py-1 px-3 w-full border-0 focus:outline-none" placeholder="Buscar">
                            <span @click="clearSearchIngredients"
                                class="py-0 cursor-pointer hover:bg-gray-300 px-3 flex items-center justify-center">x</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <ul class="list-disc pl-4 mt-1 h-44 overflow-scroll custom-scrollbar divide-y divide-gray-150">
                            <li class="flex justify-between items-center py-1"
                                v-for="ingrediente in filteredIngredients" :key="ingrediente.id">
                                <div>
                                    <p class="font-semibold text-gray-600">{{ ingrediente.nombre }}</p>
                                    <p class="text-sm text-gray-600 pl-3">{{ ingrediente.detalles || ' ' }}</p>
                                </div>
                                <div class="flex items-center">
                                    <p class="text-green px-4 text-green-700 font-semibold">${{ ingrediente.precio }}
                                    </p>
                                    <span @click="handleAddToSelection(ingrediente)"
                                        class="px-2 py-1 text-xs font-semibold bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">Añadir</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex divide-gray-200 border p-2 flex-col">
                    <!-- Marquesitas creadas -->
                    <p class="font-bold">Marquesita a crear</p>
                    <ul
                        class="divide-y divide-gray-200 text-base max-h-44 overflow-scroll custom-scrollbar text-gray-600 font-semibold">
                        <li class="flex w-full justify-between items-center py-1" v-for="(item, index) in selection"
                            :key="index" :value="item">
                            <div>
                                <p>{{ item.nombre }}</p>
                                <p class="text-xs text-gray-600 pl-3">{{ item.detalles || ' ' }}</p>
                            </div>
                            <span @click="handleRemoveSelection(item.id)"
                                class="text-sm rounded-lg text-white bg-red-500 py-1 px-2 cursor-pointer">Quitar</span>
                        </li>
                    </ul>
                    <div class="flex w-full items-end py-1 justify-between">
                        <div>
                            <p class="text-sm">Precio por marquesita</p>
                            ${{ sumaIndividual }}
                        </div>
                        <span @click="handleAddToSelectionMarquesa"
                            class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer">Crear
                            marquesita</span>
                    </div>
                </div>
                <!-- Bebidas -->
                <div class="flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between w-full">
                        <h2 class="font-bold text-lg w-8/12">Bebidas</h2>
                        <div
                            class="border sm:w-7/12 border-gray-500 text-gray-500 rounded-md overflow-hidden flex w-full mr-3">
                            <input type="text" v-model="searchQueryBebidas"
                                class="py-1 px-3 w-full border-0 focus:outline-none" placeholder="Buscar">
                            <span @click="clearSearchBebidas"
                                class="py-0 cursor-pointer hover:bg-gray-300 px-3 flex items-center justify-center">x</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <ul class="list-disc pl-4 mt-1 h-48 overflow-scroll custom-scrollbar divide-y divide-gray-150">
                            <li class="flex justify-between items-center py-1" v-for="bebida in filteredBebidas"
                                :key="bebida.id">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ bebida.nombre }}</p>
                                    <p class="text-sm text-gray-600 pl-3">{{ bebida.detalles }}</p>
                                </div>
                                <div class="flex items-center">
                                    <p class="text-green px-2 text-green-700 font-semibold">${{ bebida.precio }}</p>
                                    <span @click="handleAddBebida(bebida)"
                                        class="px-2 py-1 bg-blue-500 text-xs text-white rounded hover:bg-blue-600 cursor-pointer">Añadir</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div v-if="props.categorias">
                    <div class="flex flex-col" v-for="categoria in props.categorias" :key="categoria.id">
                        <div class="flex flex-col sm:flex-row justify-between w-full">
                            <h2 class="font-bold text-lg w-8/12">{{ categoria.nombre }}</h2>
                            <div
                                class="border sm:w-7/12 border-gray-500 text-gray-500 rounded-md overflow-hidden flex w-full mr-3">
                                <input type="text" v-model="searchQueryBebidas"
                                    class="py-1 px-3 w-full border-0 focus:outline-none" placeholder="Buscar">
                                <span @click="clearSearchBebidas"
                                    class="py-0 cursor-pointer hover:bg-gray-300 px-3 flex items-center justify-center">x</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <ul class="list-disc pl-4 mt-1 max-h-48 overflow-scroll custom-scrollbar divide-y divide-gray-150">
                                <div v-for="item in categoria.items" :key="item.id"> 
                                    <div v-if="item" class="flex justify-between items-center py-1">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ item.nombre }}</p>
                                            <p class="text-sm text-gray-600 pl-3">{{ item.detalles }}</p>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="text-green px-2 text-green-700 font-semibold">${{ item.precio }}</p>
                                            <span @click="handleAddCategoriaItem(categoria, item)"
                                                class="px-2 py-1 bg-blue-500 text-xs text-white rounded hover:bg-blue-600 cursor-pointer">Añadir</span>
                                        </div>
                                    </div>
                                    <div v-else  class="flex justify-between items-center py-1">
                                        <div>
                                            No hay items en esta categoria.
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sección Total Pedido -->
            <div class="flex flex-col flex-1 p-2">
                <h2 class="font-bold text-2xl">Pedido Total</h2>
                <div class="pl-3 min-h-[30rem] max-h-[30rem] justify-between overflow-scroll custom-scrollbar">

                    <div class="mb-4">
                        <p class="font-bold text-xl" v-if="marquesitas.length > 0">Marquesitas</p>
                        <ul class="divide-y divide-gray-200 ">
                            <li v-for="(marquesita, index) in marquesitas" :key="index">
                                <div class="flex justify-between items-center py-1">
                                    <div>
                                        <p class="font-semibold">Marquesita {{ index + 1 }} ({{ marquesita.cantidad
                                            }})
                                        </p>
                                        <ul>
                                            <li v-for="(ingrediente, idx) in marquesita.ingredientes" :key="idx">
                                                {{ ingrediente.nombre }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="flex flex-col justify-center items-center">
                                        <p class="font-semibold">${{ marquesita.precio * marquesita.cantidad }}</p>
                                        <div class="flex ml-2">
                                            <span v-if="marquesita.cantidad > 1" @click="handleRemoveOneItem(index)"
                                                class="text-xs rounded-2xl text-white bg-red-500 hover:bg-red-600 px-2 py-1 cursor-pointer m-1">-1</span>
                                            <span @click="handleAddOneItem(index)"
                                                class="text-xs rounded-2xl text-white bg-green-500 hover:bg-green-600 px-2 py-1 cursor-pointer m-1">+1</span>
                                        </div>
                                        <span @click="handleRemoveMarquesita(index)"
                                            class="text-sm rounded-lg text-white bg-red-500 hover:bg-red-600 py-1 px-2 cursor-pointer">Quitar</span>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="font-bold text-xl" v-if="bebidasSelection.length > 0">Bebidas</p>
                        <ul class="divide-y divide-gray-200">
                            <li v-for="(bebida, index) in bebidasSelection" :key="index">
                                <div class="flex justify-between items-center py-1">
                                    <div>
                                        <p class="font-semibold">{{ bebida.nombre }} ({{ bebida.cantidad }})</p>
                                        <p class="text-sm text-gray-600 pl-3">{{ bebida.detalles || ' ' }}</p>
                                    </div>
                                    <div class="flex flex-col justify-center items-center">
                                        <p class="font-semibold">${{ bebida.precio * bebida.cantidad }}</p>
                                        <div class="flex ml-2">
                                            <span v-if="bebida.cantidad > 1" @click="handleRemoveOneItemBebida(index)"
                                                class="text-xs rounded-2xl text-white bg-red-500 hover:bg-red-600 px-2 py-1 cursor-pointer m-1">-1</span>
                                            <span @click="handleAddOneItemBebida(index)"
                                                class="text-xs rounded-2xl text-white bg-green-500 hover:bg-green-600 px-2 py-1 cursor-pointer m-1">+1</span>
                                        </div>
                                        <span @click="handleRemoveBebida(bebida.id)"
                                            class="text-sm rounded-lg text-white bg-red-500 hover:bg-red-600 py-1 px-2 cursor-pointer">Quitar</span>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="font-bold text-xl" v-if="categoriasSelection.length > 0">Bebidas</p>
                        <ul class="divide-y divide-gray-200">
                            <li v-for="(items, categoriaId) in categoriasSelection" :key="categoriaId">
                                <div class=" font-bold text-xl">
                                    {{ props.categorias.find(index => index.id == categoriaId).nombre }}
                                </div>
                                
                                <div class="flex justify-between items-center py-1" v-for="(item, index) in items" :key="item.id">
                                    <div>
                                        <p class="font-semibold">{{ item.nombre }} ({{ item.cantidad }})</p>
                                        <p class="text-sm text-gray-600 pl-3">{{ items.detalles || ' ' }}</p>
                                    </div>
                                    <div class="flex flex-col justify-center items-center">
                                        <p class="font-semibold">${{ item.precio * item.cantidad }}</p>
                                        <div class="flex ml-2">
                                            <span v-if="item.cantidad > 1" @click="handleRemoveOneCategoriaItem({ id: categoriaId }, index)"
                                                class="text-xs rounded-2xl text-white bg-red-500 hover:bg-red-600 px-2 py-1 cursor-pointer m-1">-1</span>
                                            <span @click="handleAddOneCategoriaItem({ id: categoriaId }, index)"
                                                class="text-xs rounded-2xl text-white bg-green-500 hover:bg-green-600 px-2 py-1 cursor-pointer m-1">+1</span>
                                        </div>
                                        <span @click="handleRemoveCategoriaItem({ id: categoriaId }, item.id)"
                                            class="text-sm rounded-lg text-white bg-red-500 hover:bg-red-600 py-1 px-2 cursor-pointer">Quitar</span>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    

                </div>
                <div class="mt-4 flex justify-evenly items-center">
                    <div class=" flex flex-col w-8/12">
                        <label for="options" class="block text-sm font-bold text-gray-700">Método de pago</label>
                        <select id="options" v-model="metodoPago"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                        <div v-if="metodoPago === 'Efectivo'" class="mt-4">
                            <label for="pago" class="block text-sm font-bold text-gray-700">Pago</label>
                            <input id="pago" v-model.number="pago" type="number" step="0.01"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" />
                            <div v-if="pago > sumaTotal" class="mt-4 flex items-center">
                                <label for="cambio" class="block text-lg font-bold text-gray-700 mr-4">Cambio: ${{
                    cambio }}</label>
                            </div>
                        </div>
                        <p class="font-bold text-3xl p-5">Total: ${{ sumaTotal }}</p>
                        <div v-if="metodoPago !== 'Efectivo'" class="hidden">
                            {{ pago = 0 }}

                        </div>
                    </div>

                </div>
                <div v-if="error" class="text-red-500 font-bold">{{ error }}</div>

                <button @click.prevent="enviarPedido"
                    class="justify-end items-end mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Crear pedido
                </button>

            </div>
        </div>

    </div>
</template>



<style>
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