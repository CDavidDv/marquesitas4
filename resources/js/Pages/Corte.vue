<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';

const { props } = usePage();

const totalEfectivo = ref(props.totalEfectivo || 0);
const totalTarjeta = ref(props.totalTarjeta || 0);
const totalTransferencia = ref(props.totalTransferencia || 0);
const totalBruto = ref(props.totalBruto || 0);
const ordens = ref(props.ordens || []);
const numeroDeOrdenes = ref(props.numeroDeOrdenes || 0);
const hoy = ref(props.hoy || '');
const sucursal = ref(props.sucursal || 0);
const error = ref(null);
const filtro = ref(null);
const selectedFilter = ref(props.selectedFilter || 'day');
const selectedDate = ref(props.selectedDate || '');
const selectedWeek = ref(props.selectedWeek || '');
const selectedMonth = ref(props.selectedMonth || '');
const numeroDeMarquesitas = ref(props.numeroDeMarquesitas || 0);

const bebidasCantidad = ref(props.bebidasCantidad || [])

const ordensBySucursal = computed(() => {
    if (sucursal.value > 0) return [];

    const grouped = ordens.value.reduce((acc, orden) => {
        if (!acc[orden.sucursal_id]) {
            acc[orden.sucursal_id] = {
                id: orden.sucursal_id,
                totalEfectivo: 0,
                totalTarjeta: 0,
                totalTransferencia: 0,
                totalBruto: 0,
                numeroDeOrdenes: 0,
                ordens: []
            };
        }
        const totalValue = parseFloat(orden.total);
        if (!isNaN(totalValue)) {
            acc[orden.sucursal_id].totalBruto += totalValue;
            acc[orden.sucursal_id].numeroDeOrdenes += 1;
            acc[orden.sucursal_id].ordens.push(orden);
            
            switch (orden.metodo) {
                case 'Efectivo':
                    acc[orden.sucursal_id].totalEfectivo += totalValue;
                    break;
                case 'Tarjeta':
                    acc[orden.sucursal_id].totalTarjeta += totalValue;
                    break;
                case 'Transferencia':
                    acc[orden.sucursal_id].totalTransferencia += totalValue;
                    break;
            }
        }
        return acc;
    }, {});

    const sortedOrdens = Object.values(grouped).map(sucursal => {
        sucursal.ordens.sort((a, b) => a.id - b.id); // Ordenar de menor a mayor por id
        return sucursal;
    });

    return sortedOrdens;
});

const form = useForm({
    filter: selectedFilter.value,
    value: selectedMonth.value || selectedWeek.value || selectedDate.value
});

const fetchFilteredData = () => {
    if (!selectedDate.value && !selectedWeek.value && !selectedMonth.value) {
        error.value = 'Debe seleccionar una fecha.';
        return;
    }

    let value = '';
    switch (selectedFilter.value) {
        case 'day':
            value = selectedDate.value;
            break;
        case 'week':
            value = selectedWeek.value;
            break;
        case 'month':
            value = selectedMonth.value;
            break;
    }

    // Actualiza los valores del formulario
    form.filter = selectedFilter.value;
    form.value = value;

    // Realiza la solicitud para obtener datos filtrados
    form.get('/datos-filtrados', {
        onSuccess: (page) => {
            totalEfectivo.value = page.props.totalEfectivo;
            totalTarjeta.value = page.props.totalTarjeta;
            totalTransferencia.value = page.props.totalTransferencia;
            totalBruto.value = page.props.totalBruto;
            ordens.value = page.props.ordens;
            numeroDeMarquesitas.value = page.props.numeroDeMarquesitas;
            numeroDeOrdenes.value = page.props.numeroDeOrdenes;
            error.value = 'Debe seleccionar una fecha.';
            filtro.value = 'Filtrado por';
        },
        onError: (error) => {
            console.error('Error al obtener datos filtrados:', error);
        }
    });
};

const resetFilters = () => {
    selectedFilter.value = 'day'; 
    selectedDate.value = '';
    selectedWeek.value = '';
    selectedMonth.value = '';
    contador.value = 0;
    router.get('/corte')
};


