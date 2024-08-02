<script setup>
import { ref, defineProps } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { Bar } from 'vue-chartjs';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
  tableroAdmin: {
    type: Object,
    required: true,
    default: () => ({
      ingredientes: [],
      bebidas: [],
      ordens: [],
      ventasHoy: 0,
      ventasMes: 0,
      ventasMesAnterior: 0,
      diferenciaPorcentual: 0,
      salesData: [],
      numeroVentasMesAnterior: 0,
      numeroVentasMes: 0,
      sucursalConMasVentas: 0
    })
  }
});

const ingredientes = ref(props.tableroAdmin.ingredientes || []);
const bebidas = ref(props.tableroAdmin.bebidas || []);
const ordens = ref(props.tableroAdmin.ordens || []);
const ventasHoy = ref(props.tableroAdmin.ventasHoy || 0);
const ventasMes = ref(props.tableroAdmin.ventasMes || 0);
const ventasMesAnterior = ref(props.tableroAdmin.ventasMesAnterior || 0);
const diferenciaPorcentual = ref(props.tableroAdmin.diferenciaPorcentual || 0);
const salesData = ref(props.tableroAdmin.salesData || []);
const numeroVentasMesAnterior = ref(props.tableroAdmin.numeroVentasMesAnterior || 0);
const numeroVentasMes = ref(props.tableroAdmin.numeroVentasMes || 0);
const sucursalConMasVentas = ref(props.tableroAdmin.sucursalConMasVentas || 0);

console.log(salesData.value);  // Verifica los datos aquí

const chartData = ref({
  labels: salesData.value.map(data => data.month),
  datasets: [
    {
      label: 'Ventas por mes',
      backgroundColor: '#3d59a1',
      data: salesData.value.map(data => data.sales)
    }
  ]
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true
    }
  }
});
</script>

<template>
  <div class="md:py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Resumen General -->
      <div class="bg-white rounded-xl shadow-md lg m-2 sm:rounded-lg p-4 flex flex-col justify-center">
        <h2>Resumen Mensual</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 mx-2 lg:grid-cols-4 gap-4">
        <div
          class="bg-white rounded-xl shadow-md sm:rounded-lg p-4 relative h-full w-full flex flex-col justify-center">
          <div class="flex justify-between items-center pr-3">
            <h2 class="text-lg font-medium">Ventas</h2>
            <div class="flex justify-center items-center"
              :class="{ 'text-green-500': diferenciaPorcentual >= 0, 'text-red-500': diferenciaPorcentual < 0 }">
              <svg v-if="diferenciaPorcentual > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="currentColor"
                class="icon icon-tabler icons-tabler-filled icon-tabler-caret-up">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M11.293 7.293a1 1 0 0 1 1.32 -.083l.094 .083l6 6l.083 .094l.054 .077l.054 .096l.017 .036l.027 .067l.032 .108l.01 .053l.01 .06l.004 .057l.002 .059l-.002 .059l-.005 .058l-.009 .06l-.01 .052l-.032 .108l-.027 .067l-.07 .132l-.065 .09l-.073 .081l-.094 .083l-.077 .054l-.096 .054l-.036 .017l-.067 .027l-.108 .032l-.053 .01l-.06 .01l-.057 .004l-.059 .002h-12c-.852 0 -1.297 -.986 -.783 -1.623l.076 -.084l6 -6z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-caret-down -mt-1 ">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" />
              </svg>
              <p class="text-sm font-bold ">{{ Math.abs(diferenciaPorcentual).toFixed(2) }}%</p>
            </div>
          </div>
          <p class="text-2xl font-bold text-right">${{ ventasMes }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md sm:rounded-lg p-4 flex flex-col justify-center">
          <div class="flex justify-between items-center pr-3">
            <h2 class="text-lg font-medium">Ordenes</h2>
            <div class="flex justify-center items-center"
              :class="{ 'text-green-500': numeroVentasMes >= 0, 'text-red-500': numeroVentasMes < 0 }">
              <svg v-if="numeroVentasMes > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="currentColor"
                class="icon icon-tabler icons-tabler-filled icon-tabler-caret-up">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M11.293 7.293a1 1 0 0 1 1.32 -.083l.094 .083l6 6l.083 .094l.054 .077l.054 .096l.017 .036l.027 .067l.032 .108l.01 .053l.01 .06l.004 .057l.002 .059l-.002 .059l-.005 .058l-.009 .06l-.01 .052l-.032 .108l-.027 .067l-.07 .132l-.065 .09l-.073 .081l-.094 .083l-.077 .054l-.096 .054l-.036 .017l-.067 .027l-.108 .032l-.053 .01l-.06 .01l-.057 .004l-.059 .002h-12c-.852 0 -1.297 -.986 -.783 -1.623l.076 -.084l6 -6z" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-caret-down -mt-1 ">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                  d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" />
              </svg>
              <p class="text-sm font-bold ">{{ Math.abs((numeroVentasMes - numeroVentasMesAnterior) /
                (numeroVentasMesAnterior === 0 ? 1 : numeroVentasMesAnterior) * 100).toFixed(2) }}%</p>
            </div>
          </div>
          <p class="text-2xl font-bold text-right">{{ numeroVentasMes }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md sm:rounded-lg p-4 flex flex-col justify-center">
          <div class="flex justify-between items-center pr-3">
            <h2 class=" text-base font-semibold">Sucursal más productiva</h2>
            <div class="flex justify-center items-center"
              :class="{ 'text-green-500': sucursalConMasVentas.total_ventas >= 0, 'text-red-500': sucursalConMasVentas.total_ventas < 0 }">
              <p class=" font-bold ">${{ sucursalConMasVentas.total_ventas }}</p>
            </div>
          </div>
          <p class="text-2xl font-bold text-right">{{ sucursalConMasVentas.sucursal_id }}</p>
        </div>
        <div class=" bg-white rounded-xl shadow-md  sm:rounded-lg p-4 flex flex-col justify-center">
          <h2 class="text-lg font-medium">Ventas de hoy</h2>
          <p class="text-2xl font-bold text-right text-green-900">${{ ventasHoy }}</p>
        </div>
      </div>

      <!-- Órdenes Recientes -->
      <div class="bg-white rounded-xl shadow-md m-2 p-4 justify-center grid grid-cols-1 md:grid-cols-12 gap-5">
    <div class="md:col-span-3 col-span-12">
        <div class="mt-4 bg-white rounded-xl shadow-md">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium">Órdenes recientes</h2>
            </div>
            <div class="border-t border-gray-200 max-h-80 overflow-scroll">
                <ul>
                    <li v-for="orden in ordens" :key="orden.id" class="px-4 py-5 border-b-2 w-full">
                        <div class="text-sm font-medium text-gray-500">
                            <p>Sucursal: {{ orden.sucursal_id }} - No.{{ orden.id }}</p>
                            <div class="flex gap-1">
                                <p>Estado: </p>
                                <p :class="{ 'text-green-500': orden.estado === 'Entregado', 'text-yellow-500': orden.estado === 'Pagado', 'text-red-500': orden.estado === 'Cancelado' }">
                                    {{ orden.estado }}
                                </p>
                            </div>
                            <p>Pedido de {{ orden.nombre_comprador }}</p>
                        </div>
                        <div class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p class="text-right">Total: ${{ orden.total }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="md:col-span-9 col-span-12">
        <div class="mt-4 bg-white rounded-xl shadow-md">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium">Ventas por mes</h2>
            </div>
            <div class="border-t border-gray-200">
                <div class="bg-white rounded-xl shadow-md lg:m-2 sm:rounded-lg px-8 mt-4 min-h-80">
                    <Bar :data="chartData" :options="chartOptions" />
                </div>
            </div>
        </div>
    </div>
</div>





    </div>
  </div>
</template>