</script>



<template>
    <AppLayout title="Tablero">
        <template #header>
            <div class="flex justify-between flex-col md:flex-row">
                <div>
                    <div v-if="$page.props.auth.user.sucursal_id > 0">
                        <h1 class="text-xl font-bold">Corte de caja de sucursal {{ sucursal }}</h1>
                        <p>Corte del día {{ hoy.split('T')[0].split('-')[2] + "/" + hoy.split('T')[0].split('-')[1] + "/" + hoy.split('T')[0].split('-')[0] }}</p>
                    </div>
                    <div v-else>
                        <h1  class="lg:text-2xl sm:text-xl font-bold">Corte de caja de sucursales</h1>
                        <p class="text-lg">Número de órdenes: <span class="font-bold  md:text-2xl px-2 py-1 rounded-lg">{{ numeroDeOrdenes }}</span></p>
                    </div>
                    <p class="text-lg">Número de marquesitas: <span class="font-bold md:text-2xl px-2 py-1 rounded-lg">{{ numeroDeMarquesitas }}</span></p>
                    <div v-if="bebidasCantidad">
                        <p v-for="(bebidas, index) in bebidasCantidad" :key="index" class="text-lg">Número de {{ index }}: <span class="font-bold px-2 py-1 rounded-lg">{{ bebidas }}</span></p>
                    </div>
                    
                    <span>
                        
                            {{ 
                                props.selectedFilter === 'day' ? 'Filtro por día: ' + props.selectedDate.split('T')[0] :
                                props.selectedFilter === 'week' ? 'Filtro por semana: ' + props.selectedWeek :
                                props.selectedFilter === 'month' ? 'Filtro por mes: ' + props.selectedMonth.split('-').reverse().join('/') :
                                ''
                            }}
                    </span>
                </div>
                <div v-if="$page.props.auth.user.sucursal_id > 0">
                    <p class="text-lg my-3">Total en efectivo: <span class="font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg">${{ totalEfectivo }}</span></p>
                    <p class="text-lg my-3">Total por transferencia: <span class="font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg">${{ totalTransferencia }}</span></p>
                    
                    <p class="text-lg my-3">Total bruto: <span class="font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg">${{ totalBruto }}</span></p>
                    <p class="text-lg">Número de órdenes: <span class="font-bold text-white md:text-2xl bg-teal-400 px-2 py-1 rounded-lg">{{ numeroDeOrdenes }}</span></p>
                    
                </div>
                <div v-else class="flex flex-col items-center">
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <div class="w-full gap-2 flex flex-col items-center">
                            <label for="filter" class=" font-bold">Filtrar por:</label>
                            <div class="flex gap-2">
                                <select class=" ml-1 py-0 rounded" id="filter" v-model="selectedFilter">
                                    <option value="day">Día</option>
                                    <option value="week">Semana</option>
                                    <option value="month">Mes</option>
                                </select>
        
                                <input class="w-fit h-fit p-1 rounded" id="valueSelect" type="date" v-if="selectedFilter === 'day'" v-model="selectedDate" />
                                <input class="w-fit h-fit p-1 rounded" id="valueSelect" type="week" v-if="selectedFilter === 'week'" v-model="selectedWeek" />
                                <input class="w-fit h-fit p-1 rounded" id="valueSelect" type="month" v-if="selectedFilter === 'month'" v-model="selectedMonth" />
                            </div>
                            <div class="flex gap-1">
                                <button class="text-sm rounded-lg shadow-lg disabled px-3 py-2 bg-blue-500 text-white hover:bg-blue-600" @click="fetchFilteredData">Aplicar Filtro</button>
                                <button class="text-sm rounded-lg shadow-lg px-3 py-2 bg-gray-500 text-white hover:bg-gray-600" @click="resetFilters">
                                    Limpiar Filtro
                                </button>
    
                            </div>
                        </div>
                    </div>
                    <div v-if="error" class="text-red-500 font-bold mt-2">{{ error }}</div>
                    
                </div>
            </div>
        </template>
        <div class="py-4">
            <div class="max-w mx-auto sm:px-2 lg:px-4">
                <div class="overflow-hidden sm:rounded-lg">
                    <div v-if="$page.props.auth.user.sucursal_id > 0">
                        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                            <h2 class="text-2xl text-gray-500 font-bold mb-5">Pedidos atendidos de hoy</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div v-for="(orden, index) in ordens" :key="orden.id" class="mb-4 shadow-xl bg-gray-100 p-4 rounded">
                                    <div class="flex justify-between items-center">
                                        <p>No. {{ index+1 }} - {{ orden.nombre_comprador }} - Total: ${{ orden.total }}</p>
                                    </div>
                                    <div v-if="orden.marquesitas && orden.marquesitas.length">
                                        <p class="font-bold mt-2">Marquesitas:</p>
                                        <ul class="list-disc pl-5">
                                            <li v-for="marquesita in orden.marquesitas" :key="marquesita.id">
                                                Precio: ${{ marquesita.precio_marquesita }} ({{ marquesita.cantidad }})
                                                <ul class="list-disc pl-5">
                                                    <div v-if="marquesita.ingredientes?.length > 0">
                                                        <li v-for="ingrediente in marquesita.ingredientes" :key="ingrediente.id">
                                                            Ingrediente: {{ ingrediente.nombre }}
                                                        </li>
                                                    </div>
                                                    <div v-else>
                                                        <li>Sencillas.</li>
                                                    </div>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div v-if="orden.bebidas && orden.bebidas.length">
                                        <p class="font-bold mt-2">Bebidas:</p>
                                        <ul class="list-disc pl-5">
                                            <li v-for="bebida in orden.bebidas" :key="bebida.id">
                                                {{ bebida.nombre }} - ${{ bebida.precio }} ({{ bebida.cantidad }})
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="bg-white shadow-md rounded-xl px-8 pt-6 pb-8 mb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            <div v-for="sucursal in ordensBySucursal" :key="sucursal.id" class="col-span-1 border rounded-2xl p-4">
                                <h1 class="text-center font-bold text-xl">Sucursal {{ sucursal.id }}</h1>
                                <p>Total en efectivo: ${{ sucursal.totalEfectivo }}</p>
                                <p>Total por transferencia: ${{ sucursal.totalTransferencia }}</p>
                                
                                <p>Total bruto: ${{ sucursal.totalBruto }}</p>
                                <p>Número de órdenes: {{ sucursal.numeroDeOrdenes }}</p>
                                <div class="mt-4">
                                    <div v-for="(orden, index) in sucursal.ordens" :key="orden.id" class="mb-2">
                                        <p class=" font-bold">>>{{ index+1 }} - {{ orden.nombre_comprador }} - Total: ${{ orden.total + '<<' }}</p>
                                        <div v-if="orden.marquesitas && orden.marquesitas.length">
                                            <p class="font-bold mt-2">Marquesitas:</p>
                                            <ul class="list-disc pl-5">
                                                <li v-for="marquesita in orden.marquesitas" :key="marquesita.id">
                                                    Precio: ${{ marquesita.precio_marquesita }} ({{ marquesita.cantidad }})
                                                    <ul class="list-disc pl-5">
                                                        <div v-if="marquesita.ingredientes?.length > 0">
                                                            <li v-for="ingrediente in marquesita.ingredientes" :key="ingrediente.id">
                                                                Ingrediente: {{ ingrediente.nombre }}
                                                            </li>
                                                        </div>
                                                        <div v-else>
                                                            <li>Sencillas.</li>
                                                        </div>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div v-if="orden.bebidas && orden.bebidas.length">
                                            <p class="font-bold mt-2">Bebidas:</p>
                                            <ul class="list-disc pl-5">
                                                <li v-for="bebida in orden.bebidas" :key="bebida.id">
                                                    {{ bebida.nombre }} - ${{ bebida.precio }} ({{ bebida.cantidad }})
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
